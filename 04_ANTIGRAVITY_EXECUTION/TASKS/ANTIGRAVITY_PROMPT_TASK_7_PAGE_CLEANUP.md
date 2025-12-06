# WordPress Page Cleanup Task
**Task Number:** 7
**Assigned To:** Antigravity (Luke)
**Date:** 2025-12-06
**Priority:** HIGH
**Status:** READY TO EXECUTE

---

## Task Summary

Delete 189 unnecessary/duplicate WordPress pages from the Beards & Bucks site. This cleanup will reduce the site from 216 pages down to 27 essential pages.

---

## What to Do

### Step 1: Login to WordPress Admin
1. Open https://beardsandbucks.com/wp-admin
2. Login with your admin credentials
3. Take a screenshot showing logged-in state

### Step 2: Navigate to Pages Section
1. Click "Pages" in the left sidebar
2. You should see all 216 pages listed
3. Take a screenshot of the Pages list

### Step 3: Delete the 189 Pages (Method A: Bulk Delete)
**Preferred Method - Using WordPress Bulk Actions:**

1. Click "Select All" (checkbox at the top of the pages list)
   - This will select all 216 pages
2. Click "Bulk Actions" dropdown
3. Select "Delete Permanently"
4. Click "Apply"
5. You will see a confirmation - click "OK" or "Confirm"
6. Take a screenshot of the deletion confirmation

**If Bulk Delete doesn't work, use Method B below:**

### Step 3B: Delete the 189 Pages (Method B: Individual Deletion by ID)

If bulk delete isn't available, delete by page ID:

**Pages to Delete (IDs):**
```
72,76,90,91,92,93,353,409,434,441,449,507,536,547,595,609,616,638,656,663,1307,1311,1321,1370,1545,1625,2065,2244,2257,3049,3050,3138,3139,3140,3141,3282,3337,3338,3339,3340,3399,3401,3563,3566,3569,3572,3575,3578,3581,3584,3587,3590,3593,3596,3599,3638,3642,3646,3647,3650,3653,3656,3659,3660,3663,3666,3669,3672,3675,3678,3681,3684,3687,3690,3693,3696,3699,3702,3705,3708,3711,3714,3719,3722,3725,3728,3732,3737,3738,3754,3776,3779,3793,3801,3851,3854,3857,3860,3863,3866,3869,3872,3875,3878,3881,3884,3887,3924,3927,3930,3933,3936,3939,3942,3945,3948,3951,3954,3957,3960,4002,4005,4008,4011,4014,4017,4020,4023,4026,4029,4032,4035,4038,4072,4073,4074,4078,4099,4100,4180,4244,4363,4364,4365,4366,4367,4368,4369,4371,4372,4373,4374,4375,4376,4377,4378,4379,4380,4381,4382,4383,4384,4385,4386,4387,4388,4389,4390,4391,4392,4393,4394,4395,4396,4397,4398,4399,4400,4401,4402,4403,4404,4405,4406,4407,4408,4409,4410
```

**Process for each page:**
1. For each ID, navigate to: `https://beardsandbucks.com/wp-admin/post.php?post=<ID>&action=edit`
   - Example: `https://beardsandbucks.com/wp-admin/post.php?post=4410&action=edit`
2. Click "Move to Trash" or "Delete Permanently"
3. Confirm deletion

### Step 4: Verify Deletion Count
1. Return to Pages list
2. Count should now be approximately 27 pages
3. Take a screenshot showing the reduced page count
4. Take screenshot of page list showing only essential pages

### Step 5: Verify Essential Pages Are Still Present
Check that these 27 pages still exist in the list:

**Pages to Verify (Should Still Exist):**
- Home 3 (ID: 4370)
- About Us (ID: 4619)
- How It Works (ID: 4662)
- Contact (ID: 4092)
- FAQ (ID: 4102)
- Vendors (ID: 4192)
- Used Gear (ID: 4101)
- Privacy Policy (ID: 4618)
- Terms and Conditions (ID: 4617)
- Join Beards & Bucks (ID: 4620)
- Register as Buyer (ID: 4621)
- Register as Vendor (ID: 4622)
- My Dashboard (ID: 4638)
- Vendor Dashboard (ID: 4246)
- Vendor Dashboard – Listings (ID: 4248)
- Vendor Dashboard – Add Listing (ID: 4250)
- Store List (ID: 4546)
- Directory (ID: 4094)
- List Your Gear (ID: 4090)
- Vendor Detail (ID: 4091)
- Alerts/Wishlist (ID: 4085)
- Referral/Credits (ID: 4088)
- Account/Dashboard (ID: 4098)
- Blog/Updates (ID: 4097)
- Popular Categories (ID: 4663)
- Why Choose Beards & Bucks (ID: 4664)
- How It Works (ID: 4095) - Alternative

1. Scroll through the pages list
2. Verify each essential page is present
3. Take screenshot(s) of the cleaned-up pages list

---

## Expected Outcome

✅ **After this task is complete, you will have:**

- 189 duplicate/test pages deleted
- 27 essential pages remaining
- Clean WordPress page structure
- Site ready for production use

**Before:** 216 pages (cluttered)
**After:** 27 pages (clean & optimized)

---

## Important Notes

⚠️ **Careful:** This will delete 189 pages permanently. Make sure the list is correct.

✅ **Safe:** All pages being deleted are duplicates or test pages. No active content is lost.

📋 **Reference:** See `PAGE_CLEANUP_PLAN.md` for the complete list of pages and verification details.

---

## Reporting

**After completing, please document:**

1. Screenshots from each major step
2. Confirmation of final page count (should be ~27)
3. Confirmation that essential pages still exist
4. Any issues or unexpected results
5. Time taken

**Status:** Ready to execute whenever you approve

---

## Support Files

- `PAGE_CLEANUP_PLAN.md` - Complete cleanup plan with all page IDs
- `MASTER_LOG.md` - Session history and project status

---

**Task Ready:** ✅ Ready for Antigravity execution
**Complexity:** Medium (bulk operation)
**Risk:** Low (only deleting duplicates)
**Time Estimate:** 5-10 minutes
