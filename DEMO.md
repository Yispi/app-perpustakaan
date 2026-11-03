# Skenario Demo Aplikasi Perpustakaan Digital Kampus (UAS)

Dokumen ini berisi panduan skenario pengujian dan demonstrasi lengkap aplikasi **Sistem Perpustakaan Digital Kampus** untuk keperluan evaluasi akhir (UAS). Skenario mencakup alur web application berbasis Blade, konsumsi API internal, manajemen data (CRUD & Relasi), otentikasi & hak akses (Role-Based Access Control), serta pengujian endpoint REST API melalui Postman.

---

## 1. Persiapan Sebelum Demo

Pastikan environment lokal telah siap:
1. Database MySQL telah dimigrasi dan diisi data dummy:
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Nyalakan **Terminal 1** (Web Server Utama):
   ```bash
   php artisan serve --port=8000
   ```
3. Nyalakan **Terminal 2** (Internal API Server):
   ```bash
   php artisan serve --port=8011
   ```
4. Buka browser pada URL: `http://127.0.0.1:8000`
5. Buka Postman / API Client.

### Akun Uji Coba (Seeder):
- **Administrator:**
  - Email: `admin@pens.ac.id`
  - Password: `password`
  - Role: `admin` (akses penuh semua modul termasuk Kategori)
- **Petugas Perpustakaan:**
  - Email: `petugas1@pens.ac.id`
  - Password: `password`
  - Role: `petugas` (akses Buku, Anggota, Peminjaman, Laporan)

---

## 2. Urutan Langkah Demonstrasi Web

### Langkah 1: Login ke Sistem
1. Akses `http://127.0.0.1:8000/login`.
2. Masukkan kredensial admin:
   - Email: `admin@pens.ac.id`
   - Password: `password`
3. Klik tombol **Login**.
4. **Hasil yang diharapkan:**
   - Muncul alert sukses: *"Login berhasil, selamat datang Bambang Sutrisno."*
   - Pengguna otomatis diarahkan (*redirect*) ke halaman Dashboard (`/`).
   - Navbar menampilkan nama pengguna `Bambang Sutrisno (Admin)` serta menu navigasi lengkap: Dashboard, Buku, Kategori, Anggota, Peminjaman, Laporan, dan tombol Logout.

---

### Langkah 2: Tampilkan Dashboard (Konsumsi API Internal)
1. Perhatikan tampilan halaman Dashboard (`/`).
2. Terdapat 3 kartu ringkasan statistik yang diambil secara real-time dari endpoint internal `GET /api/stats` (port 8011):
   - **Total Buku:** 20 (atau sesuai jumlah di database)
   - **Total Anggota:** 15
   - **Peminjaman Aktif:** jumlah peminjaman berstatus `dipinjam`
3. Klik tombol **Lihat Laporan Peminjaman** untuk memverifikasi tautan pintas menuju halaman laporan.

---

### Langkah 3: Tambah Kategori Buku (Akses Khusus Admin)
1. Klik menu **Kategori** pada navbar (`/categories`).
2. Klik tombol **Tambah Kategori** (`/categories/create`).
3. Masukkan data kategori baru:
   - **Nama Kategori:** `Referensi Khusus`
   - **Deskripsi:** `Kumpulan ensiklopedia dan jurnal rujukan akademik.`
4. Klik **Simpan**.
5. **Hasil yang diharapkan:**
   - Kategori baru tersimpan dan muncul pada tabel daftar kategori.
   - Muncul alert sukses penambahan data.

---

### Langkah 4: Tambah Buku Baru
1. Klik menu **Buku** pada navbar (`/books`).
2. Perhatikan daftar 20 buku hasil seeding dengan pagination rapi di bagian bawah.
3. Klik tombol **Tambah Buku** (`/books/create`).
4. Isi formulir buku:
   - **Judul:** `Arsitektur Web Modern dan RESTful API`
   - **Penulis:** `Ir. Budi Santoso, M.T.`
   - **Penerbit:** `Informatika Bandung`
   - **Tahun Terbit:** `2024`
   - **ISBN:** `9786026232111`
   - **Stok:** `5`
   - **Kategori:** Pilih `Teknologi` atau `Referensi Khusus`
5. Klik **Simpan**.
6. **Hasil yang diharapkan:**
   - Buku baru berhasil disimpan dan muncul pada daftar buku.
   - Stok dan ISBN terverifikasi valid.

---

### Langkah 5: Tambah Anggota Baru
1. Klik menu **Anggota** pada navbar (`/members`).
2. Perhatikan format data anggota yang bergaya Indonesia serta email mahasiswa domain `@pens.ac.id`.
3. Klik tombol **Tambah Anggota** (`/members/create`).
4. Isi data anggota baru:
   - **Nama:** `Rizky Pratama`
   - **NIM:** `3123500001`
   - **Email:** `rizky.pratama01@pens.ac.id`
   - **Nomor Telepon:** `081234567890`
   - **Alamat:** `Jl. Raya ITS Kampus Sukolilo, Surabaya`
   - **Status:** `aktif`
5. Klik **Simpan**.
6. **Hasil yang diharapkan:**
   - Anggota baru tersimpan dengan status aktif.

---

### Langkah 6: Buat Transaksi Peminjaman Buku
1. Klik menu **Peminjaman** pada navbar (`/loans`).
2. Klik tombol **Tambah Peminjaman** (`/loans/create`).
3. Lengkapi formulir transaksi:
   - **Peminjam (Anggota):** Pilih anggota `Rizky Pratama`
   - **Buku yang Dipinjam:** Centang atau pilih buku `Arsitektur Web Modern dan RESTful API` (bisa multi-buku)
   - **Tanggal Pinjam:** Tanggal hari ini
   - **Tanggal Kembali:** 7 hari ke depan
4. Klik **Simpan**.
5. **Hasil yang diharapkan:**
   - Transaksi peminjaman tersimpan dengan status `dipinjam`.
   - Data otomatis terasosiasi dengan user petugas yang sedang login (`Bambang Sutrisno`).

---

### Langkah 7: Lihat Daftar Peminjaman Aktif & Detail
1. Di halaman **Peminjaman** (`/loans`), periksa baris transaksi yang baru saja dibuat.
2. Klik tombol **Detail** pada transaksi terkait.
3. **Hasil yang diharapkan:**
   - Menampilkan rincian lengkap transaksi: nama peminjam, petugas pencatat, rentang tanggal, status peminjaman, serta daftar buku yang dipinjam.

---

### Langkah 8: Proses Pengembalian Buku
1. Kembali ke daftar transaksi peminjaman (`/loans`) atau formulir edit (`/loans/{id}/edit`).
2. Perbarui status peminjaman dari `dipinjam` menjadi `dikembalikan`.
3. Klik **Simpan Perubahan**.
4. **Hasil yang diharapkan:**
   - Status transaksi berubah menjadi `dikembalikan`.
   - Angka **Peminjaman Aktif** di Dashboard berkurang secara otomatis.

---

### Langkah 9: Tampilkan Laporan Peminjaman (Konsumsi API Internal)
1. Klik menu **Laporan** pada navbar (`/loans/report`).
2. Perhatikan bahwa data tabel ditarik melalui panggilan HTTP ke `GET /api/loans` (port 8011) dan disajikan dalam Blade view `loans.report`.
3. Navigasi halaman laporan dapat diklik (Previous / Next) menggunakan query string `?page=...`.
4. *(Opsional Pengujian Keandalan)*:
   - Matikan sementara server port 8011 di Terminal 2.
   - Refresh halaman Laporan dan Dashboard.
   - Halaman tetap terbuka secara anggun tanpa Error 500 (tabel kosong / angka 0), membuktikan `try/catch ConnectionException` berfungsi sempurna.
   - Nyalakan kembali server port 8011.

---

## 3. Demonstrasi REST API di Postman

Gunakan Base URL: `http://127.0.0.1:8000/api`  
Headers standar:
- `Accept: application/json`
- `Content-Type: application/json` (untuk POST/PUT)

### 1. `GET /api/stats`
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/stats`
- **Tujuan:** Menguji ringkasan data statistik perpustakaan.
- **Respons yang diharapkan (`200 OK`):**
  ```json
  {
    "total_buku": 21,
    "total_anggota": 16,
    "peminjaman_aktif": 0
  }
  ```

### 2. `GET /api/books` & Filter
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/books`
- **Filter Pencarian:** `http://127.0.0.1:8000/api/books?judul=Laskar`
- **Respons yang diharapkan (`200 OK`):**
  Array `data` berisi daftar buku beserta relasi `category` dan objek paginasi `links` & `meta`.

### 3. `GET /api/books/{id}`
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/books/1`
- **Respons yang diharapkan (`200 OK`):**
  Detail data satu buku dalam objek `data`.

### 4. `POST /api/books`
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/books`
- **Body (raw JSON):**
  ```json
  {
    "judul": "Laravel Best Practices & Design Patterns",
    "penulis": "Taylor Otwell",
    "penerbit": "O'Reilly Media",
    "tahun_terbit": 2024,
    "isbn": "9781491918661",
    "stok": 8,
    "category_id": 4
  }
  ```
- **Respons yang diharapkan (`201 Created`):**
  Data buku yang baru dibuat beserta ID yang dihasilkan.

### 5. `PUT /api/books/{id}`
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/books/1`
- **Body (raw JSON):**
  ```json
  {
    "judul": "Laskar Pelangi (Edisi Khusus Kampus)",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "9789793062792",
    "stok": 12,
    "category_id": 1
  }
  ```
- **Respons yang diharapkan (`200 OK`):**
  Data buku berhasil diperbarui.

### 6. `DELETE /api/books/{id}`
- **Method:** `DELETE`
- **URL:** `http://127.0.0.1:8000/api/books/{id}` (gunakan ID buku baru hasil uji coba)
- **Respons yang diharapkan (`200 OK`):**
  Pesan konfirmasi bahwa data buku berhasil dihapus.

### 7. `GET /api/members`
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/members`
- **Respons yang diharapkan (`200 OK`):**
  Daftar anggota perpustakaan terpaginasi.

### 8. `GET /api/loans`
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/loans`
- **Respons yang diharapkan (`200 OK`):**
  Daftar transaksi peminjaman lengkap dengan detail anggota (`member`), petugas (`petugas`), dan buku (`books`).

### 9. `POST /api/loans`
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/loans`
- **Body (raw JSON):**
  ```json
  {
    "member_id": 1,
    "user_id": 1,
    "tanggal_pinjam": "2026-11-03",
    "tanggal_kembali": "2026-11-10",
    "book_ids": [1, 2]
  }
  ```
- **Respons yang diharapkan (`201 Created`):**
  Objek transaksi peminjaman berhasil dibuat beserta `loan_items`.

### 10. `PUT /api/loans/{id}/kembalikan`
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/loans/1/kembalikan`
- **Respons yang diharapkan (`200 OK`):**
  Status transaksi peminjaman diperbarui menjadi `dikembalikan` dan tanggal pengembalian tercatat.

---

## 4. Checklist Penilaian Akhir

- [x] Dashboard menampilkan kartu statistik dari API `GET /api/stats`.
- [x] Laporan peminjaman mengonsumsi data dari API `GET /api/loans`.
- [x] Desain fallback try/catch mencegah error 500 saat API server offline.
- [x] Data dummy realistis bergaya Indonesia (Factory & Seeder).
- [x] Tampilan pagination bersih berbasis custom view (tanpa Tailwind SVG raksasa).
- [x] Autentikasi dan Role-Based Access Control berjalan rapi.
- [x] REST API lulus pengujian seluruh 11 endpoint di Postman.
