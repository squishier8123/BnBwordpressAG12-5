# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

---

## Project Overview

**Beards & Bucks** — A premium WordPress platform for Illinois whitetail hunting combining:
- **Listeo Directory**: Hunting services (outfitters, lodging, gear vendors) with search, filters, reviews, booking
- **Dokan Marketplace**: Used archery/hunting gear seller platform with vendor dashboard, products, commissions
- **WooCommerce**: E-commerce backend for both systems
- **Elementor**: Page builder for custom layouts

**Site**: https://beardsandbucks.com | **Git**: Master branch is live

---

## Architecture & Key Files

### Two-System Architecture
```
Users (1 shared WordPress database)
├── System 1: Listeo (Vendor Listings/Services)
│   ├── Hunting outfitters, lodging vendors, gear shops
│   ├── Subscription tiers (Free → Pro)
│   ├── Search, filters, reviews, booking
│   └── Pages: Browse by County, Vendor Directory
│
└── System 2: Dokan (Gear Marketplace)
    ├── Individual sellers listing used equipment
    ├── Commission-based revenue
    ├── Vendor dashboard
    └── Pages: Vendor Dashboard, Store List, Register as Vendor
```

### Primary Reference Files (Read These First)
1. **LATEST_PLAN_2025_12_07.md** — Complete architecture, current pages (28), missing pages analysis
2. **README.md** — Quick navigation and current status
3. **DOCUMENTATION_INDEX.md** — Access to all reference docs (Listeo, WordPress, WooCommerce, Dokan, Elementor source code)
4. **docs/WORDPRESS_EDITING_QUICK_START.md** — How to edit pages
5. **docs/BRAND_ANALYSIS_2025_12_07.md** — Brand colors, design system

### Directory Structure
```
root/
├── LATEST_PLAN_2025_12_07.md    ⭐ PRIMARY SOURCE OF TRUTH
├── README.md                      Quick reference
├── CLAUDE.md                      This file
├── DOCUMENTATION_INDEX.md         Reference docs location
├── TODO.md                        Project todo list
├── .env                           Credentials (NOT in git)
├── .env.example                   Template
├── .mcp.json                      MCP configuration
├── package.json                   Dependencies
│
├── docs/                          Documentation
│   ├── WORDPRESS_EDITING_QUICK_START.md
│   ├── BRAND_ANALYSIS_2025_12_07.md
│   ├── reference/
│   │   └── official-docs/         ALL EXTERNAL DOCS (33.5 MB)
│   │       ├── listeo/            Listeo Knowledge Base
│   │       ├── wordpress/         WordPress API docs
│   │       ├── woocommerce/       WooCommerce API docs
│   │       ├── dokan/             Dokan plugin docs
│   │       ├── elementor/         Elementor plugin source (1,830 files)
│   │       └── migrations/        Migration guides
│   ├── guides/                    Session summaries & planning
│   ├── reports/                   Verification & analysis
│   └── archived-reports/          Historical reports
│
├── plugins/                       WordPress must-use plugins
│   ├── beards-bucks-redirects-mu.php
│   ├── beards-bucks-styles-mu.php
│   └── beards-bucks-custom-styles.php
│
├── mcp-server-wordpress/          Elementor & Respira MCP patches
├── tests/                         Playwright test files
├── brand-assets/                  Logo and branding
└── [other working directories]
```

---

## Critical Implementation Details

### Brand Identity (Always Remember These)
**Content Constraints**:
- ✅ Whitetail deer ONLY (no other animals, no firearms sales)
- ✅ Compound bows featured prominently
- ✅ Premium, modern-outdoorsman aesthetic
- ✅ Golden-hour photography style
- ✅ Illinois whitetail hunting focus

**Brand Colors** (Use Exactly):
```
Primary:    #414833, #333D29, #656D4A, #A4AC86, #C2C5AA
Secondary:  #B6AD90, #A68A64, #936639, #7F4F24, #582F0E
```

### Current Site Status
- **Live Site**: https://beardsandbucks.com (PRODUCTION)
- **Admin Panel**: https://beardsandbucks.com/wp-admin
- **Username**: jeff
- **Current Pages**: 28 published (listed in LATEST_PLAN_2025_12_07.md)
- **Active Homepage**: Home 3 (ID: 4370)
- **MCP Status**: Elementor MCP + Respira WordPress MCP configured

### WordPress Setup
- **Theme**: Listeo (premium WordPress theme for services directory)
- **Plugins**:
  - Dokan v4.2.1 (multi-vendor marketplace)
  - WooCommerce (e-commerce backend)
  - Elementor Pro v3.33.1 (page builder)
  - Custom must-use plugins in `/plugins/`

---

## How to Edit Pages in WordPress

### Quick Reference
1. Go to https://beardsandbucks.com/wp-admin
2. Login with: jeff | [password in .env]
3. **Elementor Method** (Recommended):
   - Pages → Find page → "Edit with Elementor"
   - Drag widgets, change styles, save
4. **WordPress Editor Method**:
   - Pages → Find page → "Edit"
   - Edit HTML/content directly

### Page IDs (Quick Lookup)
See LATEST_PLAN_2025_12_07.md for complete list. Examples:
- Home 3: ID 4370
- Browse by County: ID 4687
- Vendor Dashboard: ID 4246
- Store List: ID 4546

### Important Gotchas
- **Page Duplicates**: Respira creates duplicates for safety before editing live pages
- **Mobile Responsive**: Test all pages on mobile before publishing
- **Brand Colors**: Use the exact color codes above, not approximations
- **Content Constraints**: Never add firearms, non-whitetail animals, or cheap gear imagery

---

## Working with Elementor

### What You Have Access To
Complete Elementor Pro v3.33.1 source code (1,830 files, 28 MB) in `docs/reference/official-docs/elementor/` including:
- **elementor-pro/** — Full page builder plugin with all widgets
- **elementor-addons/** — Additional widget packs
- **listeo-elementor/** — Listeo-specific widgets for directory features

### Building Pages with Elementor
1. Open Elementor editor in WordPress
2. Drag widgets from left panel to canvas
3. Configure widget settings (content, style, responsive)
4. Use Listeo widgets for: listing cards, directory display, vendor profiles
5. Save as Global Template for reuse across pages
6. Test responsive design before publishing

### Custom Widgets in Elementor
Study the source code in `docs/reference/official-docs/elementor/` to:
- Understand widget structure and API
- Learn how Listeo widgets integrate with directory data
- Create custom widgets following Elementor patterns

---

## Testing & Verification

### Playwright Tests
```bash
npm install          # Install dependencies
npm test             # Run all tests
npx playwright test  # Run specific test
```

**Test Location**: `/tests/` directory
**Results**: `/test-results/` directory

### What Gets Tested
- Page accessibility and load time
- Brand color compliance
- Responsive design (desktop/mobile/tablet)
- Navigation and links
- Elementor widget rendering

### Running Tests
Tests verify the live site at https://beardsandbucks.com. Run before major changes to establish baseline, then after changes to verify no regressions.

---

## MCP Servers (Page Building Automation)

### Two MCPs Configured
1. **elementor-mcp** — Automate Elementor page building
2. **respira-wordpress-mcp** — Safe AI editing with duplicate protection

### Configuration
- Location: `.mcp.json` (main config)
- Permissions: `.claude/settings.local.json`
- Scripts: `mcp-server-wordpress/` (patch files)

### How It Works
- When editing pages, Respira automatically creates a duplicate
- Changes are made to the duplicate
- You approve the changes in WordPress admin to replace original
- Safe by default — no destructive operations without confirmation

---

## Common Development Tasks

### Building a New Page
1. Design the layout in `docs/reference/` or mockup
2. Create page in WordPress (or use duplicate of similar page)
3. Edit with Elementor
4. Use Listeo widgets for directory content
5. Apply brand colors from BRAND_ANALYSIS_2025_12_07.md
6. Test mobile responsive design
7. Publish and verify URL works

### Fixing Page Layout
1. Identify issue in WordPress editor
2. Use Elementor to adjust widget layout/styles
3. Check responsive design (desktop, tablet, mobile)
4. Save and test
5. If issues, check brand color constraints and layout specifications

### Adding Content to Existing Pages
1. WordPress Editor or Elementor
2. Add text, images, widgets
3. Use Listeo widgets for dynamic directory content (searches, filters)
4. Verify brand compliance
5. Save

### Deploying Changes
- All changes made directly to live site (https://beardsandbucks.com)
- WordPress handles versioning/revisions automatically
- Respira duplicates provide rollback capability
- Git is for documentation/tracking, not deployment

---

## Directory Organization

### Where to Put Things
- **Documentation**: `docs/` (guides, reports, reference)
- **WordPress Plugins**: `plugins/` (must-use plugins, deploy to wp-content/mu-plugins/)
- **Test Files**: `tests/`
- **Extracted Reference Docs**: `docs/reference/official-docs/`

### File Naming Convention
- Session summaries: `SESSION_SUMMARY_2025_12_XX.md`
- Reports: `*_REPORT_2025_12_XX.md`
- Implementation guides: `*_GUIDE.md`
- Archived docs: Move to `docs/archived-reports/2025-12-XX/`

---

## Key Vendor/Plugin Information

### Listeo
- **What it does**: Directory platform for hunting services (outfitters, lodging, gear shops)
- **Key Features**: Listings, search, filters, reviews, booking, subscription tiers
- **Documentation**: See `docs/reference/official-docs/listeo/listeo-knowledge-base-8211-listeo.md`
- **Theme Pages**: Browse by County, Vendor Directory, Vendor Profile

### Dokan
- **What it does**: Multi-vendor marketplace for used hunting/archery gear
- **Key Features**: Vendor dashboard, product management, commission tracking, payouts
- **Documentation**: See `docs/reference/official-docs/dokan/` (3 verification docs)
- **Critical Issues** (from verification): Vendor store disabled, missing seller role, incomplete vendor profile
- **Marketplace Pages**: Vendor Dashboard, Store List, Register as Vendor

### WooCommerce
- **What it does**: E-commerce backend for product inventory and orders
- **Integration**: Powers both Listeo services AND Dokan gear marketplace
- **Documentation**: See `docs/reference/official-docs/woocommerce/`

### Elementor
- **What it does**: Visual page builder for WordPress
- **Current Version**: Pro v3.33.1
- **Integration**: All custom page layouts built with Elementor
- **Reference**: Full source code available in `docs/reference/official-docs/elementor/`
  - 1,830 files including all widgets, CSS, JavaScript
  - Study for understanding page builder behavior, creating custom widgets

---

## Debugging & Support

### If Page Won't Load
1. Check WordPress admin logs
2. Verify Elementor widget compatibility
3. Check brand color CSS in `plugins/beards-bucks-styles-mu.php`
4. Check redirect rules in `plugins/beards-bucks-redirects-mu.php`

### If Elementor Widget Not Rendering
1. Clear WordPress cache
2. Check widget compatibility with Elementor Pro version
3. Review widget settings (may have invalid references)
4. Check JavaScript console in browser developer tools

### If Page Layout Looks Wrong
1. Check responsive design settings in Elementor
2. Verify brand colors are applied (compare to BRAND_ANALYSIS_2025_12_07.md)
3. Check if custom CSS in style plugin is interfering
4. Test in incognito mode (may be cache issue)

### Reference Documentation
- **Complete Architecture**: LATEST_PLAN_2025_12_07.md
- **Editing Guide**: docs/WORDPRESS_EDITING_QUICK_START.md
- **Brand Standards**: docs/BRAND_ANALYSIS_2025_12_07.md
- **External Docs**: docs/reference/official-docs/ (Listeo, WordPress, WooCommerce, Dokan, Elementor source)

---

## Git & Version Control

### Current State
- Main branch: Master (PRODUCTION - do not force push)
- Status: Clean working tree, ready for development
- Last major changes: Directory cleanup (Dec 8), Page builds (Dec 9)

### Commit Strategy
- Small, focused commits with clear messages
- Reference task/issue in commit message when possible
- Don't commit `.env` files (use .gitignore rules)
- Push to GitHub after testing changes

---

## Performance Notes

### Site Optimization
- Elementor pages with full responsive design (mobile-first)
- Brand colors and styling via must-use plugins (fast loading)
- WooCommerce and Dokan optimized for product listing performance
- Playwright tests verify load times and rendering

### Caching
- WordPress handles caching automatically
- Clear cache if content changes aren't showing
- Elementor cache may need clearing for CSS/JS changes

---

## Next Steps

Choose one path forward (all are eventually needed):

**Option A**: Verify existing Dokan setup (30 mins)
- Confirm Dokan pages, configuration, permissions
- See DOKAN_VERIFICATION_REPORT_2025_12_07.md

**Option B**: Build missing pages (2-3 hours)
- Create Tier 1 priority pages
- See MISSING_PAGES_BUILD_REPORT_2025_12_09.md

**Option C**: Customize Dokan (1 hour)
- Design seller profiles, custom product fields
- Plan marketplace user experience

See LATEST_PLAN_2025_12_07.md for complete details on each option.

---

## Quick Command Reference

```bash
# Install dependencies
npm install

# Run tests
npm test

# Run specific test file
npx playwright test tests/filename.spec.js

# Check test results
npx playwright show-report
```

---

## Useful Links

- **WordPress Admin**: https://beardsandbucks.com/wp-admin
- **Elementor Editor**: Click "Edit with Elementor" on any page
- **Site Frontend**: https://beardsandbucks.com
- **Documentation Index**: See DOCUMENTATION_INDEX.md (33.5 MB of reference docs)

---

**Last Updated**: December 10, 2025
**Status**: Ready for development with complete documentation and reference materials
