-- Review these queries before running the cleanup.
SELECT user_id, COUNT(*) AS total_businesses
FROM accesses
GROUP BY user_id
HAVING COUNT(*) > 1;

SELECT product_id, COUNT(*) AS total_owners
FROM accesses
GROUP BY product_id
HAVING COUNT(*) > 1;

START TRANSACTION;

-- Keep the oldest access row for each user.
DELETE duplicate_access
FROM accesses AS duplicate_access
INNER JOIN accesses AS kept_access
    ON duplicate_access.user_id = kept_access.user_id
    AND duplicate_access.id > kept_access.id;

-- Keep the oldest remaining access row for each product.
DELETE duplicate_access
FROM accesses AS duplicate_access
INNER JOIN accesses AS kept_access
    ON duplicate_access.product_id = kept_access.product_id
    AND duplicate_access.id > kept_access.id;

COMMIT;

-- Verify that every user and product now appears at most once.
SELECT user_id, COUNT(*) AS total_businesses
FROM accesses
GROUP BY user_id
HAVING COUNT(*) > 1;

SELECT product_id, COUNT(*) AS total_owners
FROM accesses
GROUP BY product_id
HAVING COUNT(*) > 1;
