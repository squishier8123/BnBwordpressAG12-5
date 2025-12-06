#!/usr/bin/env python3

"""
Screenshot Analyzer - Uses Claude's Native Vision
Purpose: Analyze Antigravity screenshots for accuracy verification
Checks: Button states, error messages, success indicators, visual state changes
Integration: Works with verification scripts to provide visual confirmation
"""

import os
import sys
import json
import base64
import subprocess
from datetime import datetime
from pathlib import Path
from typing import Dict, List, Optional, Tuple

class ScreenshotAnalyzer:
    """Analyze screenshots using Claude's vision capability via Claude Code"""

    def __init__(self):
        self.log_dir = Path("./logs")
        self.screenshots_dir = Path("./screenshots")
        self.analysis_log = self.log_dir / f"screenshot_analysis_{datetime.now().strftime('%Y%m%d_%H%M%S')}.json"

        # Ensure directories exist
        self.log_dir.mkdir(parents=True, exist_ok=True)
        self.screenshots_dir.mkdir(parents=True, exist_ok=True)

        self.analyses = []

    def encode_image_to_base64(self, image_path: str) -> str:
        """Encode image to base64 for Claude API"""
        with open(image_path, "rb") as image_file:
            return base64.standard_b64encode(image_file.read()).decode("utf-8")

    def analyze_screenshot_visual_state(self, screenshot_path: str, context: str = "") -> Dict:
        """
        Analyze a screenshot for visual state using Claude's vision.

        This function would be called by Claude Code (the main agent),
        which can read the screenshot and provide visual analysis.

        Args:
            screenshot_path: Path to screenshot file
            context: Context about what action was taken (e.g., "User clicked Save button")

        Returns:
            Dict with visual analysis results
        """

        if not os.path.exists(screenshot_path):
            return {
                "file": screenshot_path,
                "status": "error",
                "error": "Screenshot file not found"
            }

        analysis_prompt = f"""Analyze this screenshot and verify the action was completed successfully.

Context: {context if context else "Verify page state"}

Please check for:
1. **Button/Element State**: Is any button clicked, loading, or disabled?
2. **Error Messages**: Any red text, error icons, or error messages visible?
3. **Success Indicators**: Success message, checkmark, "saved" text, or page reload indication?
4. **URL/Navigation**: Correct page/URL visible in browser?
5. **Form State**: Form fields visible? Are they filled/empty as expected?
6. **Loading State**: Any loading spinners, animations, or processing indicators?
7. **Modal/Popup State**: Is modal open/closed as expected?
8. **Visual Regression**: Any obvious UI breaks or layout issues?

Respond with:
- action_completed: true/false (did the action actually complete?)
- confidence: high/medium/low (how confident in assessment?)
- observations: [list of what you see]
- errors_detected: [any errors or issues]
- recommendation: "proceed" / "retry" / "investigate"
"""

        return {
            "file": os.path.basename(screenshot_path),
            "path": screenshot_path,
            "context": context,
            "analysis_prompt": analysis_prompt,
            "timestamp": datetime.now().isoformat(),
            "note": "This analysis should be performed by Claude Code using native vision on the screenshot file"
        }

    def verify_button_clicked(self, screenshot_path: str, button_text: str) -> Dict:
        """Verify a button was actually clicked (loading state or disabled)"""
        analysis = {
            "check_type": "button_click",
            "button_text": button_text,
            "screenshot": screenshot_path,
            "prompt": f"""In this screenshot, verify that the button "{button_text}" was clicked:
1. Is button in loading/processing state (spinner, different color, disabled)?
2. Is button still visible and clickable?
3. Any error state?

Respond: action_state, is_loading, is_disabled, error_visible"""
        }
        return analysis

    def verify_success_message(self, screenshot_path: str, expected_message: Optional[str] = None) -> Dict:
        """Verify success message is visible"""
        analysis = {
            "check_type": "success_message",
            "screenshot": screenshot_path,
            "expected_message": expected_message,
            "prompt": f"""In this screenshot, verify a success state:
1. Is there a success message visible? (text containing "saved", "success", "completed", etc)
2. Is there a checkmark or success icon?
3. Is there a "✅" or green indicator?
{f'4. Specifically looking for: "{expected_message}"' if expected_message else ''}

Respond: success_visible, message_text, confidence_level"""
        }
        return analysis

    def verify_error_message(self, screenshot_path: str) -> Dict:
        """Check if any error messages are visible"""
        analysis = {
            "check_type": "error_detection",
            "screenshot": screenshot_path,
            "prompt": """In this screenshot, check for any errors:
1. Is there red text visible?
2. Error message or error icon?
3. "404" or "500" error?
4. "Access Denied" or "Permission" error?
5. Form validation errors?
6. Any warning/error toasts or alerts?

Respond: errors_detected, error_type, error_text, severity"""
        }
        return analysis

    def verify_form_fields(self, screenshot_path: str, expected_fields: List[str]) -> Dict:
        """Verify form fields are visible and in correct state"""
        analysis = {
            "check_type": "form_verification",
            "screenshot": screenshot_path,
            "expected_fields": expected_fields,
            "prompt": f"""In this screenshot, verify this form:
1. Form is visible and loaded?
2. Check for these fields: {', '.join(expected_fields)}
3. Are all fields visible?
4. Any missing fields?
5. Fields filled or empty as expected?

Respond: form_visible, fields_found, fields_missing, form_complete"""
        }
        return analysis

    def verify_modal_state(self, screenshot_path: str, should_be_open: bool = True) -> Dict:
        """Verify modal/popup is open or closed"""
        state = "open" if should_be_open else "closed"
        analysis = {
            "check_type": "modal_state",
            "screenshot": screenshot_path,
            "expected_state": state,
            "prompt": f"""In this screenshot, verify the modal state:
1. Is a modal/popup visible?
2. Is it {'open' if should_be_open else 'closed'}?
3. Can you see the close button (X or cancel)?
4. Is the modal blocking background content properly?

Respond: modal_visible, is_open, close_button_visible, state_correct"""
        }
        return analysis

    def verify_page_navigation(self, screenshot_path: str, expected_url: str) -> Dict:
        """Verify correct page is loaded"""
        analysis = {
            "check_type": "page_navigation",
            "screenshot": screenshot_path,
            "expected_url": expected_url,
            "prompt": f"""In this screenshot, verify page navigation:
1. What URL is visible in the address bar?
2. Does it match expected: {expected_url}?
3. What is the page title/heading?
4. Is the page fully loaded (no loading indicators)?

Respond: current_url, matches_expected, page_title, fully_loaded"""
        }
        return analysis

    def create_verification_report(self, analyses: List[Dict]) -> Dict:
        """Create a structured verification report"""
        report = {
            "timestamp": datetime.now().isoformat(),
            "total_checks": len(analyses),
            "analyses": analyses,
            "instruction": "Each analysis above should be performed by Claude Code using native vision capability on the screenshot files. Claude Code will read each screenshot and provide visual confirmation.",
            "next_steps": "1. Claude Code reads each screenshot path 2. Claude analyzes visual state 3. Claude reports findings 4. Verification script acts on findings"
        }
        return report

    def save_analysis_spec(self, analyses: List[Dict]):
        """Save analysis specifications for Claude Code to execute"""
        report = self.create_verification_report(analyses)

        with open(self.analysis_log, "w") as f:
            json.dump(report, f, indent=2)

        print(f"\n📋 Analysis specification saved: {self.analysis_log}")
        print(f"   Total checks to perform: {len(analyses)}")
        return report

    # ============================================================================
    # Integration Functions for Verification Scripts
    # ============================================================================

    def analyze_fix_1_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 1 (Map Loading) screenshot"""
        analyses = [
            self.verify_page_navigation(screenshot_path, "https://beardsandbucks.com/properties/"),
            self.verify_error_message(screenshot_path),
            {
                "check_type": "map_visible",
                "screenshot": screenshot_path,
                "prompt": "Verify the map is visible and loaded on this page. Look for: map container, map tiles, zoom controls, markers. Is the map rendering?"
            }
        ]
        return self.save_analysis_spec(analyses)

    def analyze_fix_2_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 2 (Add Listing) screenshot"""
        analyses = [
            self.verify_page_navigation(screenshot_path, "https://beardsandbucks.com/add-listing/"),
            self.verify_error_message(screenshot_path),
            self.verify_form_fields(screenshot_path, ["title", "description", "price", "location"])
        ]
        return self.save_analysis_spec(analyses)

    def analyze_fix_3_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 3 (Booking Module) screenshot"""
        analyses = [
            self.verify_page_navigation(screenshot_path, "https://beardsandbucks.com"),
            self.verify_error_message(screenshot_path),
            {
                "check_type": "booking_button_visible",
                "screenshot": screenshot_path,
                "prompt": "Verify the 'Book Now' button or booking widget is visible on this listing page."
            }
        ]
        return self.save_analysis_spec(analyses)

    def analyze_fix_4_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 4 (Login Modal) screenshot"""
        analyses = [
            self.verify_modal_state(screenshot_path, should_be_open=True),
            self.verify_form_fields(screenshot_path, ["email", "password"]),
            self.verify_error_message(screenshot_path)
        ]
        return self.save_analysis_spec(analyses)

    def analyze_fix_5_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 5 (Regions Field Removed) screenshot"""
        analyses = [
            self.verify_page_navigation(screenshot_path, "https://beardsandbucks.com/add-listing/"),
            {
                "check_type": "regions_field_absent",
                "screenshot": screenshot_path,
                "prompt": "Verify that the 'Regions' or 'Region' field is NOT visible on this Add Listing form. Check for absence of region dropdown, radio buttons, or field label."
            },
            self.verify_error_message(screenshot_path)
        ]
        return self.save_analysis_spec(analyses)

    def analyze_fix_6_screenshot(self, screenshot_path: str) -> Dict:
        """Analyze Fix 6 (Footer Links) screenshot"""
        analyses = [
            self.verify_page_navigation(screenshot_path, "https://beardsandbucks.com"),
            {
                "check_type": "footer_links_visible",
                "screenshot": screenshot_path,
                "prompt": "Verify footer contains legal links: 1. Look for 'Privacy Policy' link in footer 2. Look for 'Terms' or 'Terms & Conditions' link 3. Are links clickable (underlined or styled as links)?"
            }
        ]
        return self.save_analysis_spec(analyses)

    def print_usage(self):
        """Print usage instructions"""
        print("""
        Screenshot Analyzer - Claude Vision Integration

        Usage in Python:
        ----------------
        analyzer = ScreenshotAnalyzer()

        # For Fix 1 (Map)
        analyzer.analyze_fix_1_screenshot("/path/to/screenshot.png")

        # For Fix 2 (Add Listing)
        analyzer.analyze_fix_2_screenshot("/path/to/screenshot.png")

        # Custom analysis
        analyses = [
            analyzer.verify_button_clicked("screenshot.png", "Save Settings"),
            analyzer.verify_success_message("screenshot.png", "Settings saved"),
            analyzer.verify_error_message("screenshot.png")
        ]
        analyzer.save_analysis_spec(analyses)

        Usage in Bash:
        ---------------
        python3 screenshot_analyzer.py --fix 1 --screenshot /path/to/file.png
        python3 screenshot_analyzer.py --custom --check button_click --button "Save"
        """)


def main():
    """Command-line interface"""
    analyzer = ScreenshotAnalyzer()

    if len(sys.argv) < 2:
        analyzer.print_usage()
        sys.exit(0)

    import argparse

    parser = argparse.ArgumentParser(description="Analyze Antigravity screenshots using Claude vision")
    parser.add_argument("--fix", type=int, help="Fix number (1-6)")
    parser.add_argument("--screenshot", help="Path to screenshot file")
    parser.add_argument("--context", help="Context about the action taken")

    args = parser.parse_args()

    if args.fix and args.screenshot:
        if args.fix == 1:
            analyzer.analyze_fix_1_screenshot(args.screenshot)
        elif args.fix == 2:
            analyzer.analyze_fix_2_screenshot(args.screenshot)
        elif args.fix == 3:
            analyzer.analyze_fix_3_screenshot(args.screenshot)
        elif args.fix == 4:
            analyzer.analyze_fix_4_screenshot(args.screenshot)
        elif args.fix == 5:
            analyzer.analyze_fix_5_screenshot(args.screenshot)
        elif args.fix == 6:
            analyzer.analyze_fix_6_screenshot(args.screenshot)
        else:
            print(f"Unknown fix number: {args.fix}")
            sys.exit(1)
    else:
        analyzer.print_usage()
        sys.exit(1)


if __name__ == "__main__":
    main()
