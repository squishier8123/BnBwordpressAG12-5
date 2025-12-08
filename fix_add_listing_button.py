#!/usr/bin/env python3
import requests
import json
import base64

# Get credentials
# Get credentials
username = "jeff"
password = "N0yN G2OM aRKT CZrm hIrq 88jG"

base_url = "https://beardsandbucks.com"
auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {
    "Authorization": f"Basic {auth_string}",
    "Content-Type": "application/json"
}

print("=== FIXING ADD LISTING BUTTON (Menu Item 4539) ===\n")

menu_item_id = 4539
old_url = "/?page_id=4404"
new_url = "/list-your-gear-8/"

# 1. Get current menu item
print(f"1. Fetching current menu item {menu_item_id}...\n")

get_response = requests.get(
    f"{base_url}/wp-json/wp/v2/menu-items/{menu_item_id}",
    headers=headers,
    verify=False
)

if get_response.status_code != 200:
    print(f"❌ Error fetching menu item: {get_response.status_code}")
    print(get_response.text)
    exit(1)

current_item = get_response.json()
current_url = current_item.get('url', '')

print(f"Title: {current_item.get('title', {}).get('rendered', 'N/A')}")
print(f"Current URL: {current_url}")
print(f"Expected: {new_url}")
print()

if old_url in current_url or "page_id=4404" in current_url:
    print("✅ Confirmed: URL needs fixing\n")
else:
    print("⚠️  Warning: URL doesn't contain the broken page_id\n")

# 2. Update the menu item
print(f"2. Updating menu item to: {new_url}\n")

update_data = {
    "url": new_url
}

# Try with PUT first
put_response = requests.put(
    f"{base_url}/wp-json/wp/v2/menu-items/{menu_item_id}",
    json=update_data,
    headers=headers,
    verify=False
)

print(f"PUT request status: {put_response.status_code}")

if put_response.status_code in [200, 201]:
    print("✅ PUT request successful\n")
else:
    print(f"❌ PUT request failed: {put_response.text[:200]}\n")

# 3. Verify the update
print("3. Verifying update...\n")

verify_response = requests.get(
    f"{base_url}/wp-json/wp/v2/menu-items/{menu_item_id}",
    headers=headers,
    verify=False
)

if verify_response.status_code == 200:
    updated_item = verify_response.json()
    updated_url = updated_item.get('url', '')

    print(f"Title: {updated_item.get('title', {}).get('rendered', 'N/A')}")
    print(f"New URL: {updated_url}")
    print()

    if new_url in updated_url or updated_url == new_url:
        print("✅ SUCCESS: Menu item URL has been updated in WordPress!")
    else:
        print("⚠️  WARNING: URL updated in API but may not reflect on frontend yet")
        print("   This could be due to caching. Try clearing:")
        print("   - WordPress cache plugins (WP Super Cache, W3 Total Cache)")
        print("   - Browser cache (Ctrl+Shift+Del)")
        print("   - CloudFlare cache if applicable")
else:
    print(f"❌ Error verifying update: {verify_response.status_code}")

print("\n" + "="*50)
print("Fix complete. Run test to verify on live site.")
print("="*50)
