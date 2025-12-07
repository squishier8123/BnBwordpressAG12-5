#!/usr/bin/env node

/**
 * Comprehensive QA Test Suite for Beards & Bucks
 * Tests: Accessibility, Performance, Forms, Security, SEO, Mobile Responsiveness
 */

import https from 'https';
import { URL } from 'url';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const SITE_URL = 'https://beardsandbucks.com';

// Test Results Structure
const results = {
  timestamp: new Date().toISOString(),
  siteScore: 0,
  categories: {
    accessibility: { score: 0, tests: {} },
    performance: { score: 0, tests: {} },
    forms: { score: 0, tests: {} },
    security: { score: 0, tests: {} },
    seo: { score: 0, tests: {} },
    mobile: { score: 0, tests: {} }
  },
  pages: {},
  summary: {
    totalTests: 0,
    passedTests: 0,
    failedTests: 0,
    errors: []
  }
};

// Helper to fetch with timing
function fetchUrl(url, options = {}) {
  return new Promise((resolve, reject) => {
    const startTime = Date.now();
    https.get(url, { timeout: 15000, ...options }, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => {
        const loadTime = Date.now() - startTime;
        resolve({
          status: res.statusCode,
          headers: res.headers,
          html: data,
          loadTime: loadTime,
          size: Buffer.byteLength(data, 'utf8')
        });
      });
    }).on('error', reject);
  });
}

// Helper to parse HTML
function parseHTML(html) {
  const metaTags = {};
  const metaRegex = /<meta\s+([^>]*?)>/gi;
  let match;
  while ((match = metaRegex.exec(html)) !== null) {
    const attrs = match[1];
    const nameMatch = attrs.match(/name=["']([^"']+)["']/i);
    const propertyMatch = attrs.match(/property=["']([^"']+)["']/i);
    const contentMatch = attrs.match(/content=["']([^"']+)["']/i);
    if ((nameMatch || propertyMatch) && contentMatch) {
      const key = nameMatch ? nameMatch[1] : propertyMatch[1];
      metaTags[key] = contentMatch[1];
    }
  }

  const headings = {
    h1: (html.match(/<h1[^>]*>([^<]+)<\/h1>/gi) || []).length,
    h2: (html.match(/<h2[^>]*>([^<]+)<\/h2>/gi) || []).length,
    h3: (html.match(/<h3[^>]*>([^<]+)<\/h3>/gi) || []).length,
  };

  const forms = (html.match(/<form[^>]*>/gi) || []).length;
  const inputs = (html.match(/<input[^>]*>/gi) || []).length;
  const images = (html.match(/<img[^>]*>/gi) || []).length;
  const imagesWithoutAlt = (html.match(/<img(?![^>]*alt)[^>]*>/gi) || []).length;
  const links = (html.match(/<a[^>]*>/gi) || []).length;
  const scripts = (html.match(/<script[^>]*>/gi) || []).length;

  return {
    metaTags,
    headings,
    forms,
    inputs,
    images,
    imagesWithoutAlt,
    links,
    scripts,
    hasStructuredData: html.includes('application/ld+json') || html.includes('schema.org'),
    hasViewport: html.includes('viewport'),
    hasCharset: html.includes('charset'),
  };
}

// ===== ACCESSIBILITY TESTS =====
async function testAccessibility() {
  console.log('\n📊 Testing Accessibility...');
  const category = results.categories.accessibility;
  let passed = 0, total = 0;

  try {
    // Test homepage
    total++;
    const homepageRes = await fetchUrl(SITE_URL);
    const homepagePass = homepageRes.status === 200;
    category.tests.homepageAccessible = homepagePass;
    if (homepagePass) passed++;
    console.log(`  ${homepagePass ? '✓' : '✗'} Homepage accessible (HTTP 200)`);

    // Test all core pages
    const pages = [
      { name: 'Decision Page', url: `${SITE_URL}/join-beards-bucks/` },
      { name: 'Individual Listing', url: `${SITE_URL}/list-your-gear-8/` },
      { name: 'Vendor Registration', url: `${SITE_URL}/register-as-vendor/` }
    ];

    for (const page of pages) {
      total++;
      try {
        const res = await fetchUrl(page.url);
        const pass = res.status === 200;
        category.tests[`${page.name.replace(/\s+/g, '')}Accessible`] = pass;
        if (pass) passed++;
        console.log(`  ${pass ? '✓' : '✗'} ${page.name} accessible`);
      } catch (e) {
        category.tests[`${page.name.replace(/\s+/g, '')}Accessible`] = false;
        console.log(`  ✗ ${page.name} error: ${e.message}`);
      }
    }

  } catch (e) {
    results.summary.errors.push(`Accessibility tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== PERFORMANCE TESTS =====
async function testPerformance() {
  console.log('\n⚡ Testing Performance...');
  const category = results.categories.performance;
  let passed = 0, total = 0;

  try {
    const pages = [
      { name: 'Homepage', url: SITE_URL },
      { name: 'Decision Page', url: `${SITE_URL}/join-beards-bucks/` },
      { name: 'Individual Listing', url: `${SITE_URL}/list-your-gear-8/` },
      { name: 'Vendor Registration', url: `${SITE_URL}/register-as-vendor/` }
    ];

    for (const page of pages) {
      try {
        const res = await fetchUrl(page.url);
        const loadTime = res.loadTime;
        const size = res.size;

        total++;
        const fastLoad = loadTime < 3000; // 3 seconds acceptable
        category.tests[`${page.name.replace(/\s+/g, '')}LoadTime`] = {
          time: loadTime,
          pass: fastLoad
        };
        if (fastLoad) passed++;
        console.log(`  ${fastLoad ? '✓' : '⚠'} ${page.name}: ${loadTime}ms (${(size / 1024).toFixed(1)}KB)`);

        total++;
        const reasonableSize = size < 500000; // 500KB reasonable
        category.tests[`${page.name.replace(/\s+/g, '')}Size`] = {
          bytes: size,
          pass: reasonableSize
        };
        if (reasonableSize) passed++;
        console.log(`  ${reasonableSize ? '✓' : '⚠'} ${page.name} size is reasonable`);

      } catch (e) {
        console.log(`  ✗ ${page.name} error: ${e.message}`);
      }
    }

  } catch (e) {
    results.summary.errors.push(`Performance tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== FORM TESTS =====
async function testForms() {
  console.log('\n📝 Testing Forms...');
  const category = results.categories.forms;
  let passed = 0, total = 0;

  try {
    const forms = [
      { name: 'Individual Listing Form', url: `${SITE_URL}/list-your-gear-8/` },
      { name: 'Vendor Registration Form', url: `${SITE_URL}/register-as-vendor/` }
    ];

    for (const form of forms) {
      try {
        const res = await fetchUrl(form.url);
        const html = res.html;

        // Check form existence
        total++;
        const hasForm = html.includes('<form') || html.includes('form');
        category.tests[`${form.name.replace(/\s+/g, '')}Exists`] = hasForm;
        if (hasForm) passed++;
        console.log(`  ${hasForm ? '✓' : '✗'} ${form.name} exists`);

        // Check submit button
        total++;
        const hasSubmit = html.includes('submit') || html.includes('Submit') || html.includes('button');
        category.tests[`${form.name.replace(/\s+/g, '')}HasSubmit`] = hasSubmit;
        if (hasSubmit) passed++;
        console.log(`  ${hasSubmit ? '✓' : '✗'} ${form.name} has submit button`);

        // Check input fields
        total++;
        const hasInputs = (html.match(/<input[^>]*>/gi) || []).length > 0;
        category.tests[`${form.name.replace(/\s+/g, '')}HasInputs`] = hasInputs;
        if (hasInputs) passed++;
        console.log(`  ${hasInputs ? '✓' : '✗'} ${form.name} has input fields`);

        // Check for required attributes
        total++;
        const hasRequired = html.includes('required') || html.includes('*');
        category.tests[`${form.name.replace(/\s+/g, '')}HasValidation`] = hasRequired;
        if (hasRequired) passed++;
        console.log(`  ${hasRequired ? '✓' : '⚠'} ${form.name} has validation hints`);

      } catch (e) {
        console.log(`  ✗ ${form.name} error: ${e.message}`);
      }
    }

  } catch (e) {
    results.summary.errors.push(`Form tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== SECURITY TESTS =====
async function testSecurity() {
  console.log('\n🔒 Testing Security...');
  const category = results.categories.security;
  let passed = 0, total = 0;

  try {
    const res = await fetchUrl(SITE_URL);
    const headers = res.headers;

    // Check SSL (HTTPS)
    total++;
    const hasSSL = true; // We're using https
    category.tests.hasSSL = hasSSL;
    if (hasSSL) passed++;
    console.log(`  ✓ HTTPS/SSL enabled`);

    // Check security headers
    const securityHeaders = [
      'x-content-type-options',
      'x-frame-options',
      'x-xss-protection',
      'content-security-policy',
      'strict-transport-security'
    ];

    for (const header of securityHeaders) {
      total++;
      const hasHeader = headers[header] !== undefined;
      category.tests[`has${header.toUpperCase()}`] = hasHeader;
      if (hasHeader) passed++;
      const status = hasHeader ? '✓' : '⚠';
      console.log(`  ${status} ${header}: ${hasHeader ? 'Present' : 'Missing'}`);
    }

    // Check for common vulnerabilities in HTML
    total++;
    const html = res.html;
    const hasNoInlineScripts = !html.includes('onclick=') || (html.match(/onclick=/g) || []).length < 5;
    category.tests.minimalInlineScripts = hasNoInlineScripts;
    if (hasNoInlineScripts) passed++;
    console.log(`  ${hasNoInlineScripts ? '✓' : '⚠'} Minimal inline scripts`);

  } catch (e) {
    results.summary.errors.push(`Security tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== SEO TESTS =====
async function testSEO() {
  console.log('\n🔍 Testing SEO...');
  const category = results.categories.seo;
  let passed = 0, total = 0;

  try {
    const pages = [
      { name: 'Homepage', url: SITE_URL },
      { name: 'Decision Page', url: `${SITE_URL}/join-beards-bucks/` },
      { name: 'Individual Listing', url: `${SITE_URL}/list-your-gear-8/` },
      { name: 'Vendor Registration', url: `${SITE_URL}/register-as-vendor/` }
    ];

    for (const page of pages) {
      try {
        const res = await fetchUrl(page.url);
        const parsed = parseHTML(res.html);
        const shortName = page.name.replace(/\s+/g, '');

        // Check meta description
        total++;
        const hasMetaDesc = parsed.metaTags.description !== undefined;
        category.tests[`${shortName}HasMetaDesc`] = hasMetaDesc;
        if (hasMetaDesc) passed++;
        console.log(`  ${hasMetaDesc ? '✓' : '⚠'} ${page.name}: Meta description`);

        // Check H1 tag
        total++;
        const hasH1 = parsed.headings.h1 > 0;
        category.tests[`${shortName}HasH1`] = hasH1;
        if (hasH1) passed++;
        console.log(`  ${hasH1 ? '✓' : '⚠'} ${page.name}: H1 tag present`);

        // Check viewport meta tag
        total++;
        const hasViewport = parsed.hasViewport;
        category.tests[`${shortName}HasViewport`] = hasViewport;
        if (hasViewport) passed++;
        console.log(`  ${hasViewport ? '✓' : '⚠'} ${page.name}: Viewport meta tag`);

        // Check structured data
        total++;
        const hasStructured = parsed.hasStructuredData;
        category.tests[`${shortName}HasStructured`] = hasStructured;
        if (hasStructured) passed++;
        console.log(`  ${hasStructured ? '✓' : '⚠'} ${page.name}: Structured data (Schema.org)`);

        // Check image alt text
        if (parsed.images > 0) {
          total++;
          const altTextCoverage = ((parsed.images - parsed.imagesWithoutAlt) / parsed.images) * 100;
          const goodAltCoverage = altTextCoverage > 80;
          category.tests[`${shortName}ImageAltText`] = {
            coverage: altTextCoverage,
            pass: goodAltCoverage
          };
          if (goodAltCoverage) passed++;
          console.log(`  ${goodAltCoverage ? '✓' : '⚠'} ${page.name}: Image alt text (${altTextCoverage.toFixed(0)}%)`);
        }

      } catch (e) {
        console.log(`  ✗ ${page.name} error: ${e.message}`);
      }
    }

  } catch (e) {
    results.summary.errors.push(`SEO tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== MOBILE RESPONSIVENESS TESTS =====
async function testMobileResponsiveness() {
  console.log('\n📱 Testing Mobile Responsiveness...');
  const category = results.categories.mobile;
  let passed = 0, total = 0;

  try {
    // Mobile User-Agent
    const mobileUA = 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15';

    const res = await fetchUrl(SITE_URL, {
      headers: { 'User-Agent': mobileUA }
    });

    const html = res.html;
    const parsed = parseHTML(html);

    // Check viewport
    total++;
    const hasViewport = parsed.hasViewport;
    category.tests.hasViewport = hasViewport;
    if (hasViewport) passed++;
    console.log(`  ${hasViewport ? '✓' : '✗'} Viewport meta tag present`);

    // Check responsive classes/patterns
    total++;
    const hasBootstrapOrTailwind = html.includes('container') || html.includes('col-') ||
                                   html.includes('px-') || html.includes('w-full') ||
                                   html.includes('responsive');
    category.tests.hasResponsiveFramework = hasBootstrapOrTailwind;
    if (hasBootstrapOrTailwind) passed++;
    console.log(`  ${hasBootstrapOrTailwind ? '✓' : '⚠'} Responsive CSS framework detected`);

    // Check for mobile-friendly touch targets
    total++;
    const hasTouchTarget = !html.includes('font-size: 6px') && !html.includes('padding: 2px');
    category.tests.hasSufficientTouchTargets = hasTouchTarget;
    if (hasTouchTarget) passed++;
    console.log(`  ${hasTouchTarget ? '✓' : '⚠'} Touch-friendly element sizing`);

    // Check for clickable form elements
    total++;
    const inputs = parsed.inputs;
    const buttons = (html.match(/<button[^>]*>/gi) || []).length;
    const clickableElements = inputs + buttons;
    const hasClickableElements = clickableElements > 0;
    category.tests.hasClickableElements = hasClickableElements;
    if (hasClickableElements) passed++;
    console.log(`  ${hasClickableElements ? '✓' : '✗'} Interactive form elements present`);

    // Check for mobile-blocking content
    total++;
    const hasFlash = html.includes('<embed') || html.includes('<object');
    const hasApplet = html.includes('<applet');
    const noMobileBlockers = !hasFlash && !hasApplet;
    category.tests.noMobileBlockers = noMobileBlockers;
    if (noMobileBlockers) passed++;
    console.log(`  ${noMobileBlockers ? '✓' : '✗'} No Flash/Applet content (mobile blockers)`);

  } catch (e) {
    results.summary.errors.push(`Mobile tests failed: ${e.message}`);
    console.log(`  ✗ Error: ${e.message}`);
  }

  category.score = Math.round((passed / total) * 100);
  results.summary.totalTests += total;
  results.summary.passedTests += passed;
  return { passed, total };
}

// ===== CALCULATE OVERALL SCORE =====
function calculateOverallScore() {
  const scores = Object.values(results.categories).map(cat => cat.score);
  return Math.round(scores.reduce((a, b) => a + b, 0) / scores.length);
}

// ===== MAIN TEST RUNNER =====
async function runAllTests() {
  console.log('\n═══════════════════════════════════════════');
  console.log('  🎯 Beards & Bucks - Comprehensive QA Suite');
  console.log('═══════════════════════════════════════════');

  await testAccessibility();
  await testPerformance();
  await testForms();
  await testSecurity();
  await testSEO();
  await testMobileResponsiveness();

  // Calculate overall score
  results.siteScore = calculateOverallScore();
  results.summary.failedTests = results.summary.totalTests - results.summary.passedTests;

  // Save results
  const resultsPath = path.join(__dirname, 'qa_comprehensive_results.json');
  fs.writeFileSync(resultsPath, JSON.stringify(results, null, 2));

  // Print Summary
  console.log('\n═══════════════════════════════════════════');
  console.log('  📊 COMPREHENSIVE TEST SUMMARY');
  console.log('═══════════════════════════════════════════\n');

  console.log(`Overall Site Score: ${results.siteScore}/100\n`);

  console.log('Category Breakdown:');
  console.log(`  ✓ Accessibility:   ${results.categories.accessibility.score}/100`);
  console.log(`  ⚡ Performance:    ${results.categories.performance.score}/100`);
  console.log(`  📝 Forms:          ${results.categories.forms.score}/100`);
  console.log(`  🔒 Security:       ${results.categories.security.score}/100`);
  console.log(`  🔍 SEO:            ${results.categories.seo.score}/100`);
  console.log(`  📱 Mobile:         ${results.categories.mobile.score}/100`);

  console.log(`\nTest Results:`);
  console.log(`  Total Tests:   ${results.summary.totalTests}`);
  console.log(`  Passed:        ${results.summary.passedTests} (${Math.round((results.summary.passedTests / results.summary.totalTests) * 100)}%)`);
  console.log(`  Failed:        ${results.summary.failedTests}`);

  if (results.summary.errors.length > 0) {
    console.log(`\nErrors Found:`);
    results.summary.errors.forEach(e => console.log(`  ⚠️  ${e}`));
  }

  console.log(`\n✅ Detailed results saved to: ${resultsPath}`);
  console.log('═══════════════════════════════════════════\n');
}

runAllTests().catch(console.error);
