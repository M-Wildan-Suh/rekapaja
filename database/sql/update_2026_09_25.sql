-- UPDATE GABUNGAN REKAPAJA - perubahan working tree 25 September 2026.
-- MySQL / MariaDB dengan dukungan JSON, bukan untuk instalasi database kosong.
-- Pilih database aplikasi terlebih dahulu (USE nama_database).
-- Backup database, aktifkan maintenance mode, lalu jalankan SELURUH script
-- pada satu koneksi dengan client yang berhenti saat error (jangan --force).
-- DDL melakukan implicit commit sehingga seluruh script tidak bisa di-rollback.
-- Script dapat diulang setelah sukses / setelah penyebab error diperbaiki.
-- Kolom legacy sengaja dipertahankan, JSON yang sudah ada diprioritaskan.
-- Tidak menghapus desain, tidak mengubah role pengguna, tidak menebak pembuat usaha lama.
-- Prasyarat: tabel users, products, templates, migrations dari versi aplikasi sebelumnya.
-- users.id harus BIGINT UNSIGNED dan users.role VARCHAR seperti migration aplikasi.

SELECT DATABASE() AS database_target, VERSION() AS versi_database;

-- 1. Tambahkan enam section template bila belum ada.
SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'background'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `background` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'head'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `head` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'gallery'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `gallery` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'desc'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `desc` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'product'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `product` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'contact'), 'SELECT 1', 'ALTER TABLE templates ADD COLUMN `contact` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

-- 2. Tambahkan desain per usaha dan pembuat usaha. Data lama tetap NULL untuk created_by.
SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'template_settings'), 'SELECT 1', 'ALTER TABLE products ADD COLUMN `template_settings` JSON NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'created_by'), 'SELECT 1', 'ALTER TABLE products ADD COLUMN `created_by` BIGINT UNSIGNED NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'created_by' AND REFERENCED_TABLE_NAME = 'users' AND REFERENCED_COLUMN_NAME = 'id'), 'SELECT 1', 'ALTER TABLE products ADD CONSTRAINT products_created_by_foreign FOREIGN KEY (created_by) REFERENCES users (id) ON DELETE SET NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

-- 3. Isi hanya key JSON yang belum ada dari kolom legacy yang masih tersedia.
-- JSON yang sudah tersimpan tidak ditimpa oleh nilai legacy yang mungkin kedaluwarsa.
START TRANSACTION;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'bg_type'), 'UPDATE templates SET `background` = JSON_INSERT(IF(JSON_TYPE(`background`) = ''OBJECT'', `background`, JSON_OBJECT()), ''$.type'', `bg_type`) WHERE `bg_type` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'bg_image'), 'UPDATE templates SET `background` = JSON_INSERT(IF(JSON_TYPE(`background`) = ''OBJECT'', `background`, JSON_OBJECT()), ''$.image'', `bg_image`) WHERE `bg_image` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'bg_main_color'), 'UPDATE templates SET `background` = JSON_INSERT(IF(JSON_TYPE(`background`) = ''OBJECT'', `background`, JSON_OBJECT()), ''$.main_color'', `bg_main_color`) WHERE `bg_main_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'bg_second_color'), 'UPDATE templates SET `background` = JSON_INSERT(IF(JSON_TYPE(`background`) = ''OBJECT'', `background`, JSON_OBJECT()), ''$.second_color'', `bg_second_color`) WHERE `bg_second_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'accent_color'), 'UPDATE templates SET `background` = JSON_INSERT(IF(JSON_TYPE(`background`) = ''OBJECT'', `background`, JSON_OBJECT()), ''$.accent_color'', `accent_color`) WHERE `accent_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'head_type'), 'UPDATE templates SET `head` = JSON_INSERT(IF(JSON_TYPE(`head`) = ''OBJECT'', `head`, JSON_OBJECT()), ''$.type'', `head_type`) WHERE `head_type` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'gallery_type'), 'UPDATE templates SET `gallery` = JSON_INSERT(IF(JSON_TYPE(`gallery`) = ''OBJECT'', `gallery`, JSON_OBJECT()), ''$.type'', `gallery_type`) WHERE `gallery_type` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'desc_type'), 'UPDATE templates SET `desc` = JSON_INSERT(IF(JSON_TYPE(`desc`) = ''OBJECT'', `desc`, JSON_OBJECT()), ''$.type'', `desc_type`) WHERE `desc_type` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'desc_main_color'), 'UPDATE templates SET `desc` = JSON_INSERT(IF(JSON_TYPE(`desc`) = ''OBJECT'', `desc`, JSON_OBJECT()), ''$.main_color'', `desc_main_color`) WHERE `desc_main_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'desc_text_color'), 'UPDATE templates SET `desc` = JSON_INSERT(IF(JSON_TYPE(`desc`) = ''OBJECT'', `desc`, JSON_OBJECT()), ''$.text_color'', `desc_text_color`) WHERE `desc_text_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'product_type'), 'UPDATE templates SET `product` = JSON_INSERT(IF(JSON_TYPE(`product`) = ''OBJECT'', `product`, JSON_OBJECT()), ''$.type'', `product_type`) WHERE `product_type` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'product_main_color'), 'UPDATE templates SET `product` = JSON_INSERT(IF(JSON_TYPE(`product`) = ''OBJECT'', `product`, JSON_OBJECT()), ''$.main_color'', `product_main_color`) WHERE `product_main_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'product_second_color'), 'UPDATE templates SET `product` = JSON_INSERT(IF(JSON_TYPE(`product`) = ''OBJECT'', `product`, JSON_OBJECT()), ''$.second_color'', `product_second_color`) WHERE `product_second_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'product_text_color'), 'UPDATE templates SET `product` = JSON_INSERT(IF(JSON_TYPE(`product`) = ''OBJECT'', `product`, JSON_OBJECT()), ''$.text_color'', `product_text_color`) WHERE `product_text_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'contact_main_color'), 'UPDATE templates SET `contact` = JSON_INSERT(IF(JSON_TYPE(`contact`) = ''OBJECT'', `contact`, JSON_OBJECT()), ''$.main_color'', `contact_main_color`) WHERE `contact_main_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'templates' AND COLUMN_NAME = 'contact_second_color'), 'UPDATE templates SET `contact` = JSON_INSERT(IF(JSON_TYPE(`contact`) = ''OBJECT'', `contact`, JSON_OBJECT()), ''$.second_color'', `contact_second_color`) WHERE `contact_second_color` IS NOT NULL', 'SELECT 1');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

-- 4. Salin template ke usaha hanya bila template_settings masih NULL.
SET @rekapaja_sql = IF(EXISTS (SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'template_id'), 'UPDATE products AS p
LEFT JOIN templates AS t ON t.id = p.template_id
SET p.template_settings = JSON_OBJECT(
    ''background'', JSON_INSERT(
        IF(JSON_TYPE(t.`background`) = ''OBJECT'', t.`background`, JSON_OBJECT()),
        ''$.type'', ''normal'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.second_color'', ''#FFFFFF'',
        ''$.accent_color'', ''#A72018''
    ),
    ''head'', JSON_INSERT(
        IF(JSON_TYPE(t.`head`) = ''OBJECT'', t.`head`, JSON_OBJECT()),
        ''$.type'', ''one''
    ),
    ''gallery'', JSON_INSERT(
        IF(JSON_TYPE(t.`gallery`) = ''OBJECT'', t.`gallery`, JSON_OBJECT()),
        ''$.type'', ''square''
    ),
    ''desc'', JSON_INSERT(
        IF(JSON_TYPE(t.`desc`) = ''OBJECT'', t.`desc`, JSON_OBJECT()),
        ''$.type'', ''default'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.text_color'', ''#111827''
    ),
    ''product'', JSON_INSERT(
        IF(JSON_TYPE(t.`product`) = ''OBJECT'', t.`product`, JSON_OBJECT()),
        ''$.type'', ''grid2'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.second_color'', ''#A72018'',
        ''$.text_color'', ''#111827''
    ),
    ''contact'', JSON_INSERT(
        IF(JSON_TYPE(t.`contact`) = ''OBJECT'', t.`contact`, JSON_OBJECT()),
        ''$.main_color'', ''#25D366'',
        ''$.second_color'', ''#111827''
    )
)
WHERE p.template_settings IS NULL', 'UPDATE products AS p
LEFT JOIN templates AS t ON 1 = 0
SET p.template_settings = JSON_OBJECT(
    ''background'', JSON_INSERT(
        IF(JSON_TYPE(t.`background`) = ''OBJECT'', t.`background`, JSON_OBJECT()),
        ''$.type'', ''normal'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.second_color'', ''#FFFFFF'',
        ''$.accent_color'', ''#A72018''
    ),
    ''head'', JSON_INSERT(
        IF(JSON_TYPE(t.`head`) = ''OBJECT'', t.`head`, JSON_OBJECT()),
        ''$.type'', ''one''
    ),
    ''gallery'', JSON_INSERT(
        IF(JSON_TYPE(t.`gallery`) = ''OBJECT'', t.`gallery`, JSON_OBJECT()),
        ''$.type'', ''square''
    ),
    ''desc'', JSON_INSERT(
        IF(JSON_TYPE(t.`desc`) = ''OBJECT'', t.`desc`, JSON_OBJECT()),
        ''$.type'', ''default'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.text_color'', ''#111827''
    ),
    ''product'', JSON_INSERT(
        IF(JSON_TYPE(t.`product`) = ''OBJECT'', t.`product`, JSON_OBJECT()),
        ''$.type'', ''grid2'',
        ''$.main_color'', ''#FFFFFF'',
        ''$.second_color'', ''#A72018'',
        ''$.text_color'', ''#111827''
    ),
    ''contact'', JSON_INSERT(
        IF(JSON_TYPE(t.`contact`) = ''OBJECT'', t.`contact`, JSON_OBJECT()),
        ''$.main_color'', ''#25D366'',
        ''$.second_color'', ''#111827''
    )
)
WHERE p.template_settings IS NULL');
PREPARE rekapaja_update FROM @rekapaja_sql;
EXECUTE rekapaja_update;
DEALLOCATE PREPARE rekapaja_update;

-- 5. Catat hanya dua migration baru agar artisan migrate tidak mengulangnya.
SET @rekapaja_batch = (SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations);

INSERT INTO migrations (migration, batch)
SELECT '2026_09_24_000001_add_template_settings_to_products_table', @rekapaja_batch
WHERE NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_09_24_000001_add_template_settings_to_products_table');

INSERT INTO migrations (migration, batch)
SELECT '2026_09_25_000001_add_created_by_to_products_table', @rekapaja_batch
WHERE NOT EXISTS (SELECT 1 FROM migrations WHERE migration = '2026_09_25_000001_add_created_by_to_products_table');

COMMIT;

-- 6. Verifikasi: belum_memiliki_template = 0. usaha_tanpa_pencatat boleh > 0.
SELECT COUNT(*) AS jumlah_usaha,
       COALESCE(SUM(template_settings IS NULL), 0) AS belum_memiliki_template,
       COALESCE(SUM(created_by IS NULL), 0) AS usaha_tanpa_pencatat
FROM products;
SELECT migration, batch FROM migrations
WHERE migration IN ('2026_09_24_000001_add_template_settings_to_products_table',
                    '2026_09_25_000001_add_created_by_to_products_table');
