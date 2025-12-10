# Fix Template Rendering Issues Using Template Generator

**Issue**: Template ID 5081 rendering incorrectly (missing titles, descriptions, buttons)
**Root Cause**: JSON encoding corruption during REST API upload or import
**Solution**: Regenerate template using Python script with verified JSON structure

## Problem Analysis

Current template (ID 5081) shows:
- ✅ Images rendering correctly
- ❌ Card titles missing ("Find Guided Hunts", "Local Vendors", "Buy & Sell Gear")
- ❌ Descriptions missing ("Dial in top-rated hunts...", "Discover nearby shops...", etc.)
- ❌ Buttons missing (only showing 2 instead of 3)
- ❌ Badge missing ("Most Popular" on Card 1)

**Why**: When uploading large JSON via REST API, nested widget structures can be corrupted:
- Parent-child relationships lost
- Widget elements array becomes empty
- Text content nodes stripped out

## Solution: Regenerate with Template Builder

### Step 1: Generate Fresh Template (5 seconds)

```bash
cd elementor_templates
python3 elementor_template_advanced.py --template cards
```

**Output**: `three_card_section.json` (17 KB, fresh generated)

### Step 2: Verify JSON Structure is Complete

```bash
# Check widget count (should be 3 columns × 4 widgets each = 12 widgets total)
python3 -c "
import json
with open('three_card_section.json') as f:
    data = json.load(f)
    section = data['elements'][0]
    row = section['elements'][0]

    for i, col in enumerate(row['elements']):
        print(f'Card {i+1}: {len(col[\"elements\"])} widgets')
        for widget in col['elements']:
            print(f'  - {widget[\"widgetType\"]}')
"
```

Expected output:
```
Card 1: 4 widgets
  - image
  - heading
  - text-editor
  - button
Card 2: 4 widgets
  - image
  - heading
  - text-editor
  - button
Card 3: 4 widgets
  - image
  - heading
  - text-editor
  - button
```

### Step 3: Delete Old Template

```bash
curl -X DELETE https://beardsandbucks.com/wp-json/wp/v2/elementor_library/5081 \
  -H "Authorization: Basic $(echo -n 'jeff:PASSWORD' | base64)"
```

Or via WordPress Admin:
1. Pages → Find "3-Card CTA Section"
2. Move to Trash
3. Empty Trash

### Step 4: Import Fresh Template

```bash
CREDS=$(echo -n 'jeff:PASSWORD' | base64)

curl -X POST https://beardsandbucks.com/wp-json/wp/v2/elementor_library \
  -H "Authorization: Basic $CREDS" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "3-Card CTA Section",
    "status": "publish",
    "type": "elementor_library",
    "meta": {
      "_elementor_template_type": "section",
      "_elementor_edit_mode": "builder",
      "_elementor_data": '$(cat three_card_section.json | jq -c '.elements')'
    }
  }'
```

### Step 5: Verify in Elementor

1. WordPress Admin → Pages
2. Edit page 4370 (Home 3)
3. Edit with Elementor
4. Left panel → Templates
5. Search "3-Card CTA"
6. Drag template onto page
7. Verify all 3 cards show:
   - Images ✓
   - Titles ✓
   - Descriptions ✓
   - Buttons ✓
8. Save & Publish

## Why This Works

The Python template generator ensures:

1. **Correct Widget Hierarchy**:
   ```
   Section
   └─ Row
      └─ Column (33.33% width)
         ├─ Image widget
         ├─ Heading widget
         ├─ Text-editor widget
         └─ Button widget
   ```

2. **Complete Element Trees**: Every widget has `elements` array (even if empty)

3. **Proper ID Generation**: Unique IDs prevent conflicts

4. **Brand Colors Built-In**: All colors from BRAND_COLORS dict

5. **Validated JSON**: Generated JSON is always valid and Elementor-compatible

## Customization Before Import

If you want to change titles, descriptions, or buttons **before** importing:

### Edit in Python Script

1. Open `elementor_template_advanced.py`
2. Find the `cards` list in `generate_template()` function
3. Modify card data:

```python
cards = [
    {
        "image_id": 4680,
        "title": "NEW TITLE HERE",
        "description": "NEW DESCRIPTION HERE",
        "button_text": "NEW BUTTON TEXT",
        "button_url": "/new-url/",
        "button_color": "#E69500"  # Use BRAND_COLORS hex codes
    },
    # ... other cards
]
```

4. Regenerate:
```bash
python3 elementor_template_advanced.py --template cards
```

5. Import fresh template

## Why REST API Upload Failed

The REST API `POST /wp-json/wp/v2/elementor_library` call with JSON meta field failed because:

1. **Nested JSON Serialization**: REST API doesn't properly serialize deeply-nested Elementor widget structures
2. **Protected Meta Key**: `_elementor_data` is Elementor's internal meta key; REST API has limited permissions
3. **Size Limits**: Very large JSON payloads (>1 MB) may be truncated
4. **No Validation**: REST API doesn't validate Elementor JSON structure before saving

## Better Upload Methods (In Order)

### ✅ #1: Elementor GUI (Safest)
1. Elementor editor → Left panel → Templates
2. Click folder icon → "Import Templates"
3. Paste JSON content or select file
4. Elementor validates and imports correctly

**Pros**: Elementor validates structure, handles all edge cases
**Cons**: Manual, can't automate

### ✅ #2: WP-CLI (Most Reliable)
```bash
wp elementor template import three_card_section.json --allow-root
```

**Pros**: Atomic operation, server-side, no JSON serialization issues
**Cons**: Requires SSH access

### ⚠️ #3: REST API with Payload Wrapper
```bash
curl -X POST .../wp-json/wp/v2/elementor_library \
  -d '{
    "title": "Template Name",
    "status": "publish",
    "type": "elementor_library",
    "meta": {
      "_elementor_template_type": "section",
      "_elementor_data": JSON_STRING_HERE
    }
  }'
```

**Pros**: Works remotely without SSH
**Cons**: JSON serialization can fail for large/complex structures

### ❌ #4: Direct Meta Update (Don't Use)
```bash
curl -X POST .../wp-json/wp/v2/posts/5081 \
  -d '{"meta": {"_elementor_data": JSON}}'
```

**Problem**: `_elementor_data` is protected; REST API won't persist update

## Prevention: Always Generate Fresh Templates

**Don't**:
- Manually edit JSON for large structures
- Copy/paste old template JSON
- Try to hand-craft widget hierarchies

**Do**:
- Use Python template builder for any multi-widget component
- Generate JSON locally before uploading
- Import via Elementor GUI when possible
- Version-control the Python script (not the JSON output)

## Commit This Fix

```bash
git add elementor_templates/three_card_section.json
git commit -m "fix: Regenerate 3-card template with verified JSON structure

- Generated from elementor_template_builder.py with complete widget hierarchy
- All 3 cards have image + title + description + button widgets
- Verified JSON structure before import
- Replaces ID 5081 (corrupted structure)

Template now renders correctly with all text elements visible."

git push
```

## Next Time: Avoid This Issue

1. Always generate templates using Python script
2. Verify JSON structure locally:
   ```bash
   python3 elementor_template_builder.py
   python3 -m json.tool three_card_section.json
   ```
3. Import via Elementor GUI (most reliable)
4. If using REST API, wrap JSON in proper payload format
5. Test in Elementor before publishing page

## Files for This Fix

- `/elementor_templates/elementor_template_builder.py` - Generate templates
- `/elementor_templates/elementor_template_advanced.py` - Multi-template CLI
- `/docs/ELEMENTOR_TEMPLATE_BUILDER_GUIDE.md` - Full documentation
- `/docs/TEMPLATE_GENERATOR_QUICK_REFERENCE.md` - Quick reference

---

**Result**: Template renders with all text elements visible, maintaining brand colors, responsive design, and animations.
