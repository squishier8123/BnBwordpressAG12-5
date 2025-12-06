#!/bin/bash

# verify_fix_3_booking.sh - Booking Module Verification
# Verifies that Fix 3 (Enable Booking Module) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 3: Booking Module =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check if Listeo plugin is enabled
log_info "Step 1: Checking if Listeo plugin is enabled..."

if check_plugin_enabled "listeo-core"; then
    log_success "✅ PASS: Listeo Core plugin is enabled"
else
    log_error "❌ FAIL: Listeo Core plugin is not enabled"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 2: Check booking module setting in database
log_info "Step 2: Checking booking module setting in database..."

BOOKING_ENABLED=$(get_listeo_setting "enable_booking" 2>/dev/null || echo "")

if [ "$BOOKING_ENABLED" = "1" ] || [ "$BOOKING_ENABLED" = "yes" ] || [ "$BOOKING_ENABLED" = "true" ]; then
    log_success "✅ PASS: Booking module is enabled in settings"
else
    log_warn "⚠️  WARN: Booking module setting unclear in database (value: '$BOOKING_ENABLED')"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 3: Check frontend - "Book Now" button exists on listings
log_info "Step 3: Checking for 'Book Now' button on listing pages..."

if curl -s "https://beardsandbucks.com/" | grep -oP 'href=["\047]/listing/[^"]*' | head -1 > /tmp/listing_url.txt 2>/dev/null; then
    LISTING_URL=$(cat /tmp/listing_url.txt | sed 's/href=["'"'"']//;s/["'"'"']//')

    if [ ! -z "$LISTING_URL" ] && check_url_loads "https://beardsandbucks.com$LISTING_URL"; then
        LISTING_CONTENT=$(curl -s "https://beardsandbucks.com$LISTING_URL" 2>/dev/null)

        if echo "$LISTING_CONTENT" | grep -i "book.*now\|booking\|reserve" &>/dev/null; then
            log_success "✅ PASS: Booking-related elements detected on listing"
        else
            log_warn "⚠️  WARN: 'Book Now' or booking elements not clearly visible"
            if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                OVERALL_STATUS=$VERIFY_PARTIAL
            fi
        fi

        # Check for booking shortcode or widget
        if echo "$LISTING_CONTENT" | grep -i "listeo.*booking\|booking.*form\|booking.*widget" &>/dev/null; then
            log_success "✅ PASS: Booking form/widget structure detected"
        else
            log_warn "⚠️  WARN: Booking form structure not clearly detected"
            if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                OVERALL_STATUS=$VERIFY_PARTIAL
            fi
        fi
    else
        log_error "❌ FAIL: Could not access listing page for verification"
        OVERALL_STATUS=$VERIFY_FAIL
    fi
else
    log_error "❌ FAIL: Could not find sample listing for verification"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 4: Check for booking-related JavaScript
log_info "Step 4: Checking for booking module JavaScript..."

if curl -s "https://beardsandbucks.com/" | grep -i "booking.*js\|listeo.*booking" &>/dev/null; then
    log_success "✅ PASS: Booking JavaScript files detected"
else
    log_warn "⚠️  WARN: Booking JavaScript not clearly detected"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 5: Check WordPress error log for booking-related errors
log_info "Step 5: Checking for booking-related errors in error log..."

if [ -f "/var/www/html/wp-content/debug.log" ]; then
    BOOKING_ERRORS=$(grep -i "booking\|listeo.*booking" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error" | tail -3 || echo "")

    if [ ! -z "$BOOKING_ERRORS" ]; then
        log_warn "⚠️  WARN: Found booking-related errors:"
        echo "$BOOKING_ERRORS" | while read line; do
            log_warn "     $line"
        done
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    else
        log_success "✅ PASS: No booking-related errors in WordPress error log"
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 3 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 3: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 3: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 3: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
