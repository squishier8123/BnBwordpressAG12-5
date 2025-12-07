#!/bin/bash
#
# Patch the @respira/wordpress-mcp-server package to fix the Promise bug
#
# This script finds the installed package and applies a patch that fixes:
# - Promise.reject(this.handleError(error)) -> Promise.reject(await this.handleError(error))
#

set -e

echo "🔧 WordPress MCP Server Patch Tool"
echo "===================================="
echo ""
echo "This script patches the @respira/wordpress-mcp-server package"
echo "to fix a bug where async errors aren't properly awaited."
echo ""

# Function to find the wordpress-client.js file
find_client_file() {
  # First try the npm cache
  if [ -d "$HOME/.npm/_cacache" ]; then
    find "$HOME/.npm/_cacache" -name "wordpress-client.js" 2>/dev/null | head -1
  fi

  # Try node_modules if project is set up
  if [ -f "node_modules/@respira/wordpress-mcp-server/dist/wordpress-client.js" ]; then
    echo "node_modules/@respira/wordpress-mcp-server/dist/wordpress-client.js"
    return
  fi

  # Try to find in /tmp (where npx caches things)
  find /tmp -name "wordpress-client.js" 2>/dev/null | grep respira | head -1
}

CLIENT_FILE=$(find_client_file)

if [ -z "$CLIENT_FILE" ]; then
  echo "❌ Could not find installed @respira/wordpress-mcp-server"
  echo ""
  echo "The package will be installed when you first run the MCP server."
  echo "After that, run this script again to apply the patch."
  exit 0
fi

echo "📍 Found package at: $CLIENT_FILE"
echo ""

# Check if the bug is present
if grep -q "Promise.reject(this.handleError(error))" "$CLIENT_FILE"; then
  echo "⚠️  Bug detected - applying patch..."

  # Create a backup
  BACKUP="${CLIENT_FILE}.backup"
  cp "$CLIENT_FILE" "$BACKUP"
  echo "   Backup saved to: $BACKUP"

  # Apply the fix
  sed -i 's/Promise\.reject(this\.handleError(error))/Promise.reject(await this.handleError(error))/g' "$CLIENT_FILE"

  echo "✅ Patch applied successfully!"
  echo ""
  echo "The WordPress MCP server should now work correctly."

elif grep -q "Promise.reject(await this.handleError(error))" "$CLIENT_FILE"; then
  echo "✅ Package is already patched!"

else
  echo "⚠️  Could not identify the exact bug pattern."
  echo "   The patch may need manual intervention."
  exit 1
fi

echo ""
echo "To test the fix, run:"
echo "  claude mcp list"
echo ""
