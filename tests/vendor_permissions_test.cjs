/**
 * Vendor Permissions Test Script
 * Tests Dokan vendor account permissions via REST API
 *
 * Vendor Details:
 * - User ID: 3
 * - Email: sdfdksfusdfjn@gmail.com
 * - Username: temp_builder
 */

const https = require('https');

// Configuration
const SITE_URL = 'https://beardsandbucks.com';
const VENDOR_USERNAME = 'temp_builder';
const VENDOR_EMAIL = 'sdfdksfusdfjn@gmail.com';
const VENDOR_ID = 3;

// Admin credentials for API testing
const ADMIN_USERNAME = 'jeff';
const ADMIN_APP_PASSWORD = 'N0yN G2OM aRKT CZrm hIrq 88jG';

// Test results storage
const results = {
    timestamp: new Date().toISOString(),
    vendorInfo: {
        id: VENDOR_ID,
        username: VENDOR_USERNAME,
        email: VENDOR_EMAIL
    },
    tests: []
};

/**
 * Make authenticated API request
 */
function makeRequest(endpoint, auth, method = 'GET', postData = null) {
    return new Promise((resolve, reject) => {
        const url = new URL(endpoint, SITE_URL);
        const authString = Buffer.from(auth).toString('base64');

        const options = {
            hostname: url.hostname,
            path: url.pathname + url.search,
            method: method,
            headers: {
                'Authorization': `Basic ${authString}`,
                'Content-Type': 'application/json',
                'User-Agent': 'VendorPermissionTest/1.0'
            }
        };

        if (postData) {
            const data = JSON.stringify(postData);
            options.headers['Content-Length'] = Buffer.byteLength(data);
        }

        const req = https.request(options, (res) => {
            let data = '';

            res.on('data', (chunk) => {
                data += chunk;
            });

            res.on('end', () => {
                try {
                    const parsed = data ? JSON.parse(data) : null;
                    resolve({
                        status: res.statusCode,
                        headers: res.headers,
                        data: parsed
                    });
                } catch (e) {
                    resolve({
                        status: res.statusCode,
                        headers: res.headers,
                        data: data,
                        parseError: e.message
                    });
                }
            });
        });

        req.on('error', (error) => {
            reject(error);
        });

        if (postData) {
            req.write(JSON.stringify(postData));
        }

        req.end();
    });
}

/**
 * Test 1: Get vendor user details and capabilities
 */
async function testVendorUserInfo() {
    console.log('\n[TEST 1] Checking vendor user info and capabilities...');

    try {
        const response = await makeRequest(
            `/wp-json/wp/v2/users/${VENDOR_ID}?context=edit`,
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor User Info & Capabilities',
            endpoint: `/wp-json/wp/v2/users/${VENDOR_ID}`,
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                username: response.data.username,
                email: response.data.email,
                roles: response.data.roles,
                capabilities: response.data.capabilities,
                allcaps: response.data.allcaps,
                hasSeller: response.data.roles?.includes('seller'),
                hasDokanManageProduct: response.data.capabilities?.dokan_manage_product || false,
                hasManageWooCommerce: response.data.capabilities?.manage_woocommerce || false,
                hasEditProducts: response.data.capabilities?.edit_products || false,
                hasPublishProducts: response.data.capabilities?.publish_products || false
            };
            console.log('✓ User info retrieved successfully');
            console.log(`  - Roles: ${response.data.roles?.join(', ')}`);
            console.log(`  - Has seller role: ${test.findings.hasSeller}`);
        } else {
            test.error = response.data;
            console.log('✗ Failed to retrieve user info');
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor User Info & Capabilities',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 2: Check Dokan vendor dashboard access
 */
async function testVendorDashboardAccess() {
    console.log('\n[TEST 2] Testing vendor dashboard access...');

    try {
        // Test with admin credentials (to check if endpoint exists)
        const response = await makeRequest(
            '/wp-json/dokan/v1/stores',
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor Dashboard Access',
            endpoint: '/wp-json/dokan/v1/stores',
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            // Check if our vendor is in the list
            const vendorStore = Array.isArray(response.data)
                ? response.data.find(store => store.id === VENDOR_ID)
                : null;

            test.findings = {
                totalStores: Array.isArray(response.data) ? response.data.length : 0,
                vendorFound: !!vendorStore,
                vendorStoreData: vendorStore || null
            };

            console.log('✓ Dashboard endpoint accessible');
            console.log(`  - Total stores: ${test.findings.totalStores}`);
            console.log(`  - Vendor store found: ${test.findings.vendorFound}`);
        } else {
            test.error = response.data;
            console.log('✗ Dashboard endpoint not accessible');
            console.log(`  - Status: ${response.status}`);
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor Dashboard Access',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 3: Check vendor store settings
 */
async function testVendorStoreSettings() {
    console.log('\n[TEST 3] Testing vendor store settings...');

    try {
        const response = await makeRequest(
            `/wp-json/dokan/v1/stores/${VENDOR_ID}`,
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor Store Settings',
            endpoint: `/wp-json/dokan/v1/stores/${VENDOR_ID}`,
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                storeData: response.data,
                storeEnabled: response.data.enabled || false,
                storeName: response.data.store_name || 'Not set',
                publishingCapability: response.data.publishing || 'Not set',
                trusted: response.data.trusted || false
            };

            console.log('✓ Store settings retrieved');
            console.log(`  - Store enabled: ${test.findings.storeEnabled}`);
            console.log(`  - Store name: ${test.findings.storeName}`);
            console.log(`  - Publishing capability: ${test.findings.publishingCapability}`);
            console.log(`  - Trusted vendor: ${test.findings.trusted}`);
        } else {
            test.error = response.data;
            console.log('✗ Failed to retrieve store settings');
            console.log(`  - Status: ${response.status}`);
            if (response.data && response.data.message) {
                console.log(`  - Message: ${response.data.message}`);
            }
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor Store Settings',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 4: Check vendor product access
 */
async function testVendorProductAccess() {
    console.log('\n[TEST 4] Testing vendor product access...');

    try {
        const response = await makeRequest(
            `/wp-json/dokan/v1/products?vendor_id=${VENDOR_ID}`,
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor Product Access',
            endpoint: `/wp-json/dokan/v1/products?vendor_id=${VENDOR_ID}`,
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                canAccessProducts: true,
                totalProducts: Array.isArray(response.data) ? response.data.length : 0,
                products: response.data
            };

            console.log('✓ Product endpoint accessible');
            console.log(`  - Total products: ${test.findings.totalProducts}`);
        } else if (response.status === 404) {
            test.findings = {
                canAccessProducts: false,
                endpointExists: false
            };
            console.log('✗ Product endpoint not found (Dokan products endpoint may not be available)');
        } else {
            test.error = response.data;
            test.findings = {
                canAccessProducts: false
            };
            console.log('✗ Cannot access products');
            console.log(`  - Status: ${response.status}`);
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor Product Access',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 5: Check WooCommerce products for vendor
 */
async function testWooCommerceProductAccess() {
    console.log('\n[TEST 5] Testing WooCommerce product access for vendor...');

    try {
        // Get products authored by the vendor
        const response = await makeRequest(
            `/wp-json/wc/v3/products?author=${VENDOR_ID}`,
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'WooCommerce Product Access',
            endpoint: `/wp-json/wc/v3/products?author=${VENDOR_ID}`,
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                canAccessWCProducts: true,
                totalProducts: Array.isArray(response.data) ? response.data.length : 0,
                productList: response.data.map(p => ({
                    id: p.id,
                    name: p.name,
                    status: p.status,
                    price: p.price
                }))
            };

            console.log('✓ WooCommerce product endpoint accessible');
            console.log(`  - Total products: ${test.findings.totalProducts}`);
        } else {
            test.error = response.data;
            console.log('✗ Cannot access WooCommerce products');
            console.log(`  - Status: ${response.status}`);
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'WooCommerce Product Access',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 6: Check vendor order access
 */
async function testVendorOrderAccess() {
    console.log('\n[TEST 6] Testing vendor order access...');

    try {
        const response = await makeRequest(
            '/wp-json/dokan/v1/orders',
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor Order Access',
            endpoint: '/wp-json/dokan/v1/orders',
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                canAccessOrders: true,
                totalOrders: Array.isArray(response.data) ? response.data.length : 0,
                orderData: response.data
            };

            console.log('✓ Order endpoint accessible');
            console.log(`  - Total orders: ${test.findings.totalOrders}`);
        } else if (response.status === 404) {
            test.findings = {
                canAccessOrders: false,
                endpointExists: false
            };
            console.log('✗ Order endpoint not found');
        } else {
            test.error = response.data;
            test.findings = {
                canAccessOrders: false
            };
            console.log('✗ Cannot access orders');
            console.log(`  - Status: ${response.status}`);
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor Order Access',
            success: false,
            error: error.message
        });
    }
}

/**
 * Test 7: Check vendor analytics access
 */
async function testVendorAnalyticsAccess() {
    console.log('\n[TEST 7] Testing vendor analytics access...');

    try {
        const response = await makeRequest(
            '/wp-json/dokan/v1/reports/summary',
            `${ADMIN_USERNAME}:${ADMIN_APP_PASSWORD}`
        );

        const test = {
            name: 'Vendor Analytics Access',
            endpoint: '/wp-json/dokan/v1/reports/summary',
            status: response.status,
            success: response.status === 200,
            findings: {}
        };

        if (response.status === 200) {
            test.findings = {
                canAccessAnalytics: true,
                analyticsData: response.data
            };

            console.log('✓ Analytics endpoint accessible');
        } else if (response.status === 404) {
            test.findings = {
                canAccessAnalytics: false,
                endpointExists: false
            };
            console.log('✗ Analytics endpoint not found');
        } else {
            test.error = response.data;
            test.findings = {
                canAccessAnalytics: false
            };
            console.log('✗ Cannot access analytics');
            console.log(`  - Status: ${response.status}`);
        }

        results.tests.push(test);
        return test;
    } catch (error) {
        console.error('✗ Error:', error.message);
        results.tests.push({
            name: 'Vendor Analytics Access',
            success: false,
            error: error.message
        });
    }
}

/**
 * Generate recommendations based on test results
 */
function generateRecommendations() {
    console.log('\n========================================');
    console.log('RECOMMENDATIONS');
    console.log('========================================\n');

    const recommendations = [];

    // Check user info test
    const userInfoTest = results.tests.find(t => t.name === 'Vendor User Info & Capabilities');
    if (userInfoTest && userInfoTest.success) {
        if (!userInfoTest.findings.hasSeller) {
            recommendations.push({
                priority: 'HIGH',
                issue: 'Vendor does not have "seller" role',
                fix: 'Add "seller" role to user via WordPress admin or WP-CLI: wp user add-role 3 seller'
            });
        }

        if (!userInfoTest.findings.hasDokanManageProduct) {
            recommendations.push({
                priority: 'HIGH',
                issue: 'Vendor lacks "dokan_manage_product" capability',
                fix: 'This capability should be granted automatically with seller role. Check Dokan settings.'
            });
        }

        if (!userInfoTest.findings.hasPublishProducts) {
            recommendations.push({
                priority: 'MEDIUM',
                issue: 'Vendor cannot publish products directly',
                fix: 'Check Dokan > Settings > Selling Options > "Product Status" - may need admin approval'
            });
        }
    }

    // Check store settings test
    const storeTest = results.tests.find(t => t.name === 'Vendor Store Settings');
    if (storeTest && storeTest.success) {
        if (!storeTest.findings.storeEnabled) {
            recommendations.push({
                priority: 'HIGH',
                issue: 'Vendor store is disabled',
                fix: 'Enable the vendor store via Dokan > Vendors > Edit Vendor > Enable Selling'
            });
        }

        if (storeTest.findings.publishingCapability === 'pending') {
            recommendations.push({
                priority: 'MEDIUM',
                issue: 'Vendor products require admin approval',
                fix: 'Change in Dokan > Settings > Selling Options > New Product Status to "publish"'
            });
        }
    } else if (storeTest && !storeTest.success) {
        recommendations.push({
            priority: 'HIGH',
            issue: 'Cannot retrieve vendor store settings',
            fix: 'Ensure Dokan plugin is active and REST API is enabled'
        });
    }

    // Overall assessment
    console.log('Overall Assessment:\n');
    const totalTests = results.tests.length;
    const passedTests = results.tests.filter(t => t.success).length;
    console.log(`Tests Passed: ${passedTests}/${totalTests}`);

    if (recommendations.length === 0) {
        console.log('\n✓ All vendor permissions appear to be configured correctly!');
    } else {
        console.log('\n⚠ Issues Found:\n');
        recommendations.forEach((rec, idx) => {
            console.log(`${idx + 1}. [${rec.priority}] ${rec.issue}`);
            console.log(`   Fix: ${rec.fix}\n`);
        });
    }

    results.recommendations = recommendations;
}

/**
 * Main test execution
 */
async function runTests() {
    console.log('========================================');
    console.log('VENDOR PERMISSIONS TEST');
    console.log('========================================');
    console.log(`Site: ${SITE_URL}`);
    console.log(`Vendor: ${VENDOR_USERNAME} (ID: ${VENDOR_ID})`);
    console.log(`Email: ${VENDOR_EMAIL}`);
    console.log('========================================\n');

    try {
        await testVendorUserInfo();
        await testVendorDashboardAccess();
        await testVendorStoreSettings();
        await testVendorProductAccess();
        await testWooCommerceProductAccess();
        await testVendorOrderAccess();
        await testVendorAnalyticsAccess();

        generateRecommendations();

        // Write results to file
        const fs = require('fs');
        const outputPath = '/mnt/c/Users/Geoff/OneDrive/Desktop/Newbeards&Bucks12-5/tests/vendor_permissions_results.json';
        fs.writeFileSync(outputPath, JSON.stringify(results, null, 2));

        console.log('\n========================================');
        console.log(`Results saved to: ${outputPath}`);
        console.log('========================================\n');

    } catch (error) {
        console.error('Fatal error running tests:', error);
        process.exit(1);
    }
}

// Run tests
runTests();
