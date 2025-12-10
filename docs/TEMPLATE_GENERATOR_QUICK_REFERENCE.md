# Elementor Template Generator - Quick Reference

**Status**: Ready to use
**Created**: December 10, 2025
**Templates Available**: 4 (Cards, Hero, Features, Testimonials)

## One-Liner: Generate Any Template

```bash
cd elementor_templates
python3 elementor_template_advanced.py --template cards
python3 elementor_template_advanced.py --template hero
python3 elementor_template_advanced.py --template features
python3 elementor_template_advanced.py --template testimonials
```

## Generated Files

| Template | File | Size | Use Case |
|----------|------|------|----------|
| Cards | `three_card_section.json` | 17 KB | 3-card CTA (hunts/vendors/gear) |
| Hero | `hero_section.json` | 5.9 KB | Large hero with image + title + CTA |
| Features | `feature_grid.json` | 18 KB | 6-feature grid (3 columns) |
| Testimonials | `testimonial_grid.json` | 11 KB | Customer testimonials (3 columns) |

## Workflow

### Step 1: Generate Template
```bash
python3 elementor_template_advanced.py --template cards
```

### Step 2: Verify JSON is Valid
```bash
python3 -m json.tool three_card_section.json > /dev/null && echo "✓ Valid"
```

### Step 3: Import to WordPress via REST API
```bash
CREDS=$(echo -n 'jeff:PASSWORD' | base64)

curl -X POST https://beardsandbucks.com/wp-json/wp/v2/elementor_library \
  -H "Authorization: Basic $CREDS" \
  -H "Content-Type: application/json" \
  -d @three_card_section.json
```

### Step 4: Use in Elementor
1. Edit page with Elementor
2. Left panel → Templates tab
3. Search "3-Card" or template name
4. Drag onto canvas
5. Edit content/links/colors as needed
6. Save & Publish

## Customization

### Change Card Text/Links
Edit `elementor_template_advanced.py`, update the card data dict:

```python
cards = [
    {
        "image_id": 4680,
        "title": "Your Title",
        "description": "Your description",
        "button_text": "Your Button",
        "button_url": "/your-url/",
        "button_color": "#7F4F24"
    }
]
```

Then regenerate:
```bash
python3 elementor_template_advanced.py --template cards
```

### Change Colors
Use brand color constants:

```python
TemplateBuilder.BRAND_COLORS["secondary_dark_brown"]   # #7F4F24
TemplateBuilder.BRAND_COLORS["secondary_light"]        # #A4AC86
TemplateBuilder.BRAND_COLORS["primary_dark"]           # #414833
# ... all others available
```

### Add/Remove Cards
Modify the `cards` list in the `generate_template()` function. Must have 3 cards for 3-card template.

### Create Custom Template
Use the `TemplateBuilder` class in your own script:

```python
from elementor_template_advanced import TemplateBuilder, ElementorSection, ElementorRow, ElementorColumn
from elementor_template_advanced import ElementorHeading, ElementorText, ElementorButton, ElementorImage

# Your custom logic
section = ElementorSection("#F5F5F5", "40")
# ... add content
```

## Why This Works Better Than Manual JSON

| Task | Before | After |
|------|--------|-------|
| Create 3-card section | Edit 500+ lines of JSON | Run 1 command, edit 5 lines |
| Update all button colors | Find/replace, risky | Change 1 color hex |
| Add new card | Copy/paste structure, error-prone | Add 5 lines to list |
| Test layout changes | Upload JSON, reload page | Regenerate, test locally |
| Version control | Huge JSON diffs | Clean Python code diffs |

## Available Templates Breakdown

### Cards Template
- 3-column layout (responsive)
- Card: Image + Title + Description + Button
- Floats and hovers animated
- Brand colors applied
- **Usage**: Homepage CTA section, service overview, feature highlights

### Hero Template
- Full-width section with image on right
- Large title + subtitle + CTA button
- 50/50 layout (text left, image right)
- Min height 70vh
- **Usage**: Section headers, feature introductions, campaign landing pages

### Features Template
- 3-column grid (configurable)
- Optional icon/image + title + description
- Staggered animation
- Gray background
- **Usage**: 6-feature overview, service highlights, value propositions

### Testimonials Template
- 3-column card layout
- Quote + author + role
- Subtle shadows and rounded corners
- **Usage**: Social proof, customer success stories, reviews

## Advanced Customization

### Multi-row Cards
Modify `create_three_card_section()` to support more cards:

```python
@staticmethod
def create_three_card_section(cards, bg_color="#F5F5F5"):
    section = ElementorSection(bg_color, "40")

    # Split into rows of 3
    for row_idx in range(0, len(cards), 3):
        row = ElementorRow()
        for card in cards[row_idx:row_idx+3]:
            # ... add card to row
        section.add_row(row)

    return [section.to_dict()]
```

### Custom Animations
Add to widget settings:

```python
widget.settings["animation"] = "slideInLeft"
widget.settings["animation_delay"] = "0.2"
widget.settings["animation_duration"] = "1000"
```

### Conditional Styling
Add responsive column widths:

```python
col.settings["column_size"] = "50%"  # Desktop
col.settings["_column_size_tablet"] = "100%"  # Tablet
col.settings["_column_size_mobile"] = "100%"  # Mobile
```

## Troubleshooting

### JSON Import Fails
```bash
# Verify JSON syntax
python3 -m json.tool three_card_section.json

# Check file size (must be < 1 MB for REST API)
wc -c three_card_section.json

# Try importing via Elementor GUI instead
# WordPress Admin → Pages → Edit with Elementor → Templates panel
```

### Images Don't Show After Import
- Image IDs (4680, 4681, 4682) must exist in WordPress Media Library
- Verify Media URLs are accessible
- Re-import template after uploading images to WordPress

### Colors Look Wrong
- Ensure you're using exact hex codes from `BRAND_COLORS` dict
- Check color is valid hex format (#RRGGBB)
- Verify browser cache isn't serving old version

## Files in This Directory

```
elementor_templates/
├── elementor_template_builder.py       # Basic template builder (17 KB)
├── elementor_template_advanced.py      # Advanced multi-template builder (CLI)
├── three_card_section.json             # Generated 3-card template
├── hero_section.json                   # Generated hero template
├── feature_grid.json                   # Generated features template
├── testimonial_grid.json               # Generated testimonials template
├── three_card_component.zip            # Legacy (old method)
└── README.md                           # Setup guide
```

## Next Steps

1. **Test One Template**: Generate cards, verify JSON, import to WordPress
2. **Customize**: Edit card text/links, regenerate, test on live page
3. **Create More**: Use advanced builder to generate other template types
4. **Version Control**: Commit Python scripts (not JSON files) to Git

## Git Workflow

```bash
# Track the generator scripts (not the JSON output)
git add elementor_template_builder.py elementor_template_advanced.py
git commit -m "feat: Add local Elementor template generator

- Create valid Elementor JSON without WordPress plugins
- Support for 4 template types (cards, hero, features, testimonials)
- Brand colors and responsive design built-in
- Can generate templates offline and import via REST API"

git push
```

## Support

**Generator Script Docs**: See `ELEMENTOR_TEMPLATE_BUILDER_GUIDE.md`
**Elementor Official Docs**: https://developers.elementor.com/
**Python Source Code**: Fully documented in both `.py` files

---

**Key Benefit**: Complete autonomy to generate, customize, and deploy Elementor templates without any WordPress plugins, UI interactions, or manual JSON editing.
