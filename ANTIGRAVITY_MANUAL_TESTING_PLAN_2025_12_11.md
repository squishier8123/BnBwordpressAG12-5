# Antigravity Manual Testing Plan - December 11, 2025
**Beards & Bucks Site Testing as 5 Different User Personas**

---

## Overview

You will test the site (https://beardsandbucks.com) as 5 different personas, each with their own goals. For each persona, you'll:

1. **Take on their mindset** - Think like that user
2. **Follow their goal** - Try to accomplish what they want
3. **Document what you find** - Note what works and what breaks
4. **Score the experience** - Rate it across 6 dimensions (0-100 total)
5. **Report issues** - List critical, major, and minor problems

**Time per persona:** 30-60 minutes depending on thoroughness
**Total time for all 5:** ~3-4 hours
**Output:** 5 persona reports + 1 master summary report

---

## The 5 Personas

### 1. 🏹 JAKE - Hunter Seeking Outfitter
**Goal:** Find and book a hunting outfitter in Illinois

**Persona Details:**
- Experienced hunter, willing to pay for quality
- Direct, goal-oriented
- Values reviews and vendor reputation
- Wants smooth booking experience

**What Jake Tests:**
- Can find outfitters easily?
- Are reviews visible and trustworthy?
- Is booking process smooth?
- Is contact info accessible?
- Does search/browse work well?

**Jake's Checklist:**
- [ ] Homepage loads quickly
- [ ] Can find "Browse Outfitters" or similar feature
- [ ] Can search/filter by county
- [ ] Can view vendor reviews and ratings
- [ ] Can see vendor details (contact, location, pricing)
- [ ] Can find "Book" or "Request Booking" button
- [ ] Can complete booking form
- [ ] Confirmation message appears
- [ ] Site is responsive on mobile
- [ ] No JavaScript errors in console

**Success Looks Like:** You can browse outfitters, read reviews, and complete a booking request

---

### 2. 💼 SARAH - Used Gear Vendor
**Goal:** List used archery gear for sale, manage inventory

**Persona Details:**
- Experienced archer wanting to sell equipment
- Detail-oriented, practical
- Wants efficient business tools
- First-time on platform

**What Sarah Tests:**
- Can find vendor registration?
- Is account creation easy?
- Can list products quickly?
- Is vendor dashboard intuitive?
- Does it look professional?

**Sarah's Checklist:**
- [ ] Homepage loads quickly
- [ ] Can find "Sell Your Gear" or "Register as Vendor"
- [ ] Vendor registration page is clear
- [ ] Can create account without errors
- [ ] Can access vendor dashboard
- [ ] Dashboard is intuitive and professional
- [ ] Can find "Add Product" or "Create Listing" button
- [ ] Product form is complete but not overwhelming
- [ ] Can upload product photos
- [ ] Can set prices and inventory
- [ ] Can save and view listing
- [ ] Mobile responsiveness is good

**Success Looks Like:** You can register as vendor, create an account, and list a product

---

### 3. 🛍️ MIKE - Budget-Conscious Gear Shopper
**Goal:** Find affordable used hunting gear

**Persona Details:**
- New to hunting, price-sensitive
- Likes to compare products
- Looking for deals
- Wants to understand what he's buying

**What Mike Tests:**
- Can find marketplace easily?
- Are filters working?
- Can he compare products?
- Are prices clear?
- Is checkout smooth?

**Mike's Checklist:**
- [ ] Homepage loads quickly
- [ ] Can find marketplace/shop section
- [ ] Can browse products by category
- [ ] Price filters are working
- [ ] Can sort by price (low to high)
- [ ] Product images are clear
- [ ] Product descriptions are helpful
- [ ] Can see seller ratings/reviews
- [ ] Can add item to cart
- [ ] Cart updates correctly
- [ ] Can view checkout process
- [ ] Mobile experience is good

**Success Looks Like:** You can browse gear, filter by price, and add items to cart

---

### 4. 📚 EMMA - Information Seeker
**Goal:** Learn about hunting in Illinois, explore options

**Persona Details:**
- Considering getting into hunting
- Curious, thorough
- Wants comprehensive information
- Needs to feel the site is trustworthy

**What Emma Tests:**
- Is content clear and organized?
- Is navigation intuitive?
- Is information current and accurate?
- Does the site feel professional?
- Can she find answers to questions?

**Emma's Checklist:**
- [ ] Homepage is welcoming and clear
- [ ] Can find "About" or informational pages
- [ ] Vendor profiles are detailed and professional
- [ ] Reviews are visible and authentic-looking
- [ ] Site navigation is logical
- [ ] Content is well-written (no typos/errors)
- [ ] Can find educational resources
- [ ] Contact information is clear
- [ ] Site feels safe and trustworthy
- [ ] Mobile experience is clean
- [ ] Images are high-quality
- [ ] Loading times are reasonable

**Success Looks Like:** You can explore the site, read vendor info, and feel confident about the platform

---

### 5. 👔 TOM - Outfitter Vendor
**Goal:** Manage hunting outfitter business

**Persona Details:**
- Established outfitter
- Business-focused, wants efficiency
- Needs analytics and reporting
- Expects professional tools

**What Tom Tests:**
- Can access vendor dashboard?
- Is dashboard powerful and complete?
- Can update business info?
- Can manage bookings?
- Does analytics exist?

**Tom's Checklist:**
- [ ] Can find vendor login/dashboard
- [ ] Can log in successfully
- [ ] Dashboard is professional and organized
- [ ] Can update business information
- [ ] Can manage listings/services
- [ ] Can view bookings/inquiries
- [ ] Can see analytics or reporting
- [ ] Payment/commission info visible
- [ ] Can communicate with customers
- [ ] Mobile access works
- [ ] Features feel complete and useful
- [ ] No broken links or errors

**Success Looks Like:** You can access dashboard and manage business operations effectively

---

## How to Test (Step-by-Step)

### Before You Start
1. **Clear your mind** - You are now [persona name], not yourself
2. **Use the site normally** - Don't rush, explore naturally
3. **Take screenshots** - Capture issues as you find them
4. **Open console (F12)** - Check for JavaScript errors
5. **Test mobile** - Resize browser to 375px or use actual phone

### During Testing

#### Step 1: Read Your Persona
Pick one persona above and read their details carefully. Really think about their perspective.

#### Step 2: Start Fresh
Open https://beardsandbucks.com in an incognito/private browser window (clean slate)

#### Step 3: Follow the Checklist
Go through your persona's checklist systematically. For each item:
- ✅ Check it off if it works perfectly
- ❌ Note it if broken
- ⚠️ Document if confusing or slow

#### Step 4: Document Issues
When you find a problem, note:
- **What happened:** Clear description
- **Where:** Page/feature name
- **Expected vs. Actual:** What should happen vs. what does
- **Severity:** Critical / Major / Minor
- **Screenshot:** Save a screenshot

**Example:**
```
Issue: "Add to Cart" button doesn't work on product page
Location: Product detail page - all products
Expected: Item added to cart, count updates
Actual: Button doesn't respond when clicked
Severity: CRITICAL (users can't buy)
Screenshot: SC_cart_broken_2025_12_11_143020.png
```

#### Step 5: Score the Experience
At the end of testing, rate your experience on these 6 dimensions:

| Dimension | Max Points | How to Score | Your Score |
|-----------|-----------|-------------|-----------|
| **Discoverability** | 20 | Could you find what you needed? How many clicks? | ___ / 20 |
| **Performance** | 20 | Was it fast? Responsive? No lag? | ___ / 20 |
| **Design & Branding** | 15 | Visually appealing? Professional? On-brand? | ___ / 15 |
| **Functionality** | 20 | Did features work? No broken buttons? | ___ / 20 |
| **Content Quality** | 15 | Was info clear, accurate, helpful? | ___ / 15 |
| **Mobile Experience** | 10 | Works well on mobile? Touch-friendly? | ___ / 10 |
| **TOTAL** | **100** | Add them up | ___ / 100 |

**Scoring Tips:**
- 90-100: Excellent, no problems found
- 80-89: Good, minor issues only
- 70-79: Acceptable, several improvements needed
- 60-69: Fair, significant work needed
- <60: Poor, major issues

#### Step 6: Create Persona Report
Save a file named: `ANTIGRAVITY_PERSONA_[NAME]_2025_12_11.md`

**Template:**
```markdown
# Antigravity Test Report - [PERSONA NAME]
**Date:** December 11, 2025
**Tester:** [Your name or "Manual Testing"]
**Persona Goal:** [Their goal]

## Overall Score: ___ / 100

### Score Breakdown
- Discoverability: ___ / 20
- Performance: ___ / 20
- Design & Branding: ___ / 15
- Functionality: ___ / 20
- Content Quality: ___ / 15
- Mobile: ___ / 10

## What Worked Well ✅
- [Feature 1] works great
- [Feature 2] is intuitive
- [Feature 3] loads fast

## Critical Issues Found 🔴
1. [Issue name]
   - Location: [Page/feature]
   - Steps to reproduce: [How to find it]
   - Screenshot: [Filename]

2. [Issue name]
   - ...

## Major Issues Found 🟠
1. [Issue name]
   - ...

## Minor Issues Found 🟡
1. [Issue name]
   - ...

## Recommendations
- [Action item 1]
- [Action item 2]
- [Action item 3]

## Testing Notes
[Any additional observations, timing, feelings about the experience, etc.]
```

---

## Testing Schedule (Recommended)

**Ideal breakdown:**
- **Session 1:** Jake (Hunter) - 45 min
- **Session 2:** Sarah (Vendor) - 60 min
- **Session 3:** Mike (Shopper) - 45 min
- **Session 4:** Emma (Researcher) - 45 min
- **Session 5:** Tom (Outfitter) - 60 min

**Total:** ~4 hours spread over multiple sessions

---

## What to Look For

### Critical Issues (MUST FIX)
- 🔴 Site doesn't load
- 🔴 404 errors on main pages
- 🔴 Primary goal is impossible (e.g., can't book, can't register)
- 🔴 Forms don't submit
- 🔴 Checkout broken
- 🔴 Security warnings

### Major Issues (Should Fix)
- 🟠 Mobile is broken
- 🟠 Search doesn't work
- 🟠 Pages load slowly (>5 sec)
- 🟠 Key buttons don't work
- 🟠 Important info is missing
- 🟠 Confusing navigation

### Minor Issues (Nice to Fix)
- 🟡 Spelling/grammar errors
- 🟡 Inconsistent spacing
- 🟡 Small design issues
- 🟡 Missing alt text on images
- 🟡 Color contrast could be better

---

## Taking Screenshots

**When to screenshot:**
- When you find an issue
- When a feature works particularly well
- When testing mobile responsiveness
- When seeing error messages

**How to save them:**
Create a folder: `test-results/antigravity/screenshots/`

Name format: `PERSONA_[NAME]_[ISSUE]_2025_12_11_[TIME].png`

**Examples:**
- `JAKE_outfitter_search_2025_12_11_140530.png`
- `SARAH_dashboard_broken_2025_12_11_142015.png`
- `MIKE_mobile_layout_2025_12_11_143045.png`

**Easy screenshot methods:**
- Windows: `Windows + Shift + S` (select area) or `Windows + PrtScn` (full screen)
- Mac: `Cmd + Shift + 4` (select area) or `Cmd + Shift + 3` (full screen)
- Phone: Use native screenshot button

---

## Checking for JavaScript Errors

Press `F12` to open Developer Tools:
1. Click **Console** tab
2. Look for red error messages
3. Screenshot any errors
4. Note them in your report

**Example error to report:**
```
Uncaught TypeError: Cannot read property 'addEventListener' of null
(from script.js:156)
```

---

## Performance Checking

### Page Load Time
1. Open DevTools (F12)
2. Click **Network** tab
3. Reload page
4. Look at total load time (bottom right)
5. Note in your report

**Good:** < 3 seconds
**Acceptable:** 3-5 seconds
**Slow:** > 5 seconds

### Lighthouse Score
1. Open DevTools (F12)
2. Click **Lighthouse** tab
3. Click "Analyze page load"
4. Wait for results
5. Note the scores:
   - Performance (target: 90+)
   - Accessibility (target: 90+)
   - Best Practices (target: 85+)
   - SEO (target: 90+)

---

## After All 5 Personas are Tested

### Compile Master Report

**File name:** `ANTIGRAVITY_MASTER_REPORT_2025_12_11.md`

**Include:**
1. **Executive Summary**
   - Average score across all 5 personas
   - Overall assessment (Excellent/Good/Acceptable/Fair/Poor)
   - Top 3 critical issues
   - Top 3 strengths

2. **All Personas Summary**
   ```
   | Persona | Score | Status |
   |---------|-------|--------|
   | Jake    | 75/100 | Acceptable |
   | Sarah   | 68/100 | Fair |
   | Mike    | 82/100 | Good |
   | Emma    | 78/100 | Acceptable |
   | Tom     | 70/100 | Acceptable |
   | AVERAGE | 74.6/100 | Acceptable |
   ```

3. **All Issues (Combined)**
   - Group by severity (Critical, Major, Minor)
   - Note which personas encountered each
   - Link to screenshots

4. **Recommendations (Prioritized)**
   - Fix critical issues first
   - Then major issues
   - Then minor issues (time permitting)

5. **Next Steps**
   - What needs fixing immediately
   - What can wait
   - Estimated effort for each

---

## Files to Create

1. `ANTIGRAVITY_PERSONA_JAKE_2025_12_11.md`
2. `ANTIGRAVITY_PERSONA_SARAH_2025_12_11.md`
3. `ANTIGRAVITY_PERSONA_MIKE_2025_12_11.md`
4. `ANTIGRAVITY_PERSONA_EMMA_2025_12_11.md`
5. `ANTIGRAVITY_PERSONA_TOM_2025_12_11.md`
6. `ANTIGRAVITY_MASTER_REPORT_2025_12_11.md`
7. Screenshots folder: `test-results/antigravity/screenshots/` (with all screenshots)

---

## Tips for Success

### Think Like Your Persona
- You're not testing "as a developer"
- You're Sarah trying to sell gear, not Claude checking code
- What would frustrate Sarah? What would delight her?

### Test Naturally
- Don't follow a script
- Explore like a real user would
- Try things that might break
- Read content carefully

### Mobile is Important
- Resize browser to 375px width for mobile
- Or test on actual phone if possible
- Mobile UX is different from desktop
- Many users browse on phones

### Time Yourself
How long does each task take?
- Finding something: Should be < 1 minute
- Completing an action: Should be < 3 minutes
- Loading a page: Should be < 3 seconds

Users expect quick, smooth experiences.

### Try to Break Things
- Click buttons rapidly
- Use browser back button mid-process
- Search for weird keywords
- Try extreme prices or filters
- Test edge cases

### Take Breaks
- Don't test all 5 personas in one sitting
- Fatigue affects your perspective
- You'll be more thorough rested

---

## Resources

### From QA Reports (Already Done)
- The site has 1 **critical issue**: Missing `/add-a-listing/` decision page
- This blocks vendor and individual seller signup
- This is the top priority

### What You're Building On
- Playwright automated tests already identified missing pages
- Your manual testing will confirm UX impact
- You'll find additional issues Playwright missed

---

## Timeline Estimate

| Persona | Time | Notes |
|---------|------|-------|
| Jake | 45 min | Outfitter search & booking |
| Sarah | 60 min | Registration + dashboard |
| Mike | 45 min | Browsing & shopping |
| Emma | 45 min | Learning & exploration |
| Tom | 60 min | Dashboard & management |
| Reports | 60 min | Compilation & summary |
| **TOTAL** | **~5 hours** | Spread over 2-3 days |

---

## Success Criteria

When you're done, you should have:

✅ 5 detailed persona reports (one per user type)
✅ 20+ screenshots documenting findings
✅ List of all issues found (prioritized by severity)
✅ Score for each persona (0-100)
✅ Overall site score (average of 5)
✅ Master report with recommendations
✅ Clear action items for developers

**Expected Result:** One comprehensive test report showing site health across 5 different user journeys.

---

## Next Steps

**Ready to Start?**
1. Pick your first persona (recommend Jake or Emma to start)
2. Open https://beardsandbucks.com in incognito window
3. Follow their checklist
4. Document issues as you find them
5. Create persona report when done

**Questions?** Refer back to:
- Persona checklist above
- Issue documentation format section
- Scoring rubric

Good luck! 🎯
