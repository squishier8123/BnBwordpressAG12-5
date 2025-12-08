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

print("=== FINDING REVISIONS FOR HOME 3 PAGE (ID: 4370) ===\n")

# Get all revisions
response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370/revisions?per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    revisions = response.json()

    if not revisions:
        print("❌ No revisions found for this page")
    else:
        print(f"Found {len(revisions)} revision(s):\n")

        for i, rev in enumerate(revisions):
            rev_id = rev['id']
            modified = rev['modified']
            author = rev.get('author_name', 'Unknown')

            print(f"{i+1}. Revision ID: {rev_id}")
            print(f"   Date: {modified}")
            print(f"   Author: {author}")

            # Check content length
            content = rev.get('content', {}).get('rendered', '')
            print(f"   Content length: {len(content)} characters")

            if len(content) > 10000:
                print(f"   ✅ This revision has substantial content")
            else:
                print(f"   ⚠️  This revision has minimal content")

            print()

        print("="*60)
        print("RESTORATION INSTRUCTIONS:")
        print("="*60)
        print("\nTo restore the page from a previous revision:")
        print("\n1. Go to WordPress Admin > Pages")
        print("2. Find 'Home 3' page (ID: 4370)")
        print("3. Click on it to edit")
        print("4. Look for 'Revisions' section (usually on the right)")
        print("5. Click on the revision with the most content")
        print("6. Click 'Restore This Revision'")
        print("\nOr we can restore it programmatically.")
        print("\nWhich revision ID would you like to restore?")
        print("Look for the one with the largest content length.")

else:
    print(f"❌ Error fetching revisions: {response.status_code}")
    print(response.text)
