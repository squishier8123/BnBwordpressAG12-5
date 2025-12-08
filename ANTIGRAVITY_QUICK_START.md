# Antigravity Testing Suite - Quick Start
## Comprehensive Multi-Persona Testing for Beards & Bucks

**Last Updated**: December 8, 2025
**Status**: Ready to Use
**Site**: https://beardsandbucks.com

---

## 30-Second Overview

The Antigravity testing system allows you to thoroughly test the marketplace from **7 different user perspectives**, each with their own goals and concerns. Test as different personas, find real-world issues, and document everything.

---

## What You Need to Know

### Three Files

1. **`ANTIGRAVITY_COMPREHENSIVE_PROMPT.md`**
   - The complete testing guide with 7 personas
   - Detailed checklists for every feature
   - Reporting templates
   - Success criteria

2. **`scripts/run_antigravity_test.sh`**
   - Automation helper script
   - Sets up test directories
   - Generates report templates
   - Measures performance

3. **`test-results/antigravity/`** (created when you run)
   - Where all findings and screenshots go
   - Organized by persona and date

---

## Quick Start (5 Minutes)

### Option 1: Interactive Mode (Easiest)

```bash
# From project root
bash scripts/run_antigravity_test.sh
```

**What happens:**
1. Script displays all 7 personas
2. You pick one (or press Enter for random)
3. Script sets up report template
4. You manually test the site following the checklist
5. You capture screenshots as you find issues
6. You fill in the report with your findings

### Option 2: Test Specific Persona

```bash
# Test as Persona 3 (Jennifer Park - Budget Beginner)
bash scripts/run_antigravity_test.sh --persona 3
```

**Personas:**
1. **Sarah Chen** - Serious Bowhunter Shopper
2. **Marcus Williams** - Casual Visitor / Potential Outfitter
3. **Jennifer Park** - Budget-Conscious Beginner
4. **Tom Johnson** - Frustrated Tech-Savvy User
5. **Angela Martinez** - Platform Administrator
6. **Alex Rodriguez** - Competitive Marketplace Seller
7. **David Thompson** - Mobile-First User

### Option 3: Run All Personas

```bash
# Run all 7 personas sequentially
bash scripts/run_antigravity_test.sh --all
```

**Note:** This takes several hours (one session per persona). Best for comprehensive testing before launch.

---

## How to Test (Step-by-Step)

### Step 1: Start Test Session
```bash
bash scripts/run_antigravity_test.sh --persona 1
```

### Step 2: Read Your Persona
Look up your assigned persona in `ANTIGRAVITY_COMPREHENSIVE_PROMPT.md`
- Understand their role, goal, and concerns
- **Stay in character throughout the test**

**Example - Persona 1 (Sarah Chen):**
- Role: Experienced bowhunter looking for used gear deals
- Goal: Find and purchase quality used compound bow equipment
- Mindset: Price-conscious, quality-focused
- Test as if you're Sarah shopping on this site

### Step 3: Follow the Testing Checklist
Go through `ANTIGRAVITY_COMPREHENSIVE_PROMPT.md` and systematically test:
- Navigation ✓
- Directory (Listeo) features ✓
- Marketplace (Dokan) features ✓
- User account functionality ✓
- Shopping/checkout ✓
- Performance & technical ✓
- Security ✓
- SEO ✓
- Accessibility ✓
- Brand/design ✓

### Step 4: Capture Screenshots
When you find an issue or test a feature:
```bash
# Save screenshots to test-results/antigravity/screenshots/
# Naming: PERSONA_[NUM]_[FEATURE]_[DATE_TIME].png

Example:
  SC_marketplace_search_2025_12_08_14_30.png
  SC_checkout_error_2025_12_08_14_35.png
```

**Easy way on Windows:**
- Press `Windows + Shift + S` to capture region
- Press `Windows + PrtScn` for full screenshot
- Save to: `test-results/antigravity/screenshots/`

**Easy way on Mac:**
- Press `Cmd + Shift + 4` to capture region
- Press `Cmd + Shift + 3` for full screenshot
- Save to: `test-results/antigravity/screenshots/`

### Step 5: Document Issues
In the test report (auto-generated at start), document:
- **Issue Title**: Clear one-line description
- **Location**: Which page/feature affected
- **Steps to Reproduce**: How to find the bug
- **Expected vs Actual**: What should happen vs what does
- **Screenshot**: Reference to your screenshot file
- **Impact**: How serious is it for users?

Example:
```markdown
#### Issue: "Add to Cart" button doesn't work on mobile

- **Location**: Product detail page (all products)
- **Steps**: 1. Visit product page on mobile (375px)
            2. Scroll to bottom
            3. Click "Add to Cart" button
- **Expected**: Item added to cart, cart count updates
- **Actual**: Nothing happens, no error shown
- **Screenshot**: SC_add_to_cart_broken_2025_12_08_14_40.png
- **Impact**: High - Users can't buy on mobile
```

### Step 6: Fill Test Report
The script generates a report template. Fill in:
- ✅ What works perfectly
- ❌ What's broken
- ⚠️ What's frustrating
- 📊 Performance numbers (load times, Lighthouse scores)
- 💡 Suggestions for improvement

### Step 7: Save Results
Results are automatically organized:
```
test-results/antigravity/
├── screenshots/                     # All your screenshots
│   ├── SC_homepage_2025_12_08.png
│   ├── SC_checkout_error_2025_12_08.png
│   └── ...
├── reports/                         # Test reports
│   ├── persona_reports/
│   │   ├── PERSONA_1_2025_12_08.md
│   │   ├── PERSONA_2_2025_12_08.md
│   │   └── ...
│   └── ANTIGRAVITY_TEST_RESULTS_2025_12_08.md  # Master report
└── lighthouse_*.json               # Performance data
```

---

## Real-World Testing Tips

### 1. Think Like Your Persona
You're not testing "as a developer." You're Sarah shopping for hunting gear. What would frustrate you? What would delight you?

### 2. Test on Real Mobile
If possible, test on an actual phone, not just resizing your browser. Mobile UX is different.

### 3. Check Browser Console
Press `F12` → `Console` tab. Are there any JavaScript errors? Screenshot them.

### 4. Try to Break Things
- Click buttons rapidly
- Use back button during checkout
- Try expired links
- Search for nonsense keywords
- Test with extreme prices

### 5. Time Yourself
How long does it take to:
- Find a product? ⏱️
- Add to cart? ⏱️
- Checkout? ⏱️
- Complete purchase? ⏱️

Users expect each action < 3 seconds.

### 6. Check Performance
Open DevTools (`F12`) → `Lighthouse` tab → Click "Analyze page load"
Document the scores for:
- Performance (target: 90+)
- Accessibility (target: 90+)
- Best Practices (target: 90+)
- SEO (target: 90+)

### 7. Test Edge Cases
- Out of stock items
- Products with no reviews
- Products with many reviews
- Low inventory items
- Extremely high priced items
- Extreme filter combinations

### 8. Compare to Standards
How does this compare to:
- Amazon
- eBay
- Etsy
- Similar hunting/outdoor sites

Users expect similar functionality.

---

## What to Look For

### Critical Issues (Must Fix)
- ❌ Site crashes or won't load
- ❌ 404 errors on main pages
- ❌ Checkout doesn't work
- ❌ Payment processing broken
- ❌ Account creation fails
- ❌ Search returns no results

### High Priority Issues
- ⚠️ Mobile site broken
- ⚠️ Images missing
- ⚠️ Slow loading (>5 seconds)
- ⚠️ Broken search functionality
- ⚠️ Forms don't validate
- ⚠️ Security warnings

### Medium Priority Issues
- ⚠️ Spelling/grammar errors
- ⚠️ Inconsistent spacing
- ⚠️ Poor color contrast (accessibility)
- ⚠️ Confusing navigation
- ⚠️ Missing information
- ⚠️ Outdated content

### Low Priority Issues
- ℹ️ Minor design inconsistencies
- ℹ️ Could be clearer instructions
- ℹ️ Suggestion for improvement
- ℹ️ "Nice to have" feature ideas

---

## Testing Personas Explained

### Sarah Chen (Persona 1) - Bowhunter Shopper
**Best for**: Testing marketplace, product search, checkout
**Tests**: Buying used gear, seller reputation, product specs

### Marcus Williams (Persona 2) - Potential Outfitter
**Best for**: Testing directory, vendor info, inquiry process
**Tests**: Finding competitors, understanding requirements

### Jennifer Park (Persona 3) - Beginner
**Best for**: Testing clarity, beginner-friendliness, guidance
**Tests**: Homepage clarity, help resources, simple browsing

### Tom Johnson (Persona 4) - Tech-Savvy User
**Best for**: Finding bugs, performance, UX issues
**Tests**: Advanced features, error messages, responsiveness

### Angela Martinez (Persona 5) - Administrator
**Best for**: Testing all systems, security, completeness
**Tests**: All plugins, pages, security, analytics

### Alex Rodriguez (Persona 6) - Seller
**Best for**: Testing vendor features, selling tools
**Tests**: Product listing, inventory, orders, analytics

### David Thompson (Persona 7) - Mobile-First
**Best for**: Mobile responsiveness, mobile UX
**Tests**: Mobile speed, touch targets, mobile checkout

---

## Quick Command Reference

```bash
# Interactive mode (asks which persona)
bash scripts/run_antigravity_test.sh

# Test as specific persona
bash scripts/run_antigravity_test.sh --persona 1

# Run headless (no screenshot prompts)
bash scripts/run_antigravity_test.sh --persona 1 --headless

# Run all 7 personas
bash scripts/run_antigravity_test.sh --all

# Help
bash scripts/run_antigravity_test.sh --help
```

---

## Report Example

When done testing, your report should look like:

```markdown
# Antigravity Test Report
## Sarah Chen - Serious Bowhunter Shopper

### Overall Site Score: 78/100

### Issues Found

#### Critical Issues
1. Add to Cart button doesn't work on product pages
   - Location: Product detail page
   - Screenshot: SC_add_to_cart_broken.png

#### High Priority Issues
1. Search doesn't find most products
   - Location: Homepage search bar
   - Screenshot: SC_search_broken.png

#### Medium Priority Issues
1. Mobile header too tall, obscures content
   - Location: All pages on mobile (375px)
   - Screenshot: SC_mobile_header_2025_12_08.png

### Positive Findings
✅ Checkout flow is smooth and clear
✅ Product descriptions are detailed
✅ Shipping calculator works well

### Performance
- Homepage: 2.3 seconds
- Product Pages: 1.8 seconds
- Lighthouse: 85/100 Performance

### Recommendations
- Fix cart functionality before launch
- Improve search algorithm
- Reduce mobile header size
```

---

## After Testing

### Compile All Results

1. Gather all persona reports from `test-results/antigravity/reports/persona_reports/`
2. Review the master report: `ANTIGRAVITY_TEST_RESULTS_[DATE].md`
3. Collect all screenshots from `test-results/antigravity/screenshots/`

### Prioritize Findings

1. **Critical** - Must fix before launch
2. **High** - Should fix before launch
3. **Medium** - Fix soon after launch
4. **Low** - Nice to have improvements

### Create Action Items

For each issue, create:
- Issue title
- Priority level
- Current behavior
- Expected behavior
- Steps to reproduce
- Suggested fix (if obvious)

### Share Results

- Upload to shared drive or project management system
- Review with team
- Assign fixes to developers
- Schedule re-testing after fixes

---

## Troubleshooting

### "Script not found"
```bash
# Make sure you're in project root
cd "/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5"

# Run script
bash scripts/run_antigravity_test.sh
```

### "Permission denied"
```bash
chmod +x scripts/run_antigravity_test.sh
bash scripts/run_antigravity_test.sh
```

### "Directories not created"
The script creates test-results automatically. If not:
```bash
mkdir -p test-results/antigravity/{screenshots,reports}
```

### Need Lighthouse Performance Data
```bash
# Install globally
npm install -g lighthouse

# Then the script will capture detailed metrics
bash scripts/run_antigravity_test.sh --persona 1
```

---

## FAQ

**Q: How long should each test take?**
A: 45 minutes to 2 hours per persona depending on thoroughness. Average: 1 hour.

**Q: Do I need to run all 7 personas?**
A: For comprehensive testing before launch: yes. For quick spot-checking: run 2-3 key personas.

**Q: Where do I save screenshots?**
A: Run the script first - it creates the directory and tells you where to save them.

**Q: Can I test on my phone?**
A: Yes! Open https://beardsandbucks.com on your phone and test normally. Capture screenshots using your phone's screenshot button.

**Q: What if I find an issue mid-test?**
A: Document it immediately with a screenshot. Note the issue in your report and continue testing.

**Q: Can I skip sections of the checklist?**
A: Yes, focus on items relevant to your persona. Sarah (bowhunter) doesn't need to test vendor signup, for example.

**Q: What's more important - finding issues or following the checklist?**
A: Finding issues! The checklist is a guide, not a strict requirement.

**Q: How do I test on mobile without a real phone?**
A: Use browser DevTools (F12) → click the mobile device icon (top left of DevTools). But real phone testing is better if possible.

---

## Success Checklist

When all testing complete, you should have:

- ✅ 7 detailed persona reports (or however many you tested)
- ✅ 20+ screenshots documenting findings
- ✅ Performance metrics (load times, Lighthouse scores)
- ✅ List of critical issues to fix
- ✅ List of recommendations
- ✅ Master report combining all findings

**Total deliverables**: One comprehensive test report ready for development prioritization.

---

## Next Steps

1. **Run one persona test** - Pick Persona 1 and do a test run
2. **Gather all reports** - Create master summary
3. **Prioritize issues** - Critical / High / Medium / Low
4. **Share with team** - Review findings together
5. **Assign to developers** - Create tickets for fixes
6. **Re-test** - Rerun after fixes applied
7. **Sign off** - Confirm site ready for launch

---

**Generated**: December 8, 2025
**For**: Beards & Bucks Marketplace Comprehensive Testing
**Testing Framework**: Antigravity Multi-Persona System

Happy testing! 🎯
