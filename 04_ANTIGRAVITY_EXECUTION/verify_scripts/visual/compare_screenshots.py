#!/usr/bin/env python3

"""
Visual Regression Testing Script
Purpose: Compare baseline and current screenshots to detect visual breakage
Uses: Pixelmatch for image comparison
Run: After Antigravity completes, to detect UI changes
"""

import os
import sys
import json
import subprocess
from datetime import datetime
from pathlib import Path

class VisualRegressionTester:
    """Compare screenshots for visual regression detection"""

    def __init__(self):
        self.baseline_dir = Path("./visual/baseline_screenshots")
        self.current_dir = Path("./visual/current_screenshots")
        self.diff_dir = Path("./visual/diff_screenshots")
        self.report_file = Path(f"./logs/visual_regression_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json")

        # Ensure directories exist
        self.baseline_dir.mkdir(parents=True, exist_ok=True)
        self.current_dir.mkdir(parents=True, exist_ok=True)
        self.diff_dir.mkdir(parents=True, exist_ok=True)
        self.report_file.parent.mkdir(parents=True, exist_ok=True)

        self.results = {
            "timestamp": datetime.now().isoformat(),
            "comparisons": [],
            "summary": {
                "total": 0,
                "passed": 0,
                "failed": 0,
                "skipped": 0
            }
        }

    def check_dependencies(self):
        """Verify required tools are installed"""
        try:
            import PIL
            print("✅ PIL (Pillow) available")
        except ImportError:
            print("❌ PIL (Pillow) not installed")
            print("   Install with: pip install pillow")
            return False

        try:
            # Check if pixelmatch is available
            result = subprocess.run(
                ["npm", "list", "-g", "pixelmatch"],
                capture_output=True,
                text=True
            )
            if result.returncode == 0:
                print("✅ pixelmatch available")
            else:
                print("⚠️  pixelmatch not installed globally")
                print("   Install with: npm install -g pixelmatch")
        except Exception as e:
            print(f"⚠️  Could not check pixelmatch: {e}")

        return True

    def compare_images_python(self, baseline, current, diff_output):
        """Compare images using PIL (pure Python implementation)"""
        try:
            from PIL import Image, ImageChops

            img1 = Image.open(baseline)
            img2 = Image.open(current)

            # Check if images have same size
            if img1.size != img2.size:
                return {
                    "match": False,
                    "error": f"Size mismatch: {img1.size} vs {img2.size}",
                    "pixels_changed": float('inf')
                }

            # Calculate difference
            diff = ImageChops.difference(img1, img2)
            stat = diff.convert("L").getextrema()

            if stat == (0, 0):
                return {
                    "match": True,
                    "pixels_changed": 0
                }

            # Count changed pixels
            hist = diff.convert("L").histogram()
            changed_pixels = sum(1 for i in range(1, len(hist)) if hist[i] > 0)

            # Save diff image
            diff.save(str(diff_output))

            threshold_percent = 1.0  # Allow up to 1% pixel changes
            total_pixels = img1.size[0] * img1.size[1]
            threshold = total_pixels * (threshold_percent / 100)

            return {
                "match": changed_pixels < threshold,
                "pixels_changed": changed_pixels,
                "total_pixels": total_pixels,
                "percent_changed": (changed_pixels / total_pixels) * 100
            }

        except Exception as e:
            return {
                "match": False,
                "error": str(e)
            }

    def compare_with_pixelmatch(self, baseline, current, diff_output):
        """Compare images using pixelmatch CLI"""
        try:
            result = subprocess.run(
                ["pixelmatch", str(baseline), str(current), str(diff_output)],
                capture_output=True,
                text=True
            )

            # pixelmatch outputs number of different pixels
            pixels_diff = int(result.stdout.strip().split()[-1])

            return {
                "match": pixels_diff == 0,
                "pixels_changed": pixels_diff
            }

        except Exception as e:
            print(f"⚠️  pixelmatch failed: {e}, falling back to PIL")
            return self.compare_images_python(baseline, current, diff_output)

    def compare_screenshot(self, baseline_file, current_file=None):
        """Compare a single baseline with current screenshot"""
        if current_file is None:
            # Use same filename in current directory
            current_file = self.current_dir / baseline_file.name

        diff_file = self.diff_dir / f"diff_{baseline_file.stem}.png"

        # Check files exist
        if not baseline_file.exists():
            return {
                "file": baseline_file.name,
                "status": "skipped",
                "reason": "Baseline not found"
            }

        if not current_file.exists():
            return {
                "file": baseline_file.name,
                "status": "skipped",
                "reason": "Current screenshot not found"
            }

        # Compare images
        comparison = self.compare_with_pixelmatch(baseline_file, current_file, diff_file)

        result = {
            "file": baseline_file.name,
            "baseline": str(baseline_file),
            "current": str(current_file),
            "diff": str(diff_file) if comparison.get("match") is False else None,
            "status": "passed" if comparison["match"] else "failed",
            "pixels_changed": comparison.get("pixels_changed", 0),
            "percent_changed": comparison.get("percent_changed", 0),
            "error": comparison.get("error", None)
        }

        return result

    def run_comparison(self):
        """Run all screenshot comparisons"""
        print("\n" + "="*50)
        print("Visual Regression Testing")
        print("="*50)

        if not self.baseline_dir.exists() or not list(self.baseline_dir.glob("*.png")):
            print("\n⚠️  No baseline screenshots found")
            print(f"   Create baseline screenshots in: {self.baseline_dir}")
            print("   Then run comparisons again")
            self.results["summary"]["skipped"] = 1
            return

        baseline_files = list(self.baseline_dir.glob("*.png"))
        print(f"\nFound {len(baseline_files)} baseline screenshot(s)")
        print("Comparing with current screenshots...\n")

        for baseline_file in baseline_files:
            comparison = self.compare_screenshot(baseline_file)

            if comparison["status"] == "passed":
                status_icon = "✅"
                self.results["summary"]["passed"] += 1
            elif comparison["status"] == "failed":
                status_icon = "❌"
                self.results["summary"]["failed"] += 1
            else:
                status_icon = "⏭️"
                self.results["summary"]["skipped"] += 1

            self.results["summary"]["total"] += 1
            self.results["comparisons"].append(comparison)

            if comparison["status"] == "skipped":
                print(f"{status_icon} {comparison['file']}: {comparison['reason']}")
            elif comparison["status"] == "passed":
                print(f"{status_icon} {comparison['file']}: No changes detected")
            else:
                change_pct = comparison.get("percent_changed", 0)
                print(f"{status_icon} {comparison['file']}: {change_pct:.2f}% changed")

    def save_report(self):
        """Save comparison results to JSON"""
        with open(self.report_file, "w") as f:
            json.dump(self.results, f, indent=2)
        print(f"\n📊 Report saved: {self.report_file}")

    def print_summary(self):
        """Print summary results"""
        summary = self.results["summary"]
        print("\n" + "="*50)
        print("Visual Regression Summary")
        print("="*50)
        print(f"Total:   {summary['total']}")
        print(f"Passed:  {summary['passed']}")
        print(f"Failed:  {summary['failed']}")
        print(f"Skipped: {summary['skipped']}")

        if summary["failed"] > 0:
            print(f"\n❌ REGRESSION DETECTED: {summary['failed']} screenshot(s) changed")
            print("Review diff images in: ./visual/diff_screenshots/")
            return 1
        elif summary["total"] == 0 or summary["skipped"] == summary["total"]:
            print("\n⏭️ No screenshots to compare (create baseline first)")
            return 2
        else:
            print("\n✅ No visual regressions detected")
            return 0

    def run(self):
        """Run full visual regression testing"""
        print("\n🔍 Visual Regression Testing Tool")
        print(f"Baseline: {self.baseline_dir}")
        print(f"Current:  {self.current_dir}")
        print(f"Diffs:    {self.diff_dir}")

        # Check dependencies (optional)
        # self.check_dependencies()

        # Run comparisons
        self.run_comparison()

        # Save report
        self.save_report()

        # Print summary
        return self.print_summary()


def main():
    """Main entry point"""
    tester = VisualRegressionTester()
    exit_code = tester.run()
    sys.exit(exit_code)


if __name__ == "__main__":
    main()
