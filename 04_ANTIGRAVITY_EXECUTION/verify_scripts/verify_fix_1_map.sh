#!/bin/bash

# verify_fix_1_map.sh - Map Loading Verification (Mapbox API)
# Verifies that Fix 1 (Map Loading - Mapbox API) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 1: Map Loading (Mapbox API) =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check database for Mapbox API key
log_info "Step 1: Checking database for Mapbox API key..."
MAPBOX_KEY=$(get_listeo_setting "mapbox_api_key" 2>/dev/null || echo "")

if [ -z "$MAPBOX_KEY" ]; then
    log_error "❌ FAIL: Mapbox API key not found in database"
    OVERALL_STATUS=$VERIFY_FAIL
else
    log_success "✅ PASS: Mapbox API key found in database"

    # Validate API key format (should start with pk.)
    if [[ $MAPBOX_KEY == pk.* ]]; then
        log_success "✅ PASS: API key format is valid (starts with pk.)"
    else
        log_warn "⚠️  WARN: API key format unexpected (expected pk.* prefix)"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
fi

# Step 2: Test Mapbox API endpoint
log_info "Step 2: Testing Mapbox API endpoint..."
if command -v curl &> /dev/null; then
    API_TEST=$(curl -s "https://api.mapbox.com/v4/mapbox.places.json?access_token=$MAPBOX_KEY" 2>/dev/null | grep -q "features" && echo "1" || echo "0")

    if [ "$API_TEST" = "1" ]; then
        log_success "✅ PASS: Mapbox API responds to key"
    else
        log_error "❌ FAIL: Mapbox API did not respond correctly"
        OVERALL_STATUS=$VERIFY_FAIL
    fi
else
    log_warn "⚠️  WARN: curl not available, skipping API test"
fi

# Step 3: Check frontend - map loads on search page
log_info "Step 3: Checking if map loads on search/listings page..."
if check_url_loads "https://beardsandbucks.com/search/"; then
    log_success "✅ PASS: Search page loads without error"

    # Check for mapbox-specific indicators in page
    if curl -s "https://beardsandbucks.com/search/" | grep -i "mapbox\|map-container\|leaflet" &>/dev/null; then
        log_success "✅ PASS: Mapbox/map elements detected on search page"
    else
        log_warn "⚠️  WARN: Mapbox elements not clearly detected in HTML"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
else
    log_error "❌ FAIL: Search page not loading"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 4: Check frontend - map loads on listing detail page
log_info "Step 4: Checking if map loads on listing detail page..."
# Get a sample listing page (first listing)
if curl -s "https://beardsandbucks.com/" | grep -oP 'href=["\047]/listing/[^"]*' | head -1 > /tmp/listing_url.txt 2>/dev/null; then
    LISTING_URL=$(cat /tmp/listing_url.txt | sed 's/href=["'"'"']//;s/["'"'"']//')

    if [ ! -z "$LISTING_URL" ] && check_url_loads "https://beardsandbucks.com$LISTING_URL"; then
        log_success "✅ PASS: Listing detail page loads without error"

        if curl -s "https://beardsandbucks.com$LISTING_URL" | grep -i "mapbox\|map-container" &>/dev/null; then
            log_success "✅ PASS: Map elements detected on listing detail"
        else
            log_warn "⚠️  WARN: Map not clearly detected on listing detail"
            if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                OVERALL_STATUS=$VERIFY_PARTIAL
            fi
        fi
    else
        log_warn "⚠️  WARN: Could not verify listing detail page"
    fi
else
    log_warn "⚠️  WARN: Could not find sample listing for verification"
fi

# Step 5: Check for console/JavaScript errors related to maps
log_info "Step 5: Checking for map-related errors in WordPress error log..."
if [ -f "/var/www/html/wp-content/debug.log" ]; then
    if grep -i "mapbox\|map.*error\|leaflet.*error" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error\|warning" | head -5 | while read line; do
        log_warn "⚠️  Found potential map error: $line"
    done; then
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 1 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 1: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 1: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 1: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
