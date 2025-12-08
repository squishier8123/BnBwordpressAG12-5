#!/usr/bin/env python3
"""
Restore Home 3 page Elementor data from revision 4682
This requires updating the _elementor_data meta field
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
print("ELEMENTOR DATA RESTORATION FROM REVISION 4682")
print("="*60)
print()

# Step 1: Get revision 4682 with Elementor meta
print("Step 1: Fetching revision 4682 Elementor metadata...")
try:
    rev_response = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370/revisions/4682?context=edit",
        headers=headers,
        verify=False
    )
    
    if rev_response.status_code != 200:
        print(f"❌ Error: {rev_response.status_code}")
        print(rev_response.text[:500])
        sys.exit(1)
    
    revision = rev_response.json()
    meta = revision.get('meta', {})
    elementor_data = meta.get('_elementor_data', None)
    
    if not elementor_data:
        print("❌ No _elementor_data found in revision")
        sys.exit(1)
    
    print(f"✓ Revision meta fetched")
    if isinstance(elementor_data, str):
        print(f"  Elementor data length: {len(elementor_data)} characters")
    else:
        print(f"  Elementor data is {type(elementor_data).__name__}")
    print()
    
except Exception as e:
    print(f"❌ Error: {e}")
    sys.exit(1)

# Step 2: Update current page with Elementor meta
print("Step 2: Updating page with Elementor metadata...")
try:
    update_data = {
        "meta": {
            "_elementor_data": elementor_data,
            "_elementor_edit_mode": "builder",
            "_elementor_template_type": "wp-page"
        }
    }
    
    update_response = requests.post(
        f"{base_url}/wp-json/wp/v2/pages/4370",
        json=update_data,
        headers=headers,
        verify=False
    )
    
    if update_response.status_code not in [200, 201]:
        print(f"❌ Error: {update_response.status_code}")
        print(update_response.text[:500])
        sys.exit(1)
    
    updated = update_response.json()
    print(f"✓ Page meta updated")
    print(f"  Status: {updated.get('status')}")
    print(f"  Modified: {updated.get('modified')}\n")
    
except Exception as e:
    print(f"❌ Error: {e}")
    sys.exit(1)

# Step 3: Verify restoration
print("Step 3: Verifying Elementor data restoration...")
try:
    verify_response = requests.get(
        f"{base_url}/wp-json/wp/v2/pages/4370?context=edit",
        headers=headers,
        verify=False
    )
    
    if verify_response.status_code == 200:
        verified = verify_response.json()
        verify_meta = verified.get('meta', {})
        verify_elementor = verify_meta.get('_elementor_data', None)
        
        if verify_elementor:
            print(f"✅ ELEMENTOR DATA RESTORED!\n")
            if isinstance(verify_elementor, str):
                print(f"   Data length: {len(verify_elementor)} characters")
            else:
                print(f"   Data type: {type(verify_elementor).__name__}")
            print(f"   Edit mode: {verify_meta.get('_elementor_edit_mode')}")
            print(f"   Template type: {verify_meta.get('_elementor_template_type')}")
            print(f"\n   Next: Clear cache and reload the page to see changes")
        else:
            print(f"⚠️  WARNING: Elementor data not found in verification")
    else:
        print(f"❌ Verification failed: {verify_response.status_code}")
        
except Exception as e:
    print(f"❌ Verification error: {e}")
    sys.exit(1)

print()
print("="*60)
print("Elementor data restoration complete!")
print("="*60)
