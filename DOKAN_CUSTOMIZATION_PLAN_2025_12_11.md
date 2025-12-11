# Dokan Customization Plan — Beards & Bucks Marketplace

**Date**: December 11, 2025
**Status**: DRAFT - Design Phase
**Project**: Used Hunting & Archery Gear Marketplace (Dokan)
**Audience**: Geoff (Project Owner), Claude Code (Implementation)

---

## 📋 Executive Summary

This document outlines the customization strategy for the Dokan-powered used hunting/archery gear marketplace on Beards & Bucks. The goal is to create a premium, gear-focused selling experience tailored to hunters and archery enthusiasts in Illinois.

**Key Outcomes**:
- Specialized product form with hunting/archery gear fields
- Professional seller profiles with ratings and portfolio
- Organized gear categories with smart filtering
- Clear revenue model and commission structure
- Phased implementation roadmap

---

## Part 1: Product Form Customization

### 1.1 Current State Analysis

**Dokan Version**: 4.2.1 (Lite)
**Default Fields**: Standard WooCommerce product form
- Title, Description, Price
- SKU, Stock/Inventory
- Images (gallery)
- Categories, Tags
- Attributes (basic)

**Limitation**: Dokan Lite has limited custom field capabilities. Advanced ACF integration requires Pro or custom coding.

### 1.2 Gear-Specific Custom Fields Design

The following fields should be added to the product creation form to capture hunting/archery-specific data:

#### **Core Gear Fields** (Essential)

| Field Name | Type | Options/Details | Required? | Notes |
|------------|------|-----------------|-----------|-------|
| **Condition** | Dropdown | Excellent, Good, Fair, Needs Tune | Yes | Critical for used gear transparency |
| **Bow Type** | Multi-Select | Compound, Recurve, Crossbow, Longbow | No | Allows filtering by bow category |
| **Brand** | Text Input | Free text (e.g., "Hoyt", "PSE", "Mathews") | No | Essential for brand-based search |
| **Model** | Text Input | (e.g., "Invicta Pro", "Full Throttle") | No | Specific product model |
| **Year/Age** | Number Input | (1-2025, or "Vintage") | No | How old is the equipment? |
| **Draw Weight** | Text | e.g., "65 lbs", "50 lbs", "Adjustable 40-70" | No | Critical spec for compound bows |
| **Draw Length** | Text | e.g., "29.5 in", "Adjustable 26-31.5 in" | No | Critical spec for compound bows |

#### **Condition & Details Fields**

| Field Name | Type | Options/Details | Required? | Notes |
|------------|------|-----------------|-----------|-------|
| **Condition Details** | WYSIWYG Editor | Rich text | No | Free-form description of condition (dings, wear, functionality) |
| **Functionality Status** | Dropdown | Fully Functional, Needs Minor Tune, Needs Major Tune, Parts Only | Yes | Transparency on usability |
| **Accessories Included** | Checkbox Group | Rest, Stabilizer, Sight, Release, Arrows, Broadheads, Case, Other | No | What's included with the bow/gear |

#### **Logistics Fields**

| Field Name | Type | Options/Details | Required? | Notes |
|------------|------|-----------------|-----------|-------|
| **Shipping Options** | Checkbox Group | Ships Safely (insured), Local Pickup Only, Meet in Person | No | How can buyer receive item? |
| **Local Delivery Area** | Text | Free text, e.g., "Central Illinois (50 mile radius)" | No | For local meetups |
| **Warranty Status** | Dropdown | No Warranty, Manufacturer Warranty (years), Seller Warranty | No | What protection does buyer get? |

#### **Safety & Compliance Fields**

| Field Name | Type | Options/Details | Required? | Notes |
|------------|------|-----------------|-----------|-------|
| **Animal Restriction** | Info Text | "Illinois whitetail hunting only" | Display Only | Reinforces brand compliance |
| **Age Requirement** | Info Text | "Must be 18+ to purchase" | Display Only | Legal requirement |

### 1.3 Field Implementation Strategy

**Three Implementation Options**:

#### **Option 1: ACF (Advanced Custom Fields) for Dokan [RECOMMENDED]**
- **Pro**: User-friendly field builder, easy to manage, conditional logic
- **Con**: Requires ACF Pro ($99/year), but worth the investment
- **Effort**: 2-3 hours for setup + testing
- **Dokan Integration**: ACF works natively with Dokan product forms
- **Recommendation**: ✅ **BEST CHOICE** - Professional, maintainable solution

**Implementation**:
1. Install ACF Pro (or ACF Free with limited features)
2. Create custom field group "Gear Specifications"
3. Add all fields from 1.2 (Condition, Bow Type, Brand, etc.)
4. Assign field group to Dokan product post type
5. ACF automatically adds fields to Dokan form
6. Frontend display via ACF shortcodes or Elementor ACF widgets

#### **Option 2: Dokan Hooks & Filters [ADVANCED]**
- **Pro**: Free, no plugins needed, full control
- **Con**: Requires PHP coding, more maintenance
- **Effort**: 4-6 hours for development + testing
- **Integration**: Custom code in child theme or mu-plugin
- **Recommendation**: ⚠️ **FALLBACK** - Only if ACF not available

**Implementation**:
1. Create custom plugin or add to theme `functions.php`
2. Hook: `dokan_product_edit_form_after_general` (add custom fields)
3. Hook: `dokan_process_product_meta` (save custom fields)
4. Store in `post_meta` table with prefixed keys
5. Display on frontend via custom template

#### **Option 3: Custom Post Type Extension [COMPLEX]**
- **Pro**: Complete control, independent of Dokan updates
- **Con**: High complexity, significant testing required
- **Effort**: 6-8 hours, ongoing maintenance
- **Integration**: Requires rebuilding parts of Dokan workflow
- **Recommendation**: ❌ **NOT RECOMMENDED** - Over-engineering

### 1.4 Field Grouping & Form Layout

**Recommended form organization** (when building with ACF or custom code):

```
Product Form Structure
├── Standard WooCommerce Fields (built-in)
│   ├── Title
│   ├── Description
│   ├── Price
│   └── Featured Image
│
├── Gear Specifications (NEW - Custom Group 1)
│   ├── Condition (dropdown)
│   ├── Bow Type (multi-select)
│   ├── Brand (text)
│   ├── Model (text)
│   ├── Year/Age (number)
│   ├── Draw Weight (text)
│   └── Draw Length (text)
│
├── Condition & Details (NEW - Custom Group 2)
│   ├── Condition Details (WYSIWYG)
│   ├── Functionality Status (dropdown)
│   └── Accessories Included (checkboxes)
│
└── Logistics & Safety (NEW - Custom Group 3)
    ├── Shipping Options (checkboxes)
    ├── Local Delivery Area (text)
    ├── Warranty Status (dropdown)
    └── Safety/Compliance (info display)
```

### 1.5 Field Validation & Rules

**Required Field Validation**:
- Condition: REQUIRED
- Functionality Status: REQUIRED
- All other fields: OPTIONAL

**Conditional Logic** (if using ACF Pro):
- IF Bow Type = "Compound" THEN Show Draw Weight & Draw Length fields (required)
- IF Bow Type = "Recurve" THEN Show Draw Weight & Draw Length fields (required)
- IF Shipping Options = "Local Pickup Only" THEN Hide shipping cost options

**Data Type Validation**:
- Year: Must be between 1900-2025
- Draw Weight: Must match pattern "XX lbs" or "XX-XX lbs"
- Draw Length: Must match pattern "XX.X in" or "XX.X-XX.X in"

---

## Part 2: Seller Profile Page Design

### 2.1 Current State

**Dokan Default**: Basic public store page at `/store/[store-name]`
- Minimal seller information
- Product list only
- Limited customization options

**Gap**: No professional seller portfolio or trust signals

### 2.2 Seller Profile Page Elements

**Layout**: Responsive flexbox design (desktop 3-column, mobile 1-column)

#### **Section 1: Seller Header (Above-the-fold)**

```
┌─────────────────────────────────────┐
│  [Seller Avatar]  Seller Name        │
│  ⭐⭐⭐⭐⭐ (4.8 rating)             │
│  92 items sold | 98% positive       │
│  Active since: November 2024        │
│  🚀 Avg Response Time: 2 hours       │
├─────────────────────────────────────┤
│  "Premium bow builder, 15 years exp" │
│  (Seller Bio - 1-2 sentences)        │
└─────────────────────────────────────┘
```

**Fields to Display**:
- Seller name / store name
- Avatar / profile picture
- Overall rating (stars + number)
- Total reviews count
- Items sold count
- Positive feedback percentage
- Member since date
- Response time average (if tracked)
- Bio/description (150-200 chars)

#### **Section 2: Store Statistics (Sidebar)**

```
┌──────────────────────┐
│   SELLER STATS       │
├──────────────────────┤
│ Total Sales: 92      │
│ Avg Rating: 4.8⭐   │
│ Positive: 98%        │
│ Member: 13 months    │
│ Response: 2h avg     │
└──────────────────────┘
```

#### **Section 3: Contact & Message Section**

```
┌──────────────────────────────────────┐
│ 📧 Questions? Contact Seller         │
│                                      │
│ [Send Message Button]                │
│ [Call (if phone enabled)]            │
│ [View Contact Policy]                │
└──────────────────────────────────────┘
```

#### **Section 4: Product Showcase**

```
┌────────────────────────────────────────────────────────────┐
│ FEATURED PRODUCTS FROM THIS SELLER                        │
├────────────────────────────────────────────────────────────┤
│ [Product Card] [Product Card] [Product Card]              │
│ [Product Card] [Product Card] [Product Card]              │
│ [View All Products] (link to store)                       │
└────────────────────────────────────────────────────────────┘
```

**Show**: Latest 6 products, with prices, images, ratings

#### **Section 5: Seller Reviews/Feedback**

```
┌────────────────────────────────────────────────────────────┐
│ BUYER FEEDBACK                                             │
├────────────────────────────────────────────────────────────┤
│ ⭐⭐⭐⭐⭐ "Fast shipping, great communication!"            │
│           - John D., Purchased 3 weeks ago                 │
│                                                            │
│ ⭐⭐⭐⭐☆ "Item exactly as described. Highly recommend"   │
│           - Sarah M., Purchased 2 months ago               │
│                                                            │
│ [View All Reviews (15 total)]                             │
└────────────────────────────────────────────────────────────┘
```

### 2.3 Design Specifications

**Color Scheme**:
- Use brand colors from docs/BRAND_ANALYSIS_2025_12_07.md
- Primary: #414833, #656D4A
- Accent: #A4AC86, #B6AD90
- Text: Dark gray (#333D29)
- Backgrounds: Light cream (#F5F3F0)

**Typography**:
- Seller Name: 32px bold, brand primary color
- Section Headers: 24px semi-bold, brand primary
- Body Text: 16px regular, dark gray
- Stats Numbers: 20px bold, accent color

**Layout Breakpoints**:
- Desktop (1200px+): 3-column (header, stats sidebar, products)
- Tablet (768px-1199px): 2-column (stacked sections)
- Mobile (<768px): 1-column (full width sections)

**Responsive Image Sizes**:
- Avatar: 120px (desktop), 100px (mobile)
- Product thumbnails: 180px (desktop), 140px (mobile)

### 2.4 Implementation Strategy

**Option 1: Custom Elementor Template [RECOMMENDED]**
- Create custom Elementor page template
- Use Dokan hooks to fetch seller data
- Display in dynamic Elementor widgets
- Fully customizable, brand-consistent
- Effort: 3-4 hours

**Option 2: Dokan Store Template Override [ADVANCED]**
- Copy Dokan template to child theme
- Customize HTML/CSS directly
- More control, requires development knowledge
- Effort: 4-5 hours

**Option 3: Use Dokan Pro "Custom Brand Page" [ALTERNATIVE]**
- Requires Dokan Pro ($499/year)
- Drag-and-drop builder
- Limited customization for Lite
- Not recommended for Lite version

**Recommendation**: ✅ **Option 1 (Custom Elementor Template)** - Best balance of control and ease

---

## Part 3: Gear Category Structure

### 3.1 Category Hierarchy

**Proposed Category Structure** (organized for hunters/archers):

```
🎯 Bows & Crossbows (Parent)
├── Compound Bows
├── Recurve Bows
├── Crossbows
└── Longbows

➡️ Arrows & Bolts (Parent)
├── Carbon Arrows
├── Aluminum Arrows
├── Bolts
└── Arrow Components

🔍 Optics (Parent)
├── Riflescopes
├── Rangefinders
├── Binoculars
└── Thermal/Night Vision

🎒 Packs & Bags (Parent)
├── Hunting Packs
├── Waist Packs
├── Rope Bags
└── Gun/Bow Cases

👢 Boots & Clothing (Parent)
├── Hunting Boots
├── Camouflage Clothing
├── Base Layers
└── Accessories (Gloves, Hats)

🌲 Climbing Stands (Parent)
├── Treestand (Hang-on)
├── Ladder Stands
├── Climbing Stick Sets
└── Stand Accessories

📢 Calls & Decoys (Parent)
├── Deer Calls
├── Decoy Kits
├── Duck Calls
└── Electronic Calls

⚙️ Accessories & Other (Parent)
├── Release Aids
├── Rests & Stabilizers
├── Broadheads
├── Targets
└── Tools & Maintenance
```

### 3.2 Category Details

**Each category should have**:

| Element | Content |
|---------|---------|
| **Icon** | Category-specific emoji or image |
| **Description** | 1-2 sentence category overview |
| **Typical Filters** | What users search for in this category |
| **Featured Subcategories** | Top 3-4 most popular items |
| **Example Products** | 2-3 example product names |

### 3.3 Category Landing Pages

**Design**: Each category gets a dedicated landing page with:
- Category hero image (hunting/archery themed)
- Category description and use cases
- Filter sidebar:
  - Condition (Excellent, Good, Fair)
  - Bow Type (if applicable)
  - Brand (checkboxes)
  - Price Range (slider)
  - New/Used toggle
- Product grid (6-12 products, load more)
- Sorting options: New, Price Low-High, Best Rated, Most Popular

**Implementation**: Use WooCommerce product category templates (customized in Elementor)

### 3.4 Category Strategy

**Tier 1 (Launch)**: Create 5 core categories
1. Bows & Crossbows
2. Arrows & Bolts
3. Optics
4. Climbing Stands
5. Accessories & Other

**Tier 2 (Expansion)**: Add 3 supporting categories
1. Packs & Bags
2. Boots & Clothing
3. Calls & Decoys

**Timeline**: Tier 1 on launch, Tier 2 after 3 months when marketplace has more products

---

## Part 4: Commission & Pricing Strategy

### 4.1 Current Dokan Configuration

**Status**: Dokan 4.2.1 configured with:
- Commission Rate: **0%** (currently disabled - needs decision)
- Payment Gateways: WooPayments + Stripe (live mode)
- Withdrawal Methods: PayPal + Bank Transfer
- Withdrawal Minimum: Not set (recommend $50)
- Payout Schedule: Monthly (configurable)

### 4.2 Commission Strategy Options

#### **Option A: No Commission (Free Listing) [CURRENT]**

```
Product Price:      $100
Platform Commission: $0 (0%)
Seller Gets:        $100
Platform Gets:      $0
```

**Pros**:
- Maximum incentive to list products
- Easy to understand for new sellers
- Low barrier to entry
- Good for marketplace growth phase

**Cons**:
- No revenue for Beards & Bucks
- Cannot cover payment processing fees (~3%)
- Unsustainable long-term

**When to Use**: Launch phase (first 6 months) to attract sellers and build inventory

---

#### **Option B: Flat Percentage Commission [RECOMMENDED]**

```
Product Price:      $100
Payment Processing: -$3 (3%, Stripe)
Platform Commission: -$8 (8% platform fee)
Seller Gets:        $89 ($100 - $3 - $8)
Platform Gets:      $8 + payment processing covers itself
```

**Pros**:
- Fair to sellers (predictable)
- Scales with product price (expensive items = more revenue)
- Industry standard (8-15% typical)
- Simple to explain and calculate

**Cons**:
- Less flexible for volume sellers
- No incentive for high-velocity sellers

**Recommendation**: ✅ **START AT 8% for Tier 1, increase to 12-15% for Tier 2**

---

#### **Option C: Category-Based Commission [ALTERNATIVE]**

```
Bows & Crossbows:        12% (high value items)
Arrows & Bolts:          8%  (lower value, higher volume)
Optics:                  10% (mid-range)
Climbing Stands:         10%
Accessories & Other:     5%  (cheap items, encourage sales)
```

**Pros**:
- Can optimize revenue by category
- Lower commission on volume categories (Arrows) = more sales
- Reflects item value and handling costs

**Cons**:
- More complex, harder to communicate
- Requires category enforcement
- More administrative overhead

**When to Use**: Phase 2 (after 6 months of operation with data)

---

#### **Option D: Tiered Commission Based on Sales Volume [ADVANCED]**

```
Seller Tier 1 (0-10 sales):     15% commission
Seller Tier 2 (11-50 sales):    12% commission
Seller Tier 3 (51+ sales):      8% commission
```

**Pros**:
- Incentivizes high-volume sellers
- Rewards loyalty
- Can improve seller retention

**Cons**:
- Complex for new sellers to understand
- Requires tier tracking system
- Could incentivize low-quality bulk selling

**When to Use**: Phase 3 (after 12+ months with mature seller base)

---

### 4.3 Recommended Strategy: Phased Approach

**Phase 1 (Months 1-3): 0% Commission**
- Goal: Attract initial sellers, build inventory
- Action: Market as "Commission-Free Launch Period"
- Track: # of sellers, # of products listed
- Revenue: $0 from commissions (investment phase)

**Phase 2 (Months 4-12): 8% Flat Commission**
- Goal: Establish revenue stream, maintain seller base
- Action: Announce commission with 30-day notice
- Communication: Explain payment processing costs, marketplace sustainability
- Grandfather clause: Existing sellers get 6% for 6 months (loyalty reward)
- Track: Seller revenue, payment processing costs
- Target Revenue: ~$5-10K/month (depends on volume)

**Phase 3 (Year 2): 12-15% Commission with Tiers**
- Goal: Optimize revenue, reward high-volume sellers
- Action: Implement tiered system based on sales volume
- Incentives: Volume discounts, exclusive seller badges
- Track: Seller retention, commission revenue
- Target Revenue: ~$20-30K/month

### 4.4 Payment Processing & Payouts

**Current Setup**: ✅ Already configured
- **Stripe**: Live mode enabled, 3% processing fee
- **PayPal**: Configured for seller payouts
- **Bank Transfer**: Available as payout method

**Payout Configuration**:
- **Minimum Threshold**: $50 (recommended - prevents small transactions)
- **Payout Schedule**: Monthly (automatic on specified date)
- **Payout Day**: Choose: 1st, 15th, or Last day of month
- **Fee Structure**: Sellers absorb payment processing fee (~3%)

**Seller Payout Calculation Example**:
```
Gross Sales (Month):        $5,000
Beards & Bucks Commission:  -$400 (8%)
Stripe Processing Fee:      -$150 (3%)
Seller Receives:            $4,450
```

---

## Part 5: Implementation Roadmap

### 5.1 Phase Breakdown

#### **Phase 1: Foundation & Setup (Weeks 1-2)**

**Objectives**: Get custom fields and seller profiles working

**Tasks**:
- [ ] Task 1.1: Install & configure ACF Pro
- [ ] Task 1.2: Create custom field groups (Gear Specifications)
- [ ] Task 1.3: Test field display in Dokan form
- [ ] Task 1.4: Create seller profile page template (Elementor)
- [ ] Task 1.5: Test seller profile display
- [ ] Task 1.6: Document field mapping and templates
- [ ] Task 1.7: Create test products with new fields

**Effort**: 8-10 developer hours
**Cost**: ACF Pro ($99/year)
**Output**: Functional gear form + seller profile page
**Risk**: Low (using established plugins)

#### **Phase 2: Categories & Filtering (Weeks 3-4)**

**Objectives**: Organize products by category, add smart filtering

**Tasks**:
- [ ] Task 2.1: Create category hierarchy in WooCommerce
- [ ] Task 2.2: Design category landing pages (Elementor)
- [ ] Task 2.3: Implement category filters (ACF + WooCommerce)
- [ ] Task 2.4: Add brand-specific filtering
- [ ] Task 2.5: Test filtering on products
- [ ] Task 2.6: Create category content (descriptions, icons)
- [ ] Task 2.7: User testing & refinement

**Effort**: 6-8 developer hours
**Cost**: $0 (using built-in WooCommerce features)
**Output**: Organized product browsing experience
**Risk**: Low-Medium (category structure impacts SEO)

#### **Phase 3: Commission & Revenue (Weeks 5-6)**

**Objectives**: Set up payment processing and commission tracking

**Tasks**:
- [ ] Task 3.1: Decide on commission percentage (workshop with Geoff)
- [ ] Task 3.2: Configure Dokan commission settings
- [ ] Task 3.3: Set up payout threshold & schedule
- [ ] Task 3.4: Create seller documentation (how payouts work)
- [ ] Task 3.5: Test payout calculation with dummy transactions
- [ ] Task 3.6: Create admin dashboard for commission tracking
- [ ] Task 3.7: Legal review of seller terms/conditions

**Effort**: 4-6 developer hours
**Cost**: $0 (using existing Stripe/PayPal setup)
**Output**: Functional payment processing
**Risk**: Medium (payment processing requires testing, PCI compliance)

#### **Phase 4: Advanced Features (Weeks 7-8)**

**Objectives**: Add seller ratings, reviews, performance tracking

**Tasks**:
- [ ] Task 4.1: Implement seller rating system (WooCommerce native)
- [ ] Task 4.2: Add review moderation workflow
- [ ] Task 4.3: Create seller dashboard with analytics (if Dokan supports)
- [ ] Task 4.4: Implement response time tracking
- [ ] Task 4.5: Create seller badge/reward system (optional)
- [ ] Task 4.6: Add seller report generation

**Effort**: 8-10 developer hours
**Cost**: $0-200 (optional pro plugins)
**Output**: Professional seller management
**Risk**: Medium (requires data tracking integration)

### 5.2 Timeline & Milestones

```
Week 1-2: ✅ Gear Form + Seller Profile (Foundation)
  ├─ By Dec 20: ACF installed, custom fields working
  ├─ By Dec 24: Seller profile page live
  └─ Checkpoint: Test with real products

Week 3-4: Categories & Filtering (Discovery)
  ├─ By Dec 27: Category structure created
  ├─ By Jan 3: Category pages published
  └─ Checkpoint: Test category navigation

Week 5-6: Commission & Revenue (Monetization)
  ├─ By Jan 10: Commission configured
  ├─ By Jan 17: Payout system tested
  └─ Checkpoint: Verify seller earnings calculation

Week 7-8: Advanced Features (Polish)
  ├─ By Jan 24: Seller ratings implemented
  ├─ By Jan 31: Analytics dashboard live
  └─ Final Checkpoint: QA testing complete

📊 FINAL LAUNCH: February 1, 2026
```

### 5.3 Effort & Cost Summary

| Phase | Hours | Cost | Risk |
|-------|-------|------|------|
| Phase 1: Foundation | 8-10 | $99 (ACF) | Low |
| Phase 2: Categories | 6-8 | $0 | Low-Medium |
| Phase 3: Commission | 4-6 | $0 | Medium |
| Phase 4: Advanced | 8-10 | $0-200 | Medium |
| **TOTAL** | **26-34** | **$99-299** | **Low-Medium** |

**Interpretation**:
- ~4-5 weeks of development (assuming 6 hours/day)
- Or 2 weeks of focused work (12 hours/day)
- Minimal additional cost beyond ACF Pro
- Can be done incrementally (Phase 1 → Phase 2 → etc.)

### 5.4 Success Criteria

**Phase 1 Success**:
- ✅ Custom fields save correctly to Dokan products
- ✅ Seller profile page displays all required elements
- ✅ Mobile responsive on all breakpoints
- ✅ Passes accessibility audit (WCAG AA)

**Phase 2 Success**:
- ✅ All 5 Tier-1 categories created
- ✅ Products filterable by category, condition, brand
- ✅ Category pages load in <2 seconds
- ✅ No broken category links

**Phase 3 Success**:
- ✅ Commission calculations accurate to the cent
- ✅ Sellers receive payouts on schedule
- ✅ Admin can view commission reports
- ✅ No payment processing errors

**Phase 4 Success**:
- ✅ Seller ratings display correctly
- ✅ Seller analytics show meaningful data
- ✅ Response time tracking working
- ✅ Seller badges earned and displayed

---

## Part 6: Technical Implementation Notes

### 6.1 Dokan API & Hooks

**Key Dokan Hooks** (for custom field integration):

```php
// Add custom fields to product form
add_action('dokan_product_edit_form_after_general', function() {
    // Custom field HTML here
});

// Save custom field values
add_action('dokan_process_product_meta', function($product_id, $post_data) {
    // Save custom field meta
});

// Display on frontend
add_filter('dokan_product_single_content', function($product) {
    // Display custom fields on product page
});
```

### 6.2 WooCommerce Attributes

**Using WooCommerce Attributes for Gear Specs** (alternative to ACF):

```
Attribute: pa_condition
  - Excellent
  - Good
  - Fair
  - Needs Tune

Attribute: pa_bow_type
  - Compound
  - Recurve
  - Crossbow
  - Longbow

Attribute: pa_brand
  - Hoyt
  - PSE
  - Mathews
  - Bowtech
  - [etc.]
```

**Pros**: Built-in to WooCommerce, good for filtering
**Cons**: Less flexible than ACF, limited to dropdowns

### 6.3 Database Considerations

**Custom Field Storage**:
- ACF stores in `postmeta` table (wp_postmeta)
- Key pattern: `field_[field_key]`
- Example: `field_abc123def456` = "Condition: Excellent"

**Query Performance**:
- Index on `post_id` and `meta_key` (default)
- Should be fast even with hundreds of products
- Monitor if product count exceeds 10,000

### 6.4 Migration & Data Import

**When Phase 1 is ready**, existing products may need data migration:

```
Current Dokan Products:
├─ ~0 products initially (fresh marketplace)
├─ Will add 50-100 in Phase 2
└─ Easy to add custom fields retroactively

No migration needed at launch.
Custom fields are added before first seller upload.
```

---

## Part 7: Risk Assessment & Mitigation

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| ACF Pro not compatible with Dokan | High | Low | Test in staging before deployment |
| Custom fields break Dokan form | High | Low | Thorough testing, have rollback plan |
| Payment processing issues | High | Medium | Test with real transactions in sandbox |
| Seller confusion about commission | Medium | Medium | Clear documentation + email updates |
| Category structure unclear to users | Medium | Medium | User testing, analytics tracking |
| Performance issues with many products | Medium | Low | Database indexing, caching strategy |
| Dokan update breaks custom code | High | Medium | Monitor Dokan releases, keep code maintainable |

**Mitigation Strategy**: Use staging environment for all changes, test thoroughly before production, maintain documentation, plan rollback procedures.

---

## Part 8: Decisions Required (From Geoff)

Before implementing, confirm these decisions:

### **Decision 1: ACF Pro Purchase**
- [ ] Approve $99/year ACF Pro purchase?
- [ ] Or use WooCommerce Attributes as alternative?

### **Decision 2: Commission Rate**
- [ ] Start with 0% (Phase 1)?
- [ ] Move to 8% in Phase 2?
- [ ] Alternative: Category-based commission?

### **Decision 3: Timeline**
- [ ] Fast track: Complete all phases by Jan 31?
- [ ] Standard: Complete by Feb 28?
- [ ] Flexible: Start Phase 1 only, decide Phase 2 later?

### **Decision 4: Seller Communication**
- [ ] Send announcement about new gear fields?
- [ ] Include onboarding guide for sellers?
- [ ] Offer seller training webinar?

### **Decision 5: Launch Date**
- [ ] Hard launch (all features at once)?
- [ ] Soft launch (Phase 1-2 only)?
- [ ] Beta phase (invite 5-10 sellers for testing)?

---

## Part 9: Recommendations Summary

### **RECOMMENDED APPROACH** ✅

**Phase 1 Implementation (Weeks 1-2)**:
1. ✅ **Install ACF Pro** ($99) - Best investment for customization
2. ✅ **Create Gear Specifications** field group (Condition, Bow Type, Brand, etc.)
3. ✅ **Build Seller Profile Page** in Elementor (responsive, brand-compliant)
4. ✅ **Test with 5-10 sample products**
5. ✅ **Deploy to production**

**Phase 2 Implementation (Weeks 3-4)**:
6. ✅ **Create 5 core categories** (Bows, Arrows, Optics, Stands, Accessories)
7. ✅ **Add category landing pages** with filtering
8. ✅ **Test with real seller data**

**Phase 3 Implementation (Weeks 5-6)**:
9. ✅ **Configure 0% commission** for Phase 1 (launch incentive)
10. ✅ **Set up payment processing** testing
11. ✅ **Plan Phase 2 transition** to 8% commission

**Result**: Professional, gear-focused marketplace ready for sellers by February 2026

---

## Appendix: Additional Resources

**Dokan Documentation**: `docs/reference/official-docs/dokan/`
**WooCommerce Attributes**: `docs/reference/official-docs/woocommerce/`
**Elementor Customization**: `docs/reference/official-docs/elementor/`
**ACF Documentation**: https://www.advancedcustomfields.com/

---

**Document Status**: DRAFT - Design Phase Complete
**Next Step**: Get approval on decisions (Part 8), then proceed to Phase 1 implementation
**Owner**: Geoff (Project Owner), Claude Code (Implementation)
**Last Updated**: December 11, 2025
