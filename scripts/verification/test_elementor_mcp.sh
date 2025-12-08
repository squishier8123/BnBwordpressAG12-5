#!/bin/bash
set -e

echo "=== ELEMENTOR MCP TEST SUITE ==="
echo ""

# Test 1: Check if elementor-mcp is installed
echo "1. Checking elementor-mcp installation..."
npm list -g elementor-mcp 2>&1 | head -3

# Test 2: Check MCP server connectivity
echo ""
echo "2. Checking Claude MCP list..."
claude mcp list

# Test 3: Check elementor-mcp version
echo ""
echo "3. Checking elementor-mcp version..."
npx elementor-mcp --version 2>&1 || echo "No --version flag available"

# Test 4: Test WordPress REST API directly
echo ""
echo "4. Testing WordPress REST API (Home 3 page)..."
curl -s -u "jeff:N0yN G2OM aRKT CZrm hIrq 88jG" \
  "https://beardsandbucks.com/wp-json/wp/v2/pages/4370?_fields=id,title,status,modified" \
  2>&1 | python3 -m json.tool | head -15

# Test 5: Check elementor-mcp environment variables
echo ""
echo "5. Checking environment configuration..."
echo "   WP_URL: $WP_URL"
echo "   WP_APP_USER: $WP_APP_USER"
echo "   WP_SITES_PATH: ${WP_SITES_PATH:-not set}"

# Test 6: Check if credentials file exists
echo ""
echo "6. Checking WordPress credentials..."
if [ -f ~/.wordpress/wp-sites.json ]; then
  echo "   ✓ ~/.wordpress/wp-sites.json exists"
  python3 -c "import json; sites=json.load(open('$HOME/.wordpress/wp-sites.json')); print('   Sites configured:', len(sites.get('sites', [])))" 2>/dev/null || echo "   Could not parse"
else
  echo "   ✗ ~/.wordpress/wp-sites.json NOT found"
fi

echo ""
echo "=== END OF TEST SUITE ==="
