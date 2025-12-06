# WordPress Page Cleanup Plan

## Goal
Delete 189 unnecessary WordPress pages to reduce the total count from 216 to ~27 pages, ensuring essential pages are preserved.

## Proposed Changes
No code changes. This is a content cleanup task.

1.  **Login to WP Admin**: Access `https://beardsandbucks.com/wp-admin`.
2.  **Navigation**: Go to "Pages" section.
3.  **Deletion Strategy**:
    *   Attempt to use the "IDs to Delete" list to programmatically or semi-automatically delete the specific 189 pages to avoid accidental deletion of essential pages.
    *   Alternatively, if bulk selection in UI is feasible (e.g., filtering by date or author if distinct), use that.
    *   Will prioritize using the specific Page IDs provided by the user to ensure accuracy.
4.  **Preservation**: specifically exclude the 27 essential pages listed in the request.

## Verification Plan
1.  **Count Verification**: Check that the total published page count appears as approximately 27.
2.  **Existence Check**: Manually or programmatically verify that each of the 27 essential pages (Home, About Us, Vendors, Dashboard pages, etc.) still exists and is accessible.
3.  **Before/After Evidence**: Capture screenshots of the Page list before and after deletion.
