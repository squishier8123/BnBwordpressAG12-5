# Beards & Bucks - Page Mapping Quick Reference

**Last Updated:** 2025-12-06
**Total Pages:** 28

---

## Quick Lookup: Key Pages

### Homepage
- **ID 4370** - Home 3 - https://beardsandbucks.com/

### Registration & Onboarding
- **ID 4620** - Join Beards & Bucks (Decision Page) - https://beardsandbucks.com/join-beards-bucks/
- **ID 4622** - Register as Vendor - https://beardsandbucks.com/register-as-vendor/
- **ID 4621** - Register as Buyer - https://beardsandbucks.com/register-as-buyer/

### Listing Submission
- **ID 4090** - List Your Gear (Public) - https://beardsandbucks.com/list-your-gear-8/
- **ID 4250** - Vendor Dashboard – Add Listing (Vendors) - https://beardsandbucks.com/vendor-dashboard-add-listing/

### Vendor Dashboard
- **ID 4246** - Vendor Dashboard (Main) - https://beardsandbucks.com/vendor-dashboard/
- **ID 4248** - Vendor Dashboard – Listings (Manage) - https://beardsandbucks.com/vendor-dashboard-listings/

### User Dashboard
- **ID 4638** - My Dashboard - https://beardsandbucks.com/my-dashboard/

### Marketplace Browsing
- **ID 4192** - Vendors - https://beardsandbucks.com/vendors-2/
- **ID 4546** - Store List - https://beardsandbucks.com/store-listing-2/
- **ID 4094** - Directory - https://beardsandbucks.com/directory-9/
- **ID 4101** - Used Gear - https://beardsandbucks.com/used-gear-8/

---

## Current User Flows

### Flow 1: Individual Listing Submission (Non-Vendor)
```
User clicks "Add a Listing"
    ↓
[MISSING DECISION PAGE]
    ↓
List Your Gear (ID 4090)
```

**GAP:** No routing page to distinguish individual listing vs vendor signup

---

### Flow 2: Vendor Registration & Store Setup
```
User clicks "Become a Vendor"
    ↓
Join Beards & Bucks (ID 4620) - Decision page
    ↓
Register as Vendor (ID 4622)
    ↓
Vendor Dashboard (ID 4246)
    ↓
Vendor Dashboard – Add Listing (ID 4250)
```

**STATUS:** Complete flow exists

---

### Flow 3: Buyer Registration
```
User clicks "Sign Up"
    ↓
Join Beards & Bucks (ID 4620) - Decision page
    ↓
Register as Buyer (ID 4621)
    ↓
My Dashboard (ID 4638)
```

**STATUS:** Complete flow exists

---

## Page Categories

### Navigation Pages (9)
4370, 4619, 4662, 4095, 4092, 4102, 4097, 4664, 4663

### Marketplace Pages (5)
4192, 4546, 4101, 4094, 4091

### Registration Pages (3)
4622, 4621, 4620

### User Dashboard Pages (4)
4638, 4098, 4085, 4088

### Vendor Pages (4)
4246, 4248, 4250, 4090

### Legal Pages (2)
4618, 4617

### Misc (1)
2 (Sample Page - can be deleted)

---

## Duplicate Pages to Address

| Current Pages | Recommendation |
|---------------|----------------|
| **How It Works:** 4662 + 4095 | Keep 4662, delete 4095 |
| **Dashboard:** 4638 + 4098 | Keep 4638, delete 4098 |

---

## Missing Pages to Create

| Page Needed | Purpose | Routes To |
|-------------|---------|-----------|
| **Add Listing Decision** | Choose listing type | ID 4090 (individual) or ID 4622 (vendor) |
| **Dokan Vendor Dashboard** | Official Dokan page | Vendor tools |
| **Dokan Setup Wizard** | Vendor onboarding | N/A |

---

## Dokan Configuration Needed

**Current Status:** Dokan is active but pages not configured

**Required Dokan Pages:**
1. Vendor Dashboard - Suggest using ID 4246
2. Vendor Registration - Suggest using ID 4622
3. Store Listing - Already exists at ID 4546
4. Terms & Conditions - Already exists at ID 4617

**Action:** Configure in WordPress Admin → Dokan → Settings → Pages

---

## Listeo Configuration Needed

**Current Status:** Listeo is active (API namespace detected)

**Check for Listeo Pages:**
- Submission page
- Search results page
- Single listing template

**Action:** Check WordPress Admin → Listeo → Settings

---

## Summary

✅ **Working:**
- Homepage is set (ID 4370)
- Vendor registration flow (4620 → 4622 → 4246 → 4250)
- Buyer registration flow (4620 → 4621 → 4638)

⚠️ **Needs Attention:**
- Missing "Add Listing" decision/routing page
- Duplicate pages (How It Works, Dashboard)
- Dokan page configuration
- Clarify difference between ID 4090 (List Your Gear) and ID 4250 (Vendor Add Listing)

❌ **Gaps:**
- No clear routing for individual listing vs vendor signup
- Dokan and Listeo pages not explicitly configured
- Sample page (ID 2) still exists

---

## Quick Decision Matrix

**User wants to:**

| Goal | Current Page | Status |
|------|-------------|--------|
| Browse vendors | ID 4192 or 4546 | ✅ Works |
| Browse listings | ID 4094 or 4101 | ✅ Works |
| Add one listing | ID 4090 | ⚠️ No routing |
| Become vendor | ID 4622 | ✅ Works |
| Manage vendor store | ID 4246 | ✅ Works |
| View their dashboard | ID 4638 | ✅ Works |

---

## Files

- Full report: `/CURRENT_PAGE_STRUCTURE_REPORT.md`
- This quick reference: `/PAGE_MAPPING_QUICK_REFERENCE.md`
- Cleanup plan: `/04_ANTIGRAVITY_EXECUTION/PAGE_CLEANUP_PLAN.md`
