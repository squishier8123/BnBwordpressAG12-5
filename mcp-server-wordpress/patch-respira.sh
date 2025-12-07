#!/bin/bash
echo "🔧 WordPress MCP Server Patch"
echo "============================="
echo ""

# Try to find the installed package
echo "Searching for @respira/wordpress-mcp-server..."

# First, install the package if not found
npx -y @respira/wordpress-mcp-server &>/dev/null &
NPXPID=$!

# Give it time to download and cache
sleep 5

# Now find it in the cache
CACHE_FILES=$(find ~/.npm -name "wordpress-client.js" 2>/dev/null)

if [ -z "$CACHE_FILES" ]; then
  echo "❌ Could not locate package in cache"
  kill $NPXPID 2>/dev/null || true
  exit 1
fi

echo "Found $(echo "$CACHE_FILES" | wc -l) instance(s)"
echo ""

# Kill the background process
kill $NPXPID 2>/dev/null || true

# Apply patch to all instances
for FILE in $CACHE_FILES; do
  echo "Patching: $FILE"

  if grep -q "Promise.reject(this.handleError(error))" "$FILE"; then
    echo "  ✓ Bug found, applying fix..."
    sed -i 's/Promise\.reject(this\.handleError(error))/Promise.reject(await this.handleError(error))/g' "$FILE"

    if grep -q "Promise.reject(await this.handleError(error))" "$FILE"; then
      echo "  ✓ Patch applied successfully!"
    else
      echo "  ✗ Patch failed!"
      exit 1
    fi
  elif grep -q "Promise.reject(await this.handleError(error))" "$FILE"; then
    echo "  ✓ Already patched!"
  else
    echo "  ⚠ Could not identify bug pattern"
  fi
  echo ""
done

echo "✅ Done! The WordPress MCP should now work correctly."
echo ""
echo "Test with: claude mcp list"
