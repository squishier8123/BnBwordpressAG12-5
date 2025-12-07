#!/bin/bash

echo "=== Testing Fixed WordPress MCP Server ==="
echo ""

(
  echo '{"jsonrpc":"2.0","id":1,"method":"initialize","params":{"protocolVersion":"2024-11-05","capabilities":{},"clientInfo":{"name":"claude-code","version":"1.0"}}}'
  sleep 0.5
  echo '{"jsonrpc":"2.0","id":2,"method":"tools/list","params":{}}'
  sleep 0.5
  echo '{"jsonrpc":"2.0","id":3,"method":"tools/call","params":{"name":"wordpress_get_site_context","arguments":{}}}'
  sleep 2
) | node server.js 2>&1

