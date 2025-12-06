# ANTIGRAVITY EXECUTION PROMPT - TASK 6
## Debug and Fix Pagination Bug

**Status:** Ready for Execution
**Priority:** HIGH
**Estimated Time:** 15 minutes
**Browser Automation Required:** YES (Investigation + potential fix)
**Depends On:** Task 4 (after deleting test listings, pagination should be investigated)

---

## Your Mission

Investigate and fix a pagination bug where pages 2-3 show duplicate listings. After removing test listings in Task 4, verify pagination displays unique listings per page.

**Current State:** Homepage directory shows duplicate listings on pages 2-3 (same listings appear on multiple pages).
**Desired State:** Pagination shows 8 unique listings per page with no duplicates across pages.

---

## Understanding the Bug

**Symptoms:**
- Page 1: Shows 8 listings
- Page 2: Shows same 8 listings (duplicates)
- Page 3: Shows same 8 listings (duplicates)

**Root Causes (potential):**
1. Posts-per-page setting mismatch (theme says 8, WordPress says 10)
2. Pagination query not filtering correctly
3. Sorting/ordering causing duplicate results
4. Caching serving old pagination state
5. Post count in database doesn't match actual published listings

---

## Investigation Steps

### Step 1: Navigate to Homepage Directory
1. Go to: `https://beardsandbucks.com/` (homepage)
2. Look for the Listings/Directory section
3. Usually shows listings in a grid with pagination controls
4. Take screenshot labeled: `task_6_01_homepage_loaded.png`

### Step 2: Check Page 1
1. On the homepage directory listing section
2. Make sure you're on Page 1
3. Scroll and count the visible listings
4. Note the listing titles visible on Page 1
5. Take screenshot labeled: `task_6_02_page_1_listings.png` (showing all listings on page 1, with titles visible)

**Expected:** Should see 8 unique listings

### Step 3: Navigate to Page 2
1. Look for pagination controls (usually at bottom of listing section)
2. Click "Page 2" or "Next" button
3. Wait for page to load
4. Take screenshot labeled: `task_6_03_page_2_loaded.png`

### Step 4: Check Page 2 Listings
1. Count listings on Page 2
2. Note the listing titles
3. Compare with Page 1 titles
4. **If identical to Page 1:** Bug confirmed (duplicates)
5. **If different from Page 1:** Bug might be fixed or different issue
6. Take screenshot labeled: `task_6_04_page_2_listings.png` (showing listings, with titles visible)

**Expected:** Should see 8 different listings (not same as Page 1)
**If Bug Exists:** Titles will match Page 1

### Step 5: Check Page 3 (if it exists)
1. Look for Page 3 link or "Next" button
2. If no Page 3 button, skip to Step 6
3. Click to navigate to Page 3
4. Wait for page to load
5. Take screenshot labeled: `task_6_05_page_3_loaded.png`

### Step 6: Determine Bug Scenario

Based on what you found:

**Scenario A: Duplicates confirmed**
- Pages 1, 2, 3 show identical listings
- Total of 8 unique listings when there should only be 8 total
- Issue: Pagination query is broken

**Scenario B: Bug already fixed**
- Page 1 shows listings 1-8
- Page 2 has no listings or shows appropriate message
- No duplicates found
- Issue: Already resolved

**Scenario C: Partial duplicates**
- Some listings repeat, some don't
- Complex issue requiring deeper investigation
- Issue: Sorting/filtering problem

---

## Fixing the Pagination Bug

### If Scenario A (Duplicates exist):

#### Fix Option 1: WordPress Settings

1. Go to: `https://beardsandbucks.com/wp-admin`
2. Navigate to: Settings → Reading
3. Look for "Blog pages show at most" setting
4. Current value is probably 10 or similar
5. Change to 8 (to match theme design)
6. Save changes
7. Go back to homepage
8. Hard refresh (Ctrl+Shift+R)
9. Check if Page 2 still duplicates
10. Take screenshot labeled: `task_6_06_posts_per_page_updated.png`

#### Fix Option 2: Check Theme Pagination Settings

1. Go to: `https://beardsandbucks.com/wp-admin`
2. Navigate to: Appearance → Customize
3. Look for "Listing Grid", "Directory", "Posts Per Page", or pagination settings
4. Find the current setting (probably says 8)
5. Verify this matches WordPress Reading setting (should be 8)
6. If different, update to match (use 8)
7. Save/Publish
8. Go back to homepage
9. Check pagination again
10. Take screenshot labeled: `task_6_07_theme_settings_checked.png`

#### Fix Option 3: Check Sidebar Widget Listings

1. Go to: `https://beardsandbucks.com/`
2. Check if there are multiple listing sections:
   - Main directory section (center)
   - Widget section (sidebar showing listings)
3. Widget might also be paginated and causing duplicate count
4. If widget exists, edit it:
   - Admin → Widgets
   - Find listing widget
   - Set to 0 or hide it if not needed
5. Save
6. Check pagination again

#### Fix Option 4: Clear WordPress Cache

Sometimes caching causes pagination to serve old data:

1. Go to: `https://beardsandbucks.com/wp-admin`
2. If you see a caching plugin (WP Super Cache, W3 Total Cache, etc.):
   - Click on the cache plugin menu
   - Look for "Purge cache" or "Clear cache" button
   - Click to clear all cache
3. Navigate to homepage
4. Hard refresh (Ctrl+Shift+R)
5. Check pagination
6. Take screenshot labeled: `task_6_08_cache_cleared.png`

#### Fix Option 5: Check Post Count Query

If none of above work, there might be database issue:

1. Go to: `https://beardsandbucks.com/wp-admin`
2. Navigate to: Tools → Site Health
3. Look for any database errors or warnings
4. Or go to: Posts → Listings
5. Look at the count shown (should say "8 items" after task 4)
6. If count wrong, might indicate database issue
7. Report the count shown vs expected
8. Take screenshot labeled: `task_6_09_post_count_verification.png`

---

## Final Verification

After attempting fixes:

### Step 1: Navigate to Homepage
1. Go to: `https://beardsandbucks.com/`
2. Hard refresh (Ctrl+Shift+R) to clear browser cache
3. Take screenshot labeled: `task_6_10_final_page_1.png`

### Step 2: Check All Pages
1. Count listings on Page 1
2. Click to Page 2
3. Count listings on Page 2
4. Check if titles differ from Page 1
5. If Page 3 exists, check it too
6. Take screenshots of each page

### Step 3: Verify Results
- [ ] Page 1: Shows 8 unique listings
- [ ] Page 2: Shows 0 listings (or appropriate "no more listings" message)
- [ ] No duplicate listings across pages
- [ ] Pagination controls work (next/previous)

---

## Success Criteria - ALL Must Be True

- [ ] Bug investigated and documented
- [ ] Root cause identified (posts-per-page mismatch, cache, etc.)
- [ ] Fix applied (settings changed, cache cleared, etc.)
- [ ] Page 1 shows unique listings
- [ ] Page 2 shows different listings (or empty/no more listings)
- [ ] No listing appears on multiple pages
- [ ] Pagination controls functional

---

## Expected Results After Task 4 Cleanup

**Listing count:** 8 total (after deleting 2 test listings)
**Pagination setup:** 8 items per page
**Expected pages:** 1 page containing all 8 listings
**Page 2:** Should be empty or not exist

---

## Troubleshooting

**Problem: Still seeing duplicates after fixes**
- Check if cache clearing worked (might need cache plugin settings)
- Try deactivating all plugins except Listeo to isolate issue
- Check theme documentation for pagination settings
- Might require custom theme code modification

**Problem: Can't find pagination settings**
- Look for "Items per page", "Posts per page", "Grid items"
- Might be under different menu section
- Check Listeo Core → Settings for listing-specific options
- Check WordPress Customizer (Appearance → Customize)

**Problem: Pagination disappeared after fix**
- That's actually okay - means there's only 1 page of listings now
- 8 total items = 1 page if showing 8 items per page
- Pagination only shows if there are multiple pages

**Problem: Still shows 10+ items per page**
- WordPress settings and theme settings conflict
- Update WordPress Reading settings to 8
- Update theme setting to 8
- Clear cache
- May require code modification if mismatch in theme

---

## When Done

Report back with:
- Task 6 PASS / FAIL / PARTIAL status
- Description of bug found (were there duplicates?)
- Root cause identified (which setting was wrong?)
- Fix applied (which solution worked?)
- Verification: listing counts per page
- Screenshots showing before/after
- Any issues encountered

---

## Summary

**This task requires:**
1. Investigating the pagination issue
2. Identifying why duplicates exist
3. Finding the root cause (likely posts-per-page setting)
4. Applying the fix
5. Verifying pagination works correctly

**Most common fix:** Update WordPress Settings → Reading → "Blog pages show at most" to 8 items per page to match theme expectations.

**Least common but possible:** Cache issue or database post count issue.

When finished with all 6 tasks, I will run automatic verification scripts to confirm everything is working correctly.
