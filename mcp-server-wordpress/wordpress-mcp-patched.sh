#!/bin/bash
#
# WordPress MCP Server Wrapper with Auto-Patch
#
# This script downloads the WordPress MCP server, patches the Promise bug,
# and runs it. It's meant to be used in place of:
#   npx -y @respira/wordpress-mcp-server
#

# Clean up old instances to force fresh download
#rm -rf ~/.npm/_npx 2>/dev/null || true

# Download and run the server in the background, capturing its startup
(npx -y @respira/wordpress-mcp-server &) &
NPXPID=$!

# Give it time to download
sleep 3

# Find the newly downloaded instance
LATEST_FILE=$(find ~/.npm -name "wordpress-client.js" -type f -printf '%T@ %p\n' 2>/dev/null | sort -rn | head -1 | cut -d' ' -f2-)

if [ -n "$LATEST_FILE" ] && [ -f "$LATEST_FILE" ]; then
  echo "Found WordPress MCP at: $LATEST_FILE" >&2

  # Apply the patch
  if grep -q "Promise.reject(this.handleError(error))" "$LATEST_FILE"; then
    echo "Applying Promise fix..." >&2

    # Make error handler async
    sed -i 's/}, (error) => {$/}, async (error) => {/g' "$LATEST_FILE"

    # Add await before handleError
    sed -i 's/Promise\.reject(this\.handleError(error))/Promise.reject(await this.handleError(error))/g' "$LATEST_FILE"

    if grep -q "Promise.reject(await this.handleError(error))" "$LATEST_FILE"; then
      echo "✓ Patch applied" >&2
    else
      echo "✗ Patch failed" >&2
    fi
  fi
fi

# Wait for background process
wait $NPXPID
