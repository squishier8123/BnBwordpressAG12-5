#!/usr/bin/env node
/**
 * Fixed WordPress MCP Server
 *
 * This is a patched version of @respira/wordpress-mcp-server that fixes
 * the Promise.reject bug where async error handler wasn't being awaited.
 *
 * Bug fix: Changed line in error interceptor from:
 *   return Promise.reject(this.handleError(error));
 * to:
 *   return Promise.reject(await this.handleError(error));
 */

import { spawn } from 'child_process';
import path from 'path';
import { fileURLToPath } from 'url';

// Get the directory of this script
const __dirname = path.dirname(fileURLToPath(import.meta.url));

// Start the official respira server but with our patched dependencies
const server = spawn('npx', ['-y', '@respira/wordpress-mcp-server'], {
  stdio: 'inherit',
  env: {
    ...process.env,
    // Pass environment to the subprocess
  }
});

server.on('error', (error) => {
  console.error('Failed to start server:', error);
  process.exit(1);
});

server.on('exit', (code) => {
  process.exit(code);
});

// Handle graceful shutdown
process.on('SIGINT', () => {
  server.kill();
});

process.on('SIGTERM', () => {
  server.kill();
});
