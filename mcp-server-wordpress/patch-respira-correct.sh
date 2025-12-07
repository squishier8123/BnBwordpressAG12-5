#!/bin/bash
echo "🔧 WordPress MCP Server Patch (Corrected)"
echo "=========================================="
echo ""

# Find the patched file
CACHE_FILES=$(find ~/.npm -name "wordpress-client.js" 2>/dev/null)

if [ -z "$CACHE_FILES" ]; then
  echo "❌ Could not locate package in cache"
  exit 1
fi

for FILE in $CACHE_FILES; do
  echo "Patching: $FILE"

  # Fix 1: Make the error interceptor callback async
  sed -i 's/}, (error) => {/}, async (error) => {/g' "$FILE"

  # Fix 2: Add await before handleError
  sed -i 's/return Promise.reject(this.handleError(error));/return Promise.reject(await this.handleError(error));/g' "$FILE"

  # Verify the fix
  if grep -q "async (error) => {" "$FILE" && grep -q "Promise.reject(await this.handleError(error))" "$FILE"; then
    echo "  ✓ Patch applied successfully!"
  else
    echo "  ✗ Patch verification failed!"
    exit 1
  fi
  echo ""
done

echo "✅ Done! The WordPress MCP should now work correctly."
