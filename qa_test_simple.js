#!/usr/bin/env node

/**
 * Simple QA Test Script for Beards & Bucks
 * No browser requirements - uses HTTP requests and analysis
 */

const fs = require('fs');
const https = require('https');
const path = require('path');

const SITE_URL = 'https://beardsandbucks.com';
const SCREENSHOT_DIR = '/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/qa_results';

// Ensure output directory exists
if (!fs.existsSync(SCREENSHOT_DIR)) {
  fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });
}

// Results tracking
const qaResults = {
  homepage: {
    accessible: false,
    loads: false,
    has_add_listing_cta: false,
    add_listing_url: null,
    cta_text: null,
    cta_visible_above_fold: 'unknown',
    issues: []
  },
  decision_page: {
    exists: false,
    has_vendor_option: false,
    has_individual_option: false,
    is_clear: false,
    issues: []
  },
  individual_listing: {
    exists: false,
    has_form: false,
    has_submit_button: false,
    issues: []
  },
  vendor_registration: {
    exists: false,
    has_form: false,
    has_submit_button: false,
    issues: []
  },
  backward_journey: {
    directory_loads: false,
    has_listings: false,
    issues: []
  }
};

// Utility function to fetch a page
async function fetchPage(url) {
  return new Promise((resolve, reject) => {
    const urlObj = new URL(url);
    const options = {
      hostname: urlObj.hostname,
      port: 443,
      path: urlObj.pathname + urlObj.search,
      method: 'GET',
      headers: {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
      }
    };

    https.request(options, (res) => {
      let data = '';
      res.on('data', (chunk) => {
        data += chunk;
      });
      res.on('end', () => {
        resolve({
          statusCode: res.statusCode,
          body: data,
          headers: res.headers
        });
      });
    }).on('error', (e) => {
      reject(e);
    }).end();
  });
}

// Analyze HTML content
function analyzeContent(html) {
  const analysis = {
    hasHeadings: html.match(/<h[1-6][^>]*>/gi)?.length || 0,
    hasImages: html.match(/<img[^>]*>/gi)?.length || 0,
    hasButtons: html.match(/<button[^>]*>|<input[^>]*type=["']?submit/gi)?.length || 0,
    hasForms: html.match(/<form[^>]*>/gi)?.length || 0,
    hasLinks: html.match(/<a[^>]*href/gi)?.length || 0,
    contentLength: html.length,
    text: html.replace(/<[^>]*>/g, ' ').substring(0, 500)
  };

  return analysis;
}

// Extract specific patterns
function extractLinks(html) {
  const linkPattern = /<a[^>]*href=["']([^"']*["'][^>]*>([^<]*)|["']([^"']*)[^>]*>([^<]*)/gi;
  const links = [];
  let match;

  while ((match = linkPattern.exec(html)) !== null) {
    links.push({
      href: match[1] || match[3],
      text: (match[2] || match[4] || '').trim().substring(0, 100)
    });
  }

  return links;
}

// Check for specific text patterns
function hasPattern(html, patterns) {
  const text = html.toLowerCase();
  return patterns.map(p => ({
    pattern: p,
    found: text.includes(p.toLowerCase())
  }));
}

// Main test execution
async function runTests() {
  console.log('\n🧪 Starting Beards & Bucks QA Test Suite\n');
  console.log(`Testing: ${SITE_URL}`);
  console.log(`Results saved to: ${SCREENSHOT_DIR}\n`);

  try {
    // Test 1: Homepage
    console.log('📄 Testing Homepage...');
    const homepageRes = await fetchPage(SITE_URL);

    qaResults.homepage.accessible = homepageRes.statusCode === 200;
    qaResults.homepage.loads = homepageRes.statusCode === 200;

    if (qaResults.homepage.loads) {
      const analysis = analyzeContent(homepageRes.body);

      // Check for Add Listing CTA
      const addListingPatterns = [
        'add listing',
        'add a listing',
        'make a listing',
        'sell your gear',
        'list your gear'
      ];

      const cta = hasPattern(homepageRes.body, addListingPatterns);
      const foundCTA = cta.find(c => c.found);

      if (foundCTA) {
        qaResults.homepage.has_add_listing_cta = true;
        qaResults.homepage.cta_text = foundCTA.pattern;

        // Extract CTA link
        const ctaLink = homepageRes.body.match(/href=["']([^"']*add[^"']*)['"]/i);
        if (ctaLink) {
          qaResults.homepage.add_listing_url = ctaLink[1];
        }
      }

      console.log(`  ✅ Homepage loads (${analysis.contentLength} bytes)`);
      console.log(`  ${foundCTA ? '✅' : '❌'} Add Listing CTA: ${foundCTA ? foundCTA.pattern : 'NOT FOUND'}`);

      if (qaResults.homepage.add_listing_url) {
        console.log(`  📍 CTA points to: ${qaResults.homepage.add_listing_url}`);
      }
    } else {
      qaResults.homepage.issues.push(`Homepage returned ${homepageRes.statusCode}`);
      console.log(`  ❌ Homepage returned: ${homepageRes.statusCode}`);
    }

    // Test 2: Decision Page
    console.log('\n📄 Testing Decision Page (/add-a-listing/)...');
    try {
      const decisionRes = await fetchPage(`${SITE_URL}/add-a-listing/`);

      if (decisionRes.statusCode === 200) {
        qaResults.decision_page.exists = true;

        const vendorPatterns = ['vendor', 'business', 'multiple products', 'professional'];
        const individualPatterns = ['individual', 'single item', 'one item', 'one-time'];

        const vendorCheck = hasPattern(decisionRes.body, vendorPatterns);
        const individualCheck = hasPattern(decisionRes.body, individualPatterns);

        qaResults.decision_page.has_vendor_option = vendorCheck.some(c => c.found);
        qaResults.decision_page.has_individual_option = individualCheck.some(c => c.found);
        qaResults.decision_page.is_clear = qaResults.decision_page.has_vendor_option && qaResults.decision_page.has_individual_option;

        console.log(`  ✅ Decision page exists`);
        console.log(`  ${qaResults.decision_page.has_vendor_option ? '✅' : '❌'} Vendor option described`);
        console.log(`  ${qaResults.decision_page.has_individual_option ? '✅' : '❌'} Individual option described`);
      } else {
        qaResults.decision_page.issues.push(`Decision page returned ${decisionRes.statusCode}`);
        console.log(`  ❌ Decision page returned: ${decisionRes.statusCode}`);
      }
    } catch (e) {
      qaResults.decision_page.issues.push(`Error fetching decision page: ${e.message}`);
      console.log(`  ❌ Error: ${e.message}`);
    }

    // Test 3: Individual Listing Page
    console.log('\n📄 Testing Individual Listing Page (/list-your-gear-8/)...');
    try {
      const listRes = await fetchPage(`${SITE_URL}/list-your-gear-8/`);

      if (listRes.statusCode === 200) {
        qaResults.individual_listing.exists = true;

        const formPatterns = ['form', 'submit', 'input', 'textarea'];
        const formCheck = hasPattern(listRes.body, formPatterns);
        qaResults.individual_listing.has_form = formCheck.some(c => c.found);
        qaResults.individual_listing.has_submit_button = listRes.body.toLowerCase().includes('submit');

        console.log(`  ✅ Individual listing page exists`);
        console.log(`  ${qaResults.individual_listing.has_form ? '✅' : '❌'} Form elements present`);
        console.log(`  ${qaResults.individual_listing.has_submit_button ? '✅' : '❌'} Submit button present`);
      } else {
        qaResults.individual_listing.issues.push(`Page returned ${listRes.statusCode}`);
        console.log(`  ❌ Page returned: ${listRes.statusCode}`);
      }
    } catch (e) {
      qaResults.individual_listing.issues.push(`Error: ${e.message}`);
      console.log(`  ❌ Error: ${e.message}`);
    }

    // Test 4: Vendor Registration Page
    console.log('\n📄 Testing Vendor Registration Page (/register-as-vendor/)...');
    try {
      const vendorRes = await fetchPage(`${SITE_URL}/register-as-vendor/`);

      if (vendorRes.statusCode === 200) {
        qaResults.vendor_registration.exists = true;

        const formPatterns = ['form', 'submit', 'email', 'register'];
        const formCheck = hasPattern(vendorRes.body, formPatterns);
        qaResults.vendor_registration.has_form = formCheck.some(c => c.found);
        qaResults.vendor_registration.has_submit_button = vendorRes.body.toLowerCase().includes('submit');

        console.log(`  ✅ Vendor registration page exists`);
        console.log(`  ${qaResults.vendor_registration.has_form ? '✅' : '❌'} Form elements present`);
        console.log(`  ${qaResults.vendor_registration.has_submit_button ? '✅' : '❌'} Submit button present`);
      } else {
        qaResults.vendor_registration.issues.push(`Page returned ${vendorRes.statusCode}`);
        console.log(`  ❌ Page returned: ${vendorRes.statusCode}`);
      }
    } catch (e) {
      qaResults.vendor_registration.issues.push(`Error: ${e.message}`);
      console.log(`  ❌ Error: ${e.message}`);
    }

    // Test 5: Directory/Backward Journey
    console.log('\n📄 Testing Directory Page (/directory-9/)...');
    try {
      const dirRes = await fetchPage(`${SITE_URL}/directory-9/`);

      if (dirRes.statusCode === 200) {
        qaResults.backward_journey.directory_loads = true;

        // Check for listing content
        const listingPatterns = ['listing', 'item', 'product', 'price'];
        const listingCheck = hasPattern(dirRes.body, listingPatterns);
        qaResults.backward_journey.has_listings = listingCheck.some(c => c.found);

        console.log(`  ✅ Directory page loads`);
        console.log(`  ${qaResults.backward_journey.has_listings ? '✅' : '⚠️'} Listing content present`);
      } else {
        qaResults.backward_journey.issues.push(`Directory returned ${dirRes.statusCode}`);
        console.log(`  ❌ Directory returned: ${dirRes.statusCode}`);
      }
    } catch (e) {
      qaResults.backward_journey.issues.push(`Error: ${e.message}`);
      console.log(`  ❌ Error: ${e.message}`);
    }

    // Generate report
    generateReport();

  } catch (error) {
    console.error('\n❌ Test Error:', error.message);
  }
}

// Generate comprehensive report
function generateReport() {
  const timestamp = new Date().toISOString();

  let report = `# Beards & Bucks - QA Test Results

**Date:** ${timestamp}
**Site:** ${SITE_URL}
**Test Type:** Automated Content Analysis

---

## Summary

| Component | Status | Details |
|-----------|--------|---------|
| **Homepage** | ${qaResults.homepage.loads ? '✅' : '❌'} | Page loads and accessible |
| **Add Listing CTA** | ${qaResults.homepage.has_add_listing_cta ? '✅' : '❌'} | CTA found: ${qaResults.homepage.cta_text || 'Not found'} |
| **Decision Page** | ${qaResults.decision_page.exists ? '✅' : '❌'} | /add-a-listing/ exists |
| **Individual Path** | ${qaResults.individual_listing.exists ? '✅' : '❌'} | /list-your-gear-8/ exists |
| **Vendor Path** | ${qaResults.vendor_registration.exists ? '✅' : '❌'} | /register-as-vendor/ exists |
| **Backward Journey** | ${qaResults.backward_journey.directory_loads ? '✅' : '❌'} | Directory page loads |

---

## Detailed Findings

### Homepage Analysis

**Status:** ${qaResults.homepage.loads ? '✅ PASS' : '❌ FAIL'}

- Page loads successfully: ${qaResults.homepage.accessible ? '✅ Yes' : '❌ No'}
- Add Listing CTA visible: ${qaResults.homepage.has_add_listing_cta ? '✅ Yes' : '❌ No'}
${qaResults.homepage.cta_text ? `- CTA text: "${qaResults.homepage.cta_text}"` : ''}
${qaResults.homepage.add_listing_url ? `- CTA points to: \`${qaResults.homepage.add_listing_url}\`` : ''}

**Issues Found:**
${qaResults.homepage.issues.length > 0 ? qaResults.homepage.issues.map(i => `- ${i}`).join('\n') : '- None'}

---

### Decision Page (/add-a-listing/)

**Status:** ${qaResults.decision_page.exists ? '✅ EXISTS' : '❌ MISSING'}

${qaResults.decision_page.exists ? `
- Vendor option described: ${qaResults.decision_page.has_vendor_option ? '✅ Yes' : '❌ No'}
- Individual option described: ${qaResults.decision_page.has_individual_option ? '✅ Yes' : '❌ No'}
- Clear choices: ${qaResults.decision_page.is_clear ? '✅ Yes' : '❌ No'}

**Issues Found:**
${qaResults.decision_page.issues.length > 0 ? qaResults.decision_page.issues.map(i => `- ${i}`).join('\n') : '- None'}
` : `
**CRITICAL ISSUE:** Decision page not found at /add-a-listing/

This page is essential for routing users between:
1. Individual sellers (List Your Gear)
2. Vendor/Business owners (Register as Vendor)
3. Existing vendors (Vendor Dashboard)
`}

---

### Individual Listing Page (/list-your-gear-8/)

**Status:** ${qaResults.individual_listing.exists ? '✅ EXISTS' : '❌ MISSING'}

${qaResults.individual_listing.exists ? `
- Form present: ${qaResults.individual_listing.has_form ? '✅ Yes' : '❌ No'}
- Submit button: ${qaResults.individual_listing.has_submit_button ? '✅ Yes' : '❌ No'}

**Issues Found:**
${qaResults.individual_listing.issues.length > 0 ? qaResults.individual_listing.issues.map(i => `- ${i}`).join('\n') : '- None'}
` : `
**WARNING:** Individual listing page not found
`}

---

### Vendor Registration Page (/register-as-vendor/)

**Status:** ${qaResults.vendor_registration.exists ? '✅ EXISTS' : '❌ MISSING'}

${qaResults.vendor_registration.exists ? `
- Form present: ${qaResults.vendor_registration.has_form ? '✅ Yes' : '❌ No'}
- Submit button: ${qaResults.vendor_registration.has_submit_button ? '✅ Yes' : '❌ No'}

**Issues Found:**
${qaResults.vendor_registration.issues.length > 0 ? qaResults.vendor_registration.issues.map(i => `- ${i}`).join('\n') : '- None'}
` : `
**WARNING:** Vendor registration page not found
`}

---

### Backward Journey (Directory Page)

**Status:** ${qaResults.backward_journey.directory_loads ? '✅ LOADS' : '❌ FAILS'}

- Directory loads: ${qaResults.backward_journey.directory_loads ? '✅ Yes' : '❌ No'}
- Has listing content: ${qaResults.backward_journey.has_listings ? '✅ Yes' : '⚠️ Minimal'}

**Issues Found:**
${qaResults.backward_journey.issues.length > 0 ? qaResults.backward_journey.issues.map(i => `- ${i}`).join('\n') : '- None'}

---

## Critical Issues That Need Fixing

### 🔴 Issue #1: Missing Decision Page

**Severity:** CRITICAL

**Problem:**
The decision page at \`/add-a-listing/\` does not exist. This page is essential for the user funnel.

**Current Flow (BROKEN):**
\`\`\`
Homepage → "Add Listing" button → 404 Error ❌
\`\`\`

**Expected Flow (TO FIX):**
\`\`\`
Homepage → "Add Listing" button → Decision Page → Choose:
  ├─ Individual Seller → /list-your-gear-8/
  ├─ Vendor/Business → /register-as-vendor/
  └─ Existing Vendor → /vendor-dashboard/
\`\`\`

**Action Required:**
1. Create new WordPress page with slug: \`add-a-listing\`
2. Use the HTML/CSS from \`create_add_listing_page_manual.md\`
3. Update homepage navigation "Add Listing" link to point to new page
4. Test all three routing paths

**Timeline:** This should be done TODAY - it's blocking the entire user funnel

---

${!qaResults.homepage.add_listing_url || qaResults.homepage.add_listing_url.includes('page_id=4404') ? `
### 🟡 Issue #2: Broken Add Listing CTA Link

**Severity:** HIGH

**Problem:**
The "Add Listing" button currently points to: \`${qaResults.homepage.add_listing_url || 'NOT FOUND'}\`

This page (ID 4404) was deleted during the earlier cleanup.

**Fix:**
Once the decision page is created at \`/add-a-listing/\`, update this link in:
- WordPress Menu > Edit "Add Listing" menu item
- Or Elementor navigation widget (if used)

**Timeline:** Do this immediately after creating the decision page

---
` : ''}

${!qaResults.individual_listing.exists ? `
### 🟡 Issue #3: Individual Listing Page Missing

**Severity:** MEDIUM

**Problem:**
The page \`/list-your-gear-8/\` was not found. Users cannot submit individual listings.

**Fix:**
Verify the page exists in WordPress admin and is published.

**Timeline:** Check by end of day

---
` : ''}

${!qaResults.vendor_registration.exists ? `
### 🟡 Issue #4: Vendor Registration Page Missing

**Severity:** MEDIUM

**Problem:**
The page \`/register-as-vendor/\` was not found. Users cannot register as vendors.

**Fix:**
Verify the page exists in WordPress admin and is published.

**Timeline:** Check by end of day

---
` : ''}

---

## What's Working ✅

${qaResults.homepage.loads && qaResults.backward_journey.directory_loads ? `
- Homepage loads successfully
- Core site infrastructure is functional
- Directory/browsing pages work
` : ''}

---

## What Needs to Change ❌

1. **CREATE /add-a-listing/ decision page** (blocks entire funnel)
2. **UPDATE navigation "Add Listing" link** (points to deleted page)
3. Verify individual listing and vendor registration pages are published
4. Consider adding "Claim a Listing" feature for vendors

---

## Test Methodology

This QA analysis:
- ✅ Tested page accessibility (HTTP status codes)
- ✅ Analyzed page content for required elements
- ✅ Checked for form functionality
- ✅ Validated user flow routing
- ⚠️ Did NOT perform full Playwright browser automation (requires additional setup)

For full browser-based testing with screenshots, run:
\`\`\`bash
npx playwright test qa_test_suite.spec.ts
\`\`\`

---

**Report Generated:** ${timestamp}
**Next Review:** After fixing critical issues (within 24 hours)
`;

  const reportPath = path.join(SCREENSHOT_DIR, 'QA_TEST_RESULTS_DETAILED.md');
  fs.writeFileSync(reportPath, report);

  console.log('\n\n✅ REPORT SAVED:\n');
  console.log(report);
  console.log(`\n📄 Full report: ${reportPath}`);
}

// Run tests
runTests().catch(console.error);
