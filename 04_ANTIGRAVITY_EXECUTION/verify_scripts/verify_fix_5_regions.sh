#!/bin/bash

# verify_fix_5_regions.sh - Regions Field Removal Verification
# Verifies that Fix 5 (Remove Regions Field from Add Listing Form) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 5: Remove Regions Field =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check Listeo field configuration in database
log_info "Step 1: Checking Listeo field configuration in database..."

# Query the Listeo fields table/option for regions field
REGIONS_FIELD_FOUND=$(db_query "SELECT COUNT(*) FROM wp_postmeta WHERE meta_key='_listings_fields' AND meta_value LIKE '%regions%'" 2>/dev/null | grep -o "[0-9]*" | tail -1 || echo "0")

if [ "$REGIONS_FIELD_FOUND" = "0" ]; then
    log_success "✅ PASS: Regions field not found in Listeo field configuration"
else
    log_warn "⚠️  WARN: Regions field still present in database ($REGIONS_FIELD_FOUND instances)"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 2: Check Listeo form fields setting
log_info "Step 2: Checking Listeo form fields setting..."

LISTEO_FORM_SETTING=$(get_listeo_setting "form_fields" 2>/dev/null || echo "")

if echo "$LISTEO_FORM_SETTING" | grep -i "region" &>/dev/null; then
    log_warn "⚠️  WARN: Regions field still appears in form settings"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
else
    log_success "✅ PASS: Regions field not in form field settings"
fi

# Step 3: Check frontend - Add Listing form doesn't show Regions field
log_info "Step 3: Checking Add Listing form for Regions field..."

if check_url_loads "https://beardsandbucks.com/add-listing/"; then
    ADD_LISTING_FORM=$(curl -s "https://beardsandbucks.com/add-listing/" 2>/dev/null)

    # Check for regions field by various patterns
    REGIONS_PRESENT=$(echo "$ADD_LISTING_FORM" | grep -i "regions\|region.*field\|id=\".*region" | wc -l)

    if [ "$REGIONS_PRESENT" = "0" ]; then
        log_success "✅ PASS: Regions field NOT visible on Add Listing form"
    else
        log_error "❌ FAIL: Regions field still visible on form ($REGIONS_PRESENT instances)"
        OVERALL_STATUS=$VERIFY_FAIL
    fi

    # Verify other form fields are still present (to ensure we didn't break the form)
    LOCATION_FIELD=$(echo "$ADD_LISTING_FORM" | grep -i "location\|address" | wc -l)
    TITLE_FIELD=$(echo "$ADD_LISTING_FORM" | grep -i 'name=".*title"' | wc -l)
    DESCRIPTION_FIELD=$(echo "$ADD_LISTING_FORM" | grep -i "description" | wc -l)

    if [ $LOCATION_FIELD -gt 0 ] || [ $TITLE_FIELD -gt 0 ] || [ $DESCRIPTION_FIELD -gt 0 ]; then
        log_success "✅ PASS: Other form fields still present (Location: $LOCATION_FIELD, Title: $TITLE_FIELD, Description: $DESCRIPTION_FIELD)"
    else
        log_warn "⚠️  WARN: Standard form fields not clearly detected"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
else
    log_error "❌ FAIL: Could not access Add Listing form"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 4: Test form submission compatibility
log_info "Step 4: Checking form structure integrity..."

if [ ! -z "$ADD_LISTING_FORM" ]; then
    # Check if form tag exists
    if echo "$ADD_LISTING_FORM" | grep -i '<form' &>/dev/null; then
        log_success "✅ PASS: Form structure intact"

        # Check for required form elements
        FORM_ID=$(echo "$ADD_LISTING_FORM" | grep -oP 'id=["\047]([^"]*form[^"]*)["\047]' | wc -l)

        if [ $FORM_ID -gt 0 ]; then
            log_success "✅ PASS: Form has proper ID attributes"
        else
            log_warn "⚠️  WARN: Form IDs not clearly detected"
            if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                OVERALL_STATUS=$VERIFY_PARTIAL
            fi
        fi
    else
        log_error "❌ FAIL: No form tag detected"
        OVERALL_STATUS=$VERIFY_FAIL
    fi
fi

# Step 5: Check for form submission errors
log_info "Step 5: Checking for field removal-related errors..."

if [ -f "/var/www/html/wp-content/debug.log" ]; then
    FIELD_ERRORS=$(grep -i "region\|field.*error\|field.*removed\|undefined.*field" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error\|notice" | tail -5 || echo "")

    if [ ! -z "$FIELD_ERRORS" ]; then
        log_warn "⚠️  WARN: Found potential field-related notices:"
        echo "$FIELD_ERRORS" | while read line; do
            log_warn "     $line"
        done
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    else
        log_success "✅ PASS: No field removal-related errors detected"
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 5 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 5: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 5: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 5: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
