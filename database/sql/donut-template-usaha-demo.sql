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
    'Donut Manis',
    NULL,
    'normal',
    NULL,
    '#FFF8F4',
    '#FFECEF',
    '#E66B98',
    'donut',
    'square',
    'default',
    '#FFF8F4',
    '#4A2F22',
    'grid3',
    '#FFFFFF',
    '#F58CB3',
    '#4A2F22',
    '#8CC56E',
    '#FDECEF',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'donut'
);

SET @donut_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'donut'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Bahan Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Bahan Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Tanpa Pengawet', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Tanpa Pengawet'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Dikemas Higienis', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Dikemas Higienis'
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
    'Donat Lezat,',
    'donat-lezat',
    'donut-banner-hero.jpg',
    'one',
    @donut_template_id,
    'Setiap Gigitan Penuh Kenangan',
    NULL,
    'Donat fresh setiap hari, dibuat dari bahan berkualitas dengan topping pilihan terbaik. Lembut, empuk dan nikmat!',
    'Produk Unggulan',
    'Chat WhatsApp',
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
WHERE NOT EXISTS (
    SELECT 1
    FROM products
    WHERE slug = 'donat-lezat'
);

SET @donut_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'donat-lezat'
    LIMIT 1
);

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @donut_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN ('Bahan Berkualitas', 'Tanpa Pengawet', 'Dikemas Higienis')
  AND @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @donut_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-cokelat-kacang.jpg', 'Donat Cokelat Kacang', 12000, 'Cokelat glaze dengan taburan kacang yang renyah.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Cokelat Kacang'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-strawberry.jpg', 'Donat Strawberry', 12000, 'Glaze stroberi manis dengan taburan sprinkle warna-warni.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Strawberry'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-matcha.jpg', 'Donat Matcha', 13000, 'Perpaduan matcha premium yang lembut dan nikmat.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Matcha'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-cookies-cream.jpg', 'Donat Cookies & Cream', 13000, 'Krim vanila lembut dengan taburan cookies.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Cookies & Cream'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-choco-delight.jpg', 'Donat Choco Delight', 12000, 'Cokelat glaze premium yang bikin nagih.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Choco Delight'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @donut_product_id, 'donat-rainbow.jpg', 'Donat Rainbow', 12000, 'Glaze manis dengan taburan sprinkle warna-warni.', 1, NULL, NOW(), NOW()
WHERE @donut_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @donut_product_id AND title = 'Donat Rainbow'
  );

COMMIT;
