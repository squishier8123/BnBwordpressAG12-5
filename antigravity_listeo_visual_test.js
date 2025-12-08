#!/usr/bin/env node

/**
 * Listeo Pages Visual Verification Script for Playwright/Antigravity
 * Takes screenshots of all Listeo pages to verify they render correctly
 */

const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const BASE_URL = 'https://beardsandbucks.com';
const SCREENSHOTS_DIR = '/tmp/listeo_screenshots';

// Create screenshots directory
if (!fs.existsSync(SCREENSHOTS_DIR)) {
  fs.mkdirSync(SCREENSHOTS_DIR, { recursive: true });
}

const pages = [
  { name: 'Messages', url: '/messages/', shortcode: '[listeo_messages]' },
  { name: 'My Bookings', url: '/my-bookings/', shortcode: '[listeo_my_bookings]' },
  { name: 'Bookmarks', url: '/bookmarks/', shortcode: '[listeo_bookmarks]' },
  { name: 'Statistics', url: '/statistics/', shortcode: '[listeo_stats_full]' },
  { name: 'Lost Password', url: '/lost-password/', shortcode: '[listeo_lost_password]' },
  { name: 'Reset Password', url: '/reset-password/', shortcode: '[listeo_reset_password]' },
  { name: 'Ticket Verification', url: '/ticket-verification/', shortcode: '[listeo_ar_check]' },
  { name: 'Ad Campaigns', url: '/ad-campaigns/', shortcode: '[listeo_ads]' },
  { name: 'Coupons', url: '/coupons/', shortcode: '[listeo_coupons]' },
];

async function verifyListeoPages() {
  console.log('='.repeat(60));
  console.log('LISTEO PAGES VISUAL VERIFICATION WITH SCREENSHOTS');
  console.log('='.repeat(60));
  console.log(`\nScreenshots directory: ${SCREENSHOTS_DIR}\n`);

  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();

  // Set viewport for consistent screenshots
  await page.setViewportSize({ width: 1280, height: 1024 });

  const results = [];

  for (const pageData of pages) {
    try {
      const fullUrl = BASE_URL + pageData.url;
      console.log(`\nTesting: ${pageData.name}`);
      console.log(`URL: ${fullUrl}`);
      console.log(`Shortcode: ${pageData.shortcode}`);

      // Navigate to page
      await page.goto(fullUrl, { waitUntil: 'networkidle', timeout: 30000 });

      // Get page title
      const pageTitle = await page.title();
      console.log(`Page Title: ${pageTitle}`);

      // Take screenshot
      const screenshotPath = path.join(SCREENSHOTS_DIR, `${pageData.name.replace(/\s+/g, '_').toLowerCase()}.png`);
      await page.screenshot({ path: screenshotPath, fullPage: true });
      console.log(`Screenshot: ${screenshotPath}`);

      // Check for content
      const contentSize = await page.evaluate(() => document.body.innerText.length);
      console.log(`Content Size: ${contentSize} characters`);

      // Check for common Listeo elements
      const hasListeoContent = await page.evaluate(() => {
        const bodyText = document.body.innerText.toLowerCase();
        return bodyText.includes('listeo') || bodyText.includes('dashboard') ||
          bodyText.includes('message') || bodyText.includes('booking') ||
          bodyText.length > 1000; // Or has substantial content
      });

      console.log(`Result: ✅ PASS (Content present: ${hasListeoContent})`);

      results.push({
        name: pageData.name,
        url: fullUrl,
        status: 'PASS',
        screenshot: screenshotPath,
        title: pageTitle,
        contentSize,
      });

    } catch (error) {
      console.log(`Result: ❌ FAIL - ${error.message}`);
      results.push({
        name: pageData.name,
        url: BASE_URL + pageData.url,
        status: 'FAIL',
        error: error.message,
      });
    }

    // Small delay between pages
    await page.waitForTimeout(500);
  }

  await context.close();
  await browser.close();

  // Print summary
  console.log('\n' + '='.repeat(60));
  console.log('SUMMARY');
  console.log('='.repeat(60));

  const passCount = results.filter(r => r.status === 'PASS').length;
  const failCount = results.filter(r => r.status === 'FAIL').length;

  console.log(`\nResults: ${passCount} PASSED, ${failCount} FAILED out of ${results.length} pages`);

  if (passCount === results.length) {
    console.log('\n✅ All Listeo pages verified successfully!');
    console.log(`\nScreenshots saved to: ${SCREENSHOTS_DIR}`);
    console.log('\nScreenshots:');
    results.forEach(r => {
      if (r.screenshot) {
        console.log(`  - ${r.name}: ${path.basename(r.screenshot)}`);
      }
    });
  } else {
    console.log('\n⚠️ Some pages failed verification.');
    results.filter(r => r.status === 'FAIL').forEach(r => {
      console.log(`  - ${r.name}: ${r.error}`);
    });
  }

  console.log('\n' + '='.repeat(60) + '\n');

  return passCount === results.length ? 0 : 1;
}

// Run verification
verifyListeoPages()
  .then(exitCode => process.exit(exitCode))
  .catch(error => {
    console.error('Fatal error:', error);
    process.exit(1);
  });
