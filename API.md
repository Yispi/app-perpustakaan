# Dokumentasi REST API - Sistem Perpustakaan (Pertemuan 9)

Dokumentasi ini mencakup seluruh 11 endpoint REST API yang dibangun pada Pertemuan 9 untuk resource `books`, `members`, `loans`, dan `stats`. Seluruh endpoint bersifat stateless, mengembalikan format JSON, dan menggunakan Laravel API Resource untuk konsistensi struktur data.

- **Base URL:** `http://127.0.0.1:8000/api`
- **Headers Wajib:**
  - `Accept: application/json`
  - `Content-Type: application/json` (untuk request ber-body)

---

## Ringkasan Endpoint

| No | Method | URL | Request Body | Status Code | Keterangan |
|---|---|---|---|---|---|
| 1 | `GET` | `/api/books` | - | `200 OK` | Daftar buku dengan paginasi & filter (`?judul=`, `?category_id=`) |
| 2 | `GET` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | Detail buku berdasarkan ID |
| 3 | `POST` | `/api/books` | JSON Buku | `201 Created` / `422 Unprocessable Content` | Menambahkan buku baru |
| 4 | `PUT` | `/api/books/{id}` | JSON Buku | `200 OK` / `422 Unprocessable Content` / `404 Not Found` | Memperbarui data buku |
| 5 | `DELETE` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | Menghapus buku |
| 6 | `GET` | `/api/members` | - | `200 OK` | Daftar anggota perpustakaan (paginasi) |
| 7 | `GET` | `/api/members/{id}` | - | `200 OK` / `404 Not Found` | Detail anggota berdasarkan ID |
| 8 | `GET` | `/api/loans` | - | `200 OK` | Daftar transaksi peminjaman (paginasi) |
| 9 | `POST` | `/api/loans` | JSON Peminjaman | `201 Created` / `422 Unprocessable Content` | Membuat transaksi peminjaman baru |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | - | `200 OK` / `404 Not Found` | Pengembalian buku transaksi peminjaman |
| 11 | `GET` | `/api/stats` | - | `200 OK` | Ringkasan statistik perpustakaan |

---

## Detail Endpoint dan Contoh Response

### 1. `GET /api/books`
Menampilkan daftar seluruh buku yang dilengkapi relasi `category` dan metadata paginasi. Mendukung query string:
- `?judul=<kata_kunci>` (filter LIKE)
- `?category_id=<id>` (filter eksak kategori)
- `?page=<nomor_halaman>`

**Request:**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/books`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 2,
      "judul": "Laut Bercerita",
      "penulis": "Leila S. Chudori",
      "penerbit": "Hasta Mitra",
      "tahun_terbit": "2001",
      "isbn": null,
      "stok": 3,
      "sampul": null,
      "category": {
        "id": 3,
        "nama_kategori": "Fiksi"
      },
      "created_at": "2026-10-05T22:15:06.000000Z",
      "updated_at": "2026-10-12T22:38:44.000000Z"
    },
    {
      "id": 3,
      "judul": "Bumi Manusia",
      "penulis": "Pramoedya Ananta Toer",
      "penerbit": "Hasta Mitra",
      "tahun_terbit": "1980",
      "isbn": null,
      "stok": 4,
      "sampul": null,
      "category": {
        "id": 3,
        "nama_kategori": "Fiksi"
      },
      "created_at": "2026-10-12T22:38:05.000000Z",
      "updated_at": "2026-10-12T22:38:05.000000Z"
    },
    {
      "id": 4,
      "judul": "Rich Dad, Poor Dad",
      "penulis": "Robert T Kiyosaki",
      "penerbit": "Hebat Jaya",
      "tahun_terbit": "1998",
      "isbn": null,
      "stok": 2,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Finansial"
      },
      "created_at": "2026-10-12T22:38:32.000000Z",
      "updated_at": "2026-10-12T22:38:32.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/books?page=1",
    "last": "http://127.0.0.1:8000/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/books?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "path": "http://127.0.0.1:8000/api/books",
    "per_page": 10,
    "to": 3,
    "total": 3
  }
}
```

---

### 2. `GET /api/books/{id}`
Mendapatkan detail satu buku berdasarkan ID.

**Request (Sukses):**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/books/2`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": {
    "id": 2,
    "judul": "Laut Bercerita",
    "penulis": "Leila S. Chudori",
    "penerbit": "Hasta Mitra",
    "tahun_terbit": "2001",
    "isbn": null,
    "stok": 3,
    "sampul": null,
    "category": {
      "id": 3,
      "nama_kategori": "Fiksi"
    },
    "created_at": "2026-10-05T22:15:06.000000Z",
    "updated_at": "2026-10-12T22:38:44.000000Z"
  }
}
```

**Request (ID Tidak Ditemukan):**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/books/999`

**Response `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 3. `POST /api/books`
Menambahkan buku baru menggunakan validasi `StoreBookRequest`.

**Request (Sukses):**
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/books`
- **Body (JSON):**
```json
{
  "judul": "Laskar Pelangi",
  "penulis": "Andrea Hirata",
  "penerbit": "Bentang Pustaka",
  "tahun_terbit": 2005,
  "isbn": "978-979-3062-79-2",
  "stok": 10,
  "category_id": 3
}
```

**Response `201 Created`:**
```json
{
  "data": {
    "id": 6,
    "judul": "Laskar Pelangi",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "978-979-3062-79-2",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 3,
      "nama_kategori": "Fiksi"
    },
    "created_at": "2026-11-03T13:23:18.000000Z",
    "updated_at": "2026-11-03T13:23:18.000000Z"
  }
}
```

**Request (Gagal Validasi - Body Kosong):**
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/books`
- **Body (JSON):** `{}`

**Response `422 Unprocessable Content`:**
```json
{
  "message": "Judul buku wajib diisi. (and 5 more errors)",
  "errors": {
    "judul": [
      "Judul buku wajib diisi."
    ],
    "penulis": [
      "Nama penulis wajib diisi."
    ],
    "penerbit": [
      "Nama penerbit wajib diisi."
    ],
    "tahun_terbit": [
      "Tahun terbit wajib diisi."
    ],
    "stok": [
      "Stok wajib diisi."
    ],
    "category_id": [
      "Kategori wajib dipilih."
    ]
  }
}
```

---

### 4. `PUT /api/books/{id}`
Memperbarui informasi buku berdasarkan ID.

**Request (Sukses):**
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/books/6`
- **Body (JSON):**
```json
{
  "judul": "Laskar Pelangi (Edisi Khusus)",
  "penulis": "Andrea Hirata",
  "penerbit": "Bentang Pustaka",
  "tahun_terbit": 2008,
  "isbn": "978-979-3062-79-2",
  "stok": 15,
  "category_id": 3
}
```

**Response `200 OK`:**
```json
{
  "data": {
    "id": 6,
    "judul": "Laskar Pelangi (Edisi Khusus)",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2008,
    "isbn": "978-979-3062-79-2",
    "stok": 15,
    "sampul": null,
    "category": {
      "id": 3,
      "nama_kategori": "Fiksi"
    },
    "created_at": "2026-11-03T13:23:18.000000Z",
    "updated_at": "2026-11-03T13:23:18.000000Z"
  }
}
```

**Request (ID Tidak Ditemukan):**
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/books/999`

**Response `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 5. `DELETE /api/books/{id}`
Menghapus buku berdasarkan ID dari sistem perpustakaan.

**Request (Sukses):**
- **Method:** `DELETE`
- **URL:** `http://127.0.0.1:8000/api/books/6`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "message": "Buku berhasil dihapus."
}
```

**Request (ID Tidak Ditemukan):**
- **Method:** `DELETE`
- **URL:** `http://127.0.0.1:8000/api/books/999`

**Response `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Book] 999"
}
```

---

### 6. `GET /api/members`
Menampilkan daftar anggota terdaftar dengan paginasi melalui `MemberResource`.

**Request:**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/members`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Rudi",
      "nim": "3125600042",
      "email": "Rudikalsum@gmail.com",
      "nomor_telepon": "081298767",
      "alamat": "bungurasih",
      "status": "aktif",
      "created_at": "2026-10-05T22:27:19.000000Z",
      "updated_at": "2026-10-12T22:33:56.000000Z"
    },
    {
      "id": 2,
      "nama": "galga",
      "nim": "209837",
      "email": "Galgia@gmail.com",
      "nomor_telepon": "0882839772",
      "alamat": "Jepark Regency",
      "status": "nonaktif",
      "created_at": "2026-10-05T22:40:32.000000Z",
      "updated_at": "2026-10-12T22:34:10.000000Z"
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/members?page=1",
    "last": "http://127.0.0.1:8000/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/members?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "path": "http://127.0.0.1:8000/api/members",
    "per_page": 10,
    "to": 2,
    "total": 2
  }
}
```

---

### 7. `GET /api/members/{id}`
Menampilkan data detail anggota perpustakaan berdasarkan ID.

**Request (Sukses):**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/members/1`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": {
    "id": 1,
    "nama": "Rudi",
    "nim": "3125600042",
    "email": "Rudikalsum@gmail.com",
    "nomor_telepon": "081298767",
    "alamat": "bungurasih",
    "status": "aktif",
    "created_at": "2026-10-05T22:27:19.000000Z",
    "updated_at": "2026-10-12T22:33:56.000000Z"
  }
}
```

**Request (ID Tidak Ditemukan):**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/members/999`

**Response `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Member] 999"
}
```

---

### 8. `GET /api/loans`
Menampilkan daftar transaksi peminjaman lengkap dengan relasi `member`, `petugas` (`user`), dan array `books` (`loanItems.book`).

**Request:**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/loans`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Rudi"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-11-01",
      "tanggal_kembali": "2026-11-08",
      "tanggal_dikembalikan": "2026-11-03",
      "status": "dikembalikan",
      "books": [
        {
          "id": 2,
          "judul": "Laut Bercerita"
        },
        {
          "id": 3,
          "judul": "Bumi Manusia"
        }
      ]
    },
    {
      "id": 2,
      "member": {
        "id": 1,
        "nama": "Rudi"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-11-01",
      "tanggal_kembali": "2026-11-08",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 2,
          "judul": "Laut Bercerita"
        },
        {
          "id": 3,
          "judul": "Bumi Manusia"
        }
      ]
    }
  ],
  "links": {
    "first": "http://127.0.0.1:8000/api/loans?page=1",
    "last": "http://127.0.0.1:8000/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://127.0.0.1:8000/api/loans?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "path": "http://127.0.0.1:8000/api/loans",
    "per_page": 10,
    "to": 2,
    "total": 2
  }
}
```

---

### 9. `POST /api/loans`
Mencatat transaksi peminjaman baru beserta item buku (`book_ids[]`). Karena stateless dan tanpa session browser, parameter `user_id` wajib dikirim pada body.

**Request (Sukses):**
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/loans`
- **Body (JSON):**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-11-01",
  "tanggal_kembali": "2026-11-08",
  "book_ids": [2, 3]
}
```

**Response `201 Created`:**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Rudi"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-01",
    "tanggal_kembali": "2026-11-08",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 2,
        "judul": "Laut Bercerita"
      },
      {
        "id": 3,
        "judul": "Bumi Manusia"
      }
    ]
  }
}
```

**Request (Gagal Validasi - Body Kosong):**
- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/loans`
- **Body (JSON):** `{}`

**Response `422 Unprocessable Content`:**
```json
{
  "message": "Anggota wajib dipilih. (and 4 more errors)",
  "errors": {
    "member_id": [
      "Anggota wajib dipilih."
    ],
    "user_id": [
      "Petugas (user_id) wajib diisi."
    ],
    "tanggal_pinjam": [
      "Tanggal pinjam wajib diisi."
    ],
    "tanggal_kembali": [
      "Tanggal kembali wajib diisi."
    ],
    "book_ids": [
      "Pilih minimal satu buku."
    ]
  }
}
```

---

### 10. `PUT /api/loans/{id}/kembalikan`
Memperbarui status transaksi menjadi `'dikembalikan'` dan menetapkan `tanggal_dikembalikan` ke tanggal hari ini.

**Request (Sukses):**
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/loans/2/kembalikan`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Rudi"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-11-01",
    "tanggal_kembali": "2026-11-08",
    "tanggal_dikembalikan": "2026-11-03",
    "status": "dikembalikan",
    "books": [
      {
        "id": 2,
        "judul": "Laut Bercerita"
      },
      {
        "id": 3,
        "judul": "Bumi Manusia"
      }
    ]
  }
}
```

**Request (ID Tidak Ditemukan):**
- **Method:** `PUT`
- **URL:** `http://127.0.0.1:8000/api/loans/999/kembalikan`

**Response `404 Not Found`:**
```json
{
  "message": "No query results for model [App\\Models\\Loan] 999"
}
```

---

### 11. `GET /api/stats`
Menghasilkan ringkasan agregasi jumlah buku, total anggota, dan peminjaman aktif langsung sebagai objek JSON sederhana.

**Request:**
- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/stats`
- **Body:** `-`

**Response `200 OK`:**
```json
{
  "total_buku": 3,
  "total_anggota": 2,
  "peminjaman_aktif": 0
}
```
