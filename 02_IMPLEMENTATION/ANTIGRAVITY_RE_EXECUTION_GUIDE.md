# Antigravity Re-Execution Guide - 6 Fixes
**Date:** 2025-12-06
**Status:** Ready for browser agent execution
**Context:** Site was restored from 2025-12-05 backup. The 6 fixes need to be re-applied.

---

## Background

The Beards & Bucks WordPress site was restored from a backup due to a corrupted wp-config.php file. This restore undid the 6 fixes that were previously completed:

1. **Map Loading** - Mapbox API key update
2. **"Add Listing" Button (404)** - Permalink refresh
3. **Booking Module** - Enable bookings functionality
4. **Login/Register** - Verify modal works
5. **Remove "Regions" Field** - Disable from Add Listing form
6. **Footer Legal Links** - Add Privacy Policy and Terms & Conditions

All 6 fixes are now needed again. This guide is identical to the previous execution guide (fix_walkthrough.md).

---

## Environment & Credentials

**Site URL:** https://beardsandbucks.com
**WordPress Admin:** https://beardsandbucks.com/wp-admin
**Environment File:** `/mnt/c/Users/Geoff/OneDrive/Desktop/.env.beardsandbucks`

Load credentials from environment file before starting.

---

## Critical Rules

🚨 **DO NOT HALLUCINATE**
- Click only actual visible DOM elements
- Report when you can't find something (don't assume)
- Take screenshots for proof of every action
- Verify results before moving to next fix

---

## FIX 1: Map Loading

**Issue:** Map was blank/not loading.

**Steps:**
1. Log in to WordPress Admin
2. Navigate to: **Listeo Core > Map Settings**
3. Find the **Mapbox API Access Token** field
4. Enter/update the token from environment file (WP_MAPBOX_API_KEY)
5. Save settings
6. Take screenshot of saved settings

**Verification:**
- Go to frontend listing pages (e.g., search page with map)
- Verify map displays correctly (not blank)
- Take screenshot showing map loaded

---

## FIX 2: "Add Listing" Button (404 Error)

**Issue:** "Add Listing" button links to 404 page.

**Steps:**
1. In WordPress Admin, go to: **Settings > Permalinks**
2. Review current permalink structure
3. Click **Save Changes** to flush rewrite rules
4. Take screenshot of permalink settings

**Verification:**
- Go to frontend homepage
- Click "Add Listing" button
- Verify it loads `/add-listing/` page (not 404)
- Take screenshot of Add Listing page

---

## FIX 3: Enable Booking on Listings

**Issue:** "Book Now" button missing from listing pages.

**Steps:**
1. In WordPress Admin, go to: **Listeo Core > Settings**
2. Find **Bookings** module
3. Enable/check the Bookings option
4. Save settings
5. Take screenshot of enabled Bookings module

**Verification:**
- Go to a listing page on frontend
- Verify "Book Now" button/widget appears
- Take screenshot showing "Book Now" button

---

## FIX 4: Verify Login/Register Modal

**Issue:** Need to verify login/register flow works.

**Steps:**
1. Go to frontend homepage
2. Click "Sign In" or "Login" button
3. Verify modal popup appears (standard Listeo behavior)
4. Modal should NOT redirect to separate page
5. Take screenshot of login modal

**Verification:**
- Login modal appears correctly
- Modal does not cause page navigation
- Modal can be closed
- Take screenshot of modal

---

## FIX 5: Remove "Regions" Field from Add Listing

**Issue:** "Regions" field not needed in Add Listing form.

**Steps:**
1. In WordPress Admin, go to: **Listeo Editor > Field Editor**
2. Find **Listing Fields** section
3. Uncheck/disable the **Regions** field
4. Save settings
5. Take screenshot of field editor with Regions unchecked

**Verification:**
- Go to "Add Listing" page on frontend
- Verify "Regions" dropdown is NOT present in the form
- Take screenshot of Add Listing form without Regions field

---

## FIX 6: Add Footer Legal Links

**Issue:** Footer needs Privacy Policy and Terms & Conditions links.

**Steps:**
1. In WordPress Admin, go to: **Appearance > Widgets**
2. Find **Footer 1st Column** widget area
3. Add a **Custom HTML** widget
4. Insert HTML with links:
   ```html
   <a href="/privacy-policy">Privacy Policy</a> | <a href="/terms-and-conditions">Terms & Conditions</a>
   ```
5. Save widget
6. Take screenshot of widget saved

**Verification:**
- Go to frontend website footer
- Verify "Privacy Policy" link appears
- Verify "Terms & Conditions" link appears
- Click links to verify they work
- Take screenshot of footer with links

---

## Final Verification - All 6 Fixes

Before completing, verify all fixes are working:

- [ ] Map loads on listing pages
- [ ] "Add Listing" button works (no 404)
- [ ] "Book Now" button appears on listings
- [ ] Login modal works correctly
- [ ] "Regions" field is NOT in Add Listing form
- [ ] Footer shows Privacy Policy and Terms links
- [ ] All pages load without errors
- [ ] No console errors in browser

---

## Completion Summary

Once all 6 fixes are verified, provide:

1. **Total execution time:** [X minutes]
2. **All fixes completed successfully:** Yes/No
3. **Screenshots provided:** List the fixes documented with screenshots
4. **Any issues encountered:** [Describe if any]
5. **Recommended next steps:** Page cleanup audit and execution

---

**Status:** Ready to execute
**Next Step:** Proceed with FIX 1

