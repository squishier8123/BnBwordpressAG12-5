#!/usr/bin/env python3
"""
Extract Elementor metadata for page 4370 to understand the structure
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

print("=== CHECKING ELEMENTOR METADATA ===\n")

# Get page with Elementor meta
response = requests.get(
    f"{base_url}/wp-json/wp/v2/pages/4370?context=edit",
    headers=headers,
    verify=False
)

if response.status_code == 200:
    page = response.json()
    
    print("Page Information:")
    print(f"  ID: {page.get('id')}")
    print(f"  Title: {page.get('title', {}).get('rendered')}")
    print(f"  Status: {page.get('status')}")
    print()
    
    # Check for Elementor meta
    meta = page.get('meta', {})
    print("Meta Fields:")
    if meta:
        for key, value in meta.items():
            if 'elementor' in key.lower():
                if isinstance(value, str):
                    val_preview = value[:100] + "..." if len(value) > 100 else value
                    print(f"  {key}: {val_preview}")
                else:
                    print(f"  {key}: {value}")
    else:
        print("  (no meta fields)")
    
    print()
    print("Content type detection:")
    content = page.get('content', {}).get('rendered', '')
    if 'data-elementor' in content:
        print("  ✓ Elementor content detected")
    if '[' in content and ']' in content:
        print("  ✓ Shortcodes detected")
    if '<' in content:
        print("  ✓ HTML content detected")
        
else:
    print(f"Error: {response.status_code}")
    print(response.text[:500])
