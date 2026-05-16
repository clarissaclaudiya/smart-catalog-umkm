# Panduan Presentasi UTS: Smart-Catalog UMKM

**Oleh:** Clarissa Yesha Claudiya
**Mata Kuliah:** Pemrograman Web (Framework Laravel 13)

---

## I. Ringkasan Proyek
**Smart-Catalog UMKM** adalah platform *Business-to-Business* (B2B) yang dirancang untuk menghubungkan Admin (Pemilik Sistem) dengan ribuan Merchant UMKM. Sistem ini memastikan keamanan data dan kemudahan pengelolaan katalog produk, serta alur pemesanan stok barang oleh Merchant kepada Admin.

### Kesesuaian dengan 8 Syarat UTS:
1. **Routing & Controller:** Struktur URL terpisah rapi dengan Controller spesifik (`AuthController`, `DashboardController`, `ProductController`, dll).
2. **Model:** Model yang mendefinisikan tabel dan *Mass Assignment* (`$fillable`) untuk integritas data.
3. **View Layouting:** Menggunakan Blade Template Engine dengan *Template Inheritance* (`@extends('layouts.app')`).
4. **CRUD Kategori & Produk:** Terdapat relasi *One-to-Many* antara Kategori dan Produk.
5. **Autentikasi:** Fitur keamanan Register & Login menggunakan sistem bawaan Laravel Auth.
6. **Middleware:** Proteksi hak akses. Merchant tidak bisa mengakses menu Admin, begitu pula sebaliknya.
7. **Manajemen File:** Setiap produk diwajibkan memiliki foto sebagai bukti fisik, menggunakan `Storage` facade Laravel dan `php artisan storage:link`.
8. **Dashboard & Laporan:** Dashboard dinamis menampilkan statistik, ditambah sistem log History Approval dan Order.

---

## II. Arsitektur Sistem (Model-View-Controller)

Proyek ini dibangun di atas fondasi MVC standar Laravel:

*   **Model (`app/Models`):** 
    *   `User`: Menangani autentikasi, role (`admin`, `merchant`), dan status (`pending`, `approved`, `rejected`, `suspended`).
    *   `Category` & `Product`: Relasi barang.
    *   `Order` & `Cart`: Proses transaksi stok.
    *   `MerchantLog`: Menyimpan jejak aktivitas admin terhadap akun merchant.
*   **View (`resources/views`):**
    *   Dibagi menjadi folder-folder logis (`categories/`, `products/`, `merchants/`, `orders/`).
    *   Setiap view difokuskan pada UI/UX yang responsif menggunakan Bootstrap.
*   **Controller (`app/Http/Controllers`):**
    *   Menjadi otak aplikasi. Contoh: `MerchantController` menangani logika persetujuan (approve/reject/suspend), sementara `OrderController` mengelola validasi stok admin saat merchant melakukan pesanan.

---

## III. Alur Bisnis (System Flow)

### 1. Alur Registrasi & Approval Merchant
*   **Merchant:** Mendaftar -> Status menjadi `pending`. Belum bisa login.
*   **Admin:** Melihat permohonan di menu "Persetujuan Baru".
    *   Jika **Disetujui** -> Status `approved` -> Merchant bisa login. Masuk ke "History Persetujuan".
    *   Jika **Ditolak** -> Status `rejected` -> Merchant gagal login. Masuk ke "History Persetujuan".
*   **Admin:** Bisa menonaktifkan merchant aktif -> Status `suspended`. Merchant tidak bisa login lagi sampai diaktifkan kembali dari menu "Nonaktif".

### 2. Alur Pengelolaan Produk (Admin)
*   Admin wajib membuat **Kategori** terlebih dahulu.
*   Admin membuat **Produk** dengan mengisi data, stok, dan **wajib upload foto**. File foto disimpan di direktori `storage/app/public/products`.

### 3. Alur Order Stok (Merchant)
*   Merchant melihat produk yang stoknya > 0 di menu "Belanja Barang".
*   Merchant memasukkan ke Keranjang atau langsung Order.
*   Order masuk ke Admin ("Persetujuan Order") dengan status `pending`.
*   Admin klik Approve -> Stok Master Produk berkurang -> Status Order menjadi `approved` -> Muncul di "Stok Toko Saya" milik Merchant.

---

## IV. Daftar 20 Kemungkinan Pertanyaan & Jawaban (Q&A)

Berikut adalah pertanyaan yang sering diajukan dosen penguji beserta cara menjawabnya secara profesional:

### **A. Konsep Dasar & Arsitektur (MVC)**

**1. Q: Apa itu arsitektur MVC dan bagaimana kamu menerapkannya di project ini?**
> A: MVC adalah Model-View-Controller. Di aplikasi ini, **Model** (seperti `Product.php`) berinteraksi dengan database. **Controller** (seperti `ProductController.php`) menerima *request* dari user, meminta data dari Model, lalu mengirimkannya ke **View** (file `.blade.php`) untuk ditampilkan secara visual di browser.

**2. Q: Kenapa kamu menggunakan atribut `$fillable` pada Model kamu?**
> A: `$fillable` digunakan untuk mencegah kerentanan keamanan *Mass Assignment Vulnerability*. Ini memberitahu Laravel secara eksplisit kolom mana saja di tabel database yang diizinkan untuk diisi datanya secara bersamaan melalui form, contohnya seperti `name`, `email`, dan `status`.

**3. Q: Bagaimana cara kamu mengatur Layouting View (Template Inheritance)?**
> A: Saya membuat satu file induk bernama `layouts/app.blade.php` yang berisi struktur HTML utama, CSS, dan Sidebar. Kemudian view lain seperti `index.blade.php` hanya perlu memanggil `@extends('layouts.app')` dan mengisi bagian konten menggunakan `@section('content')`. Ini membuat kode jauh lebih bersih dan tidak berulang (DRY).

### **B. Routing & Middleware**

**4. Q: Apa fungsi Middleware pada aplikasi kamu?**
> A: Middleware bertindak sebagai satpam aplikasi. Saya menggunakan middleware bawaan `auth` untuk memastikan hanya user yang sudah login yang bisa mengakses dashboard. Jika belum login, middleware otomatis mengarahkan user ke halaman login.

**5. Q: Bagaimana cara kamu memisahkan akses menu antara Admin dan Merchant?**
> A: Di sisi View (Blade), saya menggunakan percabangan `@if(Auth::user()->role == 'admin')`. Jadi, sidebar menu yang dirender akan berbeda secara dinamis. Di sisi Controller/Route, kita bisa memvalidasinya kembali dengan mengecek peran user yang sedang login agar merchant tidak bisa menembus URL admin.

**6. Q: Apa fungsi dari file `web.php`?**
> A: File `routes/web.php` adalah peta jalan dari aplikasi web. Semua URL yang bisa dikunjungi oleh pengguna didefinisikan di sini dan diarahkan ke Controller serta method yang tepat untuk diproses.

### **C. Database & Relasi**

**7. Q: Bagaimana kamu menghubungkan tabel Kategori dengan tabel Produk?**
> A: Saya menggunakan relasi *One-to-Many*. Di Model `Category`, ada fungsi `hasMany(Product::class)`. Sedangkan di Model `Product`, ada fungsi `belongsTo(Category::class)`. Di tabel `products`, ada kolom `category_id` sebagai *Foreign Key*.

**8. Q: Bagaimana jika sebuah kategori dihapus, apakah produknya ikut terhapus?**
> A: Ya, pada sistem *migration* database, saya menambahkan opsi `onDelete('cascade')` pada *foreign key* `category_id`. Jadi, saat kategori dihapus, Laravel dan MySQL secara otomatis menghapus produk yang terkait untuk mencegah data yatim (*orphan data*).

**9. Q: Ceritakan tentang fitur Merchant Approval System yang kamu buat!**
> A: Saya memodifikasi proses registrasi agar merchant yang mendaftar diberikan status awal `pending` dan tidak langsung aktif. Saya juga menambahkan pengecekan di `AuthController@login` untuk memblokir login bagi yang statusnya `pending`, `rejected`, atau `suspended`. Admin memiliki panel khusus untuk merubah status tersebut melalui `MerchantController`.

**10. Q: Kenapa repot-repot membuat tabel `merchant_approval_logs`?**
> A: Tabel log ini (Riwayat Persetujuan) dibuat untuk keperluan *Audit Trail* (rekam jejak). Agar sistem akuntabel, admin bisa melacak siapa merchant yang disetujui/ditolak, oleh admin siapa tindakan itu dilakukan, beserta waktu spesifiknya.

### **D. Manajemen File & Penyimpanan**

**11. Q: Bagaimana cara aplikasi menyimpan foto produk yang diupload?**
> A: Saat form disubmit (dengan atribut `enctype="multipart/form-data"`), `ProductController` akan memvalidasi file agar formatnya berupa gambar (jpeg, png, dll). Kemudian file disimpan menggunakan Facade `Storage` ke folder `public/products`. Nama file unik dibuat menggunakan fungsi `time()` untuk mencegah file dengan nama sama tertimpa.

**12. Q: Kenapa kamu harus menjalankan `php artisan storage:link`?**
> A: Secara default, file yang diupload ke folder `storage/app/public` tidak bisa diakses langsung melalui browser (URL) demi keamanan. Perintah `storage:link` membuat *shortcut* (symbolic link) dari direktori `public/storage` ke direktori rahasia tersebut agar gambar bisa ditampilkan di halaman web.

### **E. Validasi & Flow Data**

**13. Q: Jika merchant memesan (order) barang, apakah stok master otomatis berkurang saat itu juga?**
> A: Tidak. Saat merchant mengklik pesanan, statusnya adalah `pending`. Stok master admin hanya akan berkurang **ketika Admin menekan tombol Approve** di menu Persetujuan Order. Logika pengurangannya menggunakan fungsi `decrement('stock', $quantity)` di dalam `OrderController`.

**14. Q: Apa yang terjadi jika admin ingin approve order, tapi sisa stok tiba-tiba kurang dari jumlah yang dipesan?**
> A: Sebelum sistem memproses tombol Approve, saya menambahkan validasi `$order->quantity > $product->stock`. Jika melebihi, transaksi dibatalkan dan sistem mengembalikan pesan error (*Error alert*) kepada admin bahwa stok tidak mencukupi.

**15. Q: Sebutkan jenis validasi apa saja yang kamu terapkan saat menambah produk?**
> A: Saat Admin klik "Simpan", sistem memvalidasi: 1) Nama produk wajib diisi, 2) Kategori wajib dipilih, 3) Harga wajib berupa angka numerik, 4) Stok wajib angka minimal 0, 5) Foto wajib disertakan dengan format gambar maksimal 2MB.

### **F. Teknis Tambahan**

**16. Q: Perintah Artisan apa yang paling sering kamu gunakan dalam project ini?**
> A: `php artisan serve` untuk menjalankan local server, `php artisan make:controller` dan `make:model` untuk membuat struktur MVC, serta `php artisan migrate` untuk mengeksekusi skema tabel ke database MySQL.

**17. Q: Bagaimana kamu menampilkan fallback/gambar darurat jika foto produk rusak atau dihapus?**
> A: Di file Blade, saya menggunakan pengecekan kondisi `@if($product->image && Storage::exists('public/products/' . $product->image))`. Jika file fisik foto benar-benar ada di storage, fotonya ditampilkan. Jika tidak ada, sistem akan menampilkan sebuah Icon Box SVG sebagai pengganti otomatis (*fallback*).

**18. Q: Apa maksud dari kode `@csrf` yang ada di setiap form HTML kamu?**
> A: `@csrf` adalah fitur perlindungan dari Laravel terhadap serangan *Cross-Site Request Forgery*. Ini menanamkan token rahasia di dalam form. Jika form disubmit dari website luar (bajakan) yang tidak memiliki token tersebut, Laravel akan menolak permintaan tersebut dengan error 419 Page Expired.

**19. Q: Bagaimana kamu mendesain antarmuka aplikasinya? Menggunakan framework apa?**
> A: Saya menggunakan **Bootstrap** (melalui integrasi CDN) yang dikombinasikan dengan sentuhan *Custom CSS* (seperti efek gradient warna premium, *rounded corners*, dan *hover transitions*) agar aplikasi tidak terlihat kaku dan terasa seperti sistem yang profesional & modern.

**20. Q: Kesulitan terbesar apa yang kamu hadapi saat membuat ini dan solusinya?**
> A: (*Catatan: Kamu bisa sesuaikan ini. Saran jawaban umum:*)
> Kesulitan terbesar adalah memisahkan alur logika antara Admin dan Merchant yang berada di dalam satu sistem utuh. Solusinya, saya menggambar *flowchart* manual terlebih dahulu. Memastikan penambahan status di tabel `users` (pending/approved), dan dengan teliti memisahkan Controller `Merchant` serta `Order` agar *logic*-nya tidak bercampur.

---

### Tips Presentasi (Do's and Don'ts)
*   **Do:** Mulai presentasi dengan menjelaskan "MASALAH" yang diselesaikan oleh aplikasi ini (mengatur ribuan barang UMKM dan men-screening merchant nakal).
*   **Do:** Tunjukkan fitur andalan: Registrasi -> Tunggu Approve (pending login) -> Admin klik setujui -> Login berhasil. Ini poin nilai plus yang tinggi!
*   **Don't:** Jangan panik kalau ada error live. Jelaskan saja ke dosen, *"Sepertinya ada perbedaan env lokal, tapi alur kodenya berada di Controller X"*.
*   **Do:** Buka aplikasi database (phpMyAdmin/DBeaver) di background, untuk berjaga-jaga kalau dosen ingin melihat apakah data benar-benar tersimpan dan stok benar-benar berkurang.

**Sukses untuk presentasi UTS-nya Clarissa! 🚀**
