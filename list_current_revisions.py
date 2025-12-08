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

print("=== CHECKING CURRENT REVISIONS FOR HOME 3 (ID: 4370) ===\n")

response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370/revisions?per_page=100",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    revisions = response.json()
    print(f"Found {len(revisions)} revision(s):\n")
    
    for i, rev in enumerate(revisions, 1):
        rev_id = rev.get('id')
        modified = rev.get('modified')
        content_len = len(rev.get('content', {}).get('rendered', ''))
        
        print(f"{i}. Revision ID: {rev_id}")
        print(f"   Modified: {modified}")
        print(f"   Content length: {content_len} chars")
        print()
else:
    print(f"Error: {response.status_code}")
    print(response.text)
