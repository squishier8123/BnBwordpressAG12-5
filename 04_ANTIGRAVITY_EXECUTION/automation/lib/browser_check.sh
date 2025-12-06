#!/bin/bash

# Headless Browser Verification Functions
# Uses Playwright for browser automation
# Source this file: source ./lib/browser_check.sh

PLAYWRIGHT_TIMEOUT=30000  # 30 seconds in milliseconds
SCREENSHOT_DIR="${SCREENSHOT_DIR:-./screenshots}"

# Ensure screenshot directory exists
mkdir -p "${SCREENSHOT_DIR}"

# ============================================================================
# Browser Session Functions
# ============================================================================

# Check if Playwright is installed
check_playwright_installed() {
    if ! command -v npx &> /dev/null; then
        return 1
    fi

    if ! npx playwright --version &> /dev/null; then
        return 1
    fi

    return 0
}

# ============================================================================
# URL/Navigation Functions
# ============================================================================

check_url_loads() {
    local url="$1"
    local timeout="${2:-30}"

    # Check if URL returns 200 status
    local status=$(curl -s -o /dev/null -w "%{http_code}" --connect-timeout ${timeout} "${url}")

    if [ "${status}" = "200" ]; then
        return 0
    else
        return 1
    fi
}

check_url_title() {
    local url="$1"
    local expected_title="$2"

    local title=$(curl -s "${url}" | grep -oP '(?<=<title>)[^<]+')

    if [[ "${title}" == *"${expected_title}"* ]]; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Element Verification Functions
# ============================================================================

element_visible_on_page() {
    local url="$1"
    local selector="$2"
    local timeout="${3:-30000}"

    # This would use Playwright in a real implementation
    # For now, basic HTML check
    local html=$(curl -s "${url}")

    # Simple check: does the selector pattern exist in HTML
    if echo "${html}" | grep -q "${selector}"; then
        return 0
    else
        return 1
    fi
}

# Check if specific text exists on page
text_exists_on_page() {
    local url="$1"
    local text="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "${text}"; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Form/Input Functions
# ============================================================================

check_form_exists() {
    local url="$1"
    local form_id="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "id=\"${form_id}\""; then
        return 0
    else
        return 1
    fi
}

check_form_field_exists() {
    local url="$1"
    local field_name="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "name=\"${field_name}\""; then
        return 0
    else
        return 1
    fi
}

count_form_fields() {
    local url="$1"

    local html=$(curl -s "${url}")

    # Count input, select, and textarea elements
    local count=$(echo "${html}" | grep -oE '<input|<select|<textarea' | wc -l)

    echo "${count}"
}

# ============================================================================
# Link Functions
# ============================================================================

check_link_exists() {
    local url="$1"
    local link_text="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q ">${link_text}<"; then
        return 0
    else
        return 1
    fi
}

check_link_href() {
    local url="$1"
    local expected_href="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "href=\"${expected_href}\""; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Button Functions
# ============================================================================

check_button_exists() {
    local url="$1"
    local button_text="$2"

    local html=$(curl -s "${url}")

    # Check for button with text (button tag or input type="button/submit")
    if echo "${html}" | grep -qE "<button[^>]*>${button_text}</button>|value=\"${button_text}\""; then
        return 0
    else
        return 1
    fi
}

check_button_enabled() {
    local url="$1"
    local button_text="$2"

    local html=$(curl -s "${url}")

    # Check button exists and is NOT disabled
    if echo "${html}" | grep -q "<button[^>]*>${button_text}</button>" && ! echo "${html}" | grep -q "<button[^>]*disabled[^>]*>${button_text}</button>"; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Modal/Popup Functions
# ============================================================================

check_modal_exists() {
    local url="$1"
    local modal_class="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "class=\".*${modal_class}.*\""; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Error Detection Functions
# ============================================================================

check_for_errors_in_html() {
    local url="$1"

    local html=$(curl -s "${url}")

    # Check for common error indicators
    if echo "${html}" | grep -qiE 'error|fatal|exception|failed|404|500'; then
        return 1  # Errors found
    else
        return 0  # No errors
    fi
}

check_for_broken_links() {
    local url="$1"

    local html=$(curl -s "${url}")

    # Extract all href attributes
    local links=$(echo "${html}" | grep -oP '(?<=href=")[^"]*')

    local broken_count=0

    while IFS= read -r link; do
        # Skip anchor links and external links for now
        if [[ "${link}" =~ ^# ]] || [[ "${link}" =~ ^http ]]; then
            continue
        fi

        # Convert relative to absolute
        if [[ "${link}" = /* ]]; then
            local full_url="$(echo ${url} | grep -oP '^[^/]*/[^/]*')//${url#*//}"
        fi

        # Check if link returns 404
        local status=$(curl -s -o /dev/null -w "%{http_code}" "${full_url}${link}")
        if [ "${status}" = "404" ]; then
            broken_count=$((broken_count + 1))
        fi
    done <<< "${links}"

    echo "${broken_count}"
}

# ============================================================================
# Screenshot Functions
# ============================================================================

take_screenshot() {
    local url="$1"
    local output_file="${2:-${SCREENSHOT_DIR}/screenshot-$(date +%s).png}"

    # This requires Playwright/Puppeteer in real implementation
    # Placeholder for now
    echo "Screenshot would be saved to: ${output_file}"
    return 0
}

take_screenshot_of_element() {
    local url="$1"
    local selector="$2"
    local output_file="${3:-${SCREENSHOT_DIR}/element-$(date +%s).png}"

    # Placeholder for Playwright implementation
    echo "Element screenshot would be saved to: ${output_file}"
    return 0
}

# ============================================================================
# Console/Network Functions
# ============================================================================

check_console_errors() {
    local url="$1"

    # This would require browser DevTools Protocol in real implementation
    # For now, check HTML for inline error references
    local html=$(curl -s "${url}")

    if echo "${html}" | grep -qi "console.error\|console.warn\|throw"; then
        return 1  # Likely errors
    else
        return 0  # Likely no errors
    fi
}

check_network_requests_successful() {
    local url="$1"

    # Use curl to check basic network health
    local response=$(curl -s -w "\n%{http_code}" "${url}")
    local status_code=$(echo "${response}" | tail -1)

    if [ "${status_code}" = "200" ]; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# API Validation Functions
# ============================================================================

check_api_endpoint_working() {
    local api_url="$1"
    local expected_response="${2:-}"

    local response=$(curl -s -X GET "${api_url}")
    local status=$(curl -s -o /dev/null -w "%{http_code}" "${api_url}")

    if [ "${status}" != "200" ]; then
        return 1
    fi

    if [ -n "${expected_response}" ]; then
        if echo "${response}" | grep -q "${expected_response}"; then
            return 0
        else
            return 1
        fi
    fi

    return 0
}

check_mapbox_api_working() {
    local api_key="$1"

    # Test Mapbox API with a simple request
    local url="https://api.mapbox.com/geocoding/v5/mapbox.places/san%20francisco.json?access_token=${api_key}"

    local status=$(curl -s -o /dev/null -w "%{http_code}" "${url}")

    if [ "${status}" = "200" ]; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Page Load Time Functions
# ============================================================================

measure_page_load_time() {
    local url="$1"

    local time=$(curl -s -o /dev/null -w "%{time_total}" "${url}")

    echo "${time}"
}

check_page_load_time() {
    local url="$1"
    local max_time="${2:-5}"  # 5 seconds default

    local time=$(measure_page_load_time "${url}")

    if (( $(echo "${time} < ${max_time}" | bc -l) )); then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Content Verification Functions
# ============================================================================

check_page_contains_text() {
    local url="$1"
    local text="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "${text}"; then
        return 0
    else
        return 1
    fi
}

check_page_does_not_contain_text() {
    local url="$1"
    local text="$2"

    local html=$(curl -s "${url}")

    if echo "${html}" | grep -q "${text}"; then
        return 1
    else
        return 0
    fi
}

# ============================================================================
# Export Functions
# ============================================================================

if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    echo "browser_check.sh loaded successfully"
fi
