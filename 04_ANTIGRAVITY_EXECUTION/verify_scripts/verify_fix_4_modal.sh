#!/bin/bash

# verify_fix_4_modal.sh - Login Modal Verification
# Verifies that Fix 4 (Login/Register Modal) is working correctly
# Returns: 0 = PASS, 1 = FAIL, 2 = PARTIAL

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
source "$SCRIPT_DIR/../../automation/lib/common.sh"
source "$SCRIPT_DIR/../../automation/lib/wordpress_api.sh"
source "$SCRIPT_DIR/../../automation/lib/browser_check.sh"

log_info "========== Fix 4: Login/Register Modal =========="

VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
OVERALL_STATUS=$VERIFY_PASS

# Step 1: Check if WooCommerce or Listeo user login is enabled
log_info "Step 1: Checking if login/user system is enabled..."

if check_plugin_enabled "listeo-core" || check_plugin_enabled "woocommerce"; then
    log_success "✅ PASS: Required plugin (Listeo or WooCommerce) is enabled"
else
    log_warn "⚠️  WARN: Could not confirm required plugins are enabled"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 2: Check homepage for login button/link
log_info "Step 2: Checking for login button on homepage..."

HOMEPAGE=$(curl -s "https://beardsandbucks.com/" 2>/dev/null)

if echo "$HOMEPAGE" | grep -i "login\|sign.*in\|my account" &>/dev/null; then
    log_success "✅ PASS: Login-related elements found on homepage"
else
    log_error "❌ FAIL: No login elements detected on homepage"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 3: Check for modal structure (not page redirect)
log_info "Step 3: Checking if login opens as modal (not page redirect)..."

if echo "$HOMEPAGE" | grep -i "modal\|dialog\|popup\|lightbox" &>/dev/null; then
    log_success "✅ PASS: Modal/dialog framework detected on page"

    if echo "$HOMEPAGE" | grep -i "login.*modal\|auth.*modal\|user.*modal" &>/dev/null; then
        log_success "✅ PASS: Login modal structure confirmed"
    else
        log_warn "⚠️  WARN: Modal structure found but login-specific modal not explicitly confirmed"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
else
    log_warn "⚠️  WARN: Modal framework not detected (may still work, verification limited)"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 4: Check for login form fields
log_info "Step 4: Checking for login form fields..."

if echo "$HOMEPAGE" | grep -E 'name="(log|user|email|password)"' &>/dev/null; then
    log_success "✅ PASS: Login form fields detected"

    # Check for both email and password fields
    EMAIL_FIELD=$(echo "$HOMEPAGE" | grep -i 'name=".*email\|name=".*user\|name="log"' | wc -l)
    PASSWORD_FIELD=$(echo "$HOMEPAGE" | grep -i 'name=".*password\|name="pwd"' | wc -l)

    if [ $EMAIL_FIELD -gt 0 ] && [ $PASSWORD_FIELD -gt 0 ]; then
        log_success "✅ PASS: Both email/username and password fields found"
    else
        log_warn "⚠️  WARN: Form fields incomplete (email: $EMAIL_FIELD, password: $PASSWORD_FIELD)"
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    fi
else
    log_error "❌ FAIL: No login form fields detected"
    OVERALL_STATUS=$VERIFY_FAIL
fi

# Step 5: Check for register/signup link
log_info "Step 5: Checking for register/signup link..."

if echo "$HOMEPAGE" | grep -i "register\|sign.*up\|create.*account\|new.*account" &>/dev/null; then
    log_success "✅ PASS: Register/signup link found"
else
    log_warn "⚠️  WARN: Register/signup link not explicitly found"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 6: Check for modal close/dismiss mechanism
log_info "Step 6: Checking for modal close mechanism..."

if echo "$HOMEPAGE" | grep -i "close\|dismiss\|cancel\|&#215;\|&times;" &>/dev/null; then
    log_success "✅ PASS: Modal close/dismiss mechanism detected"
else
    log_warn "⚠️  WARN: Close mechanism not clearly detected"
    if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
        OVERALL_STATUS=$VERIFY_PARTIAL
    fi
fi

# Step 7: Check for JavaScript errors related to login/modal
log_info "Step 7: Checking for login/modal-related errors in error log..."

if [ -f "/var/www/html/wp-content/debug.log" ]; then
    LOGIN_ERRORS=$(grep -i "login\|modal\|auth" "/var/www/html/wp-content/debug.log" 2>/dev/null | grep -i "error\|fatal" | tail -3 || echo "")

    if [ ! -z "$LOGIN_ERRORS" ]; then
        log_warn "⚠️  WARN: Found login/modal-related errors:"
        echo "$LOGIN_ERRORS" | while read line; do
            log_warn "     $line"
        done
        if [ $OVERALL_STATUS -eq $VERIFY_PASS ]; then
            OVERALL_STATUS=$VERIFY_PARTIAL
        fi
    else
        log_success "✅ PASS: No login/modal-related errors in WordPress error log"
    fi
else
    log_info "ℹ️  Debug log not found (expected in some configurations)"
fi

# Final Report
log_info ""
log_info "========== FIX 4 VERIFICATION RESULT =========="
case $OVERALL_STATUS in
    $VERIFY_PASS)
        log_success "✅ FIX 4: PASSED - All checks passed"
        ;;
    $VERIFY_PARTIAL)
        log_warn "⚠️  FIX 4: PARTIAL - Some checks passed, some warnings"
        ;;
    $VERIFY_FAIL)
        log_error "❌ FIX 4: FAILED - One or more checks failed"
        ;;
esac

exit $OVERALL_STATUS
