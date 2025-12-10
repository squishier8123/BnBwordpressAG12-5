# Inspector Agent: Verify Dokan Vendor Capabilities & Permissions (Task 1.2.3)

**Task**: Locate and verify vendor capabilities/permissions configuration interface
**Date**: 2025-11-29
**Status**: ✅ COMPLETE

---

## 1. Location Path
- **Confirmed**: The "Vendor Capabilities" section is located **DIRECTLY BELOW** the Commission settings within the **Selling Options** card/tab.
- **Path**: WP Admin -> Dokan -> Settings -> Selling Options -> Scroll down past Commission Settings.

## 2. Vendor Permission Options Available (Dokan Lite)
The following capabilities are available for configuration in the Lite version:
1.  **Order Status Change**: Allow vendor to update order status.
2.  **Select any category**: Allow vendors to select any category while creating/editing products.
3.  **Remove Add to Cart Button**: (Under "Product Catalog Mode") Hides the add to cart button.

**Note**: The "Add new product in single page view" is present as a descriptive heading/option but does not have a toggle in the view, likely a display setting or default behavior.

## 3. Permission Configuration Type
- **Type**: **Toggles** (Yes/No switches).
- **Visuals**: Standard rounded toggle switches (Left = Off, Right/Blue = On).

## 4. Current Vendor Capabilities Setup
- **Order Status Change**: **OFF** (Default)
- **Select any category**: **OFF** (Default)
- **Remove Add to Cart Button**: **OFF** (Default)

## 5. UI Pattern Match
- **Consistent**: Yes.
- **Style**: Uses the same card-based layout, typography, and toggle switch style as the Commission settings and other Dokan settings pages.
- **Layout**: Single column of options within the "Selling Options" card.

## 6. Permission Granularity
- **Scope**: **Global Defaults**.
- **Granularity**: These settings apply to ALL vendors. There is no option in this specific interface to configure permissions per-vendor or per-role.
- **Role-Based**: No role selection dropdown or role-specific columns were found in this section.

## 7. Seller/Vendor Terminology
- **Term Used**: "**Vendor**" (e.g., "Allow vendor to update order status").

## 8. Discrepancies & Limitations
- **Limited Options**: The available permissions are very limited compared to a full multi-vendor setup. Key capabilities like "Manage Orders" (beyond status), "View Reports", "Store Settings" are not togglable here, implying they are either enabled by default or locked behind the Pro version.
- **Pro Features**: Buttons like "Check Out All Vendor Functionalities" and "Upgrade to Pro" strongly suggest that granular permissions and advanced capabilities are Pro features.

## 9. Screenshots
![Vendor Capabilities Section](vendor_capabilities_section.png)

## 10. Feedback for Next Phase (Task 1.1.2 Worker)
- **Scope**: The configuration work for Task 1.1.2 will be minimal for *this specific section* unless the user upgrades to Dokan Pro.
- **Action Items**:
    - Decide whether to enable "Order Status Change" (allows vendors to mark orders as complete/processing).
    - Decide on "Select any category" (allows vendors to post in any category vs. restricted).
- **Red Flags**:
    - If the business model requires strict vendor restrictions or specific role-based capabilities, Dokan Lite may be insufficient.
    - "Product Catalog Mode" is available if the marketplace is for display only (no purchasing).

**Confidence Level**: **HIGH**
