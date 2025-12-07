#!/bin/bash

# Test Navigation Debug Script
# Run this to diagnose navigation issues
# Results saved to: test_navigation_results.txt

OUTPUT_FILE="test_navigation_results.txt"

{
    echo "=== NAVIGATION DEBUG TEST ==="
    echo "Date: $(date)"
    echo ""

    echo "=== PART 1: CHECK MENU ITEMS IN DATABASE ==="
    echo ""

    # Get the menu items that are rendering
    echo "Testing three key navigation items:"
    echo ""

    # Test By Category
    echo "1. BY CATEGORY:"
    status=$(curl -s -o /dev/null -w "%{http_code}" "https://beardsandbucks.com/directory-9/" 2>/dev/null)
    echo "   URL: https://beardsandbucks.com/directory-9/"
    echo "   Status: $status"
    if [ "$status" = "200" ]; then
        echo "   Result: ✅ WORKING"
    else
        echo "   Result: ❌ BROKEN"
    fi
    echo ""

    # Test By Location
    echo "2. BY LOCATION:"
    status=$(curl -s -o /dev/null -w "%{http_code}" "https://beardsandbucks.com/browse-by-county/" 2>/dev/null)
    echo "   URL: https://beardsandbucks.com/browse-by-county/"
    echo "   Status: $status"
    if [ "$status" = "200" ]; then
        echo "   Result: ✅ WORKING"
    else
        echo "   Result: ❌ BROKEN"
    fi
    echo ""

    # Test Add Listing
    echo "3. ADD LISTING:"
    status=$(curl -s -o /dev/null -w "%{http_code}" "https://beardsandbucks.com/list-your-gear-8/" 2>/dev/null)
    echo "   URL: https://beardsandbucks.com/list-your-gear-8/"
    echo "   Status: $status"
    if [ "$status" = "200" ]; then
        echo "   Result: ✅ WORKING"
    else
        echo "   Result: ❌ BROKEN"
    fi
    echo ""

    echo "=== PART 2: CHECK WHAT'S IN THE HTML ==="
    echo ""

    echo "Checking homepage HTML for these links:"
    echo ""

    if curl -s https://beardsandbucks.com/ 2>&1 | grep -q "directory-9"; then
        echo "  ✅ Found 'directory-9' link in HTML"
    else
        echo "  ❌ NOT FOUND: 'directory-9' link"
    fi

    if curl -s https://beardsandbucks.com/ 2>&1 | grep -q "browse-by-county"; then
        echo "  ✅ Found 'browse-by-county' link in HTML"
    else
        echo "  ❌ NOT FOUND: 'browse-by-county' link"
    fi

    if curl -s https://beardsandbucks.com/ 2>&1 | grep -q "list-your-gear"; then
        echo "  ✅ Found 'list-your-gear' link in HTML"
    else
        echo "  ❌ NOT FOUND: 'list-your-gear' link"
    fi

    if curl -s https://beardsandbucks.com/ 2>&1 | grep -q "page_id=4404"; then
        echo "  ❌ STILL FOUND: 'page_id=4404' (this is the broken link!)"
    else
        echo "  ✅ NOT FOUND: 'page_id=4404' (good, it's been removed)"
    fi

    echo ""
    echo "=== END OF TEST ==="

} > "$OUTPUT_FILE" 2>&1

echo "✅ Results saved to: $OUTPUT_FILE"
cat "$OUTPUT_FILE"
