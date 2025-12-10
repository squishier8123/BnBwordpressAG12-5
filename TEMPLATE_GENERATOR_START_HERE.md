# Elementor Template Generator - START HERE

**TL;DR**: You now have a Python system that generates correct Elementor JSON templates locally.

## What This Is

Two Python scripts that create properly-structured Elementor templates without:
- Manual JSON editing
- WordPress plugins
- REST API serialization issues
- Copy/paste errors

## Get Started (2 minutes)

### 1. List Available Templates
```bash
cd elementor_templates
python3 elementor_template_advanced.py --list
```

Output:
```
Available templates:
  cards        - 3-card CTA section (hunts/vendors/gear)
  hero         - Full-width hero section
  features     - 3x2 feature grid
  testimonials - Testimonial cards
```

### 2. Generate a Template
```bash
python3 elementor_template_advanced.py --template cards
```

Creates: `three_card_section.json` (17 KB)

### 3. Import to WordPress

**Option A: Elementor GUI (Easiest)**
1. WordPress Admin → Pages → Edit with Elementor
2. Left panel → Templates tab
3. Click folder icon → "Import Templates"
4. Open `three_card_section.json`
5. Click Import

**Option B: REST API (if you know curl)**
```bash
CREDS=$(echo -n 'jeff:PASSWORD' | base64)
curl -X POST https://beardsandbucks.com/wp-json/wp/v2/elementor_library \
  -H "Authorization: Basic $CREDS" \
  -H "Content-Type: application/json" \
  -d @three_card_section.json
```

### 4. Use Template
1. Edit any page with Elementor
2. Left panel → Templates
3. Search "3-Card CTA"
4. Drag onto page
5. Save & Publish

**Done!** Template renders with all text, images, buttons.

## Customizing Templates

### Change Card Titles/Descriptions
1. Open `elementor_template_advanced.py`
2. Find `cards = [` in the code (around line 250)
3. Update titles, descriptions, button text
4. Regenerate: `python3 elementor_template_advanced.py --template cards`
5. Re-import template

### Change Button Colors
Same file, change hex codes in card data:
```python
"button_color": "#7F4F24"  # Brown
# or
"button_color": "#E69500"  # Orange
```

## Available Templates

| Name | Description | Use Case |
|------|-------------|----------|
| **cards** | 3-card section (image + title + description + button) | Homepage CTA, feature overview |
| **hero** | Large section with title, subtitle, CTA, image | Section header, landing page |
| **features** | 6-feature grid (3 columns) | Service overview, value props |
| **testimonials** | 3 customer testimonials | Social proof, reviews |

## Why This Works Better

| Task | Old Way | New Way |
|------|---------|---------|
| Create 3-card section | Edit 500 lines of JSON | Run 1 command |
| Change button color | Find/replace in JSON | Edit 1 hex code, regenerate |
| Fix template errors | Delete and recreate | Regenerate from Python |
| Add/remove cards | Manual copy/paste | Edit list, regenerate |
| Version control | Huge JSON diffs | Clean Python code diffs |

## Files You Need

```
elementor_templates/
├── elementor_template_builder.py        ← Main builder (don't edit unless extending)
├── elementor_template_advanced.py       ← What you run
├── three_card_section.json              ← Generated (import to WordPress)
├── hero_section.json                    ← Generated
├── feature_grid.json                    ← Generated
└── testimonial_grid.json                ← Generated
```

## Documentation

- **Quick Start**: This file (you're reading it)
- **Detailed Guide**: `docs/ELEMENTOR_TEMPLATE_BUILDER_GUIDE.md`
- **Troubleshooting**: `docs/FIX_TEMPLATE_RENDERING_GUIDE.md`
- **Complete Overview**: `docs/TEMPLATE_SYSTEM_SUMMARY.md`
- **Quick Reference**: `docs/TEMPLATE_GENERATOR_QUICK_REFERENCE.md`

## Common Issues

### "Template doesn't show images after import"
→ Verify image IDs (4680, 4681, 4682) exist in WordPress Media Library

### "JSON import fails"
→ Try Elementor GUI instead of REST API (more reliable)

### "I want different text on the cards"
→ Edit Python script, regenerate, re-import

### "Can I use different colors?"
→ All brand colors available in `BRAND_COLORS` dict in Python script

## Need Help?

- **How to generate a template**: Read this file
- **How to customize templates**: `TEMPLATE_GENERATOR_QUICK_REFERENCE.md`
- **How to fix broken templates**: `FIX_TEMPLATE_RENDERING_GUIDE.md`
- **Complete API reference**: `ELEMENTOR_TEMPLATE_BUILDER_GUIDE.md`

## One-Minute Commands

```bash
# Generate all templates at once
cd elementor_templates
for t in cards hero features testimonials; do
  python3 elementor_template_advanced.py --template $t
done

# Verify all JSON is valid
for f in *.json; do
  python3 -m json.tool "$f" > /dev/null && echo "✓ $f" || echo "✗ $f"
done

# See file sizes
ls -lh *.json
```

---

**Next**: Go to `docs/TEMPLATE_GENERATOR_QUICK_REFERENCE.md` for more details.

**Or**: Just run `python3 elementor_template_advanced.py --template cards` and import it!
