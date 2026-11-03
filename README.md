# Sistem Perpustakaan Digital Kampus

Aplikasi web manajemen perpustakaan digital kampus berbasis **Laravel 12**. Aplikasi ini mencakup pengelolaan buku, kategori, anggota, transaksi peminjaman, autentikasi berbasis session dengan *Role-Based Access Control* (Admin & Petugas), RESTful API lengkap (11 endpoint), serta implementasi arsitektur konsumsi API internal (*Internal API Consumption / Backend-for-Frontend pattern*) untuk Dashboard dan Laporan Peminjaman.

---

## Fitur Utama

1. **Dashboard Statistik (BFF / Consume API Internal):**
   - Menampilkan total buku, total anggota, dan peminjaman aktif secara real-time.
   - Dikonsumsi langsung dari endpoint `GET /api/stats` menggunakan Laravel HTTP Client (`Http::get()`) dengan penanganan `ConnectionException` yang aman.
2. **Manajemen Data (CRUD):**
   - **Kategori Buku:** Khusus hak akses Admin.
   - **Buku:** Pengelolaan data buku, stok, ISBN, dan relasi kategori.
   - **Anggota:** Manajemen data anggota/mahasiswa aktif dan nonaktif.
   - **Peminjaman:** Pencatatan transaksi peminjaman multi-buku, relasi petugas, dan proses pengembalian buku.
3. **Laporan Transaksi Peminjaman (Consume API Internal):**
   - Mengambil data transaksi dari `GET /api/loans` dan dirender ke Blade view dengan paginasi API.
4. **REST API Siap Pakai:**
   - 11 endpoint API yang terdokumentasi lengkap di [API.md](API.md) untuk resource `books`, `members`, `loans`, dan `stats`.
5. **Seeder & Factory Data Realistis:**
   - Data dummy bergaya Indonesia (`APP_FAKER_LOCALE=id_ID`), nama pengarang, judul buku terkurasi per kategori, penerbit lokal ternama, serta email mahasiswa `@pens.ac.id`.
6. **Custom Clean Pagination:**
   - Tampilan paginasi teks/link yang rapi tanpa ketergantungan framework CSS eksternal.

---

## Kebutuhan Sistem

- PHP >= 8.2 (ekstensi: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, cURL)
- Composer >= 2.x
- MySQL / MariaDB Server

---

## Panduan Instalasi dan Menjalankan Proyek

### 1. Clone Repository
```bash
git clone https://github.com/Yispi/app-perpustakaan.git
cd app-perpustakaan
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Di Windows PowerShell: `copy .env.example .env`)*

Buka file `.env` dan pastikan konfigurasi berikut telah terisi:
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Base URL instance kedua untuk panggilan API internal
INTERNAL_API_URL=http://127.0.0.1:8011

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=app-perpustakaan
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Migrasi Database dan Seeder
Pastikan database MySQL bernama `app-perpustakaan` sudah dibuat, kemudian jalankan:
```bash
php artisan migrate:fresh --seed
```
Perintah ini akan menjalankan seluruh migrasi dan mengisi data dummy realistis (3 user, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman).

---

## Cara Menjalankan Aplikasi (Dua Server)

Karena server pengembangan bawaan PHP (`php artisan serve`) bekerja secara *single-threaded* (satu request dalam satu waktu), pemanggilan API dari Controller ke aplikasi sendiri akan memicu *deadlock* jika berada di port yang sama. Oleh karena itu, jalankan **dua server** di dua terminal terpisah:

### Terminal 1: Server Utama (Aplikasi Web & UI Browser)
```bash
php artisan serve --port=8000
```
Akses aplikasi melalui browser: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Terminal 2: Server API Internal (Port 8011)
```bash
php artisan serve --port=8011
```
Server ini khusus melayani request internal dari `DashboardController` (`/api/stats`) dan `LoanController@report` (`/api/loans`).

---

## Akun Default untuk Login

| Email | Password | Role | Nama | Hak Akses |
|---|---|---|---|---|
| `admin@pens.ac.id` | `password` | Admin | Bambang Sutrisno | Akses Penuh (Kategori, Buku, Anggota, Peminjaman, Laporan, Dashboard) |
| `petugas1@pens.ac.id` | `password` | Petugas | Siti Rahmawati | Buku, Anggota, Peminjaman, Laporan, Dashboard |
| `petugas2@pens.ac.id` | `password` | Petugas | Ahmad Fauzi | Buku, Anggota, Peminjaman, Laporan, Dashboard |

---

## Dokumentasi Pendukung

- [API.md](API.md) - Dokumentasi lengkap 11 endpoint REST API, parameter query, contoh request body, dan format respons JSON.
- [DEMO.md](DEMO.md) - Panduan skenario uji coba dan demonstrasi langkah demi langkah untuk evaluasi UAS.

---

## Lisensi

Proyek ini dikembangkan untuk keperluan akademik dan praktikum pemrograman web berbasis framework Laravel.
