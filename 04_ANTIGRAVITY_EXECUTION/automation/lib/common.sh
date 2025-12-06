#!/bin/bash

# Common Helper Functions for Automation Scripts
# Source this file in any automation script: source ./lib/common.sh

set -o pipefail

# Configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOG_DIR="${SCRIPT_DIR}/logs"
ALERT_FLAG="${LOG_DIR}/ATTENTION_NEEDED.flag"
SITE_URL="https://beardsandbucks.com"

# Ensure log directory exists
mkdir -p "${LOG_DIR}"

# Color codes for output
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# ============================================================================
# Logging Functions
# ============================================================================

log_info() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${BLUE}[${timestamp}]${NC} INFO: ${message}" | tee -a "${LOG_DIR}/automation.log"
}

log_warn() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${YELLOW}[${timestamp}]${NC} WARN: ${message}" | tee -a "${LOG_DIR}/automation.log"
    echo "${timestamp} WARN: ${message}" >> "${LOG_DIR}/ALERTS.log"
}

log_error() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${RED}[${timestamp}]${NC} ERROR: ${message}" | tee -a "${LOG_DIR}/automation.log"
    echo "${timestamp} ERROR: ${message}" >> "${LOG_DIR}/ALERTS.log"
}

log_success() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo -e "${GREEN}[${timestamp}]${NC} ✅ ${message}" | tee -a "${LOG_DIR}/automation.log"
}

# ============================================================================
# Alert Functions
# ============================================================================

create_alert_flag() {
    local severity="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')

    {
        echo "ALERT_TIMESTAMP=${timestamp}"
        echo "ALERT_SEVERITY=${severity}"
        echo "ALERT_MESSAGE=${message}"
    } > "${ALERT_FLAG}"

    log_warn "Alert flag created: ${severity} - ${message}"
}

clear_alert_flag() {
    if [ -f "${ALERT_FLAG}" ]; then
        rm "${ALERT_FLAG}"
        log_info "Alert flag cleared"
    fi
}

# ============================================================================
# Database Functions (MySQL)
# ============================================================================

db_query() {
    local sql="$1"
    local db_host="${DB_HOST:-localhost}"
    local db_user="${DB_USER:-wordpress}"
    local db_pass="${DB_PASSWORD}"
    local db_name="${DB_NAME:-beardsandbucks_db}"

    if [ -z "${db_pass}" ]; then
        log_error "DB_PASSWORD not set"
        return 1
    fi

    mysql -h "${db_host}" -u "${db_user}" -p"${db_pass}" "${db_name}" -se "${sql}" 2>/dev/null
    return $?
}

get_wp_option() {
    local option_name="$1"
    local query="SELECT option_value FROM wp_options WHERE option_name='${option_name}' LIMIT 1;"
    db_query "${query}"
}

update_wp_option() {
    local option_name="$1"
    local option_value="$2"
    local query="UPDATE wp_options SET option_value='${option_value}' WHERE option_name='${option_name}';"
    db_query "${query}"
    return $?
}

check_wp_user_admin() {
    local user_login="$1"
    local query="SELECT meta_value FROM wp_usermeta WHERE user_id=(SELECT ID FROM wp_users WHERE user_login='${user_login}') AND meta_key='wp_capabilities' LIMIT 1;"
    local result=$(db_query "${query}")

    if echo "${result}" | grep -q "administrator"; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Site Health Functions
# ============================================================================

check_site_online() {
    local url="${1:-${SITE_URL}}"
    local timeout=10

    if curl -s --connect-timeout ${timeout} -o /dev/null -w "%{http_code}" "${url}" | grep -q "200"; then
        return 0
    else
        return 1
    fi
}

check_wordpress_admin() {
    local admin_url="${SITE_URL}/wp-admin/"

    if curl -s -o /dev/null -w "%{http_code}" "${admin_url}" | grep -q "200"; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Git Functions
# ============================================================================

git_repo_clean() {
    local repo_path="${1:-.}"

    if [ ! -d "${repo_path}/.git" ]; then
        log_error "Not a git repository: ${repo_path}"
        return 1
    fi

    cd "${repo_path}"
    if [ -z "$(git status --porcelain)" ]; then
        return 0
    else
        return 1
    fi
}

git_create_checkpoint() {
    local repo_path="${1:-.}"
    local message="${2:-Pre-automation checkpoint}"

    cd "${repo_path}"
    git add -A
    git commit -m "${message}" 2>/dev/null
    return $?
}

git_get_commit_hash() {
    cd "${1:-.}"
    git rev-parse --short HEAD
}

# ============================================================================
# Backup Functions
# ============================================================================

check_backup_exists() {
    local backup_dir="${1:-./backups}"
    local min_size="${2:-1048576}" # 1MB default

    if [ ! -d "${backup_dir}" ]; then
        return 1
    fi

    # Find most recent backup
    local latest_backup=$(ls -t "${backup_dir}"/backup-*.sql 2>/dev/null | head -1)

    if [ -z "${latest_backup}" ]; then
        return 1
    fi

    # Check size
    local size=$(stat -f%z "${latest_backup}" 2>/dev/null || stat -c%s "${latest_backup}" 2>/dev/null)
    if [ ${size} -lt ${min_size} ]; then
        return 1
    fi

    return 0
}

get_latest_backup() {
    local backup_dir="${1:-./backups}"
    ls -t "${backup_dir}"/backup-*.sql 2>/dev/null | head -1
}

# ============================================================================
# File/Path Functions
# ============================================================================

check_file_exists() {
    local file="$1"
    if [ -f "${file}" ]; then
        return 0
    else
        return 1
    fi
}

check_env_file() {
    local env_file="$1"
    if [ ! -f "${env_file}" ]; then
        log_error "Environment file not found: ${env_file}"
        return 1
    fi

    # Source it safely
    source "${env_file}"
    return 0
}

# ============================================================================
# Process Functions
# ============================================================================

no_other_antigravity_running() {
    # Check if another Antigravity process is running
    # This is a placeholder - adapt to your process naming

    if pgrep -f "antigravity" > /dev/null; then
        return 1
    else
        return 0
    fi
}

# ============================================================================
# Verification Helpers
# ============================================================================

wait_for_element() {
    local url="$1"
    local selector="$2"
    local timeout="${3:-30}"

    # Placeholder for headless browser check
    # Actual implementation in browser_check.sh
    log_info "Waiting for element: ${selector} on ${url} (timeout: ${timeout}s)"
    return 0
}

# ============================================================================
# Test/Export Functions (for verification scripts)
# ============================================================================

# Return codes for verification
VERIFY_PASS=0
VERIFY_FAIL=1
VERIFY_PARTIAL=2
VERIFY_TIMEOUT=3

export VERIFY_PASS VERIFY_FAIL VERIFY_PARTIAL VERIFY_TIMEOUT

# ============================================================================
# Main Message
# ============================================================================

# Print sourcing confirmation if run directly
if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    log_success "common.sh loaded successfully"
fi
