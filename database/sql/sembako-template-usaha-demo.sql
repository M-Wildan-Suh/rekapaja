SET NAMES utf8mb4;
START TRANSACTION;

INSERT INTO templates (
    name,
    image,
    bg_type,
    bg_image,
    bg_main_color,
    bg_second_color,
    accent_color,
    head_type,
    gallery_type,
    desc_type,
    desc_main_color,
    desc_text_color,
    product_type,
    product_main_color,
    product_second_color,
    product_text_color,
    contact_main_color,
    contact_second_color,
    created_at,
    updated_at
)
SELECT
    'Sembako Hijau',
    NULL,
    'normal',
    NULL,
    '#FFF8E9',
    '#EAF4DE',
    '#2F9E44',
    'sembako',
    'square',
    'default',
    '#FFF8E9',
    '#24411F',
    'grid3',
    '#FFFFFF',
    '#2F9E44',
    '#24411F',
    '#2F9E44',
    '#FFFFFF',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'sembako'
);

SET @sembako_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'sembako'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

INSERT INTO categories (category, created_at, updated_at)
SELECT 'Kebutuhan sehari-hari, cukup dari rumah aja!', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM categories
    WHERE BINARY category = BINARY 'Kebutuhan sehari-hari, cukup dari rumah aja!'
);

SET @sembako_category_id := (
    SELECT id
    FROM categories
    WHERE BINARY category = BINARY 'Kebutuhan sehari-hari, cukup dari rumah aja!'
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Lengkap', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Lengkap'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Harga Hemat', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Harga Hemat'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Kualitas Terjamin', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Kualitas Terjamin'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Pengiriman Cepat', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Pengiriman Cepat'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Segar & Fresh', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Segar & Fresh'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Belanja mudah, barang sampai rumah!', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Belanja mudah, barang sampai rumah!'
);

INSERT INTO products (
    name,
    slug,
    image,
    template,
    template_id,
    subtitle,
    price,
    description,
    product_title,
    order_title,
    price_prefix,
    status,
    customer_data,
    qris_status,
    order_via_whatsapp,
    no_tlp,
    qris,
    domain,
    address,
    home_button,
    created_at,
    updated_at
)
SELECT
    'Sembako Lengkap',
    'sembako-lengkap',
    'sembako-banner.jpg',
    'one',
    @sembako_template_id,
    'Harga Bersahabat!',
    NULL,
    'Menyediakan berbagai kebutuhan sembako pilihan dengan kualitas terjamin dan harga terjangkau untuk keluarga Anda.',
    'Katalog Produk',
    'Order via WhatsApp',
    NULL,
    'active',
    'active',
    'active',
    'instan_rekap',
    '6281234567890',
    NULL,
    NULL,
    'Jakarta, Indonesia',
    'off',
    NOW(),
    NOW()
WHERE @sembako_template_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM products
      WHERE slug = 'sembako-lengkap'
  );

SET @sembako_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'sembako-lengkap'
    LIMIT 1
);

INSERT INTO pivot_product_categories (product_id, category_id, created_at, updated_at)
SELECT @sembako_product_id, @sembako_category_id, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND @sembako_category_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_categories
      WHERE product_id = @sembako_product_id
        AND category_id = @sembako_category_id
  );

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @sembako_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN (
    'Belanja mudah, barang sampai rumah!',
    'Lengkap',
    'Harga Hemat',
    'Kualitas Terjamin',
    'Pengiriman Cepat',
    'Segar & Fresh'
)
  AND @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @sembako_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'minyak-goreng-premium.jpg', 'Minyak Goreng Premium', 20000, 'Minyak goreng berkualitas, jernih, dan tahan panas.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Minyak Goreng Premium'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'beras-premium-5kg.jpg', 'Beras Premium 5kg', 65000, 'Beras pulen, bersih, dan wangi. Cocok untuk keluarga.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Beras Premium 5kg'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'mie-instan-rasa-ayam.jpg', 'Mie Instan Rasa Ayam', 3000, 'Rasa gurih dan nikmat, praktis dan mengenyangkan.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Mie Instan Rasa Ayam'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'gula-pasir-premium-1kg.jpg', 'Gula Pasir Premium 1kg', 13000, 'Gula pasir putih berkualitas, bersih dan higienis.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Gula Pasir Premium 1kg'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'tepung-terigu-serbaguna.jpg', 'Tepung Terigu Serbaguna', 12000, 'Cocok untuk berbagai jenis kue dan masakan.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Tepung Terigu Serbaguna'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'sarden-dalam-saus-tomat.jpg', 'Sarden Dalam Saus Tomat', 9500, 'Sumber protein tinggi, lezat dan siap santap.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND title = 'Sarden Dalam Saus Tomat'
  );

COMMIT;
