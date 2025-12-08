#!/usr/bin/env python3
import requests
import json
import base64

# Get credentials
with open('/home/geoff25/.wordpress/wp-sites.json', 'r') as f:
    creds_list = json.load(f)
    creds = creds_list[0]
    username = creds.get('username', 'jeff')
    password = creds.get('password', '')

base_url = "https://beardsandbucks.com"
auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {
    "Authorization": f"Basic {auth_string}",
    "Content-Type": "application/json"
}

print("=== FINDING ALL REFERENCES TO 'VENDOR-TOOLS' ===\n")

# 1. Check menu items
print("1. Checking MENU ITEMS for 'vendor-tools'...\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/menu-items?per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    menu_items = response.json()
    found_vendor_tools = False

    for item in menu_items:
        url = item.get('url', '')
        if 'vendor-tools' in url.lower():
            found_vendor_tools = True
            print(f"❌ FOUND in Menu Item {item['id']}:")
            print(f"   Title: {item.get('title', {}).get('rendered', 'N/A')}")
            print(f"   URL: {url}")
            print()

    if not found_vendor_tools:
        print("✅ No menu items link to 'vendor-tools'")
else:
    print(f"Error querying menu items: {response.status_code}")

print("\n2. Checking all PAGES for 'vendor-tools' reference...\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages?per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    pages = response.json()
    found_in_pages = False

    for page in pages:
        # Check if page content contains vendor-tools link
        content = page.get('content', {}).get('rendered', '')

        if 'vendor-tools' in content.lower():
            found_in_pages = True
            print(f"❌ FOUND in Page: {page['title']['rendered']} (ID: {page['id']})")
            print(f"   Slug: {page['slug']}")
            # Find the specific link
            if 'vendor-tools' in content.lower():
                # Extract snippet
                idx = content.lower().find('vendor-tools')
                snippet = content[max(0, idx-50):idx+100]
                print(f"   Content snippet: ...{snippet}...")
            print()

    if not found_in_pages:
        print("✅ No page content references 'vendor-tools'")
else:
    print(f"Error querying pages: {response.status_code}")

print("\n3. Checking homepage HTML directly...\n")

homepage = requests.get(base_url, verify=False)
if homepage.status_code == 200:
    html_content = homepage.text

    if 'vendor-tools' in html_content.lower():
        print("❌ 'vendor-tools' found in homepage HTML")
        # Find all occurrences
        import re
        matches = re.finditer(r'vendor-tools', html_content, re.IGNORECASE)
        count = 0
        for match in matches:
            count += 1
            start = max(0, match.start() - 100)
            end = min(len(html_content), match.end() + 100)
            snippet = html_content[start:end]
            print(f"\n   Match #{count}:")
            print(f"   ...{snippet}...")
    else:
        print("✅ 'vendor-tools' NOT found in homepage HTML")
else:
    print(f"Error fetching homepage: {homepage.status_code}")

print("\n" + "="*50)
print("Summary: Where is /vendor-tools/ being referenced?")
print("="*50)
