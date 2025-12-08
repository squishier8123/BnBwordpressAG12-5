#!/usr/bin/env python3
import requests, json, base64, sys

username = "jeff"
password = "N0yN G2OM aRKT CZrm hIrq 88jG"
base_url = "https://beardsandbucks.com"

auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {"Authorization": f"Basic {auth_string}", "Content-Type": "application/json"}

print("="*60)
print("FIXING ADD LISTING BUTTON (Menu Item 4539)")
print("="*60 + "\n")

# Get current properties
print("Step 1: Getting current menu item properties...")
current = requests.get(f"{base_url}/wp-json/wp/v2/menu-items/4539", headers=headers, verify=False).json()
title = current.get('title', 'Add Listing')
menus = current.get('menus')
menu_order = current.get('menu_order', 4)
print(f"✓ Title: {title}\n  Menu ID: {menus}\n  Menu Order: {menu_order}\n")

# Delete with force=true
print("Step 2: Deleting old menu item (force=true)...")
delete_resp = requests.delete(f"{base_url}/wp-json/wp/v2/menu-items/4539?force=true", headers=headers, verify=False)
if delete_resp.status_code in [200, 204]:
    print(f"✓ Menu item deleted\n")
else:
    print(f"✗ Error: {delete_resp.status_code}\n{delete_resp.text[:200]}\n")
    sys.exit(1)

# Create new menu item with correct URL
print("Step 3: Creating new menu item with correct URL...")
new_data = {
    "title": "Add Listing",
    "url": "https://beardsandbucks.com/list-your-gear-8/",
    "menu_order": menu_order,
    "status": "publish",
    "menus": [menus] if isinstance(menus, int) else [menus]
}

create_resp = requests.post(f"{base_url}/wp-json/wp/v2/menu-items", json=new_data, headers=headers, verify=False)
if create_resp.status_code in [200, 201]:
    new_item = create_resp.json()
    new_id = new_item.get('id')
    print(f"✓ New menu item created\n  New ID: {new_id}\n")
else:
    print(f"✗ Error: {create_resp.status_code}\n{create_resp.text[:300]}\n")
    sys.exit(1)

# Verify
print("Step 4: Verifying fix...")
verify = requests.get(f"{base_url}/wp-json/wp/v2/menu-items/{new_id}", headers=headers, verify=False).json()
actual_url = verify.get('url')
if "list-your-gear" in actual_url:
    print(f"✅ SUCCESS!\n   New URL: {actual_url}\n   Menu item ID: {new_id}\n")
else:
    print(f"⚠️  URL: {actual_url}\n")

print("="*60)
print("Add Listing button fix complete!")
print("="*60)
