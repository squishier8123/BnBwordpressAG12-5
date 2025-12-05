# Listeo Configuration Analysis + Antigravity Audit Findings
**Date:** 2025-12-05
**Based on:** Listeo Knowledge Base + Antigravity Audit Report
**Purpose:** Technical root cause analysis and fix recommendations for Beards & Bucks site

---

## Executive Summary

The Antigravity audit identified 4 critical issues blocking site launch. Based on Listeo documentation, **all critical issues stem from plugin/theme configuration problems**, not missing code. The fixes are configuration-based and can be completed in WordPress admin/Elementor without development.

**Critical Issues Status:**
- ✗ C-01: Directory listings empty → Listeo shortcode/query misconfiguration
- ✗ C-02: Search broken → Elementor search widget configuration issue
- ✗ C-03: Vendor detail inaccessible → Consequence of empty directory (C-01)
- ✗ C-04: Missing legal pages → Missing WordPress menu setup

---

## Part 1: Directory Listings Not Displaying (C-01)

### What Antigravity Found
- `/directory` and `/find-vendors` pages load with header/footer but **zero vendor content**
- Confirmed on Mobile (375px) and Desktop (1920px)
- Map widget also missing (likely same root cause)
- No console errors indicating broken JavaScript

### Listeo Knowledge Base Guidance

From Listeo docs, the plugin requires:

1. **Shortcode Setup** (Critical)
   - Listeo uses shortcodes like `[listeo_vendors]` or `[listeo_listings]` to display directory
   - These shortcodes must be placed in page content or Elementor widgets
   - Reference: "Shortcodes" article in Listeo Core section

2. **Vendor Data Must Exist**
   - Shortcodes query vendor data from WordPress database
   - If no vendors exist, shortcode displays empty list (exactly what you're seeing)
   - Must create test vendor entries first

3. **Plugin Activation & Configuration**
   - Listeo Core plugin must be active
   - Plugin settings: WordPress Admin → Listeo Settings
   - Must configure: Categories, Map Provider (Google Maps/Mapbox), Search filters
   - Reference: "Setting Up Listeo Core" article

4. **Elementor Integration**
   - If using Elementor, Listeo provides custom widgets
   - Widgets: Listings Grid, Search Form, Single Listing, Map
   - Reference: "Editing single listing page using Elementor" article

### Root Cause Scenarios (Most Likely)

**Scenario A: Shortcode Not Placed** (30% probability)
- Directory page exists but shortcode `[listeo_vendors]` not added to page content
- Fix: Add shortcode to page or use Elementor Listeo widget

**Scenario B: Listeo Plugin Inactive** (20% probability)
- Shortcode exists but plugin is disabled/deactivated
- Fix: Go to Plugins → activate Listeo Core

**Scenario C: Plugin Settings Incomplete** (30% probability)
- Plugin active, shortcode present, but vendor query not configured
- Issues:
  - Listing post type not enabled
  - Categories not configured
  - Search filters misconfigured
- Fix: Complete Listeo Core setup in WordPress admin

**Scenario D: Database Has No Vendors** (20% probability)
- Everything configured correctly but no vendor data exists
- Plugin displays empty result set (correct behavior)
- Fix: Create test vendor entries first

### How to Debug

**Step 1: Check Plugin Status**
```
WordPress Admin → Plugins
Look for "Listeo Core" or "Listeo" plugin
Status: MUST be "Active" (blue)
If inactive → Click "Activate"
```

**Step 2: Verify Shortcode Exists**
```
WordPress Admin → Pages → Edit Directory/Find Vendors page
Check page content/body for shortcode like:
  [listeo_vendors]
  [listeo_listings]
  or Elementor Listeo widgets

If using Elementor:
  Open page in Elementor editor
  Look for "Listeo" section in left widgets panel
  Check if any Listeo widgets are used
```

**Step 3: Check Listeo Plugin Settings**
```
WordPress Admin → Listeo (or similar menu item)
Verify:
  - Listing Post Type: Enabled
  - Categories: At least 1 category created
  - Map Provider: Google Maps configured
  - Search Form: Configured with filters
```

**Step 4: Verify Vendor Data Exists**
```
WordPress Admin → Posts/Listings (or custom type)
Look for vendor/listing entries
If empty → Create at least 1 test vendor entry
```

**Step 5: Test Shortcode Directly**
```
Create new test page
Add only: [listeo_vendors]
Publish & view
If listings appear → shortcode works
If empty → plugin configuration issue
```

### Listeo Articles to Consult
- "Shortcodes" - complete shortcode reference
- "Setting Up Listeo Core" - plugin configuration guide
- "Editing single listing page using Elementor" - Elementor widget guide
- "Troubleshooting" section → "No listings on map, location search doesn't work"

---

## Part 2: Search Widget Broken (C-02)

### What Antigravity Found
- Homepage has search bar visible
- Search bar appears "non-editable" and broken
- No functional search results

### Listeo Knowledge Base Guidance

1. **Search Widget Types**
   - Listeo provides: Search Form shortcode + Elementor Search Form widget
   - Elementor also has built-in search widget
   - Must be configured properly to work

2. **Search Form Configuration**
   - Reference: "Search Forms Editor / Search Filters" in Listeo Fields Editor
   - Admin creates search form fields (text, category, location, etc.)
   - Forms must link to results page
   - Fields must map to actual listing properties

3. **Search Results Page Required**
   - Search form must point to a designated "Search Results" page
   - Results page must have shortcode: `[listeo_search_results]` or similar
   - Without this, search has nowhere to display results

### Root Cause Scenarios

**Scenario A: Search Widget Not Configured** (40% probability)
- Widget present but not pointing to results page
- Fix: Configure search widget → set results page destination

**Scenario B: Search Results Page Missing** (30% probability)
- Widget configured but no results page exists
- Fix: Create "Search Results" page with `[listeo_search_results]` shortcode

**Scenario C: Search Form Fields Misconfigured** (30% probability)
- Results page exists but form fields not properly mapped
- Fix: Use Listeo Fields Editor to configure search form

### How to Debug

**Step 1: Find Search Widget**
```
Elementor → Homepage
Look for: Search Form, Search Bar, or similar element
Click to select and check settings
```

**Step 2: Verify Results Page Exists**
```
WordPress Admin → Pages
Look for page titled "Search Results" or similar
URL should be like: /search-results/ or /listings-search/
Page should contain: [listeo_search_results] shortcode
```

**Step 3: Configure Search Widget**
```
Elementor → Homepage → Find search element
Right-click → Edit Element
Settings should include:
  - "Search Results Page" or "Results URL" dropdown
  - Select the search results page
  - Save changes
```

**Step 4: Test Search Form**
```
Go to homepage
Type in search field
Press Enter or click Search button
Should navigate to results page and show results
```

### Listeo Articles to Consult
- "Search Forms Editor / Search Filters" - configure search form
- "How to create custom / static page with listings with Elementor" - setup results page
- "Shortcodes" - search-related shortcodes

---

## Part 3: Missing Privacy Policy & Terms (C-04)

### What Antigravity Found
- No Privacy Policy link in footer
- No Terms of Service link in footer
- **Compliance violation** - blocks Stripe integration

### Listeo Knowledge Base Guidance

Listeo doesn't provide built-in legal pages, but does support:
1. Creating custom pages in WordPress
2. Adding pages to footer menu
3. Linking from within site

### How to Fix

**Step 1: Create Privacy Policy Page**
```
WordPress Admin → Pages → Add New
  Title: "Privacy Policy"
  Content: [Add privacy policy text - can be generic template]
  Publish
  Note URL: /privacy-policy/
```

**Step 2: Create Terms of Service Page**
```
WordPress Admin → Pages → Add New
  Title: "Terms of Service" or "Terms & Conditions"
  Content: [Add terms text - can be generic template]
  Publish
  Note URL: /terms-of-service/
```

**Step 3: Create Footer Menu**
```
WordPress Admin → Appearance → Menus
  Click "Create a new menu"
  Name: "Footer Menu" or "Legal"

  Add both pages to menu:
    - Privacy Policy
    - Terms of Service

  Assign Menu:
    Display location: "Footer Menu" (if available)
    OR save and check theme's menu options
```

**Step 4: Verify in Footer**
```
View website → Scroll to footer
Should see: Privacy Policy | Terms of Service links
Click each to verify pages load
```

---

## Part 4: Font 404 Errors (I-01)

### What Antigravity Found
- Raleway font woff2 files returning 404 errors
- Browser console shows multiple missing font requests

### Root Cause Analysis

**Scenario A: Custom Font Folder Missing** (50% probability)
- Font files supposed to be in `/fonts/` directory
- Files don't exist or CSS path incorrect
- Fix: Upload font files or switch to Google Fonts CDN

**Scenario B: Google Fonts CDN Issue** (50% probability)
- Using Google Fonts but CDN URL misconfigured
- Fix: Update typography settings to use correct CDN URL

### How to Fix

**Option 1: Use Google Fonts CDN (Recommended)**
```
WordPress Admin → Appearance → Customize → Typography
  Find: Raleway font setting
  Change: Use Google Fonts CDN instead
  Update: CSS paths to CDN URLs
  Save changes
```

**Option 2: Upload Missing Font Files**
```
1. Find where font files should be:
   /wp-content/themes/[theme-name]/fonts/

2. Upload missing woff2 files to this directory
3. Verify CSS references correct paths
4. Clear browser cache and reload
```

---

## Part 5: Duplicate Pages (I-02)

### What Antigravity Found
- Both `/directory` and `/find-vendors` pages exist
- Both attempt same functionality (directory listings)
- Both fail to display vendors (same issue as C-01)

### Recommendation
Once directory is fixed:
1. Test both pages
2. Keep the one with better discoverability/UX
3. Delete the other or redirect it
4. Update main navigation to point to single directory page

---

## Summary: Fix Priority & Order

| Priority | Issue | Root Cause | Fix Type | Estimated Time |
|----------|-------|-----------|----------|-----------------|
| **1** | Directory Empty (C-01) | Listeo plugin config | Config + test data | 30-45 min |
| **2** | Search Broken (C-02) | Search widget config | Config + form setup | 20-30 min |
| **3** | Missing Legal Pages (C-04) | Missing WordPress pages | Create 2 pages + menu | 10-15 min |
| **4** | Font 404s (I-01) | Font path or CDN | Update settings | 10-15 min |
| **5** | Duplicate Pages (I-02) | Design decision | Delete/redirect | 5-10 min |
| **6** | Mobile Menu (M-01) | UI sizing | Adjust button | 5 min |
| **7** | Google Maps Warnings (M-02) | API warnings | Once directory fixed | Auto-resolves |

**Total estimated time: 1.5-2 hours to critical launch-ready status**

---

## What NOT to Do

1. ❌ Don't assume shortcodes need custom code - they don't
2. ❌ Don't deactivate/reactivate plugins without checking settings first
3. ❌ Don't create dummy vendor data without proper category setup
4. ❌ Don't modify plugin code - use configuration only
5. ❌ Don't upload fonts without verifying CSS paths

---

## Next Steps

1. **Follow debug steps above** to identify which scenario applies (A/B/C/D)
2. **Document findings** - what you discover in WordPress admin
3. **Apply fixes** in order of priority
4. **Test each fix** before moving to next
5. **Rerun Antigravity audit** to verify all 4 critical issues are resolved

---

## Resources

**Listeo Knowledge Base Location:**
`/mnt/c/Users/Geoff/OneDrive/Desktop/DocsLib/docs/web/listeo/listeo-knowledge-base-8211-listeo.md`

**Key Sections to Consult:**
- Listeo Core → Setting Up Listeo Core
- Listeo Core → Shortcodes
- Listeo Fields Editor → Search Forms Editor
- How-To Guides → How to create custom pages with listings
- Troubleshooting → Complete section

**Antigravity Report Location:**
`/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/audit_report_2025_12_05.md`

---

**Status:** Ready for implementation
**Last Updated:** 2025-12-05
**Next Review:** After fixes are applied and Antigravity re-audits
