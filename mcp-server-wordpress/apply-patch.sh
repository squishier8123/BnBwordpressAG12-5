#!/bin/bash

# Find and patch the @respira/wordpress-mcp-server package
# This works around the Promise.reject bug by patching the installed package

echo "Locating @respira/wordpress-mcp-server..."

# Check common npm cache locations
PACKAGE_LOCATIONS=(
  "$HOME/.npm/_cacache"
  "$HOME/.npm"
  "/tmp/npm-*"
  "/home/geoff25/.npm/_cacache"
)

# Try to find the actual installed location
FOUND_PATH=$(find ~/.npm -name "wordpress-client.js" 2>/dev/null | head -1)

if [ -z "$FOUND_PATH" ]; then
  # Try with npx to trigger installation and find it
  echo "Installing package via npx..."
  
  # Use npx to check location - this will install if needed
  PACKAGE_PATH=$(npx --yes -q @respira/wordpress-mcp-server 2>&1 | grep -o "/.*wordpress-client.js" | head -1)
fi

echo "Package path: $FOUND_PATH"

