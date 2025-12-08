#!/usr/bin/env python3
"""
Apply CSS Contrast Fixes to WordPress
Adds custom CSS to fix WCAG AA accessibility issues
"""

import requests
import json
import sys
from pathlib import Path

# WordPress credentials
WP_URL = "https://beardsandbucks.com"
WP_USERNAME = "jeff"
WP_APP_PASSWORD = "N0yN G2OM aRKT CZrm hIrq 88jG"

# Read CSS fixes
css_file = Path("css-contrast-fixes.css")
if not css_file.exists():
    print("❌ Error: css-contrast-fixes.css not found")
    sys.exit(1)

with open(css_file, 'r') as f:
    css_content = f.read()

print("=" * 70)
print("APPLYING CSS CONTRAST FIXES TO WORDPRESS")
print("=" * 70)
print(f"\n📄 CSS File: {css_file}")
print(f"📊 CSS Size: {len(css_content)} bytes")
print(f"\nAttempting to add custom CSS to WordPress...")

# Try Method 1: Update custom_css option
print("\n[Method 1] Updating custom_css option...")
try:
    response = requests.post(
        f"{WP_URL}/wp-json/wp/v2/settings",
        auth=(WP_USERNAME, WP_APP_PASSWORD),
        json={"custom_css": css_content},
        headers={"Content-Type": "application/json"},
        timeout=10,
        verify=False
    )

    if response.status_code in [200, 201]:
        print("✅ SUCCESS! CSS added via custom_css option")
        print(f"Response: {response.status_code}")
        sys.exit(0)
    else:
        print(f"⚠️  Status {response.status_code}")
        print(f"Response: {response.text[:200]}")
except Exception as e:
    print(f"❌ Error: {e}")

# Try Method 2: Update theme_mods
print("\n[Method 2] Attempting to update theme modification...")
try:
    # Get current theme mods
    response = requests.get(
        f"{WP_URL}/wp-json/wp/v2/settings",
        auth=(WP_USERNAME, WP_APP_PASSWORD),
        timeout=10,
        verify=False
    )

    if response.status_code == 200:
        settings = response.json()
        print(f"✅ Retrieved settings")

        # Update with custom CSS
        update_data = {
            "custom_css": css_content
        }

        response = requests.post(
            f"{WP_URL}/wp-json/wp/v2/settings",
            auth=(WP_USERNAME, WP_APP_PASSWORD),
            json=update_data,
            timeout=10,
            verify=False
        )

        if response.status_code in [200, 201]:
            print("✅ SUCCESS! CSS updated")
            sys.exit(0)
except Exception as e:
    print(f"❌ Error: {e}")

# Try Method 3: Create as custom CSS file in uploads
print("\n[Method 3] Creating custom CSS file in uploads...")
try:
    import base64

    # Prepare file content
    file_data = {
        "file": base64.b64encode(css_content.encode()).decode(),
        "name": "custom-contrast-fixes.css"
    }

    response = requests.post(
        f"{WP_URL}/wp-json/wp/v2/media",
        auth=(WP_USERNAME, WP_APP_PASSWORD),
        files={"file": css_content.encode()},
        timeout=10,
        verify=False
    )

    if response.status_code in [200, 201]:
        print("✅ CSS file uploaded")
        print(f"Response: {response.json().get('source_url', 'Unknown')}")
except Exception as e:
    print(f"❌ Error: {e}")

print("\n" + "=" * 70)
print("❌ Could not apply CSS automatically")
print("\nManual Alternative:")
print("1. Log in to WordPress admin (https://beardsandbucks.com/wp-admin)")
print("2. Go to Appearance > Customize > Additional CSS")
print("3. Paste the content of css-contrast-fixes.css")
print("4. Click Publish")
print("\nOR")
print("1. Go to plugins > Add New")
print("2. Upload the CSS as a code snippet plugin")
print("=" * 70)
sys.exit(1)
