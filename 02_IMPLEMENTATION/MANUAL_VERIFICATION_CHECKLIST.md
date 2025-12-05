# Manual WordPress Admin Verification Checklist
**Date:** 2025-12-05
**Purpose:** Verify root causes of critical issues by checking WordPress admin settings directly
**Target:** https://beardsandbucks.com/wp-admin/

---

## BEFORE YOU START

1. Open your browser
2. Go to: `https://beardsandbucks.com/wp-admin/`
3. Log in with your **production** WordPress admin credentials
4. Keep this checklist open in another window/tab

---

## VERIFICATION TASK 1: Check Listeo Core Plugin Status

**What to check:** Is the Listeo Core plugin active?

**Steps:**
1. In WordPress admin, click **Plugins** (left sidebar)
2. Look for a plugin named "Listeo" or "Listeo Core"
3. Check the status:
   - If it says **"Activate"** next to it → Plugin is INACTIVE ❌
   - If it says **"Deactivate"** next to it → Plugin is ACTIVE ✅

**What to report:**
- [ ] Plugin found?  YES / NO
- [ ] Plugin status? ACTIVE / INACTIVE
- [ ] Screenshot taken? YES / NO

**Take a screenshot** and paste it here when done.

---

## VERIFICATION TASK 2: Check Directory Page Shortcode

**What to check:** Is there a Listeo shortcode on the directory page?

**Steps:**
1. Click **Pages** (left sidebar)
2. Find and click on the **"Directory"** page (or "Find Vendors" page)
3. The page editor will open - look for one of these:
   - **Option A:** Elementor editor
     - If you see "Edit with Elementor" button → click it
     - Look in the left panel for "Listeo" widgets
     - Screenshot the Listeo widget section
   - **Option B:** Classic editor
     - Look at the page content/body
     - Search for text like `[listeo_vendors]` or `[listeo_listings]`
     - Screenshot the content area
4. Note what you see

**What to report:**
- [ ] Page found? YES / NO
- [ ] Using Elementor or Classic? ELEMENTOR / CLASSIC
- [ ] Listeo shortcode/widget found? YES / NO
- [ ] If YES - what's the shortcode/widget name? _________________
- [ ] Screenshot taken? YES / NO

**Take a screenshot** and paste it here when done.

---

## VERIFICATION TASK 3: Check Listeo Plugin Settings

**What to check:** Are Listeo settings configured?

**Steps:**
1. In WordPress admin left sidebar, look for **"Listeo"** menu item
2. Click on it (might be labeled "Listeo", "Listeo Settings", "Listings", etc.)
3. You should see a Listeo dashboard/settings page
4. Check these settings:

**Listing Post Type:**
- [ ] Is it enabled? YES / NO
- Screenshot this section

**Categories:**
- [ ] Are there any listing categories created? YES / NO
- [ ] If YES, how many? _____ categories
- Screenshot this section

**Map Provider:**
- [ ] What's selected? (Google Maps / Mapbox / None / Other?) _________________
- [ ] Screenshot this setting

**Search Filters:**
- [ ] Are search filters configured? YES / NO
- [ ] Screenshot this section

---

## VERIFICATION TASK 4: Check Vendor Data Exists

**What to check:** Are there vendor/listing entries in the database?

**Steps:**
1. In WordPress admin left sidebar, look for:
   - **"Posts"** (if listings are post type), OR
   - **"Listings"** (if custom post type), OR
   - **"Vendors"** (if custom type), OR
   - Similar under Listeo menu
2. Click on it to see the list of vendors/listings
3. Count how many entries you see

**What to report:**
- [ ] Menu item found? YES / NO
- [ ] Name of the menu? _________________
- [ ] How many vendor entries exist? _____ (or "None")
- [ ] Click one entry - does it have proper data? YES / NO
- [ ] Are entries assigned to categories? YES / NO
- [ ] Screenshot the list and one entry detail

---

## VERIFICATION TASK 5: Check Search Results Page

**What to check:** Does a Search Results page exist?

**Steps:**
1. Click **Pages** (left sidebar)
2. Look for a page named:
   - "Search Results"
   - "Listings Search"
   - "Search"
   - Or similar
3. If found:
   - Click to open it
   - Check the page content/body for shortcode like `[listeo_search_results]` or similar
   - Note the page URL (e.g., `/search-results/`)
4. If NOT found:
   - Report that it doesn't exist

**What to report:**
- [ ] Search Results page found? YES / NO
- [ ] If YES - URL? _________________
- [ ] If YES - shortcode present? YES / NO
- [ ] If YES - what's the shortcode? _________________
- [ ] Screenshot taken? YES / NO

---

## VERIFICATION TASK 6: Check Privacy Policy Page

**What to check:** Does Privacy Policy page exist?

**Steps:**
1. Click **Pages** (left sidebar)
2. Search for or scroll to find: **"Privacy Policy"**
3. If found:
   - Click it to open
   - Check it has content (not empty)
   - Note the URL (e.g., `/privacy-policy/`)
4. If NOT found:
   - Report that it doesn't exist

**What to report:**
- [ ] Privacy Policy page exists? YES / NO
- [ ] If YES - URL? _________________
- [ ] If YES - has content? YES / NO
- [ ] If YES - published? YES / NO
- [ ] Screenshot taken? YES / NO

---

## VERIFICATION TASK 7: Check Terms of Service Page

**What to check:** Does Terms of Service page exist?

**Steps:**
1. Click **Pages** (left sidebar)
2. Search for or scroll to find: **"Terms of Service"** or **"Terms & Conditions"**
3. If found:
   - Click it to open
   - Check it has content (not empty)
   - Note the URL (e.g., `/terms-of-service/`)
4. If NOT found:
   - Report that it doesn't exist

**What to report:**
- [ ] Terms page exists? YES / NO
- [ ] If YES - URL? _________________
- [ ] If YES - has content? YES / NO
- [ ] If YES - published? YES / NO
- [ ] Screenshot taken? YES / NO

---

## VERIFICATION TASK 8: Check Footer Menu

**What to check:** Does footer menu exist and have Privacy/Terms links?

**Steps:**
1. Click **Appearance** (left sidebar)
2. Click **Menus**
3. Look for a menu named:
   - "Footer Menu"
   - "Footer"
   - "Legal Links"
   - Or similar
4. If found:
   - Click to open it
   - Check what pages are in this menu
   - Look specifically for Privacy Policy and Terms of Service items
5. If NOT found:
   - Report that no footer menu exists

**What to report:**
- [ ] Footer menu exists? YES / NO
- [ ] If YES - menu name? _________________
- [ ] Privacy Policy in menu? YES / NO
- [ ] Terms of Service in menu? YES / NO
- [ ] Menu assigned to footer location? YES / NO
- [ ] Screenshot taken? YES / NO

---

## VERIFICATION TASK 9: Check Font 404 Errors (Frontend)

**What to check:** Are there actual font 404 errors in the browser console?

**Steps:**
1. Go to homepage: `https://beardsandbucks.com/`
2. Open browser DevTools: Press **F12**
3. Click on **Console** tab
4. Look for error messages containing:
   - "404"
   - "raleway" or "woff2"
   - "font" errors
5. Take a screenshot of any errors you see

**What to report:**
- [ ] Console open? YES / NO
- [ ] Font 404 errors visible? YES / NO
- [ ] If YES - what font file? _________________
- [ ] Screenshot taken? YES / NO

---

## SUMMARY REPORT

After completing all 9 tasks, create a summary:

```
## FINDINGS SUMMARY

✅ = Verified and working
❌ = Not working / Missing
❓ = Could not determine

### CRITICAL ISSUES:

1. Listeo Plugin Status: ✅ / ❌ / ❓
   Finding: _________________________________

2. Directory Shortcode: ✅ / ❌ / ❓
   Finding: _________________________________

3. Listeo Settings: ✅ / ❌ / ❓
   Finding: _________________________________

4. Vendor Data: ✅ / ❌ / ❓
   Finding: _________________________________

5. Search Results Page: ✅ / ❌ / ❓
   Finding: _________________________________

6. Privacy Policy Page: ✅ / ❌ / ❓
   Finding: _________________________________

7. Terms of Service Page: ✅ / ❌ / ❓
   Finding: _________________________________

8. Footer Menu: ✅ / ❌ / ❓
   Finding: _________________________________

9. Font 404 Errors: ✅ / ❌ / ❓
   Finding: _________________________________

### ROOT CAUSE MOST LIKELY:
Based on findings above, the root cause is most likely:
- [ ] Scenario A: Shortcode not placed on directory page
- [ ] Scenario B: Listeo plugin is inactive
- [ ] Scenario C: Listeo plugin settings incomplete
- [ ] Scenario D: Database has no vendor data
- [ ] Multiple issues combined

### CONFIDENCE LEVEL:
HIGH / MEDIUM / LOW
```

---

## NEXT STEPS

1. **Complete all 9 verification tasks above**
2. **Take screenshots** for each task
3. **Paste findings and screenshots here** in the chat
4. **I will analyze** and tell you exactly what to fix

---

**Status:** Ready for manual verification
**Last Updated:** 2025-12-05
