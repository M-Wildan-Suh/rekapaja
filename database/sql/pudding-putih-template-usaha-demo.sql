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
    'Pudding Putih',
    NULL,
    'normal',
    NULL,
    '#FFF8F4',
    '#FDEEF8',
    '#F0679A',
    'pudding_putih',
    'square',
    'default',
    '#FFF8F4',
    '#5C3446',
    'grid3',
    '#FFFFFF',
    '#F26CA7',
    '#5C3446',
    '#39B54A',
    '#FFFFFF',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'pudding_putih'
);

SET @pudding_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'pudding_putih'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

INSERT INTO categories (category, created_at, updated_at)
SELECT 'Manisnya Pas, Lembutnya Juara!', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM categories
    WHERE BINARY category = BINARY 'Manisnya Pas, Lembutnya Juara!'
);

SET @pudding_category_id := (
    SELECT id
    FROM categories
    WHERE BINARY category = BINARY 'Manisnya Pas, Lembutnya Juara!'
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Dibuat Fresh Setiap Hari', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Dibuat Fresh Setiap Hari'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Bahan Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Bahan Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Dibuat Fresh', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Dibuat Fresh'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Pengiriman Cepat', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Pengiriman Cepat'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Tanpa Pengawet', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Tanpa Pengawet'
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
    'Puding Putih',
    'puding-putih',
    'puding-putih-banner.jpg',
    'one',
    @pudding_template_id,
    'Aneka Rasa & Donat Kampung',
    NULL,
    'Pilihan camilan manis keluarga dengan tekstur lembut, rasa fresh, dan varian favorit yang cocok dinikmati setiap hari.',
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
WHERE @pudding_template_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM products
      WHERE slug = 'puding-putih'
  );

SET @pudding_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'puding-putih'
    LIMIT 1
);

INSERT INTO pivot_product_categories (product_id, category_id, created_at, updated_at)
SELECT @pudding_product_id, @pudding_category_id, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND @pudding_category_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_categories
      WHERE product_id = @pudding_product_id
        AND category_id = @pudding_category_id
  );

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @pudding_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN (
    'Dibuat Fresh Setiap Hari',
    'Bahan Berkualitas',
    'Dibuat Fresh',
    'Pengiriman Cepat',
    'Tanpa Pengawet'
)
  AND @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @pudding_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-strawberry.jpg', 'Puding Putih Strawberry', 7000, 'Puding lembut dengan rasa stroberi segar yang manis dan ringan.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Puding Putih Strawberry'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-mango.jpg', 'Puding Putih Mango', 7000, 'Rasa mangga yang fresh dengan tekstur lembut dan creamy.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Puding Putih Mango'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-melon.jpg', 'Puding Putih Melon', 7000, 'Varian melon yang ringan, harum, dan cocok untuk camilan keluarga.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Puding Putih Melon'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-taro.jpg', 'Puding Putih Taro', 7000, 'Pudding taro lembut dengan aroma khas yang manis dan elegan.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Puding Putih Taro'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-cokelat.jpg', 'Puding Putih Cokelat', 7000, 'Perpaduan rasa cokelat manis dengan tekstur pudding yang lembut.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Puding Putih Cokelat'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-original.jpg', 'Donat Kampung Original', 5000, 'Donat kampung empuk dengan rasa klasik yang selalu bikin kangen.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Donat Kampung Original'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-gula-halus.jpg', 'Donat Kampung Gula Halus', 5000, 'Donat lembut dengan taburan gula halus yang manis dan sederhana.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Donat Kampung Gula Halus'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-cokelat-meses.jpg', 'Donat Kampung Cokelat Meses', 6000, 'Donat kampung dengan topping cokelat meses yang manis dan favorit anak-anak.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND title = 'Donat Kampung Cokelat Meses'
  );

COMMIT;
