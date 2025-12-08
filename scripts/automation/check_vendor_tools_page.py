#!/usr/bin/env python3
import requests
import json
import base64

# Get credentials
# Credentials loaded from local .env by Agent
username = "jeff"
password = "N0yN G2OM aRKT CZrm hIrq 88jG"

base_url = "https://beardsandbucks.com"
auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {
    "Authorization": f"Basic {auth_string}",
    "Content-Type": "application/json"
}

print("=== CHECKING VENDOR TOOLS PAGE ===\n")

# Search for pages with 'vendor' in title or slug
print("1. Searching for pages with 'vendor' in title/slug...\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages?search=vendor&per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    pages = response.json()
    if pages:
        print(f"Found {len(pages)} page(s) with 'vendor':\n")
        for page in pages:
            print(f"- ID: {page['id']}")
            print(f"  Title: {page['title']['rendered']}")
            print(f"  Slug: {page['slug']}")
            print(f"  Status: {page['status']}")
            print(f"  URL: {page['link']}")
            print()
    else:
        print("No pages found with 'vendor' in title.\n")
else:
    print(f"Error searching: {response.status_code}\n")

# Check if there's a page with slug 'vendor-tools'
print("2. Checking specifically for 'vendor-tools' slug...\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    pages = response.json()
    vendor_tools = None

    for page in pages:
        if page['slug'] == 'vendor-tools':
            vendor_tools = page
            break

    if vendor_tools:
        print(f"[OK] Found 'vendor-tools' page:")
        print(f"   ID: {vendor_tools['id']}")
        print(f"   Title: {vendor_tools['title']['rendered']}")
        print(f"   Status: {vendor_tools['status']}")
        print(f"   URL: {vendor_tools['link']}")
    else:
        print("[FAIL] No page with slug 'vendor-tools' exists")
else:
    print(f"Error: {response.status_code}\n")

# List all pages to see what exists
print("\n3. All published pages in the system:\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages?status=publish&per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    pages = response.json()
    print(f"Total published pages: {len(pages)}\n")
    for page in pages:
        print(f"- {page['title']['rendered']} (slug: {page['slug']}) [ID: {page['id']}]")
else:
    print(f"Error: {response.status_code}")
