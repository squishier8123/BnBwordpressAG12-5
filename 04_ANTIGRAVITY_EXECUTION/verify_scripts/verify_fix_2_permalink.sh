#!/bin/bash

# verify_fix_2_permalink.sh - Add Listing 404 Fix Verification
# Verifies that Fix 2 (Add Listing 404 - Permalink rewrite) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 2: Add Listing 404 (Permalink Rewrite) =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check permalink structure
log_info "Step 1: Checking WordPress permalink structure..."
PERMALINK_STRUCTURE=$(get_site_option "permalink_structure" 2>/dev/null || echo "")

if [ ! -z "$PERMALINK_STRUCTURE" ]; then
    log_success "✅ PASS: Permalink structure is configured: $PERMALINK_STRUCTURE"
else
    log_warn "⚠️  WARN: Permalink structure is empty (default permalinks)"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 2: Test /add-listing/ returns HTTP 200
log_info "Step 2: Testing /add-listing/ page (checking for 404)..."

if check_url_loads "https://beardsandbucks.com/add-listing/"; then
    log_success "✅ PASS: /add-listing/ page loads successfully (HTTP 200)"
else
    log_error "❌ FAIL: /add-listing/ page returned error or 404"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 3: Verify page content loads correctly
log_info "Step 3: Verifying page content..."

ADD_LISTING_RESPONSE=$(curl -s -w "\n%{http_code}" "https://beardsandbucks.com/add-listing/" 2>/dev/null)
HTTP_CODE=$(echo "$ADD_LISTING_RESPONSE" | tail -1)
PAGE_CONTENT=$(echo "$ADD_LISTING_RESPONSE" | head -n -1)

if [ "$HTTP_CODE" = "200" ]; then
    log_success "✅ PASS: HTTP response code is 200"

    # Check for form fields or expected content
    if echo "$PAGE_CONTENT" | grep -i "add.*listing\|listing.*form\|property.*details" &>/dev/null; then
        log_success "✅ PASS: Add Listing page content detected"
    else
        log_warn "⚠️  WARN: Expected page content not clearly detected"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi

    # Check for form elements
    FORM_FIELDS=$(echo "$PAGE_CONTENT" | grep -o 'name="[^"]*"' | wc -l)
    if [ $FORM_FIELDS -gt 0 ]; then
        log_success "✅ PASS: Form fields found ($FORM_FIELDS detected)"
    else
        log_warn "⚠️  WARN: Form fields not clearly detected"
    fi
else
    log_error "❌ FAIL: HTTP response code is $HTTP_CODE (expected 200)"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 4: Check for 404 indicators
log_info "Step 4: Checking for 404 error indicators..."

FOUR_OH_FOUR_INDICATORS=$(echo "$PAGE_CONTENT" | grep -ic "404\|not found\|page not found" || echo "0")

if [ "$FOUR_OH_FOUR_INDICATORS" = "0" ]; then
    log_success "✅ PASS: No 404 error indicators found"
else
    log_error "❌ FAIL: Found '$FOUR_OH_FOUR_INDICATORS' 404-related indicators"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 5: Check WordPress error log
log_info "Step 5: Checking for related errors in error log..."

if [ -f "/var/www/html/wp-content/debug.log" ]; then
    # Look for permalink or rewrite rule errors
    RECENT_ERRORS=$(grep -i "permalink\|rewrite.*rule\|add-listing" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error" | tail -3)

    if [ ! -z "$RECENT_ERRORS" ]; then
        log_warn "⚠️  WARN: Found potential related errors:"
        echo "$RECENT_ERRORS" | while read line; do
            log_warn "     $line"
        done
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    else
        log_success "✅ PASS: No related errors in WordPress error log"
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 2 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 2: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 2: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 2: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
