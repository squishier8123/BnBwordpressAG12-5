#!/usr/bin/env python3
import requests
import json
import base64

try:
    with open('/home/geoff25/.wordpress/wp-sites.json', 'r') as f:
        creds_list = json.load(f)
        creds = creds_list[0]
        username = creds.get('username', 'jeff')
        password = creds.get('password', '')

    auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
    headers = {
        "Authorization": f"Basic {auth_string}",
        "Content-Type": "application/json"
    }
except:
    headers = {"Content-Type": "application/json"}

base_url = "https://beardsandbucks.com"

print("=== HOME 3 PAGE RAW CONTENT ===\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    page = response.json()
    content = page.get('content', {}).get('rendered', '')

    print(f"Total content length: {len(content)} characters\n")
    print("First 2000 characters:\n")
    print(content[:2000])
    print("\n...\n")
    print("Last 1000 characters:\n")
    print(content[-1000:])

    # Check what kind of content it is
    print("\n" + "="*50)
    print("Content Type Analysis:")
    print("="*50)

    if '<!-- wp:' in content:
        print("✅ Gutenberg blocks detected (WordPress native blocks)")

    if '[elementor-pro' in content or 'elementor' in content.lower():
        print("✅ Elementor shortcodes detected")

    if '<div class="elementor' in content:
        print("✅ Elementor HTML detected")

    if 'data-elementor' in content:
        print("✅ Elementor attributes detected")

    if content.startswith('<!--') or '<!--' in content[:100]:
        print("✅ HTML comments at start (likely page builder markup)")

    if '<style' in content:
        print("✅ Inline styles found")

    if 'display:none' in content or 'visibility:hidden' in content:
        print("⚠️  WARNING: Hidden content found!")

    # Count elements
    div_count = content.count('<div')
    span_count = content.count('<span')
    p_count = content.count('<p')

    print(f"\nHTML Element counts:")
    print(f"  <div> tags: {div_count}")
    print(f"  <span> tags: {span_count}")
    print(f"  <p> tags: {p_count}")

else:
    print(f"Error: {response.status_code}")
