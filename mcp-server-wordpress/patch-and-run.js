#!/usr/bin/env node
/**
 * WordPress MCP Server with Bug Fix
 *
 * This script applies a runtime patch to the @respira/wordpress-mcp-server
 * before running it, fixing the Promise.reject bug in the error handler.
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import { createRequire } from 'module';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const require = createRequire(import.meta.url);

// Find the installed @respira/wordpress-mcp-server package
let packagePath;
try {
  packagePath = path.dirname(require.resolve('@respira/wordpress-mcp-server/package.json'));
} catch (e) {
  console.error('Error: Could not find @respira/wordpress-mcp-server package');
  console.error('Make sure it is installed with: npm install @respira/wordpress-mcp-server');
  process.exit(1);
}

const clientPath = path.join(packagePath, 'dist', 'wordpress-client.js');

// Read the original file
let content;
try {
  content = fs.readFileSync(clientPath, 'utf8');
} catch (e) {
  console.error('Error: Could not read wordpress-client.js:', e.message);
  process.exit(1);
}

// Check if the bug is present
const bugPattern = 'return Promise.reject(this.handleError(error))';
const fixedPattern = 'return Promise.reject(await this.handleError(error))';

if (!content.includes(bugPattern)) {
  if (content.includes(fixedPattern)) {
    console.log('✓ WordPress MCP is already patched');
  } else {
    console.warn('⚠ Warning: Could not identify the exact bug pattern. The patch may not apply correctly.');
  }
} else {
  console.log('🔧 Applying WordPress MCP Promise bug fix...');

  // Apply the fix
  const patched = content.replace(bugPattern, fixedPattern);

  // Write the patched file
  try {
    fs.writeFileSync(clientPath, patched, 'utf8');
    console.log('✓ Fix applied successfully');
  } catch (e) {
    console.error('Error: Could not write patched file:', e.message);
    process.exit(1);
  }
}

// Now run the actual MCP server
console.log('Starting WordPress MCP Server...\n');

// Import and run the server
try {
  const { RespiraWordPressServer } = await import('@respira/wordpress-mcp-server/dist/server.js');
  const { loadConfig } = await import('@respira/wordpress-mcp-server/dist/config.js');

  const config = loadConfig();
  const server = new RespiraWordPressServer(config.sites);
  await server.run();
} catch (error) {
  console.error('Fatal error:', error.message);
  if (error.stack) {
    console.error(error.stack);
  }
  process.exit(1);
}
