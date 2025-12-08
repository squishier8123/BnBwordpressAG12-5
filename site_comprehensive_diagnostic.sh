#!/bin/bash

# Comprehensive Site Diagnostic and Functionality Evaluation
# This script tests critical site functionality and identifies breaks
# Run this in Antigravity to evaluate overall site health

OUTPUT_FILE="site_diagnostic_results.txt"

{
    echo "================================"
    echo "BEARDS & BUCKS SITE DIAGNOSTIC"
    echo "Date: $(date)"
    echo "================================"
    echo ""

    # 1. CORE SITE ACCESSIBILITY
    echo "=== 1. CORE SITE ACCESSIBILITY ==="
    BASE_URL="https://beardsandbucks.com"

    echo "Testing homepage..."
    if HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL"); then
        echo "Homepage: HTTP $HTTP_CODE"
        if [ "$HTTP_CODE" = "200" ]; then
            echo "✅ Homepage loads successfully"
        else
            echo "❌ Homepage returns error ($HTTP_CODE)"
        fi
    fi
    echo ""

    # 2. CRITICAL PAGES
    echo "=== 2. CRITICAL PAGES ACCESSIBILITY ==="
    declare -a CRITICAL_PAGES=(
        "/directory-9/ | Browse by Category (Directory)"
        "/browse-by-county/ | Browse by County/Location"
        "/list-your-gear-8/ | Add Listing / List Your Gear"
        "/vendor-tools/ | Vendor Tools / Dashboard"
        "/vendor-pricing/ | Vendor Pricing"
    )

    for page_info in "${CRITICAL_PAGES[@]}"; do
        IFS='|' read -r page_path page_name <<< "$page_info"
        page_path=$(echo "$page_path" | xargs)
        page_name=$(echo "$page_name" | xargs)

        if HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL$page_path"); then
            status=""
            if [ "$HTTP_CODE" = "200" ]; then
                status="✅"
            else
                status="❌"
            fi
            echo "$status $page_name: HTTP $HTTP_CODE ($page_path)"
        fi
    done
    echo ""

    # 3. NAVIGATION MENU ANALYSIS
    echo "=== 3. NAVIGATION MENU LINK VERIFICATION ==="
    echo "Fetching homepage HTML and checking for navigation links..."

    HOMEPAGE_HTML=$(curl -s "$BASE_URL/")

    declare -a MENU_CHECKS=(
        "directory-9 | Should link to: Browse by Category"
        "browse-by-county | Should link to: Browse by Location"
        "list-your-gear | Should link to: Add Listing button"
        "page_id=4404 | BROKEN: Old page ID (should NOT appear)"
    )

    for check_info in "${MENU_CHECKS[@]}"; do
        IFS='|' read -r search_text description <<< "$check_info"
        search_text=$(echo "$search_text" | xargs)
        description=$(echo "$description" | xargs)

        if echo "$HOMEPAGE_HTML" | grep -q "$search_text"; then
            echo "✅ FOUND: $search_text - $description"
        else
            echo "❌ NOT FOUND: $search_text - $description"
        fi
    done
    echo ""

    # 4. VENDOR FUNCTIONALITY
    echo "=== 4. VENDOR FUNCTIONALITY CHECKS ==="

    echo "Checking Dokan integration..."
    if echo "$HOMEPAGE_HTML" | grep -iq "dokan\|vendor"; then
        echo "✅ Vendor content detected on homepage"
    else
        echo "⚠️  No obvious vendor content detected on homepage"
    fi

    echo "Checking Vendor Tools page..."
    VENDOR_TOOLS_HTML=$(curl -s "$BASE_URL/vendor-tools/")
    if echo "$VENDOR_TOOLS_HTML" | grep -iq "dashboard\|vendor\|store\|seller"; then
        echo "✅ Vendor dashboard/tools appear functional"
    else
        echo "❌ Vendor Tools page may have content issues"
    fi
    echo ""

    # 5. FORM FUNCTIONALITY CHECK
    echo "=== 5. FORM FUNCTIONALITY CHECK ==="

    echo "Checking for forms on Add Listing page..."
    ADD_LISTING_HTML=$(curl -s "$BASE_URL/list-your-gear-8/")

    if echo "$ADD_LISTING_HTML" | grep -iq "form\|input\|submit"; then
        echo "✅ Form elements detected on Add Listing page"
    else
        echo "❌ No form elements found on Add Listing page"
    fi

    if echo "$ADD_LISTING_HTML" | grep -iq "dokan"; then
        echo "✅ Dokan integration detected on Add Listing page"
    else
        echo "❌ Dokan integration may not be on Add Listing page"
    fi
    echo ""

    # 6. DIRECTORY PAGES FUNCTIONALITY
    echo "=== 6. DIRECTORY PAGES FUNCTIONALITY ==="

    echo "Checking Browse by Category page..."
    DIRECTORY_HTML=$(curl -s "$BASE_URL/directory-9/")

    if echo "$DIRECTORY_HTML" | grep -iq "category\|filter\|gear\|equipment"; then
        echo "✅ Category directory appears to have content"
    else
        echo "❌ Category directory may have content issues"
    fi

    echo "Checking Browse by County page..."
    COUNTY_HTML=$(curl -s "$BASE_URL/browse-by-county/")

    if echo "$COUNTY_HTML" | grep -iq "county\|location\|area\|browse"; then
        echo "✅ County/location directory appears to have content"
    else
        echo "❌ County/location directory may have content issues"
    fi
    echo ""

    # 7. JAVASCRIPT/ELEMENTOR FUNCTIONALITY
    echo "=== 7. PAGE BUILDER & INTERACTIVE ELEMENTS ==="

    if echo "$HOMEPAGE_HTML" | grep -iq "elementor"; then
        echo "✅ Elementor detected (pages built with Elementor)"
    fi

    if echo "$HOMEPAGE_HTML" | grep -iq "error\|exception\|undefined"; then
        echo "❌ JavaScript errors detected in HTML (potential break)"
    else
        echo "✅ No obvious JavaScript errors in HTML"
    fi
    echo ""

    # 8. BROKEN LINK SUMMARY
    echo "=== 8. BROKEN LINK SUMMARY ==="

    BROKEN_FOUND=0

    if echo "$HOMEPAGE_HTML" | grep -q "page_id=4404"; then
        echo "❌ BROKEN: 'Add Listing' button still points to page_id=4404"
        BROKEN_FOUND=$((BROKEN_FOUND + 1))
    else
        echo "✅ FIXED: 'Add Listing' button no longer points to page_id=4404"
    fi

    if echo "$HOMEPAGE_HTML" | grep -q "post.php\?post=3401"; then
        echo "❌ BROKEN: Admin edit links still present in navigation"
        BROKEN_FOUND=$((BROKEN_FOUND + 1))
    else
        echo "✅ FIXED: No admin edit links in navigation"
    fi

    if [ $BROKEN_FOUND -eq 0 ]; then
        echo "✅ No broken links detected!"
    else
        echo "⚠️  $BROKEN_FOUND broken links still present"
    fi
    echo ""

    # 9. OVERALL FUNCTIONALITY SUMMARY
    echo "=== 9. OVERALL FUNCTIONALITY ASSESSMENT ==="

    WORKING_FEATURES=0
    TOTAL_FEATURES=8

    # Count working features
    echo "$HOMEPAGE_HTML" | grep -q "directory-9" && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    echo "$HOMEPAGE_HTML" | grep -q "browse-by-county" && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    [ "$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/list-your-gear-8/")" = "200" ] && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    [ "$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/vendor-tools/")" = "200" ] && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    [ "$(curl -s -o /dev/null -w "%{http_code}" "$BASE_URL/vendor-pricing/")" = "200" ] && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    echo "$VENDOR_TOOLS_HTML" | grep -iq "dashboard\|vendor" && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    echo "$ADD_LISTING_HTML" | grep -iq "form\|dokan" && WORKING_FEATURES=$((WORKING_FEATURES + 1))
    [ $BROKEN_FOUND -eq 0 ] && WORKING_FEATURES=$((WORKING_FEATURES + 1))

    PERCENTAGE=$((WORKING_FEATURES * 100 / TOTAL_FEATURES))

    echo "Site Functionality: $WORKING_FEATURES/$TOTAL_FEATURES features working ($PERCENTAGE%)"
    echo ""

    if [ $PERCENTAGE -ge 90 ]; then
        echo "🟢 OVERALL VERDICT: Site is mostly functional"
    elif [ $PERCENTAGE -ge 70 ]; then
        echo "🟡 OVERALL VERDICT: Site has some issues but is usable"
    else
        echo "🔴 OVERALL VERDICT: Site has significant issues"
    fi
    echo ""

    # 10. RECOMMENDATIONS
    echo "=== 10. RECOMMENDATIONS ==="

    if echo "$HOMEPAGE_HTML" | grep -q "page_id=4404"; then
        echo "⚠️  PRIORITY: Fix 'Add Listing' button URL"
        echo "   - Via WordPress Admin: Appearance → Menus → Add Listing"
        echo "   - Change URL from /?page_id=4404 to /list-your-gear-8/"
        echo "   - Or clear WordPress cache (WP Super Cache, W3 Total Cache, etc)"
    fi

    if echo "$HOMEPAGE_HTML" | grep -q "post.php\?post="; then
        echo "⚠️  Remove admin edit links from navigation"
    fi

    echo ""
    echo "================================"
    echo "Diagnostic Complete"
    echo "================================"

} > "$OUTPUT_FILE" 2>&1

echo "Results saved to: $OUTPUT_FILE"
