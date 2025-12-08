#!/bin/bash

################################################################################
# Auto-Organize Directory Structure
#
# Reads DIRECTORY_BLUEPRINT.md and automatically organizes files into their
# proper locations. Supports dry-run mode for safe preview.
#
# Usage:
#   ./organize-directory.sh --dry-run     # Preview changes
#   ./organize-directory.sh --execute     # Actually organize files
#   ./organize-directory.sh --cleanup     # Delete duplicates/metadata only
#
# Works from project root directory
################################################################################

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
DRY_RUN=false
CLEANUP_ONLY=false
MOVED=0
DELETED=0
SKIPPED=0

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

################################################################################
# Helper Functions
################################################################################

log_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

log_success() {
    echo -e "${GREEN}✓${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

log_error() {
    echo -e "${RED}✗${NC} $1"
}

move_file() {
    local src="$1"
    local dest_dir="$2"
    local filename=$(basename "$src")

    if [ ! -d "$dest_dir" ]; then
        if [ "$DRY_RUN" = true ]; then
            log_info "[DRY-RUN] Would create: $dest_dir"
        else
            mkdir -p "$dest_dir"
            log_success "Created directory: $dest_dir"
        fi
    fi

    local dest="$dest_dir/$filename"

    # Don't move to same location
    if [ "$(dirname "$src")" = "$dest_dir" ]; then
        log_warning "Skipped (already in correct location): $filename"
        ((SKIPPED++))
        return
    fi

    # Check if destination already exists
    if [ -f "$dest" ]; then
        log_warning "Skipped (file exists at destination): $filename"
        ((SKIPPED++))
        return
    fi

    if [ "$DRY_RUN" = true ]; then
        log_info "[DRY-RUN] Would move: $src → $dest"
    else
        mv "$src" "$dest"
        log_success "Moved: $filename → $dest_dir"
    fi
    ((MOVED++))
}

delete_file() {
    local file="$1"
    local reason="$2"

    if [ "$DRY_RUN" = true ]; then
        log_info "[DRY-RUN] Would delete: $(basename "$file") ($reason)"
    else
        rm "$file"
        log_success "Deleted: $(basename "$file") ($reason)"
    fi
    ((DELETED++))
}

################################################################################
# Main Organization Logic
################################################################################

organize() {
    cd "$PROJECT_ROOT"

    log_info "Starting directory organization..."
    log_info "Project root: $PROJECT_ROOT"
    echo

    # Create necessary directories
    mkdir -p docs/guides docs/reports docs/archived-reports docs/archived-tasks docs/reference
    mkdir -p plugins
    mkdir -p media/webp-reports
    mkdir -p archive/exports archive/conversations
    mkdir -p logs

    ################################################################################
    # Phase 1: Delete Metadata and Duplicates
    ################################################################################

    log_info "Phase 1: Cleaning up metadata and artifacts..."

    for file in *.metadata.json *.resolved *.resolved.* task.md.metadata.json; do
        [ -f "$file" ] || continue
        delete_file "$file" "metadata artifact"
    done 2>/dev/null

    echo

    ################################################################################
    # Phase 2: Organize Markdown Files
    ################################################################################

    log_info "Phase 2: Organizing documentation files..."

    for file in *.md; do
        [ -f "$file" ] || continue

        # Skip root allowlist
        case "$file" in
            README.md | TODO.md | DIRECTORY_STRUCTURE.md | CLAUDE.md)
                log_warning "Skipped (root allowlist): $file"
                ((SKIPPED++))
                continue
                ;;
        esac

        # Route to appropriate docs subfolder
        if [[ "$file" =~ SESSION|SUMMARY ]]; then
            move_file "$file" "docs/guides"
        elif [[ "$file" =~ REPORT|VERIFICATION|INVESTIGATION|ANALYSIS ]]; then
            move_file "$file" "docs/reports"
        elif [[ "$file" =~ GUIDE|ORGANIZATION ]]; then
            move_file "$file" "docs/guides"
        elif [[ "$file" =~ BRAND|audit ]]; then
            move_file "$file" "docs/guides"
        elif [[ "$file" =~ 2025-12-0[5-7] ]]; then
            # Extract date for subfolder
            date_folder=$(echo "$file" | sed -E 's/(2025-12-0[5-7]).*/\1/')
            move_file "$file" "docs/archived-reports/${date_folder}_Archive"
        else
            move_file "$file" "docs/guides"
        fi
    done 2>/dev/null

    echo

    ################################################################################
    # Phase 3: Organize PHP Files
    ################################################################################

    log_info "Phase 3: Organizing PHP plugin files..."

    for file in *mu.php beards-bucks-*.php; do
        [ -f "$file" ] || continue
        move_file "$file" "plugins"
    done 2>/dev/null

    echo

    ################################################################################
    # Phase 4: Organize Media Files
    ################################################################################

    log_info "Phase 4: Organizing media files..."

    for file in *.png *.jpg *.jpeg *.webp *.gif; do
        [ -f "$file" ] || continue
        move_file "$file" "media/webp-reports"
    done 2>/dev/null

    echo

    ################################################################################
    # Phase 5: Organize Log and Export Files
    ################################################################################

    log_info "Phase 5: Organizing logs and exports..."

    for file in *.log *agent*.log; do
        [ -f "$file" ] || continue
        move_file "$file" "archive/exports"
    done 2>/dev/null

    for file in *export*.txt *agent*.txt; do
        [ -f "$file" ] || continue
        move_file "$file" "archive/exports"
    done 2>/dev/null

    echo

    ################################################################################
    # Phase 6: Organize Python/Script Files
    ################################################################################

    log_info "Phase 6: Organizing utility scripts..."

    for file in apply*.py *fix*.py; do
        [ -f "$file" ] || continue
        move_file "$file" "docs/reports"
    done 2>/dev/null

    for file in *.css; do
        [ -f "$file" ] || continue
        [ "$file" != "custom.css" ] && move_file "$file" "docs/reports"
    done 2>/dev/null

    echo
}

cleanup_only() {
    cd "$PROJECT_ROOT"

    log_info "Running cleanup only (deleting metadata/duplicates)..."
    echo

    for file in *.metadata.json *.resolved *.resolved.* task.md.metadata.json; do
        [ -f "$file" ] || continue
        delete_file "$file" "metadata artifact"
    done 2>/dev/null

    echo
}

################################################################################
# Main Entry Point
################################################################################

main() {
    # Parse arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            --dry-run)
                DRY_RUN=true
                log_warning "DRY-RUN MODE: No files will actually be moved"
                echo
                shift
                ;;
            --execute)
                DRY_RUN=false
                shift
                ;;
            --cleanup)
                CLEANUP_ONLY=true
                shift
                ;;
            --help)
                echo "Usage: $0 [OPTIONS]"
                echo ""
                echo "Options:"
                echo "  --dry-run     Preview changes without executing"
                echo "  --execute     Actually organize files (default)"
                echo "  --cleanup     Delete metadata artifacts only"
                echo "  --help        Show this help message"
                exit 0
                ;;
            *)
                log_error "Unknown option: $1"
                exit 1
                ;;
        esac
    done

    if [ "$CLEANUP_ONLY" = true ]; then
        cleanup_only
    else
        organize
    fi

    # Summary
    echo
    log_info "Organization Summary:"
    log_success "Moved: $MOVED files"
    log_success "Deleted: $DELETED files"
    log_warning "Skipped: $SKIPPED files"

    if [ "$DRY_RUN" = true ]; then
        echo
        log_warning "This was a dry-run. No changes were made."
        log_info "Run with --execute to apply these changes."
    else
        echo
        log_success "Organization complete!"
    fi
}

# Run main function
main "$@"
