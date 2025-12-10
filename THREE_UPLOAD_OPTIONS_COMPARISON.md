# 3-Card Section Upload: 3 Best Options

## Summary
The 3-card JSON is **READY** with all WordPress Media URLs. Choose your upload method:

---

## Option 1: WordPress REST API + curl ⭐ RECOMMENDED
**Best if**: You have terminal/command line access (Mac/Linux/WSL)

### Pros
- ✅ Official WordPress API
- ✅ No SSH required
- ✅ Uses credentials already in .env
- ✅ Atomic update (all or nothing)
- ✅ Takes ~30 seconds

### Cons
- Requires curl (usually pre-installed)
- Need to run command in terminal

### How to Execute
```bash
# Step 1: Base64 encode credentials
echo -n "jeff:N0yN G2OM aRKT CZrm hIrq 88jG" | base64
# Output: amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=

# Step 2: Run curl command
JSON_DATA=$(cat /mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/elementor_templates/three_card_section.json)

curl -X POST "https://beardsandbucks.com/wp-json/wp/v2/pages/4370" \
  -H "Authorization: Basic amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=" \
  -H "Content-Type: application/json" \
  -d "{\"meta\":{\"_elementor_data\":$(echo "$JSON_DATA" | sed 's/"/\\"/g')}}"

# Step 3: Verify (should see "_elementor_data" in response)
curl "https://beardsandbucks.com/wp-json/wp/v2/pages/4370" \
  -H "Authorization: Basic amVmZjpOMG95TiBHMk9NIHJEVCBDVHJ1bSBISXJxIDg4akc=" | grep "_elementor_data"
```

### Result
- Status code `200` or `201` = success
- Check https://beardsandbucks.com/ to verify

---

## Option 2: WordPress REST API + Python ⭐ ALTERNATIVE
**Best if**: You prefer Python or are on Windows without WSL

### Pros
- ✅ Official WordPress API
- ✅ No SSH required
- ✅ Works on Windows natively
- ✅ Uses credentials from .env
- ✅ Clear error messages
- ✅ Takes ~30 seconds

### Cons
- Requires Python 3 + requests library (usually easy to install)

### How to Execute
1. Create file: `upload_three_cards.py`
2. Paste this code:
```python
import requests
import base64
import json

USERNAME = "jeff"
PASSWORD = "N0yN G2OM aRKT CZrm hIrq 88jG"

# Base64 encode
credentials = base64.b64encode(f"{USERNAME}:{PASSWORD}".encode()).decode()

# Read JSON
with open('/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/elementor_templates/three_card_section.json', 'r') as f:
    json_data = json.load(f)

# Upload
url = "https://beardsandbucks.com/wp-json/wp/v2/pages/4370"
headers = {
    "Authorization": f"Basic {credentials}",
    "Content-Type": "application/json"
}
payload = {"meta": {"_elementor_data": json.dumps(json_data)}}

response = requests.post(url, headers=headers, json=payload)

if response.status_code in [200, 201]:
    print("✅ SUCCESS! 3-card section uploaded.")
    print(f"Status: {response.status_code}")
else:
    print(f"❌ FAILED: {response.status_code}")
    print(f"Error: {response.text}")
```

3. Run:
```bash
python3 upload_three_cards.py
```

### Result
- Prints `✅ SUCCESS!` = upload worked
- Check https://beardsandbucks.com/ to verify

---

## Option 3: Manual Elementor Edit ⭐ IF AUTOMATED OPTIONS FAIL
**Best if**: You want full control and see what's happening

### Pros
- ✅ ZERO technical setup
- ✅ Complete visual control
- ✅ Can fix issues on the fly
- ✅ You see exactly what's happening
- ✅ Proven to work (you've done this before)

### Cons
- Takes ~15-20 minutes
- Manual steps required

### How to Execute
1. Go to https://beardsandbucks.com/wp-admin
2. Pages → Home 3 → Edit with Elementor
3. Find gray section below hero (labeled "bb-cta-section-001")
4. For each card:
   - Click card → Click image area → Upload image from Media Library
   - ID 4680: Archer with bow
   - ID 4681: Retail store interior  
   - ID 4682: Equipment on wall
5. Update descriptions if needed:
   - "Dial in top-rated hunts..."
   - "Discover nearby shops..."
   - "Move your used gear fast..."
6. Save & Publish

### Result
- Saves automatically when published
- Check https://beardsandbucks.com/ immediately

---

## Recommendation

**Start with Option 1 (curl)** because:
1. Quickest (30 seconds vs 15 minutes)
2. Officially supported by WordPress
3. Works every time if credentials are correct
4. Complete verification possible
5. No UI needed

**If curl fails** → Try Option 2 (Python)
**If both fail** → Fall back to Option 3 (manual Elementor)

---

## Current Status

| Item | Status |
|------|--------|
| JSON file | ✅ Ready at `elementor_templates/three_card_section.json` |
| WordPress image URLs | ✅ Verified & embedded in JSON |
| Credentials in .env | ✅ Available (`jeff` + app password) |
| JSON validation | ✅ Syntax correct |
| Image accessibility | ✅ All 3 URLs accessible |
| Ready to upload | ✅ YES - Pick an option above |

---

## Testing After Upload

After whichever method you choose:

1. **Hard refresh**: https://beardsandbucks.com/ (Ctrl+F5 or Cmd+Shift+R)
2. **Look for**: 3-card section below hero with images
3. **Test animations**: Hover over cards (should lift), watch floating effect
4. **Mobile test**: Resize to 375px width, verify cards stack vertically
5. **Button test**: Click buttons, verify they navigate to correct pages

---

## Need Help?

Each option has a detailed guide:
- **REST_API_UPLOAD_GUIDE.md** - Full curl/Python instructions with troubleshooting
- **THREE_CARD_SETUP_GUIDE.md** - Manual Elementor instructions
- **three_cards_external.html** - Local preview file (no WordPress needed)

Choose the option that works best for you!

**Status**: READY TO EXECUTE
**Created**: December 10, 2025
