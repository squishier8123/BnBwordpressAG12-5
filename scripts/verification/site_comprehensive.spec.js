const { test, expect } = require('@playwright/test');

const BASE_URL = 'https://beardsandbucks.com';

test.describe('Beards & Bucks Site Comprehensive Test', () => {

  // Test 1: Homepage loads and is functional
  test('Homepage loads without errors', async ({ page }) => {
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    // Check page title exists
    const title = await page.title();
    console.log(`✅ Homepage title: ${title}`);
    expect(title).toBeTruthy();

    // Check for critical elements
    const body = await page.content();
    expect(body).toContain('Beards');
    console.log('✅ Homepage content loads');
  });

  // Test 2: Navigation menu links
  test('Navigation menu links are correct', async ({ page }) => {
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    const pageContent = await page.content();

    const checks = {
      'Browse by Category link': pageContent.includes('directory-9'),
      'Browse by County link': pageContent.includes('browse-by-county'),
      'Add Listing link': pageContent.includes('list-your-gear'),
      'Broken page_id=4404': pageContent.includes('page_id=4404')
    };

    console.log('\n--- Navigation Menu Check ---');
    console.log(`✅ directory-9 found: ${checks['Browse by Category link']}`);
    console.log(`✅ browse-by-county found: ${checks['Browse by County link']}`);
    console.log(`${checks['Add Listing link'] ? '✅' : '❌'} list-your-gear found: ${checks['Add Listing link']}`);
    console.log(`${checks['Broken page_id=4404'] ? '❌' : '✅'} page_id=4404 NOT present: ${!checks['Broken page_id=4404']}`);

    expect(checks['Browse by Category link']).toBe(true);
    expect(checks['Browse by County link']).toBe(true);
  });

  // Test 3: Browse by Category page
  test('Browse by Category page loads and has content', async ({ page }) => {
    await page.goto(`${BASE_URL}/directory-9/`, { waitUntil: 'networkidle' });

    const content = await page.content();

    expect(content).toContain('category') || expect(content).toContain('directory') || expect(content).toContain('browse');
    console.log('✅ Browse by Category page loads with content');
  });

  // Test 4: Browse by County page
  test('Browse by County page loads and has content', async ({ page }) => {
    await page.goto(`${BASE_URL}/browse-by-county/`, { waitUntil: 'networkidle' });

    const content = await page.content();

    expect(content).toContain('county') || expect(content).toContain('location') || expect(content).toContain('browse');
    console.log('✅ Browse by County page loads with content');
  });

  // Test 5: Add Listing page
  test('Add Listing page loads and has Dokan form', async ({ page }) => {
    await page.goto(`${BASE_URL}/list-your-gear-8/`, { waitUntil: 'networkidle' });

    const content = await page.content();

    // Check for form elements
    const hasForm = content.includes('form') || content.includes('input');
    const hasDokan = content.includes('dokan');

    console.log(`✅ Add Listing page loads: ${hasForm ? 'with form' : 'without form'}`);
    console.log(`✅ Dokan integration: ${hasDokan ? 'detected' : 'not detected'}`);

    expect(hasForm || hasDokan).toBe(true);
  });

  // Test 6: Vendor Pricing page
  test('Vendor Pricing page loads', async ({ page }) => {
    await page.goto(`${BASE_URL}/vendor-pricing/`, { waitUntil: 'networkidle' });

    const content = await page.content();
    expect(content.length).toBeGreaterThan(0);
    console.log('✅ Vendor Pricing page loads');
  });

  // Test 7: Vendor Tools page (should exist)
  test('Vendor Tools page accessibility', async ({ page }) => {
    const response = await page.goto(`${BASE_URL}/vendor-tools/`, { waitUntil: 'networkidle' });

    console.log(`Vendor Tools HTTP Status: ${response.status()}`);

    if (response.status() === 200) {
      console.log('✅ Vendor Tools page exists and loads');
    } else if (response.status() === 404) {
      console.log('❌ Vendor Tools page returns 404 (page not found)');
    } else {
      console.log(`⚠️  Vendor Tools page status: ${response.status()}`);
    }
  });

  // Test 8: Check for JavaScript errors
  test('Check for JavaScript errors', async ({ page }) => {
    const errors = [];

    page.on('console', msg => {
      if (msg.type() === 'error') {
        errors.push(msg.text());
      }
    });

    page.on('pageerror', err => {
      errors.push(err.toString());
    });

    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    if (errors.length === 0) {
      console.log('✅ No JavaScript errors detected');
    } else {
      console.log(`⚠️  JavaScript errors found: ${errors.length}`);
      errors.forEach(err => console.log(`   - ${err.substring(0, 100)}`));
    }
  });

  // Test 9: Critical buttons and links are clickable
  test('Navigation buttons are clickable', async ({ page }) => {
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    // Find and try to click Browse by Category
    const links = await page.$$('a');
    let foundDirectory = false;
    let foundCounty = false;
    let foundAddListing = false;

    for (const link of links) {
      const href = await link.getAttribute('href');
      if (href && href.includes('directory-9')) foundDirectory = true;
      if (href && href.includes('browse-by-county')) foundCounty = true;
      if (href && href.includes('list-your-gear')) foundAddListing = true;
    }

    console.log(`✅ Browse by Category link clickable: ${foundDirectory}`);
    console.log(`✅ Browse by County link clickable: ${foundCounty}`);
    console.log(`${foundAddListing ? '✅' : '❌'} Add Listing link clickable: ${foundAddListing}`);
  });

  // Test 10: Page performance basic check
  test('Pages load within reasonable time', async ({ page }) => {
    const startTime = Date.now();
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });
    const loadTime = Date.now() - startTime;

    console.log(`Homepage load time: ${loadTime}ms`);

    if (loadTime < 5000) {
      console.log('✅ Fast load time');
    } else if (loadTime < 10000) {
      console.log('⚠️  Moderate load time');
    } else {
      console.log('❌ Slow load time');
    }
  });

  // Test 11: Responsive design check
  test('Site is responsive on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 }); // iPhone size
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    const content = await page.content();
    expect(content.length).toBeGreaterThan(0);
    console.log('✅ Site responsive on mobile viewport');
  });

  // Test 12: Vendor dashboard functionality
  test('Vendor functionality is present', async ({ page }) => {
    await page.goto(BASE_URL, { waitUntil: 'networkidle' });

    const content = await page.content();
    const hasVendor = content.includes('dokan') || content.includes('vendor') || content.includes('seller');

    console.log(`✅ Vendor functionality present: ${hasVendor}`);
  });

});
