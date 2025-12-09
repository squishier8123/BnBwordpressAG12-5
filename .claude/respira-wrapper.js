#!/usr/bin/env node

/**
 * Respira MCP Server Wrapper
 * This wrapper fixes the async handling issue in Respira 1.6.1
 * by properly implementing the MCP protocol with correct tool calling
 */

const { spawn } = require('child_process');
const readline = require('readline');

let requestId = 0;
const pendingRequests = new Map();

// Start the actual Respira server
const respiraServer = spawn('npx', ['-y', '@respira/wordpress-mcp-server'], {
  stdio: ['pipe', 'pipe', 'pipe'],
  cwd: process.cwd()
});

// Setup readline for input
const rl = readline.createInterface({
  input: process.stdin,
  output: null
});

// Track if server is initialized
let isInitialized = false;

// Listen to Respira server output
respiraServer.stdout.on('data', (data) => {
  const lines = data.toString().split('\n').filter(l => l.trim());
  lines.forEach(line => {
    try {
      const json = JSON.parse(line);
      
      // Forward all responses
      console.log(JSON.stringify(json));
      
      // Mark as initialized after init response
      if (json.id === 0 && json.result?.serverInfo) {
        isInitialized = true;
      }
    } catch (e) {
      // Ignore non-JSON output
    }
  });
});

respiraServer.stderr.on('data', (data) => {
  // Suppress non-critical server messages
});

// Handle incoming messages
rl.on('line', (line) => {
  try {
    const message = JSON.parse(line);
    
    // Handle initialization
    if (message.method === 'initialize') {
      message.id = 0;
      respiraServer.stdin.write(JSON.stringify(message) + '\n');
      return;
    }
    
    // Handle tool calls - convert direct method calls to tools/call format
    if (message.method && message.method.startsWith('wordpress_')) {
      const toolName = message.method;
      const toolArgs = message.params || {};
      
      // Convert to proper tools/call format
      const toolCallMessage = {
        jsonrpc: message.jsonrpc || '2.0',
        id: message.id,
        method: 'tools/call',
        params: {
          name: toolName,
          arguments: toolArgs
        }
      };
      
      respiraServer.stdin.write(JSON.stringify(toolCallMessage) + '\n');
      return;
    }
    
    // Pass through other messages
    respiraServer.stdin.write(JSON.stringify(message) + '\n');
  } catch (e) {
    // Ignore invalid JSON
  }
});

// Handle process termination
process.on('SIGINT', () => {
  respiraServer.kill();
  process.exit(0);
});
