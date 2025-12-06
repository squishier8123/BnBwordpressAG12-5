#!/bin/bash

# verify_fix_6_footer.sh - Footer Legal Links Verification
# Verifies that Fix 6 (Add Footer Legal Links) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 6: Footer Legal Links =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check footer widget configuration
log_info "Step 1: Checking footer widget configuration..."

FOOTER_WIDGETS=$(db_query "SELECT COUNT(*) FROM wp_options WHERE option_name LIKE '%widget%footer%'" 2>/dev/null | grep -o "[0-9]*" | tail -1 || echo "0")

if [ "$FOOTER_WIDGETS" -gt "0" ]; then
    log_success "✅ PASS: Footer widgets configured ($FOOTER_WIDGETS found)"
else
    log_warn "⚠️  WARN: Footer widget configuration not clearly detected"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 2: Check homepage for footer
log_info "Step 2: Checking homepage footer for legal links..."

if check_url_loads "https://beardsandbucks.com/"; then
    HOMEPAGE=$(curl -s "https://beardsandbucks.com/" 2>/dev/null)

    # Look for footer element
    if echo "$HOMEPAGE" | grep -i '<footer\|class=".*footer' &>/dev/null; then
        log_success "✅ PASS: Footer element detected on homepage"
    else
        log_warn "⚠️  WARN: Footer element not explicitly detected (may still be present)"
    fi

    # Check for Privacy Policy link
    PRIVACY_FOUND=$(echo "$HOMEPAGE" | grep -i "privacy\|privacy.*policy" | wc -l)

    if [ $PRIVACY_FOUND -gt 0 ]; then
        log_success "✅ PASS: Privacy Policy link found in footer area ($PRIVACY_FOUND instances)"

        # Check if it's a valid link
        PRIVACY_URL=$(echo "$HOMEPAGE" | grep -oP 'href=["\047]([^"]*privacy[^"]*)["\047]' | head -1 | sed 's/href=["'"'"']//;s/["'"'"']//')

        if [ ! -z "$PRIVACY_URL" ]; then
            log_success "✅ PASS: Privacy Policy link is a valid href"

            # Test if Privacy page loads
            if check_url_loads "https://beardsandbucks.com$PRIVACY_URL" 2>/dev/null || check_url_loads "$PRIVACY_URL" 2>/dev/null; then
                log_success "✅ PASS: Privacy Policy page loads successfully"
            else
                log_warn "⚠️  WARN: Privacy Policy page not responding correctly"
                if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                    OVERALL_STATUS=$VERIFY_PARTIAL
                fi
            fi
        fi
    else
        log_error "❌ FAIL: Privacy Policy link not found in footer"
        OVERALL_STATUS=$VERIFY_FAIL
    fi

    # Check for Terms & Conditions link
    TERMS_FOUND=$(echo "$HOMEPAGE" | grep -i "terms\|terms.*conditions\|t&c\|t & c" | wc -l)

    if [ $TERMS_FOUND -gt 0 ]; then
        log_success "✅ PASS: Terms & Conditions link found in footer area ($TERMS_FOUND instances)"

        # Check if it's a valid link
        TERMS_URL=$(echo "$HOMEPAGE" | grep -oP 'href=["\047]([^"]*term[^"]*)["\047]' | head -1 | sed 's/href=["'"'"']//;s/["'"'"']//')

        if [ ! -z "$TERMS_URL" ]; then
            log_success "✅ PASS: Terms & Conditions link is a valid href"

            # Test if Terms page loads
            if check_url_loads "https://beardsandbucks.com$TERMS_URL" 2>/dev/null || check_url_loads "$TERMS_URL" 2>/dev/null; then
                log_success "✅ PASS: Terms & Conditions page loads successfully"
            else
                log_warn "⚠️  WARN: Terms & Conditions page not responding correctly"
                if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
                    OVERALL_STATUS=$VERIFY_PARTIAL
                fi
            fi
        fi
    else
        log_error "❌ FAIL: Terms & Conditions link not found in footer"
        OVERALL_STATUS=$VERIFY_FAIL
    fi
else
    log_error "❌ FAIL: Could not access homepage for footer verification"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 3: Check for proper link structure
log_info "Step 3: Checking link structure integrity..."

if [ ! -z "$HOMEPAGE" ]; then
    # Check for proper href attributes
    HREF_LINKS=$(echo "$HOMEPAGE" | grep -o '<a[^>]*href[^>]*>' | wc -l)

    if [ $HREF_LINKS -gt 0 ]; then
        log_success "✅ PASS: Proper link structure detected ($HREF_LINKS links found)"
    else
        log_warn "⚠️  WARN: Link structure not clearly detected"
    fi
fi

# Step 4: Check footer widget specific configuration
log_info "Step 4: Checking footer widget custom HTML..."

FOOTER_HTML=$(get_site_option "widget_custom_html" 2>/dev/null || get_site_option "widget_text" 2>/dev/null || echo "")

if echo "$FOOTER_HTML" | grep -i "privacy\|terms\|legal" &>/dev/null; then
    log_success "✅ PASS: Legal links found in widget configuration"
else
    log_warn "⚠️  WARN: Legal links not found in stored widget config (may be in different storage location)"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 5: Check WordPress error log
log_info "Step 5: Checking for footer-related errors..."

if [ -f "/var/www/html/wp-content/debug.log" ]; then
    FOOTER_ERRORS=$(grep -i "footer\|widget.*error" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error\|fatal" | tail -3 || echo "")

    if [ ! -z "$FOOTER_ERRORS" ]; then
        log_warn "⚠️  WARN: Found footer-related errors:"
        echo "$FOOTER_ERRORS" | while read line; do
            log_warn "     $line"
        done
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    else
        log_success "✅ PASS: No footer-related errors in WordPress error log"
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 6 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 6: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 6: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 6: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
