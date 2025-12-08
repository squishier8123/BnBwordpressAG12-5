#!/usr/bin/env python3
import requests
import json
import base64

# Get credentials
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
except Exception as e:
    print(f"⚠️  Could not load credentials: {e}")
    print("   Proceeding without authentication (public data only).")
    headers = {
        "Content-Type": "application/json"
    }

base_url = "https://beardsandbucks.com"

print("=== CHECKING HOME 3 PAGE (ID: 4370) ===\n")

# Get the page
response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    page = response.json()

    print(f"Page Title: {page['title']['rendered']}")
    print(f"Page ID: {page['id']}")
    print(f"Status: {page['status']}")
    print(f"URL: {page['link']}\n")

    # Check content
    content = page.get('content', {}).get('rendered', '')

    print(f"Content Length: {len(content)} characters\n")

    if len(content) < 100:
        print("⚠️  Page has very little content (less than 100 characters)")
    else:
        print("✅ Page has content")

    # Check for Elementor data
    meta = page.get('meta', {})
    elementor_data = meta.get('_elementor_data', '')

    if elementor_data:
        print(f"\n✅ Elementor data found ({len(elementor_data)} characters)")

        # Try to parse it
        try:
            data = json.loads(elementor_data)
            print(f"   Elementor elements: {len(data)} items")

            if len(data) == 0:
                print("   ⚠️  WARNING: Elementor has no elements (page is empty)")
            else:
                print("   Elements found:")
                for i, element in enumerate(data[:5]):  # Show first 5
                    element_type = element.get('elType', 'unknown')
                    settings = element.get('settings', {})
                    title = settings.get('title', 'No title')
                    print(f"     {i+1}. {element_type}: {title}")
                if len(data) > 5:
                    print(f"     ... and {len(data) - 5} more elements")
        except:
            print("   Could not parse Elementor data")
    else:
        print("\n❌ No Elementor data found")

    # Check page revisions
    print("\n--- Checking for page revisions/backups ---\n")

    rev_response = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370/revisions",
        headers=headers,
        verify=False
    )

    if rev_response.status_code == 200:
        revisions = rev_response.json()
        print(f"Found {len(revisions)} revision(s):")

        for rev in revisions[:3]:  # Show first 3
            rev_id = rev['id']
            modified = rev['modified']
            print(f"  - Revision {rev_id} (Modified: {modified})")
    else:
        print(f"Could not fetch revisions: {rev_response.status_code}")

else:
    print(f"Error fetching page: {response.status_code}")
    print(response.text)
