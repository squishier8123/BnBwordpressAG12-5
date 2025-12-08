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

print("=== DIAGNOSING MENU ITEM 4539 ===\n")

# Get full menu item details
response = requests.get(
    f"{base_url}/wp-json/wp/v2/menu-items/4539",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    item = response.json()

    print("Menu Item Details:")
    print(f"  ID: {item.get('id')}")
    print(f"  Title: {item.get('title', {}).get('rendered')}")
    print(f"  Status: {item.get('status')}")
    print(f"  URL: {item.get('url')}")
    print(f"  Type: {item.get('type')}")
    print(f"  Type label: {item.get('type_label')}")
    print(f"  Parent: {item.get('parent')}")
    print(f"  Menu order: {item.get('menu_order')}")
    print(f"  Description: {item.get('description')}")
    print()

    # Check meta fields
    meta = item.get('meta', {})
    if meta:
        print("Meta fields:")
        for key, value in meta.items():
            print(f"  {key}: {value}")
    else:
        print("No special meta fields found")

    print("\n" + "="*50)
    print("Full JSON Response:")
    print("="*50)
    print(json.dumps(item, indent=2))

else:
    print(f"Error: {response.status_code}")
    print(response.text)
