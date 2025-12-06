# Beards & Bucks Homepage Analysis
**Date**: December 6, 2025
**Page ID**: 4370
**Page URL**: https://beardsandbucks.com/

## Page Overview
- **Title**: "Home 3"
- **Slug**: "home-3-2"
- **Last Modified**: 2025-12-05 06:37:47
- **Page Builder**: Elementor
- **Template**: Default

## Current CTA Structure

### 1. PRIMARY "Add Listing" CTAs

#### Navigation/Header CTA
- **Text**: "Add Listing"
- **URL**: `https://beardsandbucks.com/?page_id=4404`
- **Location**: Top navigation and footer
- **Status**: **BROKEN** - Returns 404 error

#### Pricing Section CTAs (3 instances)
Located in the pricing/packages section with three subscription tiers:

**Basic Plan (Free)**
- **Price**: $0.00 (30 days)
- **Button Text**: "Add Listing"
- **URL**: `/?add-to-cart=4475`
- **Action**: Adds WooCommerce product ID 4475 to cart

**Extended Plan**
- **Price**: $9.99 (one-time)
- **Button Text**: "Add Listing"
- **URL**: `/?add-to-cart=4474`
- **Action**: Adds WooCommerce product ID 4474 to cart

**Professional Plan**
- **Price**: $29.99/month
- **Button Text**: "Add Listing"
- **URL**: `/?add-to-cart=4473`
- **Action**: Adds WooCommerce product ID 4473 to cart

### 2. SECONDARY CTAs

**"Browse Our Listings"**
- **Location**: Hero section (main banner)
- **URL**: `#` (no destination - likely placeholder)
- **Context**: Call-to-action button in main banner below "Find Nearby" headline

**"Get Started"**
- **Location**: Streamline section
- **URL**: Not specified
- **Context**: General business/service pitch section

**"View Blog"**
- **URL**: `https://beardsandbucks.com/?page_id=616`
- **Location**: Blog section footer

**"Sign In"**
- **Action**: Opens sign-in modal dialog
- **Location**: Header and footer navigation

## Page Structure (Elementor Sections)

### Section 1: Hero Banner with Slider
- Image carousel with 2 slides (hunting imagery)
- Animated headline: "Find Nearby [Lodging / Archery shops / Outfitters]"
- Subheading: "Explore top-rated attractions, activities and more!"
- CTA: "Browse Our Listings" button (href="#")

### Section 2: Search Form
Dynamic search with:
- Keyword input field
- Location search with geolocation
- Category drilldown menu (16+ categories)
- Filter tabs for business types
- **Form Action**: `https://beardsandbucks.com/listings/`

### Section 3: Popular Categories Carousel
Display of listing categories with counts (most showing 0 listings)

### Section 4: Most Visited Places Carousel
Featured listings including:
- Premium Whitetail Guided Hunt Package ($15)
- Free Test Listing - Used Hunting Boots
- Test Approval Listing
- Various demo listings

### Section 5: Testimonials Section
Three customer testimonials with author photos

### Section 6: Browse by Category Grid
18-card grid showcasing all listing categories with folder icons

### Section 7: Pricing/Packages Section
**THIS IS WHERE THE WORKING "ADD LISTING" CTAS ARE**

Three pricing tiers with WooCommerce product integration:
- Professional: $29.99/month (Product ID: 4473)
- Extended: $9.99 one-time (Product ID: 4474)
- Basic: Free for 30 days (Product ID: 4475)

Each tier has an "Add Listing" button that adds the corresponding product to cart.

### Section 8: Blog Section
Three recent posts with images, dates, and "View Blog" link

## Key Findings

### ISSUE #1: Broken "Add Listing" Link in Navigation
- The primary "Add Listing" link in header/footer points to `/?page_id=4404`
- **This page returns a 404 error and does not exist**
- Users clicking this link get a "Page not found" error

### ISSUE #2: Placeholder Link in Hero Section
- "Browse Our Listings" button has `href="#"` (goes nowhere)
- Should probably link to `/listings/` page

### WORKING Flow:
The pricing section CTAs work by:
1. User clicks "Add Listing" under a pricing tier
2. Adds corresponding WooCommerce product to cart (4473, 4474, or 4475)
3. User proceeds through WooCommerce checkout
4. After purchase, user gains listing submission privileges

## Recommendations

### Fix #1: Update Navigation "Add Listing" Link
The broken `/?page_id=4404` link in navigation should be replaced with one of:

**Option A**: Link to pricing section on homepage
```
https://beardsandbucks.com/#pricing
```

**Option B**: Link to a dedicated listing submission page
```
https://beardsandbucks.com/submit-listing/
```
(You'll need to create this page if it doesn't exist)

**Option C**: Link to the listings packages page directly
```
https://beardsandbucks.com/listing-packages/
```

### Fix #2: Update "Browse Our Listings" Button
Change from `href="#"` to:
```
href="https://beardsandbucks.com/listings/"
```

### Fix #3: Verify WooCommerce Products
Ensure these product IDs exist and are properly configured:
- Product 4473 (Professional Plan - $29.99/month)
- Product 4474 (Extended Plan - $9.99 one-time)
- Product 4475 (Basic Plan - Free, 30 days)

## How to Fix in Elementor

### To fix the navigation link:
1. Log into WordPress admin
2. Go to Appearance > Menus
3. Find the "Add Listing" menu item
4. Update the URL from `/?page_id=4404` to your chosen option above
5. Save menu

### To fix the "Browse Our Listings" button:
1. Go to Pages > Edit "Home 3" (ID: 4370)
2. Click "Edit with Elementor"
3. Find the hero banner section (elementor-element-04ab070)
4. Click on the "Browse Our Listings" button
5. In the button settings, update the Link URL from `#` to `/listings/`
6. Update the page

## Technical Details

**Elementor Widget IDs**:
- Hero banner: `elementor-element-04ab070`
- Widget type: `listeo-homebanner-simple-slider`
- Container: `elementor-element-b3721c1`

**Search Form**:
- Form ID: `listeo_core-search-form`
- Form action: `https://beardsandbucks.com/listings/`
- Method: GET
- Categories: 16+ hunting/outdoor business categories

**Pricing Products**:
- Professional: `add-to-cart=4473`
- Extended: `add-to-cart=4474`
- Basic: `add-to-cart=4475`
