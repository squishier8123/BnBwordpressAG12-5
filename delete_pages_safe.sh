#!/bin/bash

# Safe Page Deletion Script via REST API
# Deletes ONLY the specified 189 page IDs
# No bulk selection, no risk of deleting wrong pages

BASE_URL="https://beardsandbucks.com"
API_ENDPOINT="$BASE_URL/wp-json/wp/v2/pages"

# 189 Page IDs to delete (EXACTLY as planned)
IDS=(
72 76 90 91 92 93 353 409 434 441 449 507 536 547 595 609 616 638 656 663
1307 1311 1321 1370 1545 1625 2065 2244 2257 3049 3050 3138 3139 3140 3141
3282 3337 3338 3339 3340 3399 3401 3563 3566 3569 3572 3575 3578 3581 3584
3587 3590 3593 3596 3599 3638 3642 3646 3647 3650 3653 3656 3659 3660 3663
3666 3669 3672 3675 3678 3681 3684 3687 3690 3693 3696 3699 3702 3705 3708
3711 3714 3719 3722 3725 3728 3732 3737 3738 3754 3776 3779 3793 3801 3851
3854 3857 3860 3863 3866 3869 3872 3875 3878 3881 3884 3887 3924 3927 3930
3933 3936 3939 3942 3945 3948 3951 3954 3957 3960 4002 4005 4008 4011 4014
4017 4020 4023 4026 4029 4032 4035 4038 4072 4073 4074 4078 4099 4100 4180
4244 4363 4364 4365 4366 4367 4368 4369 4371 4372 4373 4374 4375 4376 4377
4378 4379 4380 4381 4382 4383 4384 4385 4386 4387 4388 4389 4390 4391 4392
4393 4394 4395 4396 4397 4398 4399 4400 4401 4402 4403 4404 4405 4406 4407
4408 4409 4410
)

echo "=========================================="
echo "Safe Page Deletion via REST API"
echo "=========================================="
echo ""
echo "Total pages to delete: ${#IDS[@]}"
echo ""

# Get initial count
INITIAL=$(curl -s -I "$API_ENDPOINT?per_page=1" 2>&1 | grep -i "x-wp-total:" | awk '{print $2}' | tr -d '\r')
echo "Initial page count: $INITIAL"
echo ""

# Delete each page by ID
DELETED=0
FAILED=0

for ID in "${IDS[@]}"; do
  RESPONSE=$(curl -s -w "\n%{http_code}" -X DELETE "$API_ENDPOINT/$ID?force=true" 2>&1)
  HTTP_CODE=$(echo "$RESPONSE" | tail -n1)

  if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "204" ]; then
    DELETED=$((DELETED + 1))
  else
    FAILED=$((FAILED + 1))
    echo "Failed to delete ID $ID (HTTP $HTTP_CODE)"
  fi

  # Progress indicator every 20 pages
  if [ $((DELETED % 20)) -eq 0 ]; then
    echo "Progress: $DELETED deleted, $FAILED failed..."
  fi

  # Rate limiting
  sleep 0.1
done

echo ""
echo "=========================================="
echo "Deletion Complete"
echo "=========================================="
echo "Deleted: $DELETED"
echo "Failed: $FAILED"
echo ""

# Get final count
FINAL=$(curl -s -I "$API_ENDPOINT?per_page=1" 2>&1 | grep -i "x-wp-total:" | awk '{print $2}' | tr -d '\r')
echo "Final page count: $FINAL"
echo "Expected: 27"
echo ""

if [ "$FINAL" = "27" ]; then
  echo "✅ SUCCESS - Page cleanup complete!"
else
  echo "⚠️  ALERT - Final count is $FINAL, expected 27"
fi
