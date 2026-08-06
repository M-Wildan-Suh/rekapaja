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
    'Skincare Glow',
    NULL,
    'normal',
    NULL,
    '#FFF7FB',
    '#FDECF7',
    '#EF6AA5',
    'skincare',
    'square',
    'default',
    '#FFF7FB',
    '#4A2F3A',
    'grid3',
    '#FFFFFF',
    '#F26CA7',
    '#4A2F3A',
    '#EF4F97',
    '#FFFFFF',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'skincare'
);

SET @skincare_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'skincare'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

INSERT INTO categories (category, created_at, updated_at)
SELECT 'Cantik Alami, Percaya Diri Setiap Hari', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM categories
    WHERE category = 'Cantik Alami, Percaya Diri Setiap Hari'
);

SET @skincare_category_id := (
    SELECT id
    FROM categories
    WHERE category = 'Cantik Alami, Percaya Diri Setiap Hari'
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Aman', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Aman'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Hasil Nyata', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Hasil Nyata'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Bahan Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Bahan Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Aman Digunakan', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Aman Digunakan'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Cocok untuk Semua Jenis Kulit', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Cocok untuk Semua Jenis Kulit'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Hasil Nyata & Terbukti', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Hasil Nyata & Terbukti'
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
    'Skincare Terbaik',
    'skincare-terbaik',
    'skincare-banner-hero.jpg',
    'one',
    @skincare_template_id,
    'untuk Kulitmu',
    NULL,
    'Rangkaian skincare pilihan dengan bahan berkualitas untuk kulit sehat, cerah, dan glowing setiap hari!',
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
WHERE @skincare_template_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM products
      WHERE slug = 'skincare-terbaik'
  );

SET @skincare_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'skincare-terbaik'
    LIMIT 1
);

INSERT INTO pivot_product_categories (product_id, category_id, created_at, updated_at)
SELECT @skincare_product_id, @skincare_category_id, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND @skincare_category_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_categories
      WHERE product_id = @skincare_product_id
        AND category_id = @skincare_category_id
  );

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @skincare_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN (
    'Aman',
    'Berkualitas',
    'Hasil Nyata',
    'Bahan Berkualitas',
    'Aman Digunakan',
    'Cocok untuk Semua Jenis Kulit',
    'Hasil Nyata & Terbukti'
)
  AND @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @skincare_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'serum-bright-glow.jpg', 'Serum Bright Glow', 129000, 'Mencerahkan, menyamarkan noda hitam, dan membuat kulit lebih glowing.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Serum Bright Glow'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'facial-wash-bright-fresh.jpg', 'Facial Wash Bright & Fresh', 69000, 'Membersihkan kotoran dan minyak berlebih tanpa membuat kulit kering.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Facial Wash Bright & Fresh'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'toner-hydrating-brightening.jpg', 'Toner Hydrating + Brightening', 89000, 'Melembapkan, menyegarkan, dan membantu menjaga skin barrier.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Toner Hydrating + Brightening'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'moisturizer-glowing-care.jpg', 'Moisturizer Glowing Care', 119000, 'Melembapkan kulit, menjaga elastisitas, dan membuat kulit tampak lebih sehat.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Moisturizer Glowing Care'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'sunscreen-spf-50.jpg', 'Sunscreen SPF 50 PA++++', 89000, 'Melindungi kulit dari sinar UVA & UVB, tidak lengket dan nyaman di kulit.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Sunscreen SPF 50 PA++++'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'acne-treatment-serum.jpg', 'Acne Treatment Serum', 129000, 'Membantu merawat jerawat, menenangkan kemerahan, dan mengontrol minyak.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND title = 'Acne Treatment Serum'
  );

COMMIT;
