# BEARDS & BUCKS — COMPLETE ARCHITECTURE PLAN
**Date**: December 7, 2025
**Status**: Active Planning Phase
**Last Updated**: 2025-12-07

---

## TABLE OF CONTENTS
1. [Quick Reference](#quick-reference)
2. [Platform Overview](#platform-overview)
3. [Two-System Architecture](#two-system-architecture)
4. [Current Site Structure (28 Pages)](#current-site-structure-28-pages)
5. [Missing Pages Analysis](#missing-pages-analysis)
6. [Recommended Page Structure](#recommended-page-structure)
7. [Listeo Platform Details](#listeo-platform-details)
8. [Dokan Platform Details](#dokan-platform-details)
9. [Integration Requirements](#integration-requirements)
10. [Setup Checklist](#setup-checklist)
11. [Next Steps](#next-steps)

---

## QUICK REFERENCE

**Site Purpose**: Premium online platform for Illinois whitetail deer hunting ecosystem

**Two Core Functions**:
1. **Directory** — Find hunting outfitters and local vendors (Listeo)
2. **Used Gear Marketplace** — Buy/sell archery and hunting gear (Dokan + WooCommerce)

**Key Constraints**:
- NO firearms anywhere on site
- Whitetail deer only (no other animals)
- Compound bows featured prominently
- No business sellers in used gear marketplace (individuals only)

**Active Homepage**: Home 3 (ID: 4370)

---

## PLATFORM OVERVIEW

### SITE TECHNOLOGY STACK
- **Core Platform**: WordPress
- **Directory System**: Listeo (WordPress Theme)
- **Marketplace System**: Dokan (Multi-vendor WooCommerce plugin)
- **Page Builder**: Elementor
- **MCP Integration**: Elementor MCP (for page building automation)
- **Additional**: Respira WordPress MCP (for safe AI editing)

### KEY CREDENTIALS & ENDPOINTS
- **Site URL**: https://beardsandbucks.com
- **WordPress User**: jeff
- **MCP Servers Active**:
  - elementor-mcp (WP_URL, WP_APP_USER, WP_APP_PASSWORD)
  - respira-wordpress-mcp (RESPIRA_SITE_URL, RESPIRA_API_KEY)

---

## TWO-SYSTEM ARCHITECTURE

### SYSTEM 1: LISTEO (Directory & Listings)

**What It Does**:
- Manages listings for services/experiences (not products)
- Handles booking systems
- Manages vendor profiles and ratings
- Provides search, filtering, and map functionality
- Supports user reviews and messaging

**Key Features** (from Listeo docs):
- User-friendly front-end dashboard for listing management
- Built-in booking system with QR code check-ins
- Multiple listing styles and views
- Map support (Google, Bing, Mapbox, OpenStreetMap)
- Multi-criteria user ratings
- Private messaging between users
- Statistics page with performance graphs
- Elementor page builder integration

**Monetization Model**:
- Vendor subscription tiers (Free, Pro packages)
- Featured placement, listing badges, photo slots

**Pages Managed by Listeo**:
- Home/Landing
- Search results
- Single listing details
- Vendor/user dashboard
- Add/edit listing forms
- User registration

---

### SYSTEM 2: DOKAN (Multi-Vendor WooCommerce Marketplace)

**What It Does**:
- Turns WordPress into Amazon/eBay-like multi-vendor marketplace
- Manages product inventory, orders, payments, commissions
- Provides vendor store fronts
- Handles withdrawal/payment systems
- Manages commissions and earnings reports

**Key Features** (from Dokan docs):
- Unlimited vendors with unlimited products each
- Vendor dashboard with 6 main sections:
  - Products (inventory management)
  - Orders (sales management)
  - Coupons (vendor can create promotions)
  - Reports (sales analytics)
  - Reviews (customer feedback)
  - Store Settings (store customization, SEO, withdrawal methods)
- Advanced shipping options
- Multiple payment gateways (Stripe, PayPal, Razorpay, etc.)
- Withdrawal system with minimum amount thresholds
- Store hours and opening/closing times
- Social media integration
- 40+ premium modules available

**Monetization Model**:
- Admin sets commission rates (global, vendor-specific, category-specific, or product-specific)
- Admin collects commission on each product sale
- Vendors withdraw earnings after reaching minimum threshold

**Pages Required by Dokan**:
- Store Dashboard (admin-controlled page with [dokan-dashboard] shortcode)
- Store Listings (admin-controlled page with [dokan-stores] shortcode)
- WooCommerce product pages (standard)
- Customer order/account pages

**Product Form Customization** (Critical for your used gear):
- Can add custom fields via hooks, code, or ACF for Dokan PRO
- Supported field types: Text, Textarea, Number, URL, Select, Checkbox, Radio, File, Email, WYSIWYG, Gallery, Repeater, Taxonomy, Google Map
- Examples: Condition (Excellent/Good/Needs Tune), Bow Type, Brand, Year, Price, Condition Details

---

## CURRENT SITE STRUCTURE (28 Pages)

### EXISTING PAGES BREAKDOWN

#### Core Directory/Listing Pages
- **Directory** (ID: 4094) — Main listings search/browse ✓
- **Vendors** (ID: 4192) — Vendor directory ✓
- **Vendor Dashboard** (ID: 4246) — Vendor management ✓
- **Vendor Dashboard – Listings** (ID: 4248) — Vendor listing management ✓
- **Vendor Dashboard – Add Listing** (ID: 4250) — Create/edit listings ✓
- **Vendor Detail** (ID: 4091) — Single vendor/outfitter page ✓

#### User Account Pages
- **Account/Dashboard** (ID: 4098) — Individual user account area ✓
- **My Dashboard** (ID: 4638) — Account management (may be duplicate of 4098)
- **Register as Buyer** (ID: 4621) — Buyer registration ✓
- **Register as Vendor** (ID: 4622) — Vendor registration ✓

#### Marketplace Pages
- **Used Gear** (ID: 4101) — Used gear section/hub ✓
- **List Your Gear** (ID: 4090) — CTA for gear sellers ✓
- **Alerts/Wishlist** (ID: 4085) — Saved items feature ✓
- **Referral/Credits** (ID: 4088) — Loyalty/referral system ✓

#### Marketing/Brand Pages
- **Home 3** (ID: 4370) — **ACTIVE HOMEPAGE** ✓
- **About Us** (ID: 4619) — Brand mission/story ✓
- **How It Works** (ID: 4095) — Step-by-step guide ✓
- **How It Works** (ID: 4662) — Duplicate—consolidate ⚠️
- **FAQ** (ID: 4102) — Common questions ✓
- **Join Beards & Bucks** (ID: 4620) — Onboarding CTA ✓
- **Why Choose Beards & Bucks** (ID: 4664) — Value proposition ✓
- **Contact** (ID: 4092) — Contact form ✓

#### Legal/Policy Pages
- **Terms and Conditions** (ID: 4617) — Legal ✓
- **Privacy Policy** (ID: 4618) — Legal ✓

#### Location & Browse Pages
- **Popular Categories** (ID: 4663) — Category showcase ✓
- **Store List** (ID: 4546) — Vendor list (purpose unclear) ⚠️

#### Default WordPress
- **Sample Page** (ID: 2) — Default WordPress page—remove ❌

---

## MISSING PAGES ANALYSIS

### CRITICAL GAPS (Tier 1 — Business Impact)

1. **Browse by County Page** (LISTEO)
   - What: Grid or map of central Illinois counties (Peoria, Fulton, Mason, Schuyler, Brown, Cass, Tazewell, Logan, etc.)
   - Why: Essential for local discovery—users want to find hunts in their specific county
   - Status: **MISSING** ❌

2. **Vendor Pricing/Tiers Page** (LISTEO)
   - What: Display Free vs. Pro packages with benefits visualization
   - Benefits shown: More photo slots, featured placement, map pin priority, listing badges, larger listing space
   - Why: Drives monetization—vendors need to understand subscription value
   - Status: **MISSING** ❌

3. **Dokan Store Dashboard Page** (DOKAN)
   - What: Page with template "dashboard" and shortcode [dokan-dashboard]
   - Why: REQUIRED by Dokan for vendor management
   - Status: **VERIFY IF EXISTS** ⚠️

4. **Dokan Store Listings Page** (DOKAN)
   - What: Page with shortcode [dokan-stores] showing all gear sellers
   - Why: REQUIRED by Dokan for marketplace discovery
   - Status: **VERIFY IF EXISTS** ⚠️

### IMPORTANT GAPS (Tier 2 — Enhancement)

5. **Single Gear Listing Detail Page** (DOKAN/WooCommerce)
   - What: Custom template for individual used gear listing (different from vendor directory listing)
   - Why: Marketplace items need different fields/layout than directory services
   - Fields: Price, Condition (Excellent/Good/Needs Tune), Bow Type, Brand, Year, Seller Rating, etc.
   - Status: May exist as WooCommerce default template, needs customization ⚠️

6. **Gear Category Pages** (DOKAN)
   - What: Browse by gear type—Bows, Packs, Optics, Boots, Accessories, etc.
   - Why: Better UX for marketplace navigation
   - Status: **Can use WooCommerce category pages or create custom** ⚠️

7. **Seller Profile Page** (DOKAN)
   - What: Public-facing profile for individual gear sellers (separate from vendor profiles)
   - Why: Builds trust in used gear marketplace—shows seller rating, past sales, etc.
   - Status: **MISSING** ❌

### NICE-TO-HAVE (Tier 3 — Brand Building)

8. **Blog/Resources Section**
   - What: Hunting content, gear reviews, whitetail hunting tips
   - Why: Drives SEO, email capture, engagement
   - Status: **MISSING** ❌

9. **Testimonials/Success Stories Page**
   - What: Hunter success stories, case studies from outfitter bookings
   - Why: Social proof and trust building
   - Status: **MISSING** ❌

10. **Gallery/Photo Journal Page**
    - What: Curated hunting moments, gear photos
    - Why: Visual engagement, brand storytelling
    - Status: **MISSING** ❌

---

## RECOMMENDED PAGE STRUCTURE

### LISTEO-POWERED PAGES (Directory for Hunts & Services)

```
HOME TIER
├─ Home 3 (4370) — ACTIVE HOMEPAGE
│  └─ Hero: Illinois whitetail buck, search, featured outfitters, gear carousel, CTAs

SEARCH & DISCOVERY
├─ Directory (4094) — Search results for vendor listings
├─ Browse by County [NEW] — Central Illinois county grid/map
└─ Popular Categories (4663) — Category showcase

VENDOR LISTING PAGES
├─ Vendor Detail (4091) — Single outfitter/vendor details, reviews, booking
├─ Vendors (4192) — Directory of all vendors
└─ Add/Edit Listing Form (4250) — Vendor create/edit listing

VENDOR MANAGEMENT
├─ Vendor Dashboard (4246) — Main vendor dashboard
├─ Vendor Dashboard – Listings (4248) — Manage their listings
└─ Vendor Dashboard – Add Listing (4250) — Create new listing

PRICING & MONETIZATION
└─ Vendor Pricing/Tiers [NEW] — Free vs. Pro packages with benefits

USER/BUYER PAGES
├─ Register as Buyer (4621) — Buyer signup
├─ Account/Dashboard (4098) — Saved listings, bookings, messages
└─ My Dashboard (4638) — [VERIFY — may be duplicate]

VENDOR ONBOARDING
└─ Register as Vendor (4622) — Vendor signup flow
```

### DOKAN-POWERED PAGES (Marketplace for Used Gear)

```
GEAR MARKETPLACE TIER
├─ Used Gear (4101) — Marketplace hub/landing
├─ Store Listings [REQUIRED] — [dokan-stores] showing all gear sellers
│  └─ Browse individual seller stores
└─ Browse by Gear Category [RECOMMENDED] — Bows, Packs, Optics, Boots, Accessories

VENDOR MANAGEMENT (Gear Sellers)
├─ Store Dashboard [REQUIRED] — [dokan-dashboard] for seller product management
│  ├─ Products — Manage gear inventory
│  ├─ Orders — Sales management
│  ├─ Coupons — Promotions
│  ├─ Reports — Sales analytics
│  ├─ Reviews — Customer feedback
│  └─ Store Settings — Withdrawal, hours, description
└─ Seller Profile Page [NEW] — Public-facing gear seller profile

INDIVIDUAL PRODUCT PAGES
├─ Single Gear Listing (WooCommerce) — Individual item details
└─ Shopping Cart — Standard WooCommerce
```

### SHARED/BRAND PAGES

```
BRAND PAGES
├─ About Us (4619) — Mission, story, Illinois focus
├─ How It Works (4095 or 4662) — [CONSOLIDATE] Three-step guide: Book Hunts, Buy/Sell Gear, Find Local Pros
├─ FAQ (4102) — Common questions
├─ Join Beards & Bucks (4620) — Onboarding hub
└─ Why Choose Beards & Bucks (4664) — Value proposition

BLOG/CONTENT
└─ Blog [FUTURE] — Hunting tips, gear reviews, whitetail info

CONTACT/SUPPORT
└─ Contact (4092) — Contact form

LEGAL
├─ Terms and Conditions (4617) — [UPDATE for both directory + marketplace]
└─ Privacy Policy (4618) — [UPDATE for both systems]
```

---

## LISTEO PLATFORM DETAILS

### What Listeo Provides (Built-in)

**Core Features**:
- Responsive directory theme with multiple listing styles
- Front-end user dashboard
- Booking system with QR code check-ins
- Multi-vendor marketplace support (integrated with Dokan)
- Search with advanced filters and criteria
- Google/Bing/Mapbox/OpenStreetMap integration
- User ratings and reviews system
- Private messaging between users
- Statistics page with performance graphs
- Elementor page builder integration
- Setup wizard for initial configuration

**User Roles in Listeo**:
- **Vendors** — Create and manage directory listings
- **Buyers/Users** — Browse listings, save favorites, make bookings

**Listing Fields** (Customizable):
- Title, description, category, location, price/rate, images, contact info, hours, amenities, reviews, booking options

**Monetization Options**:
- Free listings for all vendors
- Premium packages: More photo slots, featured placement, badge display, map pin priority, larger listing space
- Can set tier-based visibility

### Listeo Knowledge Base Resources
- Main: https://docs.purethemes.net/listeo/
- Setup Wizard: https://www.docs.purethemes.net/listeo/knowledge-base/setup-wizard/
- Multi-vendor with Dokan: https://docs.purethemes.net/listeo/knowledge-base/how-to-enable-multi-vendor-marketplace-feature/
- Vendor Management: https://docs.purethemes.net/listeo/knowledge-base/managing-vendors-selling-capabilities/

---

## DOKAN PLATFORM DETAILS

### What Dokan Provides (Built-in)

**Core Features**:
- Unlimited vendors with unlimited products each
- Vendor dashboard with 6 main sections: Products, Orders, Coupons, Reports, Reviews, Store Settings
- WooCommerce integration (products, payments, orders)
- Advanced shipping with zone-wise configuration
- Multiple payment gateways: Stripe, PayPal, Razorpay, WireTransfer, Bank Deposit, etc.
- Withdrawal system with minimum threshold settings
- Commission system: Global, vendor-specific, category-specific, or product-specific rates
- Store hours and opening/closing times
- Social media profile linking
- SEO optimization options in store settings
- 40+ premium modules for extended functionality

**Vendor Dashboard Sections**:
1. **Products** — Create, edit, manage inventory; handle pending rejections; add brands
2. **Orders** — Full order management; manual order creation capability
3. **Coupons** — Create and manage promotional codes with calculation tools
4. **Reports** — Sales analytics and performance metrics
5. **Reviews** — Monitor and respond to customer feedback and ratings
6. **Store Settings** — Store info, contact details, hours, payment methods, social profiles, SEO

**Key Dokan Setup Requirements**:

✅ **Two Required Pages** (must be created):
1. **Store Dashboard Page**
   - Template: "dashboard"
   - Shortcode: `[dokan-dashboard]`
   - Purpose: Vendor product/order management interface

2. **Store Listings Page**
   - Shortcode: `[dokan-stores]`
   - Purpose: Public-facing list of all vendor stores

✅ **Configuration**:
- Assign both pages in **Dokan → Settings → Page Settings**
- Enable selling capabilities in **Dokan → Settings → Selling Options**
- Set commission rates and withdrawal minimums
- Configure shipping zones if needed

✅ **Product Form Customization** (for your used gear):
- Methods: Hooks/code, ACF for Dokan PRO plugin, or custom code in child theme
- Supported field types: Text, Textarea, Number, URL, Select, Checkbox, Radio, File Upload, Email, WYSIWYG Editor, Gallery, Repeater, Taxonomy, Google Map
- Use cases:
  - **Condition field** — Excellent, Good, Needs Tune (dropdown)
  - **Bow Type field** — Compound, Recurve, Crossbow (select)
  - **Brand field** — Text input
  - **Year/Age field** — Number input
  - **Photos/Gallery** — Multi-image upload
  - **Condition Details** — WYSIWYG editor for description

**Vendor Permissions**:
- Individual users can be enabled for selling via **Users** section
- Checkbox: "Enable Selling"
- Once enabled, they can create/manage products from their vendor dashboard

### Dokan Documentation Resources
- Main Docs: https://dokan.co/docs/wordpress/
- Features Overview: https://dokan.co/wordpress/features/
- Vendor Dashboard: https://dokan.co/docs/wordpress/vendor-guide/seller-dashboard/
- All Vendor Functions: https://dokan.co/docs/wordpress/all-vendors/
- Product Form Customization: https://wedevs.com/blog/409723/how-to-add-new-fields-in-dokan-product-form/
- ACF for Dokan: https://krazyplugins.com/product/acf-for-dokan-pro/

---

## INTEGRATION REQUIREMENTS

### Listeo + Dokan Integration

**How They Work Together**:
- Listeo is the primary directory theme (hunts, outfitters, lodging, archery shops, taxidermy)
- Dokan/WooCommerce runs parallel for product-based marketplace (used gear)
- Both share WordPress user database
- Both have separate dashboards and user experiences

**Important Note** (from Listeo docs):
> "Listeo supports multi-vendor marketplace with independent stores of each listing owner/vendor... Dokan is required only for multi-vendor marketplace feature. Booking functionality is built into Listeo and doesn't need Dokan."

**What This Means**:
- ✅ Use Listeo for all hunt/vendor directory listings
- ✅ Use Dokan ONLY if you want vendors to sell products (gear)
- ✅ Two separate user experiences—directory vs. marketplace

### User Role Separation (Critical)

**For Directory (Listeo)**:
- Individual user: Buyer role (browse, book hunts, message vendors)
- Vendor: Outfitter/service provider (create directory listings, manage bookings)

**For Marketplace (Dokan)**:
- Individual seller: WooCommerce vendor (sell used gear privately)
- Vendor shop owner: Could also run gear sales from their store

**Registration Flow**:
- Single login credentials
- Role determined at signup: "Individual" vs. "Vendor/Business"
- Or: Unified account with separate permission toggles

---

## SETUP CHECKLIST

### Phase 1 — Verification (Before Building Pages)

- [ ] Verify **Store Dashboard** page exists with [dokan-dashboard] shortcode
- [ ] Verify **Store Listings** page exists with [dokan-stores] shortcode
- [ ] Verify pages assigned in **Dokan → Settings → Page Settings**
- [ ] Verify selling capabilities enabled in **Dokan → Settings → Selling Options**
- [ ] Confirm Home 3 (4370) is set as active homepage
- [ ] List all active MCP servers and their capabilities

### Phase 2 — Missing Pages (Build Tier 1)

- [ ] **Browse by County** — Illinois county grid/map with vendor counts
  - Est. effort: Medium
  - Tech: Elementor + map integration or custom grid

- [ ] **Vendor Pricing/Tiers** — Display Free vs. Pro with benefits
  - Est. effort: Low
  - Tech: Elementor cards/comparison table

- [ ] **Consolidate How It Works** — Merge pages 4095 and 4662
  - Est. effort: Low
  - Tech: Copy content, delete duplicate, update links

### Phase 3 — Marketplace Enhancements (Build Tier 2)

- [ ] **Seller Profile Page** — Public gear seller profile
  - Est. effort: Medium
  - Tech: Custom template or shortcode for Dokan seller data

- [ ] **Gear Category Hub** — Browse by gear type
  - Est. effort: Low–Medium
  - Tech: WooCommerce product categories + custom layout

- [ ] **Customize Dokan Product Form** — Add gear-specific fields
  - Est. effort: Medium
  - Tech: Hooks, code, or ACF for Dokan PRO
  - Fields: Condition, Bow Type, Brand, Year, Condition Details

### Phase 4 — Content & Polish (Build Tier 3)

- [ ] Start blog/resources section
- [ ] Create testimonials page
- [ ] Set up email capture
- [ ] SEO optimization

### Phase 5 — Legal & Policy

- [ ] **Update Terms & Conditions** — Add marketplace-specific terms
  - No firearms policy
  - Bow-focused restriction
  - Gear condition expectations
  - Seller/buyer obligations

- [ ] **Update Privacy Policy** — Cover both directory and marketplace
  - Vendor data handling
  - Product listings and images
  - Commission tracking

---

## NEXT STEPS

### Immediate Actions (This Session)

**Decision Point**: Which direction first?

**Option A** — Verify Existing Setup (Low Risk)
1. Audit which of the 28 pages are Dokan pages
2. Confirm Store Dashboard and Store Listings exist
3. Check if Dokan is properly configured
4. **Time**: 30 minutes
5. **Outcome**: Clear picture of current state

**Option B** — Build Missing Pages (High Impact)
1. Create Browse by County page
2. Create Vendor Pricing/Tiers page
3. Consolidate How It Works pages
4. **Time**: 2–3 hours
5. **Outcome**: Core business pages in place

**Option C** — Plan Dokan Customization (Strategic)
1. Plan gear-specific product fields
2. Design seller profile template
3. Sketch gear category structure
4. **Time**: 1 hour
5. **Outcome**: Implementation roadmap for marketplace features

### Which Would You Like to Start With?

---

## KEY BRAND REQUIREMENTS (Always Remember)

**Visual/Content**:
- ✅ Whitetail deer only (no other animals, no firearms)
- ✅ Compound bows featured prominently
- ✅ Golden-hour forest photography
- ✅ Premium, modern-outdoorsman aesthetic
- ✅ No vintage Americana, no camo clutter

**Business Rules**:
- ✅ Only individuals sell in used gear (Dokan)
- ✅ Businesses/outfitters only in directory (Listeo)
- ✅ Illinois whitetail hunting focus
- ✅ No new gear or firearms marketplace

**Color Palette** (Use Exactly):
- Primary: #414833, #333D29, #656D4A, #A4AC86, #C2C5AA
- Secondary: #B6AD90, #A68A64, #936639, #7F4F24, #582F0E

---

## DOCUMENT METADATA

- **Created**: December 7, 2025
- **Project**: Beards & Bucks (Illinois Whitetail Hunting Directory + Used Gear Marketplace)
- **Scope**: Site architecture, platform integration, page structure, setup requirements
- **Audience**: Development team, product decisions
- **Status**: Active—Use as single source of truth for ongoing development
- **Update Frequency**: As decisions are made, update this document immediately
- **Tools Available**: Elementor MCP, Respira WordPress MCP, Dokan, Listeo, WooCommerce

