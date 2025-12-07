# WordPress MCP Patch Scripts

This directory contains scripts to patch the WordPress MCP server and enable reliable AI-powered WordPress page editing.

## Overview

The WordPress MCP server requires a patch to handle authentication correctly when used with Claude Code. These scripts automate the patching process.

## Quick Start

**Primary Script**: `auto-patch-on-launch.sh`

This script should be called ONCE when setting up WordPress MCP in Claude Code:
```bash
bash mcp-server-wordpress/auto-patch-on-launch.sh
```

It will:
1. Check if the patch is needed
2. Apply the patch automatically
3. Run the WordPress MCP server with correct configuration

## Scripts Explained

### `auto-patch-on-launch.sh` (Recommended)
**Purpose**: Auto-detects and patches WordPress MCP on launch
**When to use**: First-time setup or when you get fresh WordPress MCP installation
**Command**: `bash auto-patch-on-launch.sh`

### `patch-respira.sh` (Alternative)
**Purpose**: Manual patch application
**When to use**: If auto-patch doesn't work
**Command**: `bash patch-respira.sh`

### `patch-and-run.js`
**Purpose**: Node.js version of patching script
**When to use**: If bash scripts don't work on your system
**Command**: `node patch-and-run.js`

### Other Scripts
- `test-patch.sh` — Verify patch was applied correctly
- `test-fixed.sh` — Test WordPress MCP after patching
- `apply-patch.sh` — Apply patch without running MCP

## What The Patch Does

The WordPress MCP authentication handler has a bug where it doesn't properly handle app passwords. The patch:

1. Fixes the authentication token validation
2. Enables proper communication with WordPress API
3. Allows Claude Code tools to read and modify WordPress pages
4. Enables safe AI editing via Respira integration

## Configuration

The patch reads credentials from:
- `WP_URL` environment variable (e.g., `https://beardsandbucks.com`)
- `WP_APP_USER` environment variable (e.g., `jeff`)
- `WP_APP_PASSWORD` environment variable (app-specific password from WordPress)

These are defined in `.mcp.json` in the `respira-wordpress` section.

## Troubleshooting

**Patch not applying?**
- Ensure npm is installed: `npm --version`
- Check that WordPress MCP is installed: `npm list -g @respira/wordpress-mcp-server`
- Try running with `bash -x patch-respira.sh` for debug output

**Authentication still failing?**
- Verify WP_URL in .mcp.json is correct
- Confirm app password is current (may need to regenerate in WordPress)
- Check that user account has API permissions enabled

**Script permission denied?**
- Make executable: `chmod +x auto-patch-on-launch.sh`
- Try with bash: `bash auto-patch-on-launch.sh` instead of `./auto-patch-on-launch.sh`

## How It Works Technically

1. **Locates WordPress MCP**: Finds installed package in npm global or local node_modules
2. **Applies Patch**: Modifies the authentication handler in wordpress-client.js
3. **Tests Connection**: Verifies WordPress API is accessible
4. **Starts MCP**: Launches the server with correct credentials

## Integration with Claude Code

Once patched, you can use WordPress MCP tools in Claude Code:
- Read WordPress pages
- Update WordPress page content
- Manage WordPress settings
- Edit with Elementor integration

See `../docs/WORDPRESS_EDITING_QUICK_START.md` for usage instructions.

## Rollback

If something goes wrong, rollback to original:
```bash
npm uninstall -g @respira/wordpress-mcp-server
npm install -g @respira/wordpress-mcp-server
```

Then run `auto-patch-on-launch.sh` again.

---

**Last Updated**: December 7, 2025
**Status**: Active
**Maintenance**: Required when WordPress MCP package is updated
