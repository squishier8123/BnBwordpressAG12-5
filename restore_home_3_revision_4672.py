#!/usr/bin/env python3
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

print("=== RESTORING HOME 3 PAGE FROM REVISION 4672 ===\n")

# Get the revision content
print("1. Fetching revision 4672 content...\n")

rev_response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370/revisions/4672",
    headers=headers,
    verify=False
)

if rev_response.status_code != 200:
    print(f"❌ Error fetching revision: {rev_response.status_code}")
    print(rev_response.text)
    exit(1)

revision = rev_response.json()
content = revision.get('content', {}).get('rendered', '')
title = revision.get('title', {}).get('rendered', '')

print(f"✅ Revision fetched successfully")
print(f"   Title: {title}")
print(f"   Content length: {len(content)} characters")
print(f"   Date: {revision.get('modified')}")
print()

# Restore by updating the page with revision content
print("2. Restoring page with revision content...\n")

update_data = {
    "content": content
}

update_response = requests.post(
    f"{base_url}/wp-json/wp/v2/pages/4370",
    json=update_data,
    headers=headers,
    verify=False
)

if update_response.status_code in [200, 201]:
    print(f"✅ Page updated successfully (Status: {update_response.status_code})")

    updated = update_response.json()
    print(f"   New content length: {len(updated.get('content', {}).get('rendered', ''))} characters")
    print()

    print("="*60)
    print("✅ HOME 3 PAGE RESTORED!")
    print("="*60)
    print("\nThe page content has been restored from revision 4672.")
    print("You should now see the full homepage content when you visit the site.")
    print("\nIf you don't see changes immediately:")
    print("- Clear your browser cache (Ctrl+Shift+Del)")
    print("- Clear any WordPress cache plugins")
    print("- Refresh the page")

else:
    print(f"❌ Error updating page: {update_response.status_code}")
    print(update_response.text[:500])
