# ANTIGRAVITY EXECUTION PROMPT - TASK 4
## Remove Test Listings from Database

**Status:** Ready for Execution
**Priority:** HIGH
**Estimated Time:** 5 minutes
**Browser Automation Required:** YES

---

## Your Mission

Delete two test listings from the WordPress database to clean up production data. Keep the "Sunny Apartment" listing (it will be fixed in Task 5).

**Current State:** Database contains 10 listings including 2 test entries that should not be in production.
**Desired State:** Database contains 8 listings with only legitimate test data removed.

---

## Listings to Delete

**Delete these two:**
1. "Test Apartment A"
2. "Test Listing B"

**Keep this (will be fixed in Task 5):**
- "Sunny Apartment" (has bad geocoding but will be corrected)

---

## Execution Steps

### Step 1: Navigate to Listings
1. Go to: `https://beardsandbucks.com/wp-admin`
2. Make sure you're logged in
3. In left sidebar, find "Posts" menu
4. Hover over or click "Posts"
5. Look for "Listings" submenu option (or similar)
6. Click on "Listings"
7. Wait for listings page to load
8. Take screenshot labeled: `task_4_01_listings_page.png`

**Alternative direct URL:**
- `https://beardsandbucks.com/wp-admin/edit.php?post_type=listing`

### Step 2: Identify Test Listings
On the Listings page, you should see a table/list showing all listings with columns like:
- Title
- Author
- Category
- Date

1. Look through the list for "Test Apartment A"
2. Find and note its position
3. Look for "Test Listing B"
4. Find and note its position
5. **IMPORTANT:** Make sure you see "Sunny Apartment" in the list (don't delete it)
6. Take screenshot labeled: `task_4_02_listings_identified.png` (showing all 3 listings visible)

### Step 3: Delete "Test Apartment A"
1. Find the row for "Test Apartment A"
2. Hover over the title - you should see action links appear below it
3. Click on the title or "Edit" link to open the listing
4. Alternatively, right-click on the listing title and look for delete option
5. Once in the edit view, look for a "Delete" or "Trash" button
6. Click "Delete Permanently" (NOT just "Trash")
7. Wait for confirmation
8. You should be redirected back to listings page
9. Take screenshot labeled: `task_4_03_test_apartment_a_deleted.png`

**Alternative Method (Inline Actions):**
- Hover over "Test Apartment A" in the list
- Look for action links below the title
- Should see options like "Edit | Trash | View"
- Click "Trash" first
- Then open the Trash section
- Click "Delete Permanently" on the trashed item

### Step 4: Delete "Test Listing B"
1. In the listings page, find "Test Listing B"
2. Repeat the deletion process from Step 3
3. Open the listing (click title)
4. Click "Delete Permanently"
5. Confirm deletion
6. Take screenshot labeled: `task_4_04_test_listing_b_deleted.png`

### Step 5: Verify Listing Count
1. After both deletions, you should see 8 listings remaining
2. Count the listings visible on the page
3. Or check the page count at the bottom (should say something like "Showing 1-8 of 8")
4. Verify "Sunny Apartment" is still there
5. Take screenshot labeled: `task_4_05_final_count_8_listings.png`

**Listing count verification:**
- **Before:** 10 total listings
- **After:** 8 total listings
- **Deleted:** 2 (Test Apartment A, Test Listing B)
- **Kept:** 8 including Sunny Apartment

---

## Success Criteria - ALL Must Be True

- [ ] "Test Apartment A" successfully deleted
- [ ] "Test Listing B" successfully deleted
- [ ] Listing count decreased from 10 to 8
- [ ] "Sunny Apartment" still appears in listings (NOT deleted)
- [ ] No error messages during deletion
- [ ] Listings page shows 8 remaining entries
- [ ] Both pages in trash/deleted permanently (not just trashed)

---

## Important Notes

**DO NOT DELETE:**
- Sunny Apartment (keep it - Task 5 will fix geocoding)
- Any other legitimate listings
- Any recent listings created after initial data

**How to Verify You Have the Right Listings:**
- "Test Apartment A" - title should be exactly this or very similar
- "Test Listing B" - title should be exactly this or very similar
- If unsure, check the listing date - test listings are usually older/earlier dates
- When in doubt, don't delete - report which listings you found

---

## Troubleshooting

**Problem: Can't find Listings menu**
- Go directly to: `https://beardsandbucks.com/wp-admin/edit.php?post_type=listing`

**Problem: Delete button not appearing**
- Make sure you're in the listing edit page (not just the list)
- Look at bottom left of page for "Delete" link
- Or look for a red "Delete Permanently" button

**Problem: Only "Trash" button appears, not "Delete Permanently"**
- That's okay, click "Trash"
- Then go to Posts menu
- Find "Trash" submenu
- Open the trash
- Find the trashed item
- Click "Delete Permanently"

**Problem: Unsure which listings are the test ones**
- Check the listing titles carefully
- Test listings typically have generic/obvious test names
- If you see "Test Apartment A" or "Test Listing B", that's definitely a test listing
- If unsure, skip deletion and report the listing names found

**Problem: Count doesn't match (says more/less than 8)**
- Recount manually
- Check if pagination is active (might be showing page 1 of 2)
- Take screenshot of pagination controls
- Report actual count found

---

## When Done

Report back with:
- Task 4 PASS / FAIL / PARTIAL status
- Confirmation that "Test Apartment A" was deleted
- Confirmation that "Test Listing B" was deleted
- Confirmation that "Sunny Apartment" still exists
- Final listing count (should be 8)
- All screenshots
- Any issues encountered

Then move to Task 5.
