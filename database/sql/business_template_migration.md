# Template per usaha

Pengaturan desain sekarang disimpan di `products.template_settings`. Setiap usaha
memiliki salinan sendiri dan editor tersedia pada **Edit Usaha → Template**.
Usaha baru mendapat desain awal otomatis; penyalinan lewat voucher juga menyalin
pengaturan desain secara independen.

Untuk memperbarui instalasi yang sudah ada, jalankan:

```sh
php artisan migrate --path=database/migrations/2026_09_24_000001_add_template_settings_to_products_table.php --force
php artisan view:clear
npm run build
```

Alternatif melalui phpMyAdmin/SQL client: pilih database aplikasi lalu jalankan
[business_template_settings.sql](business_template_settings.sql). SQL ini untuk
tabel `templates` yang sudah memakai enam kolom JSON per bagian. Script menambah
`products.template_settings`, menyalin desain lama, dan mencatat migration Laravel.
Script melewati kolom yang sudah tersedia dan tidak menimpa pengaturan usaha yang
sudah terisi, sehingga juga bisa dijalankan pada database yang sudah dimigrasikan.
Untuk skema template dengan kolom datar, gunakan migration Laravel di atas.

Migrasi menyalin desain yang sebelumnya dipilih melalui `template_id`, mendukung
kolom template lama maupun JSON per bagian. Data template lama tetap disimpan
untuk referensi, tetapi halaman publik dan editor tidak lagi membacanya.
Halaman katalog, editor template terpisah, dan endpoint pengelolaannya dihapus
dari routing. Pengaturan desain hanya dapat disimpan melalui usaha yang boleh
diakses pengguna.

Rollback migrasi menghapus pengaturan desain per usaha, termasuk perubahan yang
dibuat setelah migrasi; ekspor kolom tersebut sebelum melakukan rollback.
