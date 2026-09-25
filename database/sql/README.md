# Update gabungan perubahan 25 September 2026

Gunakan [update_2026_09_25.sql](update_2026_09_25.sql) untuk update manual seluruh
perubahan database dalam working tree ini. Script ini menggantikan kebutuhan
menjalankan script konversi template dan template per usaha secara terpisah.

Urutan yang ditangani:

1. Menambahkan enam kolom JSON section pada tabel templates bila belum ada.
2. Menambahkan products.template_settings dan products.created_by beserta foreign key ON DELETE SET NULL.
3. Mengisi key JSON yang belum ada dari kolom template lama yang tersedia.
4. Menyalin desain template ke usaha yang template_settings-nya masih NULL.
5. Mencatat dua migration baru, tanpa menduplikasi migration yang sudah tercatat.
6. Menampilkan hasil verifikasi.

Sebelum menjalankan: backup database, aktifkan maintenance mode, dan pilih database
aplikasi di SQL client. Jalankan seluruh file dalam satu koneksi dengan opsi
berhenti saat error. DDL MySQL/MariaDB melakukan implicit commit, sehingga rollback
bukan pengganti backup. Jika gagal, periksa penyebabnya sebelum mengulang.

Prasyarat: tabel users, products, templates, dan migrations sudah tersedia dari
versi sebelumnya, users.id bertipe BIGINT UNSIGNED, dan users.role bertipe VARCHAR
sesuai migration aplikasi. Ini bukan script instalasi baru. Pembaruan voucher dan
invoice dari commit terdahulu tidak diulang di sini.

Script melewati kolom/foreign key/migration yang sudah ada dan tidak menimpa
products.template_settings yang sudah terisi. Kolom template lama dipertahankan
untuk menghindari penghapusan data, sedangkan model terbaru membaca kolom JSON.
Jika kedua skema tersedia, key JSON yang sudah ada diprioritaskan.

Role Operator tidak membutuhkan ALTER TABLE users atau INSERT role, karena role
berupa string. Pilih Operator melalui pengelolaan akun setelah kode aplikasi
diperbarui. Kolom created_by pada usaha lama tetap NULL karena riwayat pembuatnya
tidak tersedia; script tidak menetapkan kepemilikan berdasarkan perkiraan.
Penghapusan tombol Home dan penyesuaian UI tidak membutuhkan perubahan database.

Hasil akhir yang diharapkan: belum_memiliki_template = 0 dan kedua migration baru
tercatat. usaha_tanpa_pencatat boleh lebih dari 0 untuk usaha lama.

Pengujian script: php tests/sql/manual_update_2026_09_25.php menggunakan database
sementara MySQL/MariaDB dan memerlukan izin CREATE/DROP DATABASE. Pengujian mencakup
skema legacy, JSON, tanpa template_id, pengulangan script, pelestarian desain,
dan perilaku foreign key. Database aplikasi tidak dimigrasikan oleh pengujian ini.

---

# Konversi pengaturan template ke JSON

Untuk database yang sudah ada, jalankan `templates_to_section_json.sql` sekali
di database aplikasi melalui SQL client/phpMyAdmin. Tidak perlu menjalankan
`migrate`, `migrate:refresh`, atau `migrate:fresh`.

Aktifkan maintenance mode (`php artisan down`), jalankan SQL dengan pengaturan
berhenti jika ada error, lalu aktifkan kembali aplikasi (`php artisan up`) setelah
kode baru dan skema JSON tersedia. Script membuat backup
`templates_backup_before_section_json`, menyalin semua nilai lama ke JSON,
kemudian menghapus kolom pengaturan lama. DDL MySQL/MariaDB tidak dapat dibatalkan
dengan rollback transaksi biasa. Jika proses gagal, periksa tahap terakhir;
jangan jalankan ulang seluruh script karena kolom/tabel mungkin sudah dibuat.

Kolom `id`, `name`, `image`, timestamps, serta relasi gambar gallery/highlight
tetap seperti sebelumnya. Migration awal sudah disesuaikan untuk instalasi baru.

Contoh struktur:

```json
{
  "background": {"type": "normal", "image": null, "main_color": "#FFFFFF", "second_color": null, "accent_color": "#A72018"},
  "head": {"type": "one"},
  "gallery": {"type": "square"},
  "desc": {"type": "default", "main_color": "#FFFFFF", "text_color": "#000000"},
  "product": {"type": "grid2", "main_color": "#FFFFFF", "second_color": "#A72018", "text_color": "#000000"},
  "contact": {"main_color": "#A72018", "second_color": "#000000"}
}
```

Model mengubah JSON menjadi array secara otomatis. Untuk pengaturan baru,
gunakan pola berikut agar perubahan array tersimpan:

```php
$head = $template->head ?? [];
$head['type'] = 'one';
$head['custom_setting'] = 'value';
$template->head = $head;
$template->save();
```

Akses lama seperti `$template->head_type` tetap tersedia sebagai alias pada
model untuk form/controller/Blade yang ada. Alias menulis langsung ke JSON dan
mempertahankan key lain. Hasil `toArray()`/JSON model menggunakan enam bagian
baru; query SQL langsung harus memakai kolom JSON, bukan nama alias.
