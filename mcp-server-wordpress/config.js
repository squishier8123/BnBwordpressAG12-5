/**
 * Configuration management
 */
import { readFileSync, existsSync, writeFileSync, mkdirSync } from 'fs';
import { join } from 'path';
import { homedir } from 'os';
const CONFIG_DIR = join(homedir(), '.respira');
const CONFIG_FILE = join(CONFIG_DIR, 'config.json');
const DEFAULT_CONFIG = {
    sites: [],
    preferences: {
        autoDuplicate: true,
        securityChecks: true,
    },
};
/**
 * Load configuration from file
 */
export function loadConfig() {
    if (!existsSync(CONFIG_FILE)) {
        console.error('No configuration file found. Creating default configuration...');
        console.error(`Please edit ${CONFIG_FILE} to add your WordPress sites.`);
        // Create directory if it doesn't exist
        if (!existsSync(CONFIG_DIR)) {
            mkdirSync(CONFIG_DIR, { recursive: true });
        }
        // Create default config
        const exampleConfig = {
            sites: [
                {
                    id: 'example-site',
                    name: 'My WordPress Site',
                    url: 'https://example.com',
                    apiKey: 'respira_your-api-key-here',
                    default: true,
                },
            ],
            preferences: {
                autoDuplicate: true,
                securityChecks: true,
            },
        };
        saveConfig(exampleConfig);
        throw new Error(`Configuration file created at ${CONFIG_FILE}\n` +
            'Please update it with your WordPress site URL and API key, then run again.');
    }
    try {
        const configData = readFileSync(CONFIG_FILE, 'utf-8');
        const config = JSON.parse(configData);
        // Validate configuration
        if (!config.sites || config.sites.length === 0) {
            throw new Error('No WordPress sites configured in config.json');
        }
        // Validate each site
        config.sites.forEach((site, index) => {
            if (!site.id || !site.name || !site.url || !site.apiKey) {
                throw new Error(`Site ${index + 1} is missing required fields (id, name, url, apiKey)`);
            }
            if (!site.apiKey.startsWith('respira_')) {
                console.warn(`Warning: API key for "${site.name}" doesn't start with "respira_" prefix`);
            }
            // Validate and fix URL
            let fixedUrl = site.url.trim();
            let urlFixed = false;
            // Fix duplicate protocols (https://https://, http://http://, etc.)
            if (fixedUrl.match(/^(https?:\/\/)+/i)) {
                fixedUrl = fixedUrl.replace(/^(https?:\/\/)+/i, 'https://');
                urlFixed = true;
            }
            // Fix mixed protocols (http://https://, https://http://)
            if (fixedUrl.match(/^http:\/\/https:\/\//i)) {
                fixedUrl = fixedUrl.replace(/^http:\/\/https:\/\//i, 'https://');
                urlFixed = true;
            }
            if (fixedUrl.match(/^https:\/\/http:\/\//i)) {
                fixedUrl = fixedUrl.replace(/^https:\/\/http:\/\//i, 'https://');
                urlFixed = true;
            }
            // Fix malformed protocols (https//, http//)
            if (fixedUrl.match(/^(https?)\/\//i)) {
                fixedUrl = fixedUrl.replace(/^(https?)\/\//i, '$1://');
                urlFixed = true;
            }
            // Fix triple slashes (https:///example.com)
            if (fixedUrl.match(/^(https?:\/\/)\//)) {
                fixedUrl = fixedUrl.replace(/^(https?:\/\/)\//, '$1');
                urlFixed = true;
            }
            // Remove multiple consecutive slashes (except after protocol)
            // Split by protocol, fix slashes in path, then rejoin
            const protocolMatch = fixedUrl.match(/^(https?:\/\/)(.*)$/i);
            if (protocolMatch) {
                const protocol = protocolMatch[1];
                const path = protocolMatch[2];
                const fixedPath = path.replace(/\/+/g, '/');
                fixedUrl = protocol + fixedPath;
                if (path !== fixedPath) {
                    urlFixed = true;
                }
            }
            // Validate URL format
            try {
                // Add protocol if missing
                if (!fixedUrl.match(/^https?:\/\//i)) {
                    fixedUrl = `https://${fixedUrl}`;
                    urlFixed = true;
                }
                const urlObj = new URL(fixedUrl);
                // Ensure protocol is http or https
                if (urlObj.protocol !== 'http:' && urlObj.protocol !== 'https:') {
                    throw new Error(`Site ${index + 1} ("${site.name}") has invalid URL protocol: ${urlObj.protocol}`);
                }
                // Validate hostname
                if (!urlObj.hostname || urlObj.hostname.length === 0) {
                    throw new Error(`Site ${index + 1} ("${site.name}") has invalid hostname`);
                }
                // Remove default ports
                if (urlObj.port === '80' && urlObj.protocol === 'http:') {
                    urlObj.port = '';
                }
                if (urlObj.port === '443' && urlObj.protocol === 'https:') {
                    urlObj.port = '';
                }
                // Update site URL if it was fixed
                if (urlFixed) {
                    const normalizedUrl = urlObj.toString().replace(/\/$/, '');
                    console.warn(`Warning: Site "${site.name}" had malformed URL: ${site.url}`);
                    console.warn(`  Auto-fixed to: ${normalizedUrl}`);
                    site.url = normalizedUrl;
                    // Save fixed config back
                    saveConfig(config);
                }
            }
            catch (e) {
                if (e instanceof TypeError && e.message.includes('Invalid URL')) {
                    throw new Error(`Site ${index + 1} ("${site.name}") has invalid URL: ${site.url}`);
                }
                throw e;
            }
        });
        return config;
    }
    catch (error) {
        if (error.code === 'ENOENT') {
            return DEFAULT_CONFIG;
        }
        if (error instanceof SyntaxError) {
            throw new Error(`Invalid JSON in config file: ${CONFIG_FILE}\n${error.message}`);
        }
        const errorMessage = error?.message || error?.toString() || 'Unknown error';
        throw new Error(`Failed to load configuration from ${CONFIG_FILE}: ${errorMessage}`);
    }
}
/**
 * Save configuration to file
 */
export function saveConfig(config) {
    try {
        if (!existsSync(CONFIG_DIR)) {
            mkdirSync(CONFIG_DIR, { recursive: true });
        }
        writeFileSync(CONFIG_FILE, JSON.stringify(config, null, 2));
        console.error(`Configuration saved to ${CONFIG_FILE}`);
    }
    catch (error) {
        throw new Error(`Failed to save configuration: ${error.message}`);
    }
}
/**
 * Add a new site to configuration
 */
export function addSite(site) {
    const config = loadConfig();
    // Check for duplicate ID
    if (config.sites.some((s) => s.id === site.id)) {
        throw new Error(`Site with ID "${site.id}" already exists`);
    }
    // If this is the first site, make it default
    if (config.sites.length === 0) {
        site.default = true;
    }
    config.sites.push(site);
    saveConfig(config);
}
/**
 * Remove a site from configuration
 */
export function removeSite(siteId) {
    const config = loadConfig();
    const index = config.sites.findIndex((s) => s.id === siteId);
    if (index === -1) {
        throw new Error(`Site with ID "${siteId}" not found`);
    }
    config.sites.splice(index, 1);
    // If we removed the default site, make the first site default
    if (config.sites.length > 0 && !config.sites.some((s) => s.default)) {
        config.sites[0].default = true;
    }
    saveConfig(config);
}
/**
 * Set default site
 */
export function setDefaultSite(siteId) {
    const config = loadConfig();
    const site = config.sites.find((s) => s.id === siteId);
    if (!site) {
        throw new Error(`Site with ID "${siteId}" not found`);
    }
    // Remove default from all sites
    config.sites.forEach((s) => {
        s.default = false;
    });
    // Set new default
    site.default = true;
    saveConfig(config);
}
/**
 * Test connection to a WordPress site
 */
export async function testConnection(siteId) {
    const config = loadConfig();
    const site = config.sites.find((s) => s.id === siteId);
    if (!site) {
        throw new Error(`Site with ID "${siteId}" not found`);
    }
    const { WordPressClient } = await import('./wordpress-client.js');
    const client = new WordPressClient(site);
    try {
        const context = await client.getSiteContext();
        console.log(`✓ Connected to ${site.name}`);
        console.log(`  WordPress: ${context.wordpress_version}`);
        console.log(`  PHP: ${context.php_version}`);
        console.log(`  Theme: ${context.active_theme.name}`);
    }
    catch (error) {
        throw new Error(`Connection test failed: ${error.message}`);
    }
}
//# sourceMappingURL=config.js.map