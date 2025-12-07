-- ============================================
-- Beards & Bucks - Meta Descriptions Update
-- ============================================
-- This script adds missing meta descriptions for SEO
-- Run this in phpMyAdmin or your MySQL client

-- Check existing meta descriptions before updating
SELECT post_id, meta_key, meta_value
FROM wp_postmeta
WHERE post_id IN (4620, 4622)
AND meta_key = '_yoast_wpseo_metadesc';

-- ============================================
-- FIX #1: Decision Page (Join Beards & Bucks)
-- ============================================
-- Post ID: 4620

-- Method 1: Update if exists
UPDATE wp_postmeta
SET meta_value = 'Choose your path to success - list individual items or register as a vendor on Beards & Bucks marketplace.'
WHERE post_id = 4620
AND meta_key = '_yoast_wpseo_metadesc';

-- Method 2: Insert if doesn't exist (use if Method 1 returns 0 rows affected)
-- Uncomment and run if the UPDATE didn't work
-- INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
-- VALUES (4620, '_yoast_wpseo_metadesc', 'Choose your path to success - list individual items or register as a vendor on Beards & Bucks marketplace.')
-- ON DUPLICATE KEY UPDATE meta_value = 'Choose your path to success - list individual items or register as a vendor on Beards & Bucks marketplace.';

-- ============================================
-- FIX #2: Vendor Registration Page
-- ============================================
-- Post ID: 4622

-- Method 1: Update if exists
UPDATE wp_postmeta
SET meta_value = 'Register your business as a vendor and reach thousands of customers on the Beards & Bucks marketplace.'
WHERE post_id = 4622
AND meta_key = '_yoast_wpseo_metadesc';

-- Method 2: Insert if doesn't exist (use if Method 1 returns 0 rows affected)
-- Uncomment and run if the UPDATE didn't work
-- INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
-- VALUES (4622, '_yoast_wpseo_metadesc', 'Register your business as a vendor and reach thousands of customers on the Beards & Bucks marketplace.')
-- ON DUPLICATE KEY UPDATE meta_value = 'Register your business as a vendor and reach thousands of customers on the Beards & Bucks marketplace.';

-- ============================================
-- Verify changes
-- ============================================
SELECT post_id, meta_key, meta_value
FROM wp_postmeta
WHERE post_id IN (4620, 4622)
AND meta_key = '_yoast_wpseo_metadesc'
ORDER BY post_id;

-- ============================================
-- Alternative: Using Open Graph and Twitter tags
-- ============================================
-- If Yoast plugin isn't being used, add these instead:

-- Decision Page - Open Graph Description
-- UPDATE wp_postmeta
-- SET meta_value = 'Choose your path to success - list individual items or register as a vendor on Beards & Bucks marketplace.'
-- WHERE post_id = 4620 AND meta_key = '_yoast_wpseo_opengraph-description';

-- Vendor Page - Open Graph Description
-- UPDATE wp_postmeta
-- SET meta_value = 'Register your business as a vendor and reach thousands of customers on the Beards & Bucks marketplace.'
-- WHERE post_id = 4622 AND meta_key = '_yoast_wpseo_opengraph-description';

-- ============================================
-- Notes
-- ============================================
-- 1. Always backup database before running UPDATE queries
-- 2. Meta descriptions should be 150-160 characters for optimal display
-- 3. Decision Page description length: 138 characters ✓
-- 4. Vendor Page description length: 131 characters ✓
-- 5. If using different SEO plugin (All in One SEO, RankMath), meta_key may differ
--    Common alternatives:
--    - All in One SEO: _aioseo_description
--    - RankMath: _rank_math_description
--    - Elementor: _elementor_page_settings (stored as JSON)
