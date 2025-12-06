#!/bin/bash

# WordPress REST API Helper Functions
# Source this file: source ./lib/wordpress_api.sh

SITE_URL="${SITE_URL:-https://beardsandbucks.com}"
REST_API_BASE="${SITE_URL}/wp-json/wp/v2"

# ============================================================================
# WordPress Settings Functions
# ============================================================================

get_site_option() {
    local option_name="$1"
    local query="SELECT option_value FROM wp_options WHERE option_name='${option_name}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

set_site_option() {
    local option_name="$1"
    local option_value="$2"

    local query="INSERT INTO wp_options (option_name, option_value) VALUES ('${option_name}', '${option_value}') ON DUPLICATE KEY UPDATE option_value='${option_value}';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
    return $?
}

# ============================================================================
# Plugin/Theme Functions
# ============================================================================

check_plugin_enabled() {
    local plugin_name="$1"
    local query="SELECT COUNT(*) FROM wp_options WHERE option_name='active_plugins' AND option_value LIKE '%${plugin_name}%';"

    local result=$(mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null)

    if [ "${result}" -gt 0 ]; then
        return 0
    else
        return 1
    fi
}

get_listeo_setting() {
    local setting_name="$1"
    local query="SELECT option_value FROM wp_options WHERE option_name='listeo_${setting_name}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

set_listeo_setting() {
    local setting_name="$1"
    local setting_value="$2"

    local option_name="listeo_${setting_name}"
    local query="INSERT INTO wp_options (option_name, option_value) VALUES ('${option_name}', '${setting_value}') ON DUPLICATE KEY UPDATE option_value='${setting_value}';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
    return $?
}

# ============================================================================
# User Functions
# ============================================================================

get_user_by_login() {
    local user_login="$1"
    local query="SELECT ID, user_login, user_email FROM wp_users WHERE user_login='${user_login}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

check_user_has_capability() {
    local user_login="$1"
    local capability="$2"

    local query="SELECT meta_value FROM wp_usermeta WHERE user_id=(SELECT ID FROM wp_users WHERE user_login='${user_login}') AND meta_key='wp_capabilities' LIMIT 1;"

    local result=$(mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null)

    if echo "${result}" | grep -q "${capability}"; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Post/Page Functions
# ============================================================================

get_page_by_slug() {
    local page_slug="$1"
    local query="SELECT ID, post_title, post_status FROM wp_posts WHERE post_name='${page_slug}' AND post_type='page' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

get_post_by_slug() {
    local post_slug="$1"
    local post_type="${2:-post}"
    local query="SELECT ID, post_title, post_status FROM wp_posts WHERE post_name='${post_slug}' AND post_type='${post_type}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

page_exists() {
    local page_slug="$1"
    local query="SELECT COUNT(*) FROM wp_posts WHERE post_name='${page_slug}' AND post_type='page';"

    local result=$(mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null)

    if [ "${result}" -gt 0 ]; then
        return 0
    else
        return 1
    fi
}

# ============================================================================
# Postmeta Functions (Post Custom Fields)
# ============================================================================

get_post_meta() {
    local post_id="$1"
    local meta_key="$2"
    local query="SELECT meta_value FROM wp_postmeta WHERE post_id=${post_id} AND meta_key='${meta_key}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

update_post_meta() {
    local post_id="$1"
    local meta_key="$2"
    local meta_value="$3"

    local query="INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (${post_id}, '${meta_key}', '${meta_value}') ON DUPLICATE KEY UPDATE meta_value='${meta_value}';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
    return $?
}

# ============================================================================
# Taxonomy/Category Functions
# ============================================================================

get_term_by_slug() {
    local term_slug="$1"
    local taxonomy="${2:-category}"
    local query="SELECT t.term_id, t.name FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id=tt.term_id WHERE t.slug='${term_slug}' AND tt.taxonomy='${taxonomy}' LIMIT 1;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

# ============================================================================
# Widget Functions
# ============================================================================

get_sidebars() {
    local query="SELECT option_value FROM wp_options WHERE option_name='sidebars_widgets';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

# ============================================================================
# Rewrite Rules
# ============================================================================

flush_rewrite_rules_db() {
    local query="DELETE FROM wp_options WHERE option_name='rewrite_rules';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
    return $?
}

# ============================================================================
# REST API Functions
# ============================================================================

call_rest_api() {
    local endpoint="$1"
    local method="${2:-GET}"
    local data="${3:-}"

    local url="${REST_API_BASE}${endpoint}"

    if [ "${method}" = "GET" ]; then
        curl -s -X GET "${url}"
    elif [ "${method}" = "POST" ]; then
        curl -s -X POST "${url}" -d "${data}" -H "Content-Type: application/json"
    else
        curl -s -X "${method}" "${url}" -d "${data}" -H "Content-Type: application/json"
    fi
}

get_posts_via_rest() {
    local post_type="${1:-posts}"
    call_rest_api "/${post_type}?per_page=10"
}

# ============================================================================
# Database Maintenance Functions
# ============================================================================

check_database_integrity() {
    local query="CHECK TABLE wp_options, wp_posts, wp_postmeta, wp_users, wp_usermeta;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

get_database_size() {
    local query="SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) FROM information_schema.tables WHERE table_schema='beardsandbucks_db';"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" information_schema -se "${query}" 2>/dev/null
}

# ============================================================================
# WordPress Cron Functions
# ============================================================================

get_scheduled_events() {
    local query="SELECT option_name FROM wp_options WHERE option_name LIKE '_transient_%' LIMIT 20;"

    mysql -h localhost -u wordpress -p"${DB_PASSWORD}" beardsandbucks_db -se "${query}" 2>/dev/null
}

# ============================================================================
# Validation Functions
# ============================================================================

is_valid_api_key() {
    local api_key="$1"
    local api_provider="${2:-mapbox}"

    if [ "${api_provider}" = "mapbox" ]; then
        # Check if it starts with 'pk.'
        if [[ "${api_key}" =~ ^pk\. ]]; then
            return 0
        else
            return 1
        fi
    fi

    return 0
}

# ============================================================================
# Export Functions
# ============================================================================

if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    echo "wordpress_api.sh loaded successfully"
fi
