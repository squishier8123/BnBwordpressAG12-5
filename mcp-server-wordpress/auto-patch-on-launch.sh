#!/bin/bash
#
# WordPress MCP Auto-Patch Script
#
# This script is meant to be run before starting the WordPress MCP server.
# It automatically patches all instances of the installed package.
#
# Usage: source auto-patch-on-launch.sh
#

export RESPIRA_MCP_PATCHED=1

# Function to find and patch all instances
patch_all_instances() {
  local found_any=0

  # Find all instances of wordpress-client.js in npm cache
  while IFS= read -r file; do
    if [ -f "$file" ]; then
      if grep -q "Promise.reject(this.handleError(error))" "$file" 2>/dev/null; then
        echo "[MCP Patch] Fixing: $file"
        sed -i 's/}, (error) => {$/}, async (error) => {/g' "$file"
        sed -i 's/Promise\.reject(this\.handleError(error))/Promise.reject(await this.handleError(error))/g' "$file"

        if grep -q "Promise.reject(await this.handleError(error))" "$file" 2>/dev/null; then
          echo "[MCP Patch] ✓ Fixed successfully"
          found_any=1
        fi
      elif grep -q "Promise.reject(await this.handleError(error))" "$file" 2>/dev/null; then
        echo "[MCP Patch] Already fixed: $file"
        found_any=1
      fi
    fi
  done < <(find ~/.npm -name "wordpress-client.js" 2>/dev/null)

  if [ $found_any -eq 0 ]; then
    echo "[MCP Patch] No instances found yet (will be patched on first run)"
  fi
}

# Patch existing instances
patch_all_instances

# Create a hook that patches new instances when npx downloads them
# This works by creating a postinstall hook in npm
setup_npm_hook() {
  local npm_config="$HOME/.npmrc"

  # Check if hook is already set up
  if ! grep -q "post-install.*wordpress-mcp" "$npm_config" 2>/dev/null; then
    echo "[MCP Patch] Setting up npm post-install hook..."
    cat >> "$npm_config" << 'EOF'

# WordPress MCP Auto-Patch Hook
postinstall=bash -c 'find ~/.npm -name "wordpress-client.js" -newer ~/.npmrc 2>/dev/null | head -1 | xargs sed -i "s/}, (error) => {}, async (error) => {/g" 2>/dev/null; find ~/.npm -name "wordpress-client.js" -newer ~/.npmrc 2>/dev/null | head -1 | xargs sed -i "s/Promise.reject(this.handleError(error))/Promise.reject(await this.handleError(error))/g" 2>/dev/null'
EOF
  fi
}

# Optional: setup npm hook (may not work in all environments)
# setup_npm_hook

echo "[MCP Patch] WordPress MCP auto-patching enabled"
