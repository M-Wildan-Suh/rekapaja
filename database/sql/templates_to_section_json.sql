-- MySQL / MariaDB. Jalankan sekali pada database aplikasi yang masih memakai
-- kolom template lama. Aktifkan maintenance mode selama seluruh proses.
-- Jalankan dengan client yang berhenti saat terjadi error (jangan --force).
-- DDL melakukan implicit commit; backup ini sengaja tidak dihapus otomatis.
CREATE TABLE templates_backup_before_section_json LIKE templates;
INSERT INTO templates_backup_before_section_json SELECT * FROM templates;

ALTER TABLE templates
    ADD COLUMN background JSON NULL,
    ADD COLUMN head JSON NULL,
    ADD COLUMN gallery JSON NULL,
    ADD COLUMN `desc` JSON NULL,
    ADD COLUMN product JSON NULL,
    ADD COLUMN contact JSON NULL;

UPDATE templates SET
    background = JSON_OBJECT(
        'type', bg_type, 'image', bg_image,
        'main_color', bg_main_color, 'second_color', bg_second_color,
        'accent_color', accent_color
    ),
    head = JSON_OBJECT('type', head_type),
    gallery = JSON_OBJECT('type', gallery_type),
    `desc` = JSON_OBJECT(
        'type', desc_type, 'main_color', desc_main_color, 'text_color', desc_text_color
    ),
    product = JSON_OBJECT(
        'type', product_type, 'main_color', product_main_color,
        'second_color', product_second_color, 'text_color', product_text_color
    ),
    contact = JSON_OBJECT('main_color', contact_main_color, 'second_color', contact_second_color);

ALTER TABLE templates
    DROP COLUMN bg_type,
    DROP COLUMN bg_image,
    DROP COLUMN bg_main_color,
    DROP COLUMN bg_second_color,
    DROP COLUMN accent_color,
    DROP COLUMN head_type,
    DROP COLUMN gallery_type,
    DROP COLUMN desc_type,
    DROP COLUMN desc_main_color,
    DROP COLUMN desc_text_color,
    DROP COLUMN product_type,
    DROP COLUMN product_main_color,
    DROP COLUMN product_second_color,
    DROP COLUMN product_text_color,
    DROP COLUMN contact_main_color,
    DROP COLUMN contact_second_color;

SELECT id, name, background, head, gallery, `desc`, product, contact FROM templates;
