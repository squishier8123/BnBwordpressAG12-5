#!/usr/bin/env python3
"""
Restore Home 3 page (ID: 4370) from the best available revision (4682)
"""
import requests
import json
import base64
import sys

username = "jeff"
password = "N0yN G2OM aRKT CZrm hIrq 88jG"
base_url = "https://beardsandbucks.com"

auth_string = base64.b64encode(f"{username}:{password}".encode()).decode()
headers = {
    "Authorization": f"Basic {auth_string}",
    "Content-Type": "application/json"
}

print("="*60)
print("HOME 3 PAGE RESTORATION FROM REVISION 4682")
print("="*60)
print()

# Step 1: Get current page state
print("Step 1: Checking current page state...")
try:
    current = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370",
        headers=headers,
        verify=False
    ).json()
    
    current_len = len(current.get('content', {}).get('rendered', ''))
    print(f"✓ Current content length: {current_len} characters")
    print(f"  Last modified: {current.get('modified')}\n")
except Exception as e:
    print(f"❌ Error: {e}\n")
    sys.exit(1)

# Step 2: Get revision 4682 data
print("Step 2: Fetching revision 4682 data...")
try:
    rev_response = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370/revisions/4682",
        headers=headers,
        verify=False
    )
    
    if rev_response.status_code != 200:
        print(f"❌ Error fetching revision: {rev_response.status_code}")
        print(rev_response.text[:500])
        sys.exit(1)
    
    revision = rev_response.json()
    content = revision.get('content', {}).get('rendered', '')
    title = revision.get('title', {}).get('rendered', '')
    
    print(f"✓ Revision fetched successfully")
    print(f"  Title: {title}")
    print(f"  Content length: {len(content)} characters")
    print(f"  Modified: {revision.get('modified')}\n")
except Exception as e:
    print(f"❌ Error: {e}")
    sys.exit(1)

# Step 3: Update page with revision content
print("Step 3: Restoring page with full Elementor content...")
try:
    update_data = {
        "content": content
    }
    
    update_response = requests.post(
        f"{base_url}/wp-json/wp/v2/pages/4370",
        json=update_data,
        headers=headers,
        verify=False
    )
    
    if update_response.status_code not in [200, 201]:
        print(f"❌ Error updating page: {update_response.status_code}")
        print(update_response.text[:500])
        sys.exit(1)
    
    updated = update_response.json()
    new_content_len = len(updated.get('content', {}).get('rendered', ''))
    
    print(f"✓ Page updated successfully")
    print(f"  New content length: {new_content_len} characters")
    print(f"  Status: {updated.get('status')}")
    print(f"  Modified: {updated.get('modified')}\n")
    
except Exception as e:
    print(f"❌ Error: {e}")
    sys.exit(1)

# Step 4: Verify restoration
print("Step 4: Verifying restoration...")
try:
    verify_response = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370",
        headers=headers,
        verify=False
    )
    
    if verify_response.status_code == 200:
        verified = verify_response.json()
        verify_content_len = len(verified.get('content', {}).get('rendered', ''))
        
        if verify_content_len >= len(content) - 100:  # Allow small variance
            print(f"✅ RESTORATION SUCCESSFUL!\n")
            print(f"   Content restored: {current_len} → {verify_content_len} chars")
            print(f"   Size increase: +{verify_content_len - current_len} characters")
            print(f"   Page status: {verified.get('status')}")
            print(f"   Last modified: {verified.get('modified')}\n")
        else:
            print(f"⚠️  WARNING: Content length mismatch")
            print(f"   Expected: ~{len(content)} chars")
            print(f"   Got: {verify_content_len} chars")
    else:
        print(f"❌ Verification failed: {verify_response.status_code}")
        
except Exception as e:
    print(f"❌ Verification error: {e}")
    sys.exit(1)

print("="*60)
print("Home 3 page restoration process complete!")
print("="*60)
