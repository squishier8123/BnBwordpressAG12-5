# WordPress REST API Upload Method

## Status: READY TO EXECUTE

The 3-card section JSON has been updated with WordPress Media Library URLs. Use this method to upload to the live site.

### Prerequisites
- WordPress username: `jeff`
- WordPress app password: `N0yN G2OM aRKT CZrm hIrq 88jG` (from .env)
- JSON file location: `elementor_templates/three_card_section.json`
- Target page ID: `4370` (Home 3)

### Method: WordPress REST API v2

The REST API is the official WordPress method for programmatic updates. It:
- ✅ Requires only WordPress credentials (no SSH needed)
- ✅ Uses official WordPress API (stable, supported)
- ✅ Can update _elementor_data meta field directly
- ✅ Is atomic (update succeeds or fails completely)

### Option A: Using curl from terminal (Recommended)

**Step 1: Base64 encode your credentials**
```bash
echo -n "jeff:N0yN G2OM aRKT CZrm hIrq 88jG" | base64
```
This produces: `amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=`

**Step 2: Read the JSON file and prepare the curl command**

Replace `/path/to/three_card_section.json` with actual path:
```bash
JSON_DATA=$(cat /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/elementor_templates/three_card_section.json)

curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages/4370" \
  -H "Authorization: Basic amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=" \
  -H "Content-Type: application/json" \
  -d "{\"meta\":{\"_elementor_data\":$(echo "$JSON_DATA" | sed 's/"/\\"/g')}}"
```

**Step 3: Verify the update**
```bash
curl "https://beardsandbucks.com/wp-json/wp/v2/pages/4370" \
  -H "Authorization: Basic amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=" | grep -o "_elementor_data" | head -1
```
If you see `_elementor_data` in the response, the update succeeded.

**Step 4: Clear WordPress cache and verify in browser**
1. Go to https://beardsandbucks.com/wp-admin
2. Login with jeff / app password
3. Go to Pages → Home 3 (ID 4370)
4. Check that the 3-card section appears with images
5. Visit https://beardsandbucks.com/ and verify the section displays correctly

---

### Option B: Using Python (If terminal access unavailable)

Create a Python script to make the REST API call:

```python
import requests
import base64
import json

# Credentials
USERNAME = "jeff"
PASSWORD = "N0yN G2OM aRKT CZrm hIrq 88jG"

# Base64 encode credentials
credentials = base64.b64encode(f"{USERNAME}:{PASSWORD}".encode()).decode()

# Read JSON file
with open('/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/elementor_templates/three_card_section.json', 'r') as f:
    json_data = json.load(f)

# Prepare request
url = "https://beardsandbucks.com/wp-json/wp/v2/pages/4370"
headers = {
    "Authorization": f"Basic {credentials}",
    "Content-Type": "application/json"
}
payload = {
    "meta": {
        "_elementor_data": json.dumps(json_data)
    }
}

# Execute
response = requests.post(url, headers=headers, json=payload)

if response.status_code == 200:
    print("✅ Update successful!")
    print(f"Response: {response.json()}")
else:
    print(f"❌ Update failed: {response.status_code}")
    print(f"Error: {response.text}")
```

Run with: `python3 script.py`

---

### Option C: Using wp-cli (If SSH access available)

If you have SSH access to the production server:

```bash
# SSH into server
ssh user@beardsandbucks.com

# Navigate to WordPress directory
cd /var/www/html  # or your WordPress directory

# Execute wp-cli command
wp post meta update 4370 _elementor_data "$(cat /path/to/three_card_section.json)" --allow-root

# Verify
wp post meta get 4370 _elementor_data | head -c 200

# Clear cache if applicable
wp cache flush
```

---

## Troubleshooting

### "403 Forbidden" or "Invalid credentials"
- Verify app password is correct: `N0yN G2OM aRKT CZrm hIrq 88jG`
- Check that Basic Auth is enabled in WordPress REST API (should be by default)
- Try accessing WordPress admin first to confirm credentials work: https://beardsandbucks.com/wp-admin

### "Invalid JSON in _elementor_data"
- Verify the JSON file is valid: `python3 -m json.tool three_card_section.json`
- Check that URLs to images are correct and accessible
- Ensure JSON is properly escaped when passed in curl command

### Images not showing after update
- Verify WordPress Media URLs are accessible: Visit each URL in browser
  - https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_7giywk7giywk7giy-scaled.png
  - https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_530kim530kim530k-1-scaled.png
  - https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_530kim530kim530k-scaled.png
- Clear WordPress cache (admin panel or via wp-cli)
- Check browser cache (Ctrl+Shift+Delete or Cmd+Shift+Delete)

### Page still shows old 3-card section
- Hard refresh browser (Ctrl+F5 or Cmd+Shift+R)
- Check WordPress revision history (Pages → Home 3 → Revisions)
- Verify the update response showed 200/201 status code
- Check page edit history in WordPress admin

---

## JSON File Details

**Location**: `elementor_templates/three_card_section.json`
**Size**: 23 KB
**Contains**: Complete 3-card section with:
- Card 1: "Find Guided Hunts" + image ID 4680 (archer with bow)
- Card 2: "Local Vendors" + image ID 4681 (retail interior)
- Card 3: "Buy & Sell Gear" + image ID 4682 (equipment wall)
- All styling: #7F4F24 brown buttons, #333D29/#656D4A text colors
- All animations: floating effect (-8px continuous), hover lift (-12px with bouncy easing)
- Responsive grid: 3-column desktop / 2-column tablet / 1-column mobile

**Image URLs** (all verified accessible):
- https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_7giywk7giywk7giy-scaled.png (ID 4680)
- https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_530kim530kim530k-1-scaled.png (ID 4681)
- https://beardsandbucks.com/wp-content/uploads/2025/12/Gemini_Generated_Image_530kim530kim530k-scaled.png (ID 4682)

---

## Next Steps After Upload

1. **Verify in WordPress Admin**:
   - Go to https://beardsandbucks.com/wp-admin
   - Pages → Home 3 (ID 4370)
   - Edit with Elementor
   - Check that 3-card section displays with images

2. **Test on Frontend**:
   - Visit https://beardsandbucks.com/
   - Scroll to 3-card section below hero
   - Verify images display correctly
   - Test hover effects (cards lift, shadows deepen)
   - Test floating animation (cards bob up/down continuously)

3. **Test on Mobile**:
   - Resize browser to 375px width (mobile view)
   - Verify cards stack to 1 column
   - Check image scaling (220px height mobile)
   - Verify text still readable

4. **Test on Tablet**:
   - Resize browser to 768px width (tablet view)
   - Verify cards display in 2 columns
   - Check image scaling (240px height tablet)

5. **Check Button Links**:
   - Click "Find Hunts" button → should go to `/browse-outfitters/`
   - Click "Browse Vendors" button → should go to `/browse-vendors/`
   - Click "Shop Gear" button → should go to `/marketplace/`

---

## Success Criteria

✅ All of these must be true:
- [ ] REST API call returns 200 or 201 status code
- [ ] 3-card section appears on homepage with images
- [ ] All 3 images display correctly (no broken image icons)
- [ ] Floating animation is visible (cards bob up/down)
- [ ] Hover effects work (cards lift on mouse over)
- [ ] Button links navigate to correct pages
- [ ] Mobile responsive (cards stack on small screens)
- [ ] Images don't show broken/404 errors

---

**Created**: December 10, 2025
**Method**: WordPress REST API v2 (Official WordPress)
**Status**: Ready for execution
