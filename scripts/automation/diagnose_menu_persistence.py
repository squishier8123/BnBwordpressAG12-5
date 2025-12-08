#!/usr/bin/env python3
"""
Diagnose why menu item 4539 URL update returns 200 but doesn't persist
"""
import requests
import json
import base64

username = "jeff"
password = "N0yN G2OM aRKT CZrm hIrq 88jG"
base_url = "https://beardsandbucks.com"

auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {
    "Authorization": f"Basic {auth_string}",
    "Content-Type": "application/json"
}

print("=== MENU ITEM 4539 PERSISTENCE DIAGNOSIS ===\n")

# Get current state
print("1. Current menu item 4539 state (before update):")
r1 = requests.get(f"{base_url}/wp-json/wp/v2/menu-items/4539", headers=headers, verify=False).json()
print(f"   URL: {r1.get('url')}")
print(f"   Type: {r1.get('type')}")
print(f"   Status: {r1.get('status')}")

# Try updating with different methods
print("\n2. Attempting update with POST request...")
update_data = {"url": "/list-your-gear-8/"}
r2 = requests.post(f"{base_url}/wp-json/wp/v2/menu-items/4539", json=update_data, headers=headers, verify=False)
print(f"   Status code: {r2.status_code}")
result = r2.json()
print(f"   Response URL: {result.get('url')}")

# Verify immediately
print("\n3. Verification (GET after POST):")
r3 = requests.get(f"{base_url}/wp-json/wp/v2/menu-items/4539", headers=headers, verify=False).json()
actual_url = r3.get('url')
print(f"   Actual URL in DB: {actual_url}")
print(f"   Update persisted: {'YES' if actual_url == '/list-your-gear-8/' else 'NO'}")

# Check if there are custom post meta fields blocking updates
print("\n4. Checking for custom fields/meta that might block updates:")
r4 = requests.get(f"{base_url}/wp-json/wp/v2/menu-items/4539?context=edit", headers=headers, verify=False).json()
meta = r4.get('meta', {})
if meta:
    print(f"   Meta fields found: {list(meta.keys())}")
    for k, v in meta.items():
        if 'url' in k.lower() or 'link' in k.lower():
            print(f"     {k}: {v}")
else:
    print(f"   No meta fields")

# Check if there's a custom menu plugin
print("\n5. Checking WordPress environment:")
site_context = requests.get(f"{base_url}/wp-json/wp/v2/", headers=headers, verify=False).json()
print(f"   WordPress version: {site_context.get('description', 'unknown')}")

print("\n=== DIAGNOSIS COMPLETE ===")
