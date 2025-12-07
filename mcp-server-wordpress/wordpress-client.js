/**
 * WordPress API Client
 *
 * Handles all HTTP requests to WordPress REST API
 */
import axios from 'axios';
import FormData from 'form-data';
export class WordPressClient {
    client;
    siteConfig;
    constructor(siteConfig) {
        this.siteConfig = siteConfig;
        this.client = axios.create({
            baseURL: `${siteConfig.url}/wp-json/respira/v1`,
            headers: {
                'X-Respira-API-Key': siteConfig.apiKey,
                'Content-Type': 'application/json',
            },
            timeout: 30000,
        });
        // Add response interceptor for error handling
        this.client.interceptors.response.use((response) => response, async (error) => {
            return Promise.reject(await this.handleError(error));
        });
    }
    /**
     * Handle API errors with retry logic and format error messages with instructions
     */
    async handleError(error) {
        if (error.response) {
            const status = error.response.status;
            const data = error.response.data;
            // Handle specific error codes
            if (status === 401) {
                return new Error(`Authentication failed: Invalid API key`);
            }
            else if (status === 429) {
                return new Error(`Rate limit exceeded. Please wait before making more requests.`);
            }
            else if (status === 403) {
                // Format error with instructions if available
                return this.formatErrorWithInstructions(data);
            }
            else if (status >= 500) {
                return new Error(`WordPress server error (${status}): ${data.message || 'Internal server error'}`);
            }
            // Check if error has instructions data
            if (data.data && (data.data.instructions || data.data.links)) {
                return this.formatErrorWithInstructions(data);
            }
            return new Error(`API error (${status}): ${data.message || error.message}`);
        }
        else if (error.request) {
            return new Error(`Network error: Could not connect to WordPress site at ${this.siteConfig.url}`);
        }
        return new Error(`Unknown error: ${error.message}`);
    }
    /**
     * Format error message with instructions and links
     */
    formatErrorWithInstructions(data) {
        const message = data.message || 'Permission denied';
        const errorData = data.data || {};
        const instructions = errorData.instructions || {};
        const links = errorData.links || {};
        const duplicateId = errorData.duplicate_id;
        const originalId = errorData.original_id;
        let formattedMessage = `${message}\n\n`;
        // Add instructions
        if (Object.keys(instructions).length > 0) {
            formattedMessage += 'Instructions:\n';
            Object.values(instructions).forEach((instruction) => {
                formattedMessage += `• ${instruction}\n`;
            });
            formattedMessage += '\n';
        }
        // Add links
        if (Object.keys(links).length > 0) {
            formattedMessage += 'Links:\n';
            if (links.edit_duplicate && duplicateId) {
                formattedMessage += `• Edit Duplicate (ID: ${duplicateId}): ${links.edit_duplicate}\n`;
            }
            if (links.duplicate_endpoint && originalId) {
                formattedMessage += `• Create Duplicate: ${links.duplicate_endpoint}\n`;
            }
            if (links.approvals_page) {
                formattedMessage += `• Approvals Page: ${links.approvals_page}\n`;
            }
            if (links.settings_page) {
                formattedMessage += `• Settings: ${links.settings_page}\n`;
            }
            formattedMessage += '\n';
        }
        // Add helpful note if duplicate exists
        if (duplicateId) {
            formattedMessage += `Note: A duplicate already exists (ID: ${duplicateId}). You can edit it directly or approve it in WordPress admin.\n`;
        }
        else if (originalId) {
            formattedMessage += `Note: Create a duplicate of page/post ID ${originalId} first, then edit the duplicate.\n`;
        }
        return new Error(formattedMessage.trim());
    }
    /**
     * Get site context information
     */
    async getSiteContext() {
        const response = await this.client.get('/context/site-info');
        return response.data;
    }
    /**
     * Get theme documentation
     */
    async getThemeDocs() {
        const response = await this.client.get('/context/theme-docs');
        return response.data;
    }
    /**
     * Get page builder information
     */
    async getBuilderInfo() {
        const response = await this.client.get('/context/builder-info');
        return response.data;
    }
    /**
     * List pages
     */
    async listPages(filters) {
        const response = await this.client.get('/pages', { params: filters });
        return response.data;
    }
    /**
     * Get a single page
     */
    async getPage(id) {
        const response = await this.client.get(`/pages/${id}`);
        return response.data;
    }
    /**
     * Duplicate a page
     */
    async duplicatePage(id, suffix) {
        const response = await this.client.post(`/pages/${id}/duplicate`, { suffix });
        return response.data.duplicate;
    }
    /**
     * Update a page
     */
    async updatePage(id, data) {
        // Try PUT first, fall back to POST for compatibility
        let response;
        try {
            response = await this.client.put(`/pages/${id}`, data);
        }
        catch (error) {
            // If PUT fails with 404, try POST (for compatibility)
            if (error.response?.status === 404) {
                response = await this.client.post(`/pages/${id}`, data);
            }
            else {
                throw error;
            }
        }
        // Check if duplicate was created and format message accordingly
        if (response.data.duplicate_created) {
            const duplicateId = response.data.duplicate_id;
            const originalId = response.data.original_id;
            const approvalUrl = response.data.approval_url;
            // The message is already formatted by Respira, but we can add context
            const respiraMessage = response.data.message || '';
            const instructions = response.data.instructions || [];
            // Return the page data but note that it's a duplicate
            const page = response.data.page;
            if (page) {
                page.__respira_duplicate_info = {
                    duplicate_created: true,
                    duplicate_id: duplicateId,
                    original_id: originalId,
                    approval_url: approvalUrl,
                    message: respiraMessage,
                    instructions: instructions,
                };
            }
        }
        return response.data.page;
    }
    /**
     * Delete a page
     */
    async deletePage(id, force) {
        await this.client.delete(`/pages/${id}`, { params: { force } });
    }
    /**
     * List posts
     */
    async listPosts(filters) {
        const response = await this.client.get('/posts', { params: filters });
        return response.data;
    }
    /**
     * Get a single post
     */
    async getPost(id) {
        const response = await this.client.get(`/posts/${id}`);
        return response.data;
    }
    /**
     * Duplicate a post
     */
    async duplicatePost(id, suffix) {
        const response = await this.client.post(`/posts/${id}/duplicate`, { suffix });
        return response.data.duplicate;
    }
    /**
     * Update a post
     */
    async updatePost(id, data) {
        // Try PUT first, fall back to POST for compatibility
        let response;
        try {
            response = await this.client.put(`/posts/${id}`, data);
        }
        catch (error) {
            // If PUT fails with 404, try POST (for compatibility)
            if (error.response?.status === 404) {
                response = await this.client.post(`/posts/${id}`, data);
            }
            else {
                throw error;
            }
        }
        // Check if duplicate was created and format message accordingly
        if (response.data.duplicate_created) {
            const duplicateId = response.data.duplicate_id;
            const originalId = response.data.original_id;
            const approvalUrl = response.data.approval_url;
            // The message is already formatted by Respira, but we can add context
            const respiraMessage = response.data.message || '';
            const instructions = response.data.instructions || [];
            // Return the post data but note that it's a duplicate
            const post = response.data.post;
            if (post) {
                post.__respira_duplicate_info = {
                    duplicate_created: true,
                    duplicate_id: duplicateId,
                    original_id: originalId,
                    approval_url: approvalUrl,
                    message: respiraMessage,
                    instructions: instructions,
                };
            }
        }
        return response.data.post;
    }
    /**
     * Delete a post
     */
    async deletePost(id, force) {
        await this.client.delete(`/posts/${id}`, { params: { force } });
    }
    /**
     * List media
     */
    async listMedia(filters) {
        const response = await this.client.get('/media', { params: filters });
        return response.data;
    }
    /**
     * Upload media
     * Supports base64 strings, file URLs, or Buffer objects
     */
    async uploadMedia(file, filename, mimeType, title, alt, caption) {
        let fileBuffer;
        let detectedMimeType = mimeType || 'application/octet-stream';
        // Handle different input types
        if (typeof file === 'string') {
            // Check if it's a base64 string
            if (file.startsWith('data:')) {
                // Data URL format: data:image/png;base64,...
                const matches = file.match(/^data:([^;]+);base64,(.+)$/);
                if (matches) {
                    detectedMimeType = matches[1];
                    fileBuffer = Buffer.from(matches[2], 'base64');
                }
                else {
                    throw new Error('Invalid data URL format');
                }
            }
            else if (file.startsWith('http://') || file.startsWith('https://')) {
                // URL - download the file
                const response = await axios.get(file, { responseType: 'arraybuffer' });
                fileBuffer = Buffer.from(response.data);
                // Try to detect MIME type from URL or response headers
                if (!mimeType && response.headers['content-type']) {
                    detectedMimeType = response.headers['content-type'];
                }
            }
            else {
                // Assume it's a base64 string without data URL prefix
                fileBuffer = Buffer.from(file, 'base64');
            }
        }
        else {
            // It's already a Buffer
            fileBuffer = file;
        }
        // Create FormData
        const formData = new FormData();
        formData.append('file', fileBuffer, {
            filename,
            contentType: detectedMimeType,
        });
        // Add optional metadata
        if (title) {
            formData.append('title', title);
        }
        if (alt) {
            formData.append('alt', alt);
        }
        if (caption) {
            formData.append('caption', caption);
        }
        const response = await this.client.post('/media/upload', formData, {
            headers: {
                ...formData.getHeaders(),
            },
        });
        return response.data.media || response.data;
    }
    /**
     * Extract page builder content
     */
    async extractBuilderContent(builder, pageId) {
        try {
            // Make request directly to bypass interceptor and preserve error response data
            const response = await axios.get(`${this.siteConfig.url}/wp-json/respira/v1/builder/${builder}/extract/${pageId}`, {
                headers: {
                    'X-Respira-API-Key': this.siteConfig.apiKey,
                    'Content-Type': 'application/json',
                },
                timeout: 30000,
            });
            // Return full response including diagnostics, warnings, and success status
            return {
                content: response.data.content || [],
                diagnostics: response.data.diagnostics || null,
                warning: response.data.warning || null,
                success: response.data.success !== false,
                builder: response.data.builder || builder,
            };
        }
        catch (error) {
            // Extract diagnostics from error response (before interceptor processes it)
            if (error.response && error.response.data) {
                const errorData = error.response.data;
                // WordPress WP_Error structure: { code, message, data: { ... } }
                // Check if error response contains diagnostics in data
                const diagnostics = errorData.data?.diagnostics || errorData.diagnostics || null;
                return {
                    content: [],
                    diagnostics: diagnostics,
                    warning: errorData.message || errorData.data?.message || 'Extraction failed',
                    success: false,
                    builder: builder,
                    error: true,
                    errorCode: errorData.code || 'extraction_failed',
                    errorData: errorData.data || errorData,
                    status: error.response.status,
                };
            }
            // If no response data, return error info
            const errorMessage = error?.message || String(error);
            return {
                content: [],
                diagnostics: null,
                warning: errorMessage,
                success: false,
                builder: builder,
                error: true,
                errorCode: 'unknown_error',
            };
        }
    }
    /**
     * Inject page builder content
     */
    async injectBuilderContent(builder, pageId, content) {
        const response = await this.client.post(`/builder/${builder}/inject/${pageId}`, { content });
        return response.data;
    }
    /**
     * Update a specific module in a page builder page
     */
    async updateModule(builder, pageId, moduleIdentifier, updates) {
        try {
            // Increase timeout for large content updates
            const timeout = updates.content && updates.content.length > 50000
                ? 60000 // 60 seconds for large content
                : 30000; // 30 seconds default
            const response = await this.client.put(`/builder/${builder}/modules/${pageId}`, {
                module_identifier: moduleIdentifier,
                updates,
            }, { timeout });
            return response.data;
        }
        catch (error) {
            // Extract detailed error information
            if (error.response?.data) {
                const errorData = error.response.data;
                const errorMessage = errorData.message || errorData.error || 'Module update failed';
                const diagnostics = errorData.data?.diagnostics || errorData.diagnostics || {};
                // Build comprehensive error message
                let fullMessage = errorMessage;
                if (diagnostics.content_length) {
                    fullMessage += ` (Content size: ${diagnostics.content_length} bytes)`;
                }
                if (diagnostics.suggestion) {
                    fullMessage += ` - ${diagnostics.suggestion}`;
                }
                throw new Error(fullMessage);
            }
            throw error;
        }
    }
    /**
     * Validate content security
     */
    async validateSecurity(content) {
        const response = await this.client.post('/validate/security', { content });
        return response.data;
    }
    /**
     * Get site name (for logging)
     */
    getSiteName() {
        return this.siteConfig.name;
    }
    /**
     * Get site URL
     */
    getSiteUrl() {
        return this.siteConfig.url;
    }
    /**
     * Analyze page performance
     */
    async analyzePerformance(pageId) {
        const response = await this.client.get(`/analyze/performance/${pageId}`);
        return response.data;
    }
    /**
     * Get Core Web Vitals
     */
    async getCoreWebVitals(pageId) {
        const response = await this.client.get(`/analyze/core-web-vitals/${pageId}`);
        return response.data;
    }
    /**
     * Analyze images on a page
     */
    async analyzeImages(pageId) {
        const response = await this.client.get(`/analyze/images/${pageId}`);
        return response.data;
    }
    /**
     * Analyze SEO for a page
     */
    async analyzeSEO(pageId) {
        const response = await this.client.get(`/analyze/seo/${pageId}`);
        return response.data;
    }
    /**
     * Check SEO issues for a page
     */
    async checkSEOIssues(pageId) {
        const response = await this.client.get(`/analyze/seo-issues/${pageId}`);
        return response.data;
    }
    /**
     * Analyze readability for a page
     */
    async analyzeReadability(pageId) {
        const response = await this.client.get(`/analyze/readability/${pageId}`);
        return response.data;
    }
    /**
     * Analyze AEO for a page
     */
    async analyzeAEO(pageId) {
        const response = await this.client.get(`/analyze/aeo/${pageId}`);
        return response.data;
    }
    /**
     * Check structured data for a page
     */
    async checkStructuredData(pageId) {
        const response = await this.client.get(`/analyze/structured-data/${pageId}`);
        return response.data;
    }
    /**
     * List all plugins (EXPERIMENTAL)
     */
    async listPlugins() {
        const response = await this.client.get('/plugins');
        return response.data;
    }
    /**
     * Install a plugin (EXPERIMENTAL)
     */
    async installPlugin(slugOrUrl, source = 'wordpress.org') {
        const response = await this.client.post('/plugins/install', {
            slug_or_url: slugOrUrl,
            source,
        });
        return response.data;
    }
    /**
     * Activate a plugin (EXPERIMENTAL)
     */
    async activatePlugin(slug) {
        const response = await this.client.post(`/plugins/${slug}/activate`);
        return response.data;
    }
    /**
     * Deactivate a plugin (EXPERIMENTAL)
     */
    async deactivatePlugin(slug) {
        const response = await this.client.post(`/plugins/${slug}/deactivate`);
        return response.data;
    }
    /**
     * Update a plugin (EXPERIMENTAL)
     */
    async updatePlugin(slug) {
        const response = await this.client.post(`/plugins/${slug}/update`);
        return response.data;
    }
    /**
     * Delete a plugin (EXPERIMENTAL)
     */
    async deletePlugin(slug) {
        const response = await this.client.delete(`/plugins/${slug}`);
        return response.data;
    }
    // Users Management
    async listUsers(filters) {
        const response = await this.client.get('/users', { params: filters });
        return response.data;
    }
    async getUser(id) {
        const response = await this.client.get(`/users/${id}`);
        return response.data;
    }
    async createUser(data) {
        const response = await this.client.post('/users', data);
        return response.data;
    }
    async updateUser(id, data) {
        const response = await this.client.put(`/users/${id}`, data);
        return response.data;
    }
    async deleteUser(id, reassign) {
        const response = await this.client.delete(`/users/${id}`, {
            params: { reassign },
        });
        return response.data;
    }
    // Comments
    async listComments(filters) {
        const response = await this.client.get('/comments', { params: filters });
        return response.data;
    }
    async getComment(id) {
        const response = await this.client.get(`/comments/${id}`);
        return response.data;
    }
    async createComment(data) {
        const response = await this.client.post('/comments', data);
        return response.data;
    }
    async updateComment(id, data) {
        const response = await this.client.put(`/comments/${id}`, data);
        return response.data;
    }
    async deleteComment(id) {
        const response = await this.client.delete(`/comments/${id}`);
        return response.data;
    }
    // Taxonomies
    async listTaxonomies() {
        const response = await this.client.get('/taxonomies');
        return response.data;
    }
    async getTaxonomy(taxonomy) {
        const response = await this.client.get(`/taxonomies/${taxonomy}`);
        return response.data;
    }
    async listTerms(taxonomy, filters) {
        const response = await this.client.get(`/taxonomies/${taxonomy}/terms`, { params: filters });
        return response.data;
    }
    async getTerm(taxonomy, id) {
        const response = await this.client.get(`/taxonomies/${taxonomy}/terms/${id}`);
        return response.data;
    }
    async createTerm(taxonomy, data) {
        const response = await this.client.post(`/taxonomies/${taxonomy}/terms`, data);
        return response.data;
    }
    async updateTerm(taxonomy, id, data) {
        const response = await this.client.put(`/taxonomies/${taxonomy}/terms/${id}`, data);
        return response.data;
    }
    async deleteTerm(taxonomy, id) {
        const response = await this.client.delete(`/taxonomies/${taxonomy}/terms/${id}`);
        return response.data;
    }
    // Custom Post Types
    async listPostTypes() {
        const response = await this.client.get('/post-types');
        return response.data;
    }
    async getPostType(type) {
        const response = await this.client.get(`/post-types/${type}`);
        return response.data;
    }
    async listCustomPosts(type, filters) {
        const response = await this.client.get(`/post-types/${type}/posts`, { params: filters });
        return response.data;
    }
    async getCustomPost(type, id) {
        const response = await this.client.get(`/post-types/${type}/posts/${id}`);
        return response.data;
    }
    async createCustomPost(type, data) {
        const response = await this.client.post(`/post-types/${type}/posts`, data);
        return response.data;
    }
    async updateCustomPost(type, id, data) {
        const response = await this.client.put(`/post-types/${type}/posts/${id}`, data);
        return response.data;
    }
    async deleteCustomPost(type, id) {
        const response = await this.client.delete(`/post-types/${type}/posts/${id}`);
        return response.data;
    }
    // Options
    async listOptions(search) {
        const response = await this.client.get('/options', {
            params: search ? { search } : {},
        });
        return response.data;
    }
    async getOption(option) {
        const response = await this.client.get(`/options/${option}`);
        return response.data;
    }
    async updateOption(option, value) {
        const response = await this.client.post(`/options/${option}`, { value });
        return response.data;
    }
    async deleteOption(option) {
        const response = await this.client.delete(`/options/${option}`);
        return response.data;
    }
    // Media enhancements
    async getMedia(id) {
        const response = await this.client.get(`/media/${id}`);
        return response.data;
    }
    async updateMedia(id, data) {
        const response = await this.client.put(`/media/${id}`, data);
        return response.data.media || response.data;
    }
    async deleteMedia(id) {
        const response = await this.client.delete(`/media/${id}`);
        return response.data;
    }
}
//# sourceMappingURL=wordpress-client.js.map