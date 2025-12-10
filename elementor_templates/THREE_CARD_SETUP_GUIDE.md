# Three Card Section - Setup Guide

## What You Have

**File**: `three_card_section.json`

**Contents**:
- 3-card responsive grid layout
- Card images (placeholders for your 3 images)
- Titles, descriptions, buttons
- Floating animation effect (cards gently bob up and down)
- Hover effects (cards lift up 12px, shadows deepen, buttons change color)
- Brand colors (#7F4F24 orange buttons, #333D29 text)

---

## How to Use in WordPress

### Step 1: Upload Images to WordPress Media Library

1. Go to **WordPress Admin** → **Media** → **Add New**
2. Upload these 3 images:
   - **Image 1**: Archer with compound bow (FIND GUIDED HUNTS)
   - **Image 2**: Archery equipment on wall (BUY & SELL GEAR)
   - **Image 3**: Retail store interior (LOCAL VENDORS)
3. Note the **Image IDs** for each (shown in Media Library)

### Step 2: Import the Template in Elementor

1. Go to the page where you want this section (homepage or directory page)
2. Click **Edit with Elementor**
3. In the left panel, click **Templates** icon
4. Click **Import Templates**
5. Upload or paste the JSON content from `three_card_section.json`
6. Drag the template onto your page

### Step 3: Update Image URLs in Elementor

After importing:
1. Click on **Card 1** (left card)
2. Select the **image widget** inside
3. Click the image → **Change Image**
4. Select **Image 1** (Archer with bow) from Media Library
5. Repeat for **Card 2** and **Card 3** with their respective images

### Step 4: Verify Links (Optional)

Each button links to:
- **Find Hunts** → `/browse-outfitters/`
- **Browse Vendors** → `/browse-vendors/`
- **Shop Gear** → `/marketplace/`

Update these URLs if your actual pages are different.

### Step 5: Save & Publish

Click **Save** and **Publish**

---

## What Happens on Hover

**Cards**:
- Lift up 12px smoothly
- Shadow deepens (more dramatic)
- Text and image stay sharp

**Buttons**:
- Color changes from `#7F4F24` → `#936639` (darker brown)
- Shadow grows
- Lifts up slightly

**Continuous Animation**:
- Cards gently float up/down (infinite loop)
- Creates premium, polished feel

---

## Customization Options

### Change Button Colors
1. Select a button
2. Click button settings in Elementor
3. Change **Background Color**
4. Change **Hover Color** in CSS

### Change Card Titles
1. Click the title text
2. Edit in Elementor

### Change Descriptions
1. Click the description text
2. Edit in Elementor

### Adjust Animation Speed
In custom CSS, change `3s` to faster/slower:
```css
animation: float 3s ease-in-out infinite;
```
- `2s` = faster
- `4s` = slower

### Remove Floating Animation
Delete this from custom CSS:
```css
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-8px); }
}
```

---

## Mobile Responsive

The cards automatically stack on mobile:
- **Desktop**: 3 cards side-by-side (33% width each)
- **Tablet**: 2 cards + 1 card below
- **Mobile**: 1 card per row

All hover effects still work on touch devices.

---

## Troubleshooting

**Images not showing?**
- Verify images are uploaded to WordPress Media Library
- Check image IDs match in template
- Try uploading manually in Elementor

**Cards not floating?**
- Make sure custom CSS is enabled in Elementor
- Check browser console for CSS errors
- Try refreshing page

**Buttons not changing color on hover?**
- Custom CSS might be disabled
- Try adding `!important` to button colors

---

## File Locations

- **JSON Template**: `/elementor_templates/three_card_section.json`
- **Images**: `/NewLogo/extracted_images/`
  - `Gemini_Generated_Image_7giywk7giywk7giy.png` (Archer)
  - `Gemini_Generated_Image_530kim530kim530k (1).png` (Gear equipment)
  - `Gemini_Generated_Image_530kim530kim530k.png` (Store interior)

---

## Next Steps

1. Upload the 3 images to WordPress Media
2. Import the JSON template in Elementor
3. Update image IDs/URLs
4. Verify links point to correct pages
5. Test on desktop and mobile
6. Save & Publish

Done! Your floating card section is ready.
