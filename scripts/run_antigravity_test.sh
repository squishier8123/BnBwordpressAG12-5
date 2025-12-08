#!/bin/bash

################################################################################
# Antigravity Comprehensive Testing Automation
#
# Runs Antigravity testing suite with random persona assignment
# Captures screenshots, measures performance, and generates reports
#
# Usage:
#   ./run_antigravity_test.sh                    # Run interactive
#   ./run_antigravity_test.sh --persona 1        # Run specific persona
#   ./run_antigravity_test.sh --headless         # Run without screenshots
#   ./run_antigravity_test.sh --all              # Run all personas sequentially
#
################################################################################

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RESULTS_DIR="$PROJECT_ROOT/test-results/antigravity"
SCREENSHOTS_DIR="$RESULTS_DIR/screenshots"
REPORTS_DIR="$RESULTS_DIR/reports"
TIMESTAMP=$(date +%Y_%m_%d_%H_%M_%S)

# Color codes
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Configuration
SITE_URL="https://beardsandbucks.com"
HEADLESS=false
PERSONA=0
RUN_ALL=false

# Persona array
declare -a PERSONAS=(
    "Sarah Chen - Serious Bowhunter Shopper"
    "Marcus Williams - Casual Visitor / Potential Outfitter"
    "Jennifer Park - Budget-Conscious Beginner"
    "Tom Johnson - Frustrated Tech-Savvy User"
    "Angela Martinez - Platform Administrator"
    "Alex Rodriguez - Competitive Marketplace Seller"
    "David Thompson - Mobile-First User"
)

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

log_header() {
    echo -e "\n${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
    echo -e "${CYAN}$1${NC}"
    echo -e "${CYAN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}\n"
}

setup_directories() {
    log_info "Setting up test directories..."
    mkdir -p "$RESULTS_DIR"
    mkdir -p "$SCREENSHOTS_DIR"
    mkdir -p "$REPORTS_DIR"
    mkdir -p "$REPORTS_DIR/persona_reports"
    log_success "Directories created at: $RESULTS_DIR"
}

select_persona() {
    if [ "$PERSONA" -eq 0 ]; then
        # Random selection
        PERSONA=$((RANDOM % 7 + 1))
        log_warning "Randomly assigned Persona #$PERSONA"
    fi

    PERSONA_NAME="${PERSONAS[$((PERSONA - 1))]}"
    log_success "Testing as: $PERSONA_NAME"
}

generate_test_report_template() {
    local persona_num=$1
    local persona_name="${PERSONAS[$((persona_num - 1))]}"
    local report_file="$REPORTS_DIR/persona_reports/PERSONA_${persona_num}_${TIMESTAMP}.md"

    cat > "$report_file" << 'EOF'
# Antigravity Test Report
## [PERSONA_NAME] - [DATE]

### Persona Tested: [Full Persona Details]

#### Profile Summary
- **Role**: [Description of role]
- **Goal**: [What they're trying to accomplish]
- **Mindset**: [How they think/feel]
- **Concerns**: [What worries them]
- **Testing Duration**: [Time spent testing]

---

## 📊 Overall Site Score: __ / 100

---

## 🐛 Issues Found

### Critical Issues (Site Breaking)
**Count**: 0
- None found yet

### High Priority Issues (Functionality Broken)
**Count**: 0
- None found yet

### Medium Priority Issues (Poor UX)
**Count**: 0
- None found yet

### Low Priority Issues (Minor Issues)
**Count**: 0
- None found yet

---

## ✅ Positive Findings

### What Works Perfectly
- [ ] Feature 1
- [ ] Feature 2

---

## 📈 Performance Results

### Load Times
- **Homepage Load Time**: [X seconds]
- **Average Page Load**: [X seconds]
- **Slowest Page**: [Page name] - [X seconds]
- **Fastest Page**: [Page name] - [X seconds]

### Lighthouse Scores
- **Performance**: [X/100]
- **Accessibility**: [X/100]
- **Best Practices**: [X/100]
- **SEO**: [X/100]

### Mobile Performance
- **Mobile Page Load**: [X seconds]
- **Mobile Lighthouse**: [X/100]
- **Responsive Design Issues**: [List any]

---

## 🖥️ Browser & Device Tested

- **Browser**: Chrome / Firefox / Safari
- **Browser Version**: [Version]
- **Operating System**: Windows / macOS / iOS / Android
- **Device Type**: Desktop / Tablet / Mobile
- **Screen Width**: [pixels]
- **Device Model**: [if mobile]

---

## 📋 Testing Checklist

### Navigation & Basic Functionality
- [ ] Homepage loads without errors
- [ ] Main navigation works
- [ ] Search bar functions
- [ ] No 404 errors encountered
- [ ] All images load correctly
- [ ] Mobile menu works

### Directory Features (Listeo)
- [ ] Browse all listings
- [ ] Search by category
- [ ] Search by location
- [ ] Listing detail pages show all info
- [ ] Contact forms work
- [ ] Ratings/reviews display correctly

### Marketplace Features (Dokan)
- [ ] Browse product categories
- [ ] Product search works
- [ ] Filter functionality (price, condition, rating)
- [ ] Product detail pages complete
- [ ] Product images load and zoom
- [ ] Add to cart functions
- [ ] Reviews system works

### User Account Features
- [ ] Account creation works
- [ ] Email verification works
- [ ] Login/logout functions
- [ ] Password reset works
- [ ] Profile editing works
- [ ] Order history displays

### Shopping & Checkout
- [ ] Cart displays correctly
- [ ] Quantity editing works
- [ ] Cart totals calculated correctly
- [ ] Shipping options available
- [ ] Checkout flow is smooth
- [ ] Order confirmation works
- [ ] Email confirmation received

### Security & Technical
- [ ] HTTPS enabled (green lock)
- [ ] No mixed content warnings
- [ ] Password fields secure
- [ ] No console errors (F12 → Console)
- [ ] No JavaScript errors
- [ ] Mobile responsive at all widths

### SEO & Metadata
- [ ] Page titles are unique
- [ ] Meta descriptions present
- [ ] H1 heading on each page
- [ ] Heading hierarchy logical
- [ ] Image alt text present
- [ ] Structured data present

### Accessibility
- [ ] Color contrast adequate
- [ ] Keyboard navigation works
- [ ] Focus indicators visible
- [ ] Form labels present
- [ ] Error messages clear
- [ ] No autoplay media

---

## 📸 Screenshots Taken

- `PERSONA_[NUM]_homepage_[TIME].png`
- `PERSONA_[NUM]_[FEATURE]_[TIME].png`
- `PERSONA_[NUM]_[ISSUE]_[TIME].png`

**Total Screenshots**: [Count]

---

## 🎯 Recommendations for Next Test

- [ ] Recommendation 1
- [ ] Recommendation 2
- [ ] Recommendation 3

---

## 📝 Tester Notes

### Initial Impressions
[How did the site feel on first visit? Was it clear what to do?]

### Pain Points Encountered
[What was difficult or confusing?]

### Unexpected Discoveries
[Anything surprising - good or bad?]

### Suggestions for Improvement
[Ideas for making it better]

---

## 📊 Summary

**Total Tests Run**: [X]
**Tests Passed**: [X]
**Tests Failed**: [X]
**Success Rate**: [X%]

**Overall User Experience Rating**: [1-10] ⭐

**Would you recommend this site to others?** [Yes/No] [Why?]

---

**Test Completed**: [DATE & TIME]
**Tester**: [Name/Initials]
**Testing Environment**: [Browser/OS/Device]

EOF

    log_success "Test report template created at: $report_file"
    echo "$report_file"
}

run_lighthouse_audit() {
    local url=$1
    local audit_file="$REPORTS_DIR/lighthouse_${PERSONA}_${TIMESTAMP}.json"

    log_info "Running Lighthouse audit on $url..."

    if command -v npm &> /dev/null; then
        npm install -g lighthouse 2>/dev/null || true
    fi

    if command -v lighthouse &> /dev/null; then
        lighthouse "$url" --output=json --output-path="$audit_file" --quiet 2>/dev/null || {
            log_warning "Lighthouse audit skipped (npm/lighthouse not available)"
            return 1
        }
        log_success "Lighthouse audit saved: $audit_file"
    else
        log_warning "Lighthouse not installed. Skipping detailed performance audit."
        log_info "Install with: npm install -g lighthouse"
    fi
}

measure_page_speed() {
    local url=$1

    log_info "Measuring page load speed..."

    local start_time=$(date +%s%N | cut -b1-13)

    if command -v curl &> /dev/null; then
        curl -o /dev/null -s -w "Load Time: %{time_total}s\n" "$url"
    elif command -v wget &> /dev/null; then
        wget -O /dev/null -q "$url" 2>&1 | grep -oE '[0-9]+\.[0-9]+ seconds'
    else
        log_warning "curl or wget not found, skipping speed measurement"
    fi
}

create_master_report() {
    local master_file="$REPORTS_DIR/ANTIGRAVITY_TEST_RESULTS_${TIMESTAMP}.md"

    cat > "$master_file" << EOF
# Antigravity Comprehensive Test Results
## Beards & Bucks Marketplace

**Testing Date**: $(date +"%B %d, %Y")
**Testing Time**: $(date +"%H:%M:%S")
**Site URL**: $SITE_URL
**Test Results Directory**: $RESULTS_DIR

---

## 📊 Executive Summary

This report consolidates all Antigravity testing results from multiple personas and testing sessions.

### Test Coverage

- **Total Personas Tested**: [X]
- **Total Issues Found**: [X]
  - Critical: [X]
  - High: [X]
  - Medium: [X]
  - Low: [X]
- **Success Rate**: [X%]
- **Average Site Score**: [X/100]

---

## 🎭 Personas Tested

1. **Persona 1**: Sarah Chen - Serious Bowhunter Shopper [STATUS]
2. **Persona 2**: Marcus Williams - Casual Visitor [STATUS]
3. **Persona 3**: Jennifer Park - Budget-Conscious Beginner [STATUS]
4. **Persona 4**: Tom Johnson - Frustrated Tech-Savvy User [STATUS]
5. **Persona 5**: Angela Martinez - Platform Administrator [STATUS]
6. **Persona 6**: Alex Rodriguez - Competitive Marketplace Seller [STATUS]
7. **Persona 7**: David Thompson - Mobile-First User [STATUS]

---

## 📁 Test Results

All detailed persona reports are located in: \`persona_reports/\`

---

## 🐛 Top Issues Across All Tests

### Most Frequent Issues
1. [Issue 1] - Found in [X] personas
2. [Issue 2] - Found in [X] personas
3. [Issue 3] - Found in [X] personas

---

## 📸 Screenshots & Evidence

All screenshots are organized in: \`screenshots/\`

- Total Screenshots Captured: [X]
- Organization: \`[PERSONA]_[FEATURE]_[TIMESTAMP].png\`

---

## ✅ What's Working Well

- [Feature that consistently passed]
- [Positive user feedback]

---

## 🎯 Recommendations

### Priority 1 (Critical)
- [ ] Fix critical issues blocking functionality
- [ ] Fix 404 errors and broken links
- [ ] Fix checkout/payment issues

### Priority 2 (High)
- [ ] Improve page load times
- [ ] Fix mobile responsiveness issues
- [ ] Improve accessibility

### Priority 3 (Medium)
- [ ] Enhance UX/UI based on feedback
- [ ] Improve performance metrics
- [ ] Add missing features

---

## 📈 Performance Summary

### Average Load Times
- Homepage: [X seconds]
- Product Pages: [X seconds]
- Checkout: [X seconds]
- Admin Pages: [X seconds]

### Lighthouse Averages
- Performance: [X/100]
- Accessibility: [X/100]
- Best Practices: [X/100]
- SEO: [X/100]

---

## 🚀 Go-Live Readiness

### Requirements Met?
- [ ] No Critical Issues
- [ ] Page Load Times < 3 seconds
- [ ] Mobile Responsive
- [ ] HTTPS Enabled
- [ ] Accessibility Compliant
- [ ] SEO Optimized
- [ ] Forms Functional
- [ ] Checkout Complete
- [ ] No JavaScript Errors

**Status**: [READY / NOT READY]

---

## 📋 Next Steps

1. [ ] Review all findings with team
2. [ ] Prioritize issues for fixing
3. [ ] Create tickets for development
4. [ ] Re-test after fixes applied
5. [ ] Final sign-off for launch

---

**Generated**: $(date)
**Testing Framework**: Antigravity Comprehensive Prompt
**Platform**: Beards & Bucks Hunting Marketplace

EOF

    log_success "Master report template created: $master_file"
    echo "$master_file"
}

display_personas() {
    log_header "Available Personas"

    for i in "${!PERSONAS[@]}"; do
        echo -e "${CYAN}Persona $((i + 1))${NC}: ${PERSONAS[$i]}"
    done
    echo
}

interactive_mode() {
    log_header "Antigravity Comprehensive Testing Suite"

    display_personas

    read -p "Enter persona number (1-7) or press Enter for random: " persona_input

    if [ -z "$persona_input" ]; then
        PERSONA=0
    elif [ "$persona_input" -ge 1 ] && [ "$persona_input" -le 7 ]; then
        PERSONA=$persona_input
    else
        log_error "Invalid persona number. Using random assignment."
        PERSONA=0
    fi

    read -p "Run with headless mode (no screenshots)? (y/n): " headless_input
    if [ "$headless_input" = "y" ] || [ "$headless_input" = "Y" ]; then
        HEADLESS=true
    fi
}

run_test_session() {
    select_persona

    log_header "Starting Test Session - Persona #$PERSONA"

    log_info "Test environment:"
    echo "  Project Root: $PROJECT_ROOT"
    echo "  Site URL: $SITE_URL"
    echo "  Results Dir: $RESULTS_DIR"
    echo "  Screenshots Dir: $SCREENSHOTS_DIR"
    echo ""

    # Generate report template
    local report_template=$(generate_test_report_template "$PERSONA")
    log_success "Report template ready: $report_template"

    # Measure page speed
    measure_page_speed "$SITE_URL"

    # Run Lighthouse if available
    run_lighthouse_audit "$SITE_URL"

    log_header "Manual Testing Required"

    log_info "You must now manually test the site as the assigned persona:"
    echo "  Persona: $PERSONA_NAME"
    echo ""
    log_info "Follow the checklist in: ANTIGRAVITY_COMPREHENSIVE_PROMPT.md"
    echo ""
    log_warning "When you find issues, take screenshots:"
    echo "  Save to: $SCREENSHOTS_DIR"
    echo "  Naming: PERSONA_${PERSONA}_[FEATURE]_$(date +%Y_%m_%d_%H_%M_%S).png"
    echo ""
    log_success "Fill in your findings in: $report_template"
    echo ""

    # Wait for manual testing
    read -p "Press Enter when you've completed manual testing..."

    log_success "Test session completed for Persona #$PERSONA"
}

run_all_personas() {
    log_header "Running All Personas Sequentially"

    for i in {1..7}; do
        PERSONA=$i
        log_info "Running Persona $i of 7..."
        run_test_session

        if [ $i -lt 7 ]; then
            log_warning "Ready for next persona test. Press Enter to continue..."
            read
        fi
    done

    log_success "All persona tests completed!"
}

show_help() {
    cat << EOF
Antigravity Comprehensive Testing Suite

Usage: ./run_antigravity_test.sh [OPTIONS]

Options:
  --persona <1-7>    Run specific persona test (default: random)
  --headless         Run without taking screenshots
  --all              Run all 7 personas sequentially
  --help             Show this help message

Examples:
  ./run_antigravity_test.sh                    # Interactive mode
  ./run_antigravity_test.sh --persona 1        # Test as persona 1
  ./run_antigravity_test.sh --all              # Run all personas
  ./run_antigravity_test.sh --persona 2 --headless

EOF
}

################################################################################
# Main Entry Point
################################################################################

main() {
    # Parse arguments
    while [[ $# -gt 0 ]]; do
        case $1 in
            --persona)
                PERSONA="$2"
                shift 2
                ;;
            --headless)
                HEADLESS=true
                shift
                ;;
            --all)
                RUN_ALL=true
                shift
                ;;
            --help)
                show_help
                exit 0
                ;;
            *)
                log_error "Unknown option: $1"
                show_help
                exit 1
                ;;
        esac
    done

    # Setup
    setup_directories

    # Run tests
    if [ "$RUN_ALL" = true ]; then
        run_all_personas
    else
        if [ "$PERSONA" -eq 0 ] && [ -z "$1" ]; then
            # Interactive mode
            interactive_mode
        fi
        run_test_session
    fi

    # Generate master report
    log_info "Generating master report..."
    create_master_report

    log_header "Testing Complete"

    log_success "Results saved to: $RESULTS_DIR"
    log_success "Screenshots: $SCREENSHOTS_DIR"
    log_success "Reports: $REPORTS_DIR"
    echo ""
    log_info "Next steps:"
    echo "  1. Review findings in: $REPORTS_DIR"
    echo "  2. Check screenshots: $SCREENSHOTS_DIR"
    echo "  3. Create tickets for issues found"
    echo "  4. Re-test after fixes"
    echo ""
}

main "$@"
