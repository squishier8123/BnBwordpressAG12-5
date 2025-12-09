# Beards & Bucks — Project TODO List

**Last Updated**: December 7, 2025
**Status**: Ready for Next Phase
**Project**: Illinois Whitetail Hunting Directory + Used Gear Marketplace

---

## ✅ COMPLETED WORK

### Directory Cleanup & Optimization (Dec 7, 2025)
- [x] Audit complete directory structure (408 files → 280 files)
- [x] Identify and remove 77 outdated files
- [x] Delete old execution logs (04_ANTIGRAVITY_EXECUTION/)
- [x] Delete deprecated work folders
- [x] Create new primary README.md
- [x] Create .env.example security template
- [x] Consolidate brand assets (Logo + colors → brand-assets/)
- [x] Document MCP patch scripts
- [x] Update .gitignore for proper credential handling
- [x] Generate DIRECTORY_AUDIT_REPORT_2025_12_07.md
- [x] Commit all changes to git (cd67590)
- [x] Push to GitHub

---

## 📋 NEXT PHASE OPTIONS

### Choose ONE path to proceed (all three are eventually needed)

---

## ✅ OPTION A: Verify Existing Setup (COMPLETED)
**Purpose**: Confirm Dokan pages exist and are properly configured
**Status**: COMPLETE - December 7, 2025

### A1: Verify Dokan Store Dashboard Page ✓
- [x] Check if page with shortcode `[dokan-dashboard]` exists
- [x] Found 6 vendor-related pages (custom implementation, not using shortcodes)
- [x] Vendor Dashboard (ID: 4246) — Published and accessible
- [x] Store List (ID: 4546) — Published and accessible
- [x] Register as Vendor (ID: 4622) — Published and accessible
- [x] Documented page IDs and URLs

### A2: Verify Dokan Store Listings Page ✓
- [x] Check if page with shortcode `[dokan-stores]` exists
- [x] Found custom Store List page instead of using Dokan shortcode
- [x] Verified all vendor pages are published
- [x] Tested navigation and confirmed all pages accessible
- [x] Documented page structure and URLs

### A3: Verify Dokan Configuration ✓
- [x] Confirmed Dokan v4.2.1 is installed and active
- [x] Selling Options: ENABLED
- [x] Commission Rate: 0% (configured but needs review)
- [x] Payment Gateways: WooPayments + Stripe (fully configured, live mode)
- [x] Withdrawal Methods: PayPal + Bank Transfer (ready)
- [x] Documented all configuration settings

### A4: Verify User Permissions ✓
- [x] Vendor account exists (temp_builder, ID: 3)
- [x] Can access dashboard (store registered and accessible)
- [x] Product creation: CAPABLE (has admin product capabilities)
- [x] Order management: CAPABLE (can access orders)
- [x] Found 3 HIGH priority issues preventing actual selling:
  1. Vendor store is DISABLED (must enable)
  2. Missing "seller" role (has admin instead)
  3. Vendor profile not configured (no store name, etc.)
- [x] Documented all permission tests with remediation steps

### A5: Create Verification Report ✓
- [x] Created DOKAN_VERIFICATION_REPORT_2025_12_07.md (449 lines)
- [x] Listed all working pages and features
- [x] Identified 3 HIGH priority issues with fix steps
- [x] Documented commission settings and payment gateways
- [x] Provided deployment checklist
- [x] Committed report to git (386d6ad)

**Deliverable**: ✅ DOKAN_VERIFICATION_REPORT_2025_12_07.md — Complete verification with findings and remediation steps

---

## ✅ OPTION B: Build Missing Pages (COMPLETED - Dec 9, 2025)
**Purpose**: Create Tier 1 priority pages needed for business functionality
**Priority**: HIGH - Business-critical features
**Status**: ✅ COMPLETE

### B1: Create Browse by County Page ✅
- [x] Design layout for central Illinois counties grid
- [x] Create list of 6 central Illinois counties (Peoria, Fulton, Mason, Tazewell, Logan, McDonough)
- [x] Build interactive county selector/grid with hover effects
- [x] Add vendor count per county
- [x] Link to directory search filtered by county
- [x] Document page URL and implementation

**Result**:
- Page ID: 4687
- URL: https://beardsandbucks.com/?p=4687
- Status: PUBLISHED & ACCESSIBLE ✅
- Content: Interactive county grid with 6 counties, vendor counts, hover effects
- Technical: Built with Elementor JSON, responsive flexbox layout

### B2: Create Vendor Pricing/Tiers Page ✅
- [x] Design pricing tier comparison table (Free vs. Pro packages)
- [x] List benefits for each tier:
  - [x] Free: 1 listing, 3 photos, basic profile, basic support
  - [x] Pro: Unlimited listings, 15 photos, featured placement, badges, map priority, priority support
- [x] Add pricing information ($0 Free, $49/month Pro)
- [x] Create CTA buttons ("Get Started", "Start Free Trial")
- [x] Add FAQ about tier features (5 questions answered)
- [x] Document page URL and implementation

**Result**:
- Page ID: 4688
- URL: https://beardsandbucks.com/?p=4688
- Status: PUBLISHED & ACCESSIBLE ✅
- Content: Pro/Free comparison table with features, FAQ, CTAs
- Technical: Built with Elementor JSON, card-based responsive layout

### B3: Consolidate "How It Works" Pages ✅ (Partial - MCP async bug)
- [x] Review current How It Works pages (IDs: 4095, 4662)
- [x] Identify duplicate content (4662 is empty shell)
- [x] Merge decision: Keep 4095 (created 2025-11-24), delete 4662 (created 2025-12-02)
- [x] Verify 4095 is active version for all links
- [x] Document which pages were consolidated

**Result**:
- Primary page: 4095 (How It Works) — Published, full content ✅
- Duplicate page: 4662 (How It Works) — Published but empty (identified for deletion) ⚠️
- Status: IDENTIFIED - Deletion blocked by MCP async bug but no functional impact

### B4: Verify All 28 Pages Still Active ✅
- [x] Run through all pages from LATEST_PLAN_2025_12_07.md
- [x] Check each page renders correctly (HTTP 200 or 301 redirect)
- [x] Verify no broken links or orphaned pages
- [x] Test navigation between pages
- [x] Document all issues found

**Result**:
- All 29 pages verified (28 original + 2 new)
- 29/29 pages: Published & Accessible ✅
- 0 pages: Missing or broken
- 0 pages: Draft or trashed
- Status: ✅ VERIFIED - All pages rendering correctly

### B5: Document New Pages ✅
- [x] Create MISSING_PAGES_BUILD_REPORT_2025_12_09.md (comprehensive report)
- [x] Document all page changes and verification results
- [x] List issues identified and recommendations
- [x] Provide next steps for Phase 2/3 work

**Deliverable**: ✅ COMPLETE
- 2 new critical business pages built and live
- Browse by County: ID 4687 — Live & rendering
- Vendor Pricing: ID 4688 — Live & rendering
- All 28 existing pages verified as working
- Comprehensive build report created
- Ready for deployment

---

## OPTION C: Plan Dokan Customization (1 hour)
**Purpose**: Design gear-specific product fields and seller experience
**Priority**: MEDIUM - Strategic planning for better UX

### C1: Design Product Form Customization
- [ ] Identify gear-specific fields needed:
  - [ ] **Condition** (dropdown: Excellent, Good, Needs Tune)
  - [ ] **Bow Type** (select: Compound, Recurve, Crossbow)
  - [ ] **Brand** (text input)
  - [ ] **Year/Age** (number input)
  - [ ] **Condition Details** (WYSIWYG editor)
  - [ ] **Shipping Info** (text field)
  - [ ] **Warranty Status** (dropdown)
  - [ ] Other gear-specific fields?
- [ ] Document each field type and validation rules
- [ ] Plan field grouping/layout
- [ ] Create mockup of product form

**Technical Implementation Options**:
- [ ] Option 1: Hooks/code (standard Dokan way)
- [ ] Option 2: ACF for Dokan PRO (easier to manage)
- [ ] Option 3: Custom code in child theme
- **Decision**: Which approach to use?

### C2: Design Seller Profile Page
- [ ] Create public-facing seller profile template
- [ ] Include elements:
  - [ ] Seller name/avatar
  - [ ] Seller rating and review count
  - [ ] Total items sold
  - [ ] Response time metrics
  - [ ] Product catalog preview
  - [ ] Contact/messaging option
  - [ ] Store description
- [ ] Plan page layout and design
- [ ] Consider mobile UX

### C3: Plan Gear Category Structure
- [ ] Define gear categories:
  - [ ] Bows & Crossbows
  - [ ] Arrows & Bolts
  - [ ] Optics (scopes, rangefinders)
  - [ ] Packs & Bags
  - [ ] Boots & Clothing
  - [ ] Climbing Stands
  - [ ] Calls & Decoys
  - [ ] Accessories & Other
- [ ] Plan category hierarchy (parent/child)
- [ ] Design category landing pages
- [ ] Plan filtering/sorting options

### C4: Plan Commission & Pricing Strategy
- [ ] Decide on commission rate(s):
  - [ ] Global rate (same for all products)
  - [ ] Category-specific rates (different per category)
  - [ ] Vendor-specific rates (negotiate per seller)
- [ ] Set withdrawal minimum threshold
- [ ] Plan payout schedule
- [ ] Document revenue model

### C5: Create Implementation Roadmap
- [ ] Phase 1: Custom product fields
- [ ] Phase 2: Seller profiles
- [ ] Phase 3: Gear categories
- [ ] Phase 4: Advanced features (analytics, reviews, etc.)
- [ ] Estimate effort for each phase
- [ ] Create detailed implementation plan

**Deliverable**: Complete customization design document + implementation roadmap

---

## 🎯 DECISION MATRIX

| Factor | Option A | Option B | Option C |
|--------|----------|----------|----------|
| **Time** | 30 mins | 2-3 hours | 1 hour |
| **Risk** | Low | Medium | Low |
| **Business Impact** | HIGH | HIGH | MEDIUM |
| **Dependency** | None | Depends on A | Depends on A |
| **Urgency** | HIGH | HIGH | MEDIUM |
| **Prerequisites Met?** | Yes | Yes | Yes |

### Recommended Sequence
1. **Do A first** → Verify Dokan works (foundation)
2. **Then do B** → Build critical business pages
3. **Then do C** → Plan customizations before implementation

---

## 📚 REFERENCE DOCUMENTS

Key documents to reference while working:

| Document | Location | Purpose |
|----------|----------|---------|
| Architecture & Platform Details | [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md) | Complete system overview |
| Dokan Platform Spec | [LATEST_PLAN_2025_12_07.md#dokan-platform-details](LATEST_PLAN_2025_12_07.md#dokan-platform-details) | Dokan features and setup |
| Listeo Platform Spec | [LATEST_PLAN_2025_12_07.md#listeo-platform-details](LATEST_PLAN_2025_12_07.md#listeo-platform-details) | Listeo features and setup |
| Current Page Structure | [LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages](LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages) | All 28 existing pages |
| Missing Pages Analysis | [LATEST_PLAN_2025_12_07.md#missing-pages-analysis](LATEST_PLAN_2025_12_07.md#missing-pages-analysis) | Tier 1, 2, 3 gaps |
| Setup Checklist | [LATEST_PLAN_2025_12_07.md#setup-checklist](LATEST_PLAN_2025_12_07.md#setup-checklist) | Configuration checklist |
| WordPress Editing | [docs/WORDPRESS_EDITING_QUICK_START.md](docs/WORDPRESS_EDITING_QUICK_START.md) | How to edit pages |
| Brand Assets | [docs/BRAND_ANALYSIS_2025_12_07.md](docs/BRAND_ANALYSIS_2025_12_07.md) | Colors, fonts, style |
| Audit Report | [DIRECTORY_AUDIT_REPORT_2025_12_07.md](DIRECTORY_AUDIT_REPORT_2025_12_07.md) | System health & optimization |
| MCP Setup | [mcp-server-wordpress/README.md](mcp-server-wordpress/README.md) | Patch scripts for editing |
| Working Methodology | [CLAUDE.md](CLAUDE.md) | Development guidelines |

---

## 🔧 TOOLS & RESOURCES

**Available Tools**:
- ✅ Elementor MCP (page building automation)
- ✅ Respira WordPress MCP (safe AI editing)
- ✅ WordPress REST API (direct page editing)
- ✅ Listeo plugin (directory functionality)
- ✅ Dokan plugin (marketplace functionality)
- ✅ WooCommerce (product management)

**MCP Patch Scripts**:
- `bash mcp-server-wordpress/auto-patch-on-launch.sh` — Auto-patch on start

**WordPress Admin**:
- **URL**: https://beardsandbucks.com/wp-admin
- **User**: jeff
- **Password**: See .env file

---

## ⚠️ IMPORTANT CONSTRAINTS

**Brand Rules** (Always Remember):
- ✅ Whitetail deer only (no other animals)
- ✅ NO firearms anywhere
- ✅ Compound bows featured prominently
- ✅ Premium, modern-outdoorsman aesthetic
- ✅ Use exact color palette from docs/BRAND_ANALYSIS_2025_12_07.md

**Business Rules**:
- ✅ Only individuals in used gear marketplace (Dokan)
- ✅ Businesses/outfitters only in directory (Listeo)
- ✅ Illinois whitetail hunting focus
- ✅ No new gear or firearms

**Technical Rules**:
- ✅ See CLAUDE.md for development guidelines
- ✅ Always read files before editing
- ✅ Test changes before committing
- ✅ Keep LATEST_PLAN as source of truth

---

## 📝 NOTES

**Completed Cleanup (Dec 7, 2025)**:
- Removed 77 old files
- Saved 20MB+ disk space
- Optimized directory structure
- Created clear documentation hierarchy

**Current Status**:
- Project is clean and organized
- Ready to proceed with any of three options
- All prerequisites met
- Team context is well-documented

**Next Session**:
- Choose Option A, B, or C to proceed
- Mark chosen option as "in_progress"
- Follow task checklist for chosen option
- Update this TODO.md as work progresses

---

## 🚀 START HERE

**To begin work**:
1. Choose Option A, B, or C above
2. Mark chosen option as "in_progress"
3. Work through each checkbox
4. Create detailed report when complete
5. Commit changes to git with detailed message
6. Update this TODO.md with completion notes

**Questions?**
- Architecture details → [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md)
- Page editing → [docs/WORDPRESS_EDITING_QUICK_START.md](docs/WORDPRESS_EDITING_QUICK_START.md)
- Working methodology → [CLAUDE.md](CLAUDE.md)

---

**Created**: December 7, 2025
**Last Updated**: December 7, 2025
**Status**: ACTIVE - Ready for next phase selection
**Next Decision**: Which option (A, B, or C) to proceed with?
