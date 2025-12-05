# Antigravity Verification Prompt
**Date:** 2025-12-05
**Purpose:** Validate root causes identified in LISTEO_ANTIGRAVITY_ANALYSIS.md
**Target:** https://beardsandbucks.com/
**Task:** Browser agent verification - click real things, check actual settings, capture evidence

---

## CRITICAL INSTRUCTION

**DO NOT HALLUCINATE.** Every action must be:
- An actual click on a visible DOM element
- A real navigation to a page that loads
- A verification of actual WordPress admin settings
- A screenshot or console output of what you find

If you cannot find something, report that explicitly. Do not guess or make up what settings might exist.

---

## Verification Tasks (In Order)

### TASK 1: Verify Plugin Status (C-01 Root Cause - Scenario B)
**What we think:** Listeo Core plugin might be inactive
**What you need to verify:** Is it actually active?

**Steps:**
1. Navigate to: `https://beardsandbucks.com/wp-admin/`
2. Login with provided credentials (if needed)
3. Go to: **Plugins** (in left sidebar)
4. Search for: "Listeo" or "Listeo Core"
5. Check the plugin status:
   - If it says "Activate" → Plugin is INACTIVE ✗
   - If it says "Deactivate" → Plugin is ACTIVE ✓
6. **Take a screenshot** showing the plugin list with Listeo plugin visible
7. **Report:** Is Listeo Core plugin active or inactive?

**Expected Finding:** We think it might be inactive, but verify actual status

---

### TASK 2: Verify Directory Page Content (C-01 Root Cause - Scenario A)
**What we think:** Shortcode `[listeo_vendors]` might not be on the directory page
**What you need to verify:** Is the shortcode actually there?

**Steps:**
1. Go to: **Pages** in WordPress admin
2. Find and click: "Directory" page (or "Find Vendors" page)
3. Check if page is edited with:
   - Elementor editor (look for "Edit with Elementor" button)
   - Classic editor (look at page content)
4. **Look for shortcode:** Search the page content for:
   - `[listeo_vendors]`
   - `[listeo_listings]`
   - Or Elementor widgets labeled "Listeo" (Listings Grid, Search Form, etc.)
5. **Take a screenshot** of the page editor showing what's actually there
6. **Report:** Is there a Listeo shortcode/widget on the directory page, or is it empty?

**Expected Finding:** We think the shortcode might be missing, verify actual content

---

### TASK 3: Verify Listeo Plugin Settings (C-01 Root Cause - Scenario C)
**What we think:** Listeo Core settings might be incomplete (categories, listing post type, map provider)
**What you need to verify:** What are the actual plugin settings?

**Steps:**
1. In WordPress admin, look for: **Listeo** menu item (or similar)
2. Click on it - should open Listeo plugin settings/dashboard
3. Check these settings:
   - **Listing Post Type:** Is it enabled? (Yes/No)
   - **Categories:** Are there any listing categories created? (Count them)
   - **Map Provider:** What's configured? (Google Maps, Mapbox, None?)
   - **Search Filters:** Are they configured?
4. **Take a screenshot** of the Listeo settings page
5. **Report:** What settings are configured vs missing?

**Expected Finding:** We think configuration might be incomplete - verify what's actually set up

---

### TASK 4: Verify Vendor Data Exists (C-01 Root Cause - Scenario D)
**What we think:** There might be no vendor/listing data in the database
**What you need to verify:** Are there actual vendor entries created?

**Steps:**
1. In WordPress admin, look for: **Posts** or **Listings** menu item
2. Click it - should show a list of vendor/listing entries
3. Count visible entries
4. If entries exist:
   - Click one to verify it has data (title, category, description, etc.)
   - Check if it's assigned to a category
5. If NO entries exist:
   - Report that database is empty
6. **Take a screenshot** of the listings/posts list
7. **Report:** How many vendor entries exist? Do they have proper category assignments?

**Expected Finding:** We think database might be empty or has test data - verify actual count

---

### TASK 5: Verify Search Widget Configuration (C-02 Root Cause - Scenario A)
**What we think:** Search widget on homepage might not point to a results page
**What you need to verify:** Where does the search widget point to?

**Steps:**
1. Navigate to: **Homepage** (https://beardsandbucks.com/)
2. Identify the search bar/widget visible on the page
3. Right-click on it and inspect (or use browser dev tools F12)
4. Look for:
   - Form action URL - where does it submit to?
   - Hidden input showing destination page
   - JavaScript event handler
5. Go to WordPress admin → **Pages**
6. Look for a "Search Results" page:
   - Does it exist? (Yes/No)
   - If yes, what's its URL?
   - What shortcode is on it? ([listeo_search_results]? Something else?)
7. **Take screenshots** of:
   - The search widget in browser dev tools
   - The search results page (if it exists) in WordPress admin
8. **Report:** Does search widget have a results page configured? What's the shortcode on the results page?

**Expected Finding:** We think search results page might be missing or misconfigured - verify actual setup

---

### TASK 6: Verify Legal Pages Exist (C-04 Root Cause)
**What we think:** Privacy Policy and Terms of Service pages don't exist
**What you need to verify:** Do these pages actually exist?

**Steps:**
1. Go to WordPress admin → **Pages**
2. Search for or scroll to find:
   - "Privacy Policy" page
   - "Terms of Service" or "Terms & Conditions" page
3. For each page that exists:
   - Click it to open in editor
   - Check the URL slug (e.g., /privacy-policy/)
   - Verify content exists (at least some text)
   - Check publish status
4. For each page that's missing:
   - Report that it doesn't exist
5. **Take a screenshot** showing the Pages list
6. **Report:** Which pages exist and which are missing?

**Expected Finding:** We think both pages are missing - verify actual status

---

### TASK 7: Verify Footer Menu Links (C-04 Root Cause)
**What we think:** Footer menu might not exist or doesn't have Privacy/Terms links
**What you need to verify:** What's actually in the footer menu?

**Steps:**
1. Go to WordPress admin → **Appearance → Menus**
2. Look for a "Footer" menu or "Legal Links" menu
3. If it exists:
   - Click to open
   - Check what pages are in it
   - Look for Privacy Policy and Terms of Service items
   - Check if menu is assigned to "Footer Menu" location
4. If it doesn't exist:
   - Report that no footer menu exists
5. Navigate to: **Homepage footer** (scroll to bottom of https://beardsandbucks.com/)
6. Look for Privacy Policy and Terms of Service links
7. **Take screenshots** of:
   - WordPress menu editor showing footer menu (if it exists)
   - Homepage footer area showing what links are visible
8. **Report:** Does footer menu exist? What links are in it? Are Privacy/Terms visible in actual footer?

**Expected Finding:** We think footer menu is missing or incomplete - verify actual setup

---

### TASK 8: Font 404 Errors Verification (I-01)
**What we think:** Raleway font files are returning 404 errors
**What you need to verify:** Are font 404s actually happening?

**Steps:**
1. Go to: https://beardsandbucks.com/
2. Open browser DevTools (F12 → Console tab)
3. Look for any error messages mentioning:
   - "404"
   - "raleway" or "woff2"
   - "font" or "css"
4. **Take a screenshot** of the console showing any errors
5. Go to: **Sources** or **Network** tab in DevTools
6. Look for failed requests (shown in red):
   - Filter for "font" or ".woff2" files
   - Take screenshot of any 404s
7. **Report:** Are there actual font 404 errors in the console/network tab?

**Expected Finding:** We think font files are missing - verify if errors actually appear

---

## Summary Template (For Your Report Back)

After completing all 8 tasks, provide a summary:

```
## ANTIGRAVITY VERIFICATION RESULTS

### Task 1: Plugin Status
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [What you actually found - is it active/inactive?]

### Task 2: Directory Shortcode
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [Shortcode present? Which one?]

### Task 3: Listeo Settings
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [What settings are configured?]

### Task 4: Vendor Data
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [How many vendors exist? Categories assigned?]

### Task 5: Search Widget
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [Does search point to results page? Which page?]

### Task 6: Legal Pages
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [Privacy Policy exists? Terms exists? Both missing?]

### Task 7: Footer Menu
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [Footer menu exists? Has Privacy/Terms links?]

### Task 8: Font Errors
✓ VERIFIED / ✗ NOT VERIFIED
Finding: [Actual 404 errors in console?]

## CONFIDENCE LEVEL
Based on actual browser clicks and admin verification: [High/Medium/Low]

## ROOT CAUSE VALIDATION
Which root cause scenario (A/B/C/D) is actually correct based on what you found?
```

---

## Important Notes

- **Do not guess** - if you can't find something, say so explicitly
- **Screenshot everything** - visual evidence is critical
- **Click real elements** - verify the DOM, don't hallucinate settings
- **Check actual vs reported** - compare what Antigravity initially reported vs what you find now
- **Report discrepancies** - if you find something different than our analysis predicted, note it

**Goal:** Give us 100% confidence that the issues are real and the root causes are correctly identified before implementation begins.

---

**Created:** 2025-12-05
**Status:** Ready for Antigravity verification
