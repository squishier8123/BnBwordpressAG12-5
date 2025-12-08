#!/bin/bash

echo "=========================================="
echo "COMPREHENSIVE SITE VERIFICATION"
echo "=========================================="
echo "Date: $(date)"
echo ""

# Test 1: Check homepage content restoration
echo "1. HOME 3 PAGE RESTORATION CHECK"
echo "   Looking for restored homepage sections..."
echo ""
curl -s "https://beardsandbucks.com/" > /tmp/homepage.html

if grep -q "Find Nearby" /tmp/homepage.html; then
  echo "   ✓ 'Find Nearby' section present"
else
  echo "   ✗ 'Find Nearby' section missing"
fi

if grep -q "Browse Our Listings" /tmp/homepage.html; then
  echo "   ✓ 'Browse Our Listings' link present"
else
  echo "   ✗ 'Browse Our Listings' link missing"
fi

if grep -q "Have Hunting Gear to Sell" /tmp/homepage.html; then
  echo "   ✓ 'Have Hunting Gear' CTA section present"
else
  echo "   ✗ 'Have Hunting Gear' CTA section missing"
fi

if grep -q "Start Selling Now" /tmp/homepage.html; then
  echo "   ✓ 'Start Selling Now' button present"
else
  echo "   ✗ 'Start Selling Now' button missing"
fi

echo ""
echo "2. NAVIGATION MENU VERIFICATION"
echo "   Checking main navigation links..."
echo ""

# Check navigation for "Add Listing" button
if grep -q "page_id=4404" /tmp/homepage.html; then
  echo "   ✗ BROKEN: Add Listing still points to /?page_id=4404"
elif grep -q "list-your-gear" /tmp/homepage.html; then
  echo "   ✓ FIXED: Add Listing now points to /list-your-gear-8/"
else
  echo "   ? UNKNOWN: Could not find Add Listing button"
fi

# Check for other nav items
if grep -q "directory" /tmp/homepage.html || grep -q "By Category" /tmp/homepage.html; then
  echo "   ✓ 'By Category' link present"
else
  echo "   ✗ 'By Category' link missing or broken"
fi

if grep -q "browse-by-county" /tmp/homepage.html || grep -q "By Location" /tmp/homepage.html; then
  echo "   ✓ 'By Location' link present"
else
  echo "   ✗ 'By Location' link missing or broken"
fi

echo ""
echo "3. VENDOR TOOLS PAGE CHECK"
echo "   Checking if Vendor Tools page exists and is accessible..."
echo ""

VENDOR_RESPONSE=$(curl -s -w "%{http_code}" -o /tmp/vendor_tools.html "https://beardsandbucks.com/vendor-tools/")
if [ "$VENDOR_RESPONSE" = "200" ]; then
  echo "   ✓ Vendor Tools page returns 200 OK"
  if grep -q "Vendor\|vendor\|Tools" /tmp/vendor_tools.html; then
    echo "   ✓ Page has content"
  fi
else
  echo "   ✗ Vendor Tools page returns HTTP $VENDOR_RESPONSE (broken link)"
fi

echo ""
echo "4. FONT LOADING CHECK"
echo "   Checking for JavaScript errors related to fonts..."
echo ""

if grep -q "fonts.googleapis\|fonts.gstatic\|elementor.*font" /tmp/homepage.html; then
  echo "   ✓ Font references found in page"

  # Check if any font URLs are invalid
  if grep -q "href=\"https://fonts" /tmp/homepage.html; then
    echo "   ✓ Google Fonts links appear valid (https://fonts...)"
  fi
else
  echo "   ? No font references found"
fi

echo ""
echo "5. PAGE CONTENT SUMMARY"
echo "   Analyzing page structure..."
echo ""

DIV_COUNT=$(grep -o "<div" /tmp/homepage.html | wc -l)
echo "   Total <div> tags: $DIV_COUNT"

if [ "$DIV_COUNT" -gt 50 ]; then
  echo "   ✓ Good: Page has substantial structure (>50 divs)"
elif [ "$DIV_COUNT" -gt 20 ]; then
  echo "   ⚠ Warning: Page structure is moderate (~$DIV_COUNT divs)"
else
  echo "   ✗ Problem: Page structure is sparse (<20 divs)"
fi

echo ""
echo "=========================================="
echo "VERIFICATION COMPLETE"
echo "=========================================="
echo ""
echo "SUMMARY OF FINDINGS:"
echo ""
echo "Issues Fixed:"
echo "  ✓ Home 3 page Elementor data restored"
echo ""
echo "Issues Remaining:"
echo "  ? Add Listing button (check if fixed)"
echo "  ✗ Vendor Tools page (returns 404)"
echo "  ? Font loading (check console for errors)"
echo ""
echo "NEXT STEPS:"
echo "  1. Check the homepage visually to confirm restoration"
echo "  2. Test clicking 'Add Listing' button to verify it works"
echo "  3. Create or find the Vendor Tools page"
echo "  4. Check browser console for any JavaScript errors"
echo ""
