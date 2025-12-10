# Antigravity Audit Objectives
**Beards & Bucks - Critical Fixes from Functional Audit**

**Date**: December 10, 2025
**Source**: functional_audit_report.md (Antigravity Audit)
**Status**: Objectives to Complete

---

## Critical Issues to Fix

### 🔴 Issue #1: Contact Page Missing (404 Error)
**Severity**: CRITICAL
**Current State**: URL `/contact/` returns 404 Page Not Found
**Impact**: Users cannot reach contact information; missing standard page
**Fix**: Create `/contact/` page with contact form or details
**Effort**: Low-Medium (1-2 hours)

**Tasks**:
- [ ] Create new WordPress page at slug `contact`
- [ ] Design page layout with Elementor
- [ ] Add contact form (e.g., WPForms, Contact Form 7)
- [ ] Test page loads at https://beardsandbucks.com/contact/
- [ ] Verify HTTP 200 status (not 404)
- [ ] Link from footer if not already linked

---

### 🔴 Issue #2: Search Functionality Broken
**Severity**: CRITICAL
**Current State**: Search filters don't submit on Enter key or button click
**Impact**: Users cannot search/filter listings; core directory functionality broken
**Evidence**:
- Tested on Hunting Gear page
- Typed "test" in Keyword field
- Pressed Enter → No response
- Page didn't reload, URL didn't update

**Fix**: Debug and repair search submission
**Effort**: Medium (2-4 hours, depends on root cause)

**Tasks**:
- [ ] Identify search form location (which page builder widget?)
- [ ] Check form submission handling (JavaScript/PHP)
- [ ] Test Enter key trigger (may need event listener)
- [ ] Test "Apply" button functionality
- [ ] Verify URL updates with filter parameters
- [ ] Test on all listing category pages (Hunting Gear, Archery Sales, Used Gear, Outfitter)
- [ ] Verify search results display correctly

---

### 🔴 Issue #3: Homepage Search Bar Missing
**Severity**: CRITICAL (for UX/Discoverability)
**Current State**: No search bar visible in homepage hero section
**Impact**: Reduces discoverability; users must navigate to category pages to search
**Fix**: Add prominent search bar to homepage hero
**Effort**: Low-Medium (1-2 hours)

**Tasks**:
- [ ] Design search bar placement on homepage hero
- [ ] Add search widget to Elementor page
- [ ] Style to match brand (colors, fonts, responsive design)
- [ ] Link search to category listings (or show all results)
- [ ] Test on desktop and mobile
- [ ] Verify search queries work end-to-end

---

## Secondary Issues

### ⚠️ Footer Links Difficult to Click
**Severity**: MEDIUM
**Issue**: Footer links (Privacy, Terms, Contact) hard to click via automation; possible layout shifts
**Fix**: Investigate footer layout for overlays or positioning issues
**Tasks**:
- [ ] Review footer HTML/CSS for z-index issues
- [ ] Check for overlapping elements
- [ ] Verify footer doesn't have sticky positioning conflicts
- [ ] Test footer link clicks

---

### ⚠️ Empty Category Pages
**Severity**: LOW
**Issue**: Some pages show "Nothing found" (Archery Sales, Used Gear)
**Status**: May be intentional (test listings only)
**Action**: Verify if this is expected or if content needs to be added

---

## Fix Priority Order

**Week 1 (Immediate)**:
1. Create Contact page (`/contact/`)
2. Fix Search functionality (Enter key + Apply button)

**Week 2**:
3. Add Homepage search bar
4. Fix footer link clickability

**Week 3**:
5. Address empty category pages (if needed)

---

## Success Criteria

All issues resolved when:
- ✅ `/contact/` page loads with HTTP 200
- ✅ Search filters submit on Enter key or Apply button
- ✅ Search results display correctly
- ✅ Homepage has visible search bar
- ✅ Search works from homepage
- ✅ Antigravity re-audit shows all items passing
- ✅ All 5 agent personas can complete their goals

---

## Related Testing

Once fixes are implemented:
- Re-run Antigravity audit to verify all items fixed
- Run full Antigravity testing (all 5 agents) to measure UX score improvement
- Verify no regressions in other areas

---

**Next Steps**: Begin implementation of Issue #1 (Contact page) and Issue #2 (Search functionality)
