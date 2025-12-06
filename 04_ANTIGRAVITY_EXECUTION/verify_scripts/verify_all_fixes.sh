#!/bin/bash

# Master Verification Script - Run All Fixes (1-6) in Parallel
# Purpose: Execute all 6 verification scripts and collect results
# Time: 2-3 minutes (parallel execution vs 15-20 minutes sequential)
# Run after: Antigravity completes all fixes

set -o pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOG_DIR="${SCRIPT_DIR}/../../logs"
VERIFY_LOG="${LOG_DIR}/verification_$(date +%Y%m%d_%H%M%S).log"

mkdir -p "${LOG_DIR}"

# Color codes
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

# ============================================================================
# Initialize Verification Run
# ============================================================================

{
    echo "==============================================="
    echo "Verification Run: $(date)"
    echo "==============================================="
    echo ""
} | tee -a "${VERIFY_LOG}"

# ============================================================================
# Run All Verification Scripts in Parallel
# ============================================================================

echo -e "${BLUE}Starting parallel verification of all 6 fixes...${NC}"
echo "Running all verifications in parallel for speed (2-3 minutes)..."
echo ""

# Store PIDs of background processes
declare -A PIDS
declare -A LOG_FILES

# Function to run verification script
run_verify_script() {
    local fix_num="$1"
    local script_name="verify_fix_${fix_num}*.sh"
    local script_file=$(ls "${SCRIPT_DIR}/${script_name}" 2>/dev/null | head -1)

    if [ ! -f "${script_file}" ]; then
        echo -e "${RED}ERROR: Verification script not found for Fix ${fix_num}${NC}"
        return 1
    fi

    local temp_log="/tmp/verify_fix_${fix_num}_$$.log"

    # Run in background and capture output
    bash "${script_file}" > "${temp_log}" 2>&1 &
    PIDS[$fix_num]=$!
    LOG_FILES[$fix_num]="${temp_log}"

    echo -e "${BLUE}[Fix ${fix_num}]${NC} Started (PID: ${PIDS[$fix_num]})"
}

# Launch all 6 verifications in parallel
for fix_num in 1 2 3 4 5 6; do
    run_verify_script ${fix_num}
done

echo ""
echo "Waiting for all verifications to complete..."
echo ""

# ============================================================================
# Wait for All Processes to Complete
# ============================================================================

declare -A RESULTS

for fix_num in 1 2 3 4 5 6; do
    if [ -z "${PIDS[$fix_num]}" ]; then
        RESULTS[$fix_num]="FAILED"
        continue
    fi

    wait ${PIDS[$fix_num]}
    RESULTS[$fix_num]=$?
done

# ============================================================================
# Collect and Display Results
# ============================================================================

echo ""
echo "==============================================="
echo "Verification Results"
echo "==============================================="
echo ""

TOTAL_PASSED=0
TOTAL_FAILED=0
TOTAL_PARTIAL=0

for fix_num in 1 2 3 4 5 6; do
    result=${RESULTS[$fix_num]}
    log_file=${LOG_FILES[$fix_num]}

    case ${result} in
        0)
            echo -e "${GREEN}✅ Fix ${fix_num}: PASSED${NC}"
            TOTAL_PASSED=$((TOTAL_PASSED + 1))
            ;;
        1)
            echo -e "${RED}❌ Fix ${fix_num}: FAILED${NC}"
            TOTAL_FAILED=$((TOTAL_FAILED + 1))
            ;;
        2)
            echo -e "${YELLOW}⚠️  Fix ${fix_num}: PARTIAL${NC}"
            TOTAL_PARTIAL=$((TOTAL_PARTIAL + 1))
            ;;
        *)
            echo -e "${RED}❌ Fix ${fix_num}: ERROR${NC}"
            TOTAL_FAILED=$((TOTAL_FAILED + 1))
            ;;
    esac

    # Show key details from log
    if [ -f "${log_file}" ]; then
        # Extract first PASSED/FAILED line
        grep -m1 "PASSED\|FAILED" "${log_file}" | sed 's/^/    /'
    fi
done

echo ""
echo "==============================================="
echo "Summary"
echo "==============================================="

echo "Passed:   ${TOTAL_PASSED}/6"
echo "Partial:  ${TOTAL_PARTIAL}/6"
echo "Failed:   ${TOTAL_FAILED}/6"
echo ""

# ============================================================================
# Detailed Log Output
# ============================================================================

echo "==============================================="
echo "Detailed Verification Logs"
echo "==============================================="
echo ""

for fix_num in 1 2 3 4 5 6; do
    log_file=${LOG_FILES[$fix_num]}

    if [ -f "${log_file}" ]; then
        echo ""
        echo "--- Fix ${fix_num} Details ---"
        cat "${log_file}"
        echo ""

        # Append to main log
        cat "${log_file}" >> "${VERIFY_LOG}"
    fi
done

# ============================================================================
# Final Summary and Exit Code
# ============================================================================

echo ""
echo "==============================================="
echo "Verification Complete: $(date)"
echo "==============================================="

if [ ${TOTAL_FAILED} -gt 0 ]; then
    echo -e "${RED}❌ VERIFICATION FAILED${NC}"
    echo "Log saved to: ${VERIFY_LOG}"

    # Cleanup temp logs
    for fix_num in 1 2 3 4 5 6; do
        rm -f "${LOG_FILES[$fix_num]}"
    done

    exit 1
elif [ ${TOTAL_PARTIAL} -gt 0 ]; then
    echo -e "${YELLOW}⚠️ VERIFICATION PARTIAL${NC}"
    echo "${TOTAL_PASSED}/6 fixes verified, ${TOTAL_PARTIAL} with issues"
    echo "Log saved to: ${VERIFY_LOG}"

    # Cleanup temp logs
    for fix_num in 1 2 3 4 5 6; do
        rm -f "${LOG_FILES[$fix_num]}"
    done

    exit 2
else
    echo -e "${GREEN}✅ ALL FIXES VERIFIED${NC}"
    echo "All 6 fixes are working correctly"
    echo "Log saved to: ${VERIFY_LOG}"

    # Cleanup temp logs
    for fix_num in 1 2 3 4 5 6; do
        rm -f "${LOG_FILES[$fix_num]}"
    done

    exit 0
fi
