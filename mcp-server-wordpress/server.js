#!/usr/bin/env node
/**
 * Fixed WordPress MCP Server
 *
 * This server uses the patched wordpress-client.js that has the Promise bug fixed.
 * The bug was: Promise.reject(this.handleError(error))
 * The fix: Promise.reject(await this.handleError(error))
 */

import { Server } from '@modelcontextprotocol/sdk/server/index.js';
import { StdioServerTransport } from '@modelcontextprotocol/sdk/server/stdio.js';
import { CallToolRequestSchema, ListToolsRequestSchema } from '@modelcontextprotocol/sdk/types.js';
import { WordPressClient } from './wordpress-client.js';
import { loadConfig } from './config.js';

export class RespiraWordPressServer {
  server;
  currentSite = null;
  sites = new Map();

  constructor(siteConfigs) {
    this.server = new Server({
      name: 'respira-wordpress',
      version: '1.6.0',
    }, {
      capabilities: {
        tools: {},
      },
    });

    // Initialize WordPress clients for each site
    siteConfigs.forEach((config) => {
      const client = new WordPressClient(config);
      this.sites.set(config.id, client);
      if (config.default || this.currentSite === null) {
        this.currentSite = client;
      }
    });

    this.setupHandlers();
  }

  setupHandlers() {
    this.server.setRequestHandler(ListToolsRequestSchema, async () => {
      return {
        tools: this.getTools(),
      };
    });

    this.server.setRequestHandler(CallToolRequestSchema, async (request) => {
      const { name, arguments: args } = request.params;
      if (!this.currentSite) {
        throw new Error('No WordPress site configured');
      }
      try {
        const result = await this.handleToolCall(name, args || {});
        return {
          content: [
            {
              type: 'text',
              text: JSON.stringify(result, null, 2),
            },
          ],
        };
      } catch (error) {
        const errorMessage = error?.message || error?.toString() || String(error) || 'Unknown error';
        const errorStack = error?.stack ? `\n\nStack trace:\n${error.stack}` : '';
        return {
          content: [
            {
              type: 'text',
              text: `Error: ${errorMessage}${errorStack}`,
            },
          ],
          isError: true,
        };
      }
    });
  }

  getTools() {
    return [
      {
        name: 'wordpress_get_site_context',
        description: 'Get comprehensive information about the WordPress site including version, theme, plugins, custom post types, and page builder.',
        inputSchema: {
          type: 'object',
          properties: {},
        },
        readOnlyHint: true,
      },
      {
        name: 'wordpress_list_pages',
        description: 'List all pages with optional filtering.',
        inputSchema: {
          type: 'object',
          properties: {
            status: { type: 'string', description: 'Filter by status (publish, draft, pending)' },
            search: { type: 'string', description: 'Search term' },
            page: { type: 'number', description: 'Page number for pagination' },
            perPage: { type: 'number', description: 'Number of items per page' },
          },
        },
        readOnlyHint: true,
      },
      {
        name: 'wordpress_read_page',
        description: 'Get full content of a specific page including meta data and builder information.',
        inputSchema: {
          type: 'object',
          properties: {
            id: { type: 'number', description: 'Page ID' },
          },
          required: ['id'],
        },
        readOnlyHint: true,
      },
      {
        name: 'wordpress_update_page',
        description: 'Update a page.',
        inputSchema: {
          type: 'object',
          properties: {
            id: { type: 'number', description: 'Page ID' },
            title: { type: 'string', description: 'New page title' },
            content: { type: 'string', description: 'New page content (HTML)' },
            status: { type: 'string', description: 'Page status (publish, draft, pending)' },
          },
          required: ['id'],
        },
      },
    ];
  }

  async handleToolCall(name, args) {
    if (!this.currentSite) {
      throw new Error('No WordPress site configured');
    }

    switch (name) {
      case 'wordpress_get_site_context':
        return await this.currentSite.getSiteContext();
      case 'wordpress_list_pages':
        return await this.currentSite.listPages(args);
      case 'wordpress_read_page':
        return await this.currentSite.getPage(args.id);
      case 'wordpress_update_page':
        return await this.currentSite.updatePage(args.id, args);
      default:
        throw new Error(`Unknown tool: ${name}`);
    }
  }

  async run() {
    const transport = new StdioServerTransport();
    await this.server.connect(transport);
    console.error('Respira WordPress MCP Server (patched) running on stdio');
  }
}

async function main() {
  try {
    const config = loadConfig();
    const server = new RespiraWordPressServer(config.sites);
    await server.run();
  } catch (error) {
    const errorMessage = error?.message || error?.toString() || String(error) || 'Unknown error';
    console.error('Fatal error:', errorMessage);
    if (error?.stack) {
      console.error(error.stack);
    }
    process.exit(1);
  }
}

main();
