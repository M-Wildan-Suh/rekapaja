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
    WHERE BINARY category = BINARY 'Cantik Alami, Percaya Diri Setiap Hari'
);

SET @skincare_category_id := (
    SELECT id
    FROM categories
    WHERE BINARY category = BINARY 'Cantik Alami, Percaya Diri Setiap Hari'
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Aman', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Aman'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Hasil Nyata', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Hasil Nyata'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Bahan Berkualitas', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Bahan Berkualitas'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Aman Digunakan', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Aman Digunakan'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Cocok untuk Semua Jenis Kulit', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Cocok untuk Semua Jenis Kulit'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Hasil Nyata & Terbukti', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE BINARY tag = BINARY 'Hasil Nyata & Terbukti'
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
WHERE BINARY tag IN (
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
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Serum Bright Glow'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'facial-wash-bright-fresh.jpg', 'Facial Wash Bright & Fresh', 69000, 'Membersihkan kotoran dan minyak berlebih tanpa membuat kulit kering.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Facial Wash Bright & Fresh'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'toner-hydrating-brightening.jpg', 'Toner Hydrating + Brightening', 89000, 'Melembapkan, menyegarkan, dan membantu menjaga skin barrier.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Toner Hydrating + Brightening'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'moisturizer-glowing-care.jpg', 'Moisturizer Glowing Care', 119000, 'Melembapkan kulit, menjaga elastisitas, dan membuat kulit tampak lebih sehat.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Moisturizer Glowing Care'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'sunscreen-spf-50.jpg', 'Sunscreen SPF 50 PA++++', 89000, 'Melindungi kulit dari sinar UVA & UVB, tidak lengket dan nyaman di kulit.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Sunscreen SPF 50 PA++++'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @skincare_product_id, 'acne-treatment-serum.jpg', 'Acne Treatment Serum', 129000, 'Membantu merawat jerawat, menenangkan kemerahan, dan mengontrol minyak.', 1, NULL, NOW(), NOW()
WHERE @skincare_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @skincare_product_id AND BINARY title = BINARY 'Acne Treatment Serum'
  );

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
WHERE BINARY tag IN (
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
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Puding Putih Strawberry'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-mango.jpg', 'Puding Putih Mango', 7000, 'Rasa mangga yang fresh dengan tekstur lembut dan creamy.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Puding Putih Mango'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-melon.jpg', 'Puding Putih Melon', 7000, 'Varian melon yang ringan, harum, dan cocok untuk camilan keluarga.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Puding Putih Melon'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-taro.jpg', 'Puding Putih Taro', 7000, 'Pudding taro lembut dengan aroma khas yang manis dan elegan.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Puding Putih Taro'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'puding-putih-cokelat.jpg', 'Puding Putih Cokelat', 7000, 'Perpaduan rasa cokelat manis dengan tekstur pudding yang lembut.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Puding Putih Cokelat'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-original.jpg', 'Donat Kampung Original', 5000, 'Donat kampung empuk dengan rasa klasik yang selalu bikin kangen.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Donat Kampung Original'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-gula-halus.jpg', 'Donat Kampung Gula Halus', 5000, 'Donat lembut dengan taburan gula halus yang manis dan sederhana.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Donat Kampung Gula Halus'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @pudding_product_id, 'donat-kampung-cokelat-meses.jpg', 'Donat Kampung Cokelat Meses', 6000, 'Donat kampung dengan topping cokelat meses yang manis dan favorit anak-anak.', 1, NULL, NOW(), NOW()
WHERE @pudding_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @pudding_product_id AND BINARY title = BINARY 'Donat Kampung Cokelat Meses'
  );

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
WHERE BINARY tag IN (
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
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Minyak Goreng Premium'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'beras-premium-5kg.jpg', 'Beras Premium 5kg', 65000, 'Beras pulen, bersih, dan wangi. Cocok untuk keluarga.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Beras Premium 5kg'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'mie-instan-rasa-ayam.jpg', 'Mie Instan Rasa Ayam', 3000, 'Rasa gurih dan nikmat, praktis dan mengenyangkan.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Mie Instan Rasa Ayam'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'gula-pasir-premium-1kg.jpg', 'Gula Pasir Premium 1kg', 13000, 'Gula pasir putih berkualitas, bersih dan higienis.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Gula Pasir Premium 1kg'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'tepung-terigu-serbaguna.jpg', 'Tepung Terigu Serbaguna', 12000, 'Cocok untuk berbagai jenis kue dan masakan.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Tepung Terigu Serbaguna'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @sembako_product_id, 'sarden-dalam-saus-tomat.jpg', 'Sarden Dalam Saus Tomat', 9500, 'Sumber protein tinggi, lezat dan siap santap.', 1, NULL, NOW(), NOW()
WHERE @sembako_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @sembako_product_id AND BINARY title = BINARY 'Sarden Dalam Saus Tomat'
  );

SET @template_one_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'one'
    ORDER BY id
    LIMIT 1
);

SET @template_florist_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'florist'
    ORDER BY id
    LIMIT 1
);

UPDATE products
SET
    template_id = @template_one_id,
    template = 'one',
    updated_at = NOW()
WHERE template_id = @template_florist_id
  AND @template_one_id IS NOT NULL
  AND @template_florist_id IS NOT NULL;

DELETE FROM templates
WHERE id = @template_florist_id
  AND head_type = 'florist'
  AND @template_florist_id IS NOT NULL;

COMMIT;
