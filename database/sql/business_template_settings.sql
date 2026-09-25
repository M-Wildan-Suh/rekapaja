-- Template per usaha: MySQL / MariaDB, database aplikasi harus sudah dipilih.
-- Untuk tabel templates dengan kolom JSON background, head, gallery, desc,
-- product, contact (sesuai skema aplikasi saat ini).
-- Jika masih memakai bg_type/head_type/dll, gunakan migration Laravel yang
-- mendukung kedua skema, atau konversi ke JSON per bagian terlebih dahulu.
-- Tidak menghapus templates/template_id atau menimpa desain yang sudah tersimpan.
-- Jalankan seluruh script dengan SQL client yang berhenti jika terjadi error.

SET @business_template_ddl = IF(
    EXISTS (
        SELECT 1 FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'products'
          AND COLUMN_NAME = 'template_settings'
    ),
    'SELECT 1',
    'ALTER TABLE products ADD COLUMN template_settings JSON NULL'
);
PREPARE business_template_statement FROM @business_template_ddl;
EXECUTE business_template_statement;
DEALLOCATE PREPARE business_template_statement;

START TRANSACTION;

UPDATE products AS p
LEFT JOIN templates AS t ON t.id = p.template_id
SET p.template_settings = JSON_OBJECT(
    'background', JSON_INSERT(
        IF(JSON_TYPE(t.`background`) = 'OBJECT', t.`background`, JSON_OBJECT()),
        '$.type', 'normal',
        '$.main_color', '#FFFFFF',
        '$.second_color', '#FFFFFF',
        '$.accent_color', '#A72018'
    ),
    'head', JSON_INSERT(
        IF(JSON_TYPE(t.`head`) = 'OBJECT', t.`head`, JSON_OBJECT()),
        '$.type', 'one'
    ),
    'gallery', JSON_INSERT(
        IF(JSON_TYPE(t.`gallery`) = 'OBJECT', t.`gallery`, JSON_OBJECT()),
        '$.type', 'square'
    ),
    'desc', JSON_INSERT(
        IF(JSON_TYPE(t.`desc`) = 'OBJECT', t.`desc`, JSON_OBJECT()),
        '$.type', 'default',
        '$.main_color', '#FFFFFF',
        '$.text_color', '#111827'
    ),
    'product', JSON_INSERT(
        IF(JSON_TYPE(t.`product`) = 'OBJECT', t.`product`, JSON_OBJECT()),
        '$.type', 'grid2',
        '$.main_color', '#FFFFFF',
        '$.second_color', '#A72018',
        '$.text_color', '#111827'
    ),
    'contact', JSON_INSERT(
        IF(JSON_TYPE(t.`contact`) = 'OBJECT', t.`contact`, JSON_OBJECT()),
        '$.main_color', '#25D366',
        '$.second_color', '#111827'
    )
)
WHERE p.template_settings IS NULL;

-- Catat migration agar artisan migrate tidak menambahkan kolom yang sama lagi.
INSERT INTO migrations (migration, batch)
SELECT '2026_09_24_000001_add_template_settings_to_products_table',
       COALESCE(MAX(batch), 0) + 1
FROM migrations
HAVING NOT EXISTS (
    SELECT 1 FROM migrations
    WHERE migration = '2026_09_24_000001_add_template_settings_to_products_table'
);

COMMIT;

-- Hasil yang diharapkan: belum_memiliki_template = 0.
SELECT COUNT(*) AS jumlah_usaha,
       SUM(CASE WHEN template_settings IS NULL THEN 1 ELSE 0 END) AS belum_memiliki_template
FROM products;
