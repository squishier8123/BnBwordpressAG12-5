#!/usr/bin/env node

/**
 * Simple QA Test for Beards & Bucks
 * Uses HTTP requests and HTML parsing - no browser required
 */

import https from 'https';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const SITE_URL = 'https://beardsandbucks.com';

// Test Results
const results = {
  timestamp: new Date().toISOString(),
  homepage: {},
  pages: {},
  errors: []
};

// Helper to fetch HTML
function fetchUrl(url) {
  return new Promise((resolve, reject) => {
    https.get(url, { timeout: 10000 }, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => resolve({ status: res.statusCode, html: data }));
    }).on('error', reject);
  });
}

// Test functions
async function testHomepage() {
  try {
    console.log('Testing homepage...');
    const { status, html } = await fetchUrl(SITE_URL);

    results.homepage.accessible = status === 200;
    results.homepage.status = status;

    // Check for key elements
    results.homepage.hasAddListingCTA = html.includes('Add Listing') || html.includes('add listing') || html.includes('Add a Listing');
    results.homepage.hasNav = html.includes('<nav') || html.includes('navigation');
    results.homepage.hasFooter = html.includes('<footer') || html.includes('footer');
    results.homepage.htmlLength = html.length;

    console.log('✓ Homepage tested');
    console.log(`  - Status: ${status}`);
    console.log(`  - Has Add Listing CTA: ${results.homepage.hasAddListingCTA}`);

  } catch (e) {
    results.errors.push(`Homepage test failed: ${e.message}`);
    console.log(`✗ Homepage test failed: ${e.message}`);
  }
}

async function testDecisionPage() {
  try {
    console.log('\nTesting decision page (Join Beards & Bucks)...');
    const { status, html } = await fetchUrl(`${SITE_URL}/join-beards-bucks/`);

    results.pages.decision = {
      accessible: status === 200,
      status: status,
      hasIndividualOption: html.includes('Individual') || html.includes('individual') || html.includes('List'),
      hasVendorOption: html.includes('Vendor') || html.includes('vendor') || html.includes('Register'),
      hasChoiceButtons: html.includes('button') || html.includes('Button') || html.includes('href')
    };

    console.log('✓ Decision page tested');
    console.log(`  - Status: ${status}`);
    console.log(`  - Has Individual option: ${results.pages.decision.hasIndividualOption}`);
    console.log(`  - Has Vendor option: ${results.pages.decision.hasVendorOption}`);

  } catch (e) {
    results.errors.push(`Decision page test failed: ${e.message}`);
    console.log(`✗ Decision page test failed: ${e.message}`);
  }
}

async function testIndividualListingPage() {
  try {
    console.log('\nTesting individual listing form (List Your Gear)...');
    const { status, html } = await fetchUrl(`${SITE_URL}/list-your-gear-8/`);

    results.pages.individual = {
      accessible: status === 200,
      status: status,
      hasForm: html.includes('<form') || html.includes('form'),
      hasSubmitButton: html.includes('submit') || html.includes('Submit'),
      hasNameField: html.includes('name') || html.includes('Name'),
    };

    console.log('✓ Individual listing form tested');
    console.log(`  - Status: ${status}`);
    console.log(`  - Has form: ${results.pages.individual.hasForm}`);

  } catch (e) {
    results.errors.push(`Individual listing test failed: ${e.message}`);
    console.log(`✗ Individual listing test failed: ${e.message}`);
  }
}

async function testVendorListingPage() {
  try {
    console.log('\nTesting vendor registration page...');
    const { status, html } = await fetchUrl(`${SITE_URL}/register-as-vendor/`);

    results.pages.vendor = {
      accessible: status === 200,
      status: status,
      hasForm: html.includes('<form') || html.includes('form'),
      hasSubmitButton: html.includes('submit') || html.includes('Submit'),
      hasBusinessField: html.includes('business') || html.includes('Business') || html.includes('store'),
    };

    console.log('✓ Vendor registration page tested');
    console.log(`  - Status: ${status}`);
    console.log(`  - Has form: ${results.pages.vendor.hasForm}`);

  } catch (e) {
    results.errors.push(`Vendor registration test failed: ${e.message}`);
    console.log(`✗ Vendor registration test failed: ${e.message}`);
  }
}

// Run all tests
async function runAllTests() {
  console.log('====================================');
  console.log('Beards & Bucks QA Test Suite');
  console.log('====================================\n');

  await testHomepage();
  await testDecisionPage();
  await testIndividualListingPage();
  await testVendorListingPage();

  // Save results
  const resultsPath = path.join(__dirname, 'qa_results.json');
  fs.writeFileSync(resultsPath, JSON.stringify(results, null, 2));

  // Print summary
  console.log('\n====================================');
  console.log('Test Summary');
  console.log('====================================');
  console.log(`Timestamp: ${results.timestamp}`);
  console.log(`Homepage Accessible: ${results.homepage.accessible}`);
  console.log(`Total Errors: ${results.errors.length}`);

  if (results.errors.length > 0) {
    console.log('\nErrors:');
    results.errors.forEach(e => console.log(`  - ${e}`));
  }

  console.log(`\nResults saved to: ${resultsPath}`);
}

runAllTests().catch(console.error);
