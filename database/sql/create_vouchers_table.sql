-- Jalankan pada database aplikasi RekapAja (MySQL/MariaDB).
CREATE TABLE IF NOT EXISTS `vouchers` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(64) NOT NULL,
    `product_id` BIGINT UNSIGNED NULL,
    `role` VARCHAR(255) NOT NULL DEFAULT 'user',
    `premium_type` VARCHAR(255) NULL,
    `expired` DATE NULL,
    `used_by` BIGINT UNSIGNED NULL,
    `used_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `vouchers_code_unique` (`code`),
    KEY `vouchers_product_id_foreign` (`product_id`),
    KEY `vouchers_used_by_foreign` (`used_by`),
    CONSTRAINT `vouchers_product_id_foreign`
        FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
    CONSTRAINT `vouchers_used_by_foreign`
        FOREIGN KEY (`used_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Catat migrasi agar php artisan migrate tidak membuat tabel yang sama lagi.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_09_10_000001_create_vouchers_table', migration_batch.next_batch
FROM (SELECT COALESCE(MAX(`batch`), 0) + 1 AS next_batch FROM `migrations`) AS migration_batch
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations`
    WHERE `migration` = '2026_09_10_000001_create_vouchers_table'
);
