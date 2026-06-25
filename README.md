# 📚 Sistem Pendataan Buku

## Identitas Mahasiswa
| Field | Isi |
|-------|-----|
| **Nama** | [ISI NAMA KAMU] |
| **NIM** | [ISI NIM KAMU] |

## Judul Aplikasi
**Sistem Pendataan Buku** — UAS Pemrograman Web 2024/2025 Genap

## Deskripsi Singkat
Aplikasi web sederhana untuk mengelola data koleksi buku. Fitur utama meliputi:
- Menambah data buku baru
- Menampilkan daftar seluruh buku
- Mengedit data buku yang sudah ada
- Menghapus data buku
- Pencarian dan filter berdasarkan judul/pengarang/penerbit dan kategori
- Statistik ringkasan (total judul, total stok, total kategori)

## Teknologi yang Digunakan
- **HTML5** — Struktur halaman web
- **CSS3** — Styling eksternal (`assets/css/style.css`)
- **PHP Native** — Backend logic & CRUD
- **MySQL** — Database penyimpanan data

## Struktur Direktori
```
sistem-buku/
├── index.php           # Halaman Beranda
├── daftar.php          # Halaman Daftar Buku (Read)
├── tambah.php          # Halaman Tambah Buku (Create)
├── edit.php            # Halaman Edit Buku (Update)
├── hapus.php           # Proses Hapus Buku (Delete)
├── database.sql        # File SQL database
├── README.md           # Dokumentasi proyek
├── includes/
│   ├── koneksi.php     # Konfigurasi koneksi MySQL
│   ├── header.php      # Template header (navbar)
│   ├── footer.php      # Template footer
│   └── functions.php   # Kumpulan fungsi helper
└── assets/
    └── css/
        └── style.css   # Stylesheet eksternal
```

## Struktur Database

**Database:** `sistem_buku`

**Tabel:** `buku`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT AUTO_INCREMENT | Primary Key |
| `judul` | VARCHAR(200) | Judul buku |
| `pengarang` | VARCHAR(150) | Nama pengarang |
| `penerbit` | VARCHAR(150) | Nama penerbit |
| `tahun_terbit` | YEAR | Tahun terbit buku |
| `stok` | INT | Jumlah stok tersedia |
| `kategori` | VARCHAR(100) | Kategori buku |
| `created_at` | TIMESTAMP | Waktu data ditambahkan |

## Screenshot Aplikasi

> *(Tambahkan screenshot aplikasi di sini setelah menjalankan)*

## Cara Menjalankan Aplikasi

### Prasyarat
- XAMPP / Laragon / WAMP (PHP 7.4+ & MySQL)
- Browser modern

### Langkah-langkah

1. **Clone / download** repository ini ke folder `htdocs` (XAMPP) atau `www` (Laragon):
   ```
   C:\xampp\htdocs\sistem-buku\
   ```

2. **Buat database** melalui phpMyAdmin atau MySQL CLI:
   ```sql
   CREATE DATABASE sistem_buku;
   ```

3. **Import file SQL:**
   - Buka phpMyAdmin → pilih database `sistem_buku` → tab **Import** → pilih file `database.sql` → klik **Go**
   
   Atau via CLI:
   ```bash
   mysql -u root -p sistem_buku < database.sql
   ```

4. **Konfigurasi koneksi** di `includes/koneksi.php`:
   ```php
   define('DB_USER', 'root');   // username MySQL kamu
   define('DB_PASS', '');       // password MySQL kamu
   ```

5. **Jalankan aplikasi** di browser:
   ```
   http://localhost/sistem-buku/
   ```

## Fitur PHP yang Diimplementasikan
- ✅ Variabel
- ✅ Percabangan (`if/elseif/else`, `switch`)
- ✅ Perulangan (`while`, `foreach`)
- ✅ Function (5 fungsi di `includes/functions.php`)
- ✅ `include` / `require` (header, footer, koneksi, functions)
- ✅ Form Processing (GET untuk search, POST untuk CRUD)
- ✅ CRUD lengkap (Create, Read, Update, Delete)

---

> ⚠️ **Pernyataan Penggunaan GenAI:** Proyek ini dikembangkan dengan bantuan AI (Claude by Anthropic) sebagai alat bantu pembelajaran.
