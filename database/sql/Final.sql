SET NAMES utf8mb4;
START TRANSACTION;

UPDATE templates
SET product_type = CASE
    WHEN product_type IN ('ramen', 'network', 'florist', 'flors') THEN 'grid3'
    WHEN product_type = 'grid' THEN 'grid2'
    ELSE product_type
END
WHERE product_type IN ('ramen', 'network', 'florist', 'flors', 'grid');

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
    'Ramen Lezat',
    NULL,
    'normal',
    NULL,
    '#f0f0f0',
    NULL,
    '#b12719',
    'ramen',
    'square',
    'ramen',
    '#b12719',
    '#ffffff',
    'grid3',
    '#ffffff',
    '#3ea648',
    '#1f1915',
    '#3ea648',
    '#b12719',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'ramen'
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
    'Network',
    NULL,
    'normal',
    NULL,
    '#ffffff',
    NULL,
    '#2563eb',
    'network',
    'network',
    'network',
    '#ffffff',
    '#1e293b',
    'grid3',
    '#ffffff',
    '#2563eb',
    '#1e293b',
    '#2563eb',
    '#0f172a',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'network'
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
    '#F58CB3',
    NOW(),
    NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM templates
    WHERE head_type = 'donut'
);

SET @network_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'network'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

SET @ramen_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'ramen'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

SET @donut_template_id := (
    SELECT id
    FROM templates
    WHERE head_type = 'donut'
      AND product_type = 'grid3'
    ORDER BY id
    LIMIT 1
);

INSERT INTO categories (category, created_at, updated_at)
SELECT CONVERT(0xE3838DE38383E38388E383AFE383BCE382AFE6A99FE599A8 USING utf8mb4), NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM categories
    WHERE category = CONVERT(0xE3838DE38383E38388E383AFE383BCE382AFE6A99FE599A8 USING utf8mb4)
);

SET @network_category_id := (
    SELECT id
    FROM categories
    WHERE category = CONVERT(0xE3838DE38383E38388E383AFE383BCE382AFE6A99FE599A8 USING utf8mb4)
    LIMIT 1
);

INSERT INTO categories (category, created_at, updated_at)
SELECT CONVERT(0xE3818AE38184E38197E38184E383A9E383BCE383A1E383B3 USING utf8mb4), NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1
    FROM categories
    WHERE category = CONVERT(0xE3818AE38184E38197E38184E383A9E383BCE383A1E383B3 USING utf8mb4)
);

SET @ramen_category_id := (
    SELECT id
    FROM categories
    WHERE category = CONVERT(0xE3818AE38184E38197E38184E383A9E383BCE383A1E383B3 USING utf8mb4)
    LIMIT 1
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Produk Original', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Produk Original'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Bergaransi Resmi', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Bergaransi Resmi'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Harga Terbaik', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Harga Terbaik'
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
SELECT 'Pengiriman Cepat', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Pengiriman Cepat'
);

INSERT INTO product_tags (tag, created_at, updated_at)
SELECT 'Rasa Jepang', NOW(), NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM product_tags WHERE tag = 'Rasa Jepang'
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
    'Semua Alat Jaringan Lengkap',
    'semua-alat-jaringan-lengkap',
    'network-banner-hero.jpg',
    'one',
    @network_template_id,
    '& Berkualitas!',
    NULL,
    'Menyediakan berbagai kebutuhan jaringan untuk rumah, kantor, bisnis, dan proyek Anda. Koneksi lancar, kerja makin nyaman.',
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
WHERE @network_template_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM products
      WHERE slug = 'semua-alat-jaringan-lengkap'
  );

SET @network_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'semua-alat-jaringan-lengkap'
    LIMIT 1
);

INSERT INTO pivot_product_categories (product_id, category_id, created_at, updated_at)
SELECT @network_product_id, @network_category_id, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND @network_category_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_categories
      WHERE product_id = @network_product_id
        AND category_id = @network_category_id
  );

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @network_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN ('Produk Original', 'Bergaransi Resmi', 'Harga Terbaik')
  AND @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @network_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'kabel-lan-utp-cat6.jpg', 'Kabel LAN UTP Cat6', 1250, 'Kabel jaringan berkualitas tinggi untuk koneksi cepat dan stabil.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Kabel LAN UTP Cat6'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'router-wifi-tp-link.jpg', 'Router WiFi TP-Link', 350000, 'Koneksi WiFi stabil, jangkauan luas, ideal untuk rumah dan kantor.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Router WiFi TP-Link'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'cctv-hikvision-2mp.jpg', 'CCTV Hikvision 2MP', 450000, 'Gambar jernih, night vision jelas, keamanan lebih terjamin.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'CCTV Hikvision 2MP'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'switch-8-port-gigabit.jpg', 'Switch 8 Port Gigabit', 275000, 'Transfer data cepat dan stabil untuk kebutuhan jaringan Anda.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Switch 8 Port Gigabit'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'adapter-wifi-usb.jpg', 'Adapter WiFi USB', 125000, 'Menerima sinyal WiFi lebih kuat, praktis dan mudah digunakan.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Adapter WiFi USB'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'connector-rj45-boot.jpg', 'Connector RJ45 + Boot', 350, 'Konektor berkualitas untuk hasil crimping yang sempurna.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Connector RJ45 + Boot'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'access-point-outdoor.jpg', 'Access Point Outdoor', 650000, 'Jangkauan jauh, tahan cuaca, solusi jaringan outdoor handal.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Access Point Outdoor'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'modem-ont-fiber.jpg', 'Modem ONT Fiber', 575000, 'Koneksi fiber optik super cepat dan stabil untuk internet rumah.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'Modem ONT Fiber'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @network_product_id, 'dvr-hikvision-4-channel.jpg', 'DVR Hikvision 4 Channel', 750000, 'Mendukung 4 kamera CCTV, recording jernih dan stabil.', 1, NULL, NOW(), NOW()
WHERE @network_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @network_product_id AND title = 'DVR Hikvision 4 Channel'
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
    'Ramen Lezat,',
    'ramen-lezat',
    'ramen-banner-hero.jpg',
    'one',
    @ramen_template_id,
    'Buat Hari Makin Nikmat!',
    NULL,
    'Ramen berkualitas dengan kuah kaya rasa, mie kenyal, dan topping premium pilihan.',
    'Menu Favorit',
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
WHERE @ramen_template_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM products
      WHERE slug = 'ramen-lezat'
  );

SET @ramen_product_id := (
    SELECT id
    FROM products
    WHERE slug = 'ramen-lezat'
    LIMIT 1
);

INSERT INTO pivot_product_categories (product_id, category_id, created_at, updated_at)
SELECT @ramen_product_id, @ramen_category_id, NOW(), NOW()
WHERE @ramen_product_id IS NOT NULL
  AND @ramen_category_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_categories
      WHERE product_id = @ramen_product_id
        AND category_id = @ramen_category_id
  );

INSERT INTO pivot_product_tags (product_id, tag_id, created_at, updated_at)
SELECT @ramen_product_id, id, NOW(), NOW()
FROM product_tags
WHERE tag IN ('Bahan Berkualitas', 'Tanpa Pengawet', 'Pengiriman Cepat', 'Rasa Jepang')
  AND @ramen_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1
      FROM pivot_product_tags ppt
      WHERE ppt.product_id = @ramen_product_id
        AND ppt.tag_id = product_tags.id
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @ramen_product_id, 'tori-shoyu-ramen.jpg', 'Tori Shoyu Ramen', 32000, 'Kuah shoyu gurih dengan chashu ayam yang lembut.', 1, NULL, NOW(), NOW()
WHERE @ramen_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @ramen_product_id AND title = 'Tori Shoyu Ramen'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @ramen_product_id, 'spicy-miso-ramen.jpg', 'Spicy Miso Ramen', 34000, 'Kuah miso pedas gurih yang kaya rasa dan menggugah selera.', 1, NULL, NOW(), NOW()
WHERE @ramen_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @ramen_product_id AND title = 'Spicy Miso Ramen'
  );

INSERT INTO highlights (product_id, image, title, price, description, available, rating, created_at, updated_at)
SELECT @ramen_product_id, 'tonkotsu-ramen.jpg', 'Tonkotsu Ramen', 33000, 'Kuah tonkotsu kental khas Jepang dengan cita rasa otentik.', 1, NULL, NOW(), NOW()
WHERE @ramen_product_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM highlights WHERE product_id = @ramen_product_id AND title = 'Tonkotsu Ramen'
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
WHERE @donut_template_id IS NOT NULL
  AND NOT EXISTS (
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
