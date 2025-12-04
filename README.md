
-----

# Aplikasi Manajemen Stok Toko Buku

## 1\. Deskripsi Aplikasi

Aplikasi ini adalah sistem *back-end* sederhana berbasis web untuk mengelola inventaris toko buku. Aplikasi ini dibuat untuk memenuhi **Tugas 1 (Implementasi Aplikasi Back-End CRUD Sederhana)**.

  * **Entitas Domain:** **Buku**.
  * **Fungsi Utama:** Aplikasi memungkinkan pengguna untuk melakukan operasi CRUD (*Create, Read, Update, Delete*) pada data buku, termasuk pengelolaan informasi harga, stok, dan unggah gambar sampul (*cover*).

## 2\. Spesifikasi Teknis

### Lingkungan Pengembangan

  * **Bahasa Pemrograman:** PHP 8.4.13.
  * **DBMS:** MySQL.
  * **Driver Database:** PDO (PHP Data Objects).
  * **Server:** PHP Built-in Web Server.

### Struktur Folder

Berikut adalah ringkasan struktur folder aplikasi:

```text
tugas1/
├── class/              # Kumpulan Class (OOP)
│   ├── Buku.php        # Model utama untuk logika bisnis entitas Buku
│   ├── Database.php    # Wrapper koneksi database menggunakan PDO
│   └── Utility.php     # Fungsi bantuan (Navigasi, Flash Message, Redirect)
├── css/
│   └── admin-style.css # Stylesheet untuk tampilan antarmuka
├── inc/
│   └── config.php      # Konfigurasi Database dan Autoloader
├── uploads/            # Direktori penyimpanan file gambar cover buku
├── create.php          # Halaman tambah data buku
├── delete.php          # Script logika penghapusan data
├── edit.php            # Halaman ubah data buku
├── index.php           # Halaman utama (Menampilkan tabel daftar buku)
├── schema.sql          # Skema database untuk pembuatan tabel
└── README.md           # Dokumentasi aplikasi
```

### Penjelasan Class Utama

1.  **Database (`class/Database.php`)**: Menangani koneksi ke database `toko_buku_db` menggunakan driver PDO untuk keamanan akses data.
2.  **Buku (`class/Buku.php`)**: Merepresentasikan entitas Buku. Class ini berisi *method* untuk operasi CRUD (`getAll`, `getById`, `create`, `update`, `delete`) menggunakan *Prepared Statements*.
3.  **Utility (`class/Utility.php`)**: Class statis yang menyediakan fungsi pembantu seperti menampilkan navigasi, menangani *flash message* (notifikasi sukses/gagal), dan *redirect* halaman.

## 3\. Instruksi Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal (*Localhost*):

### 1\. Persiapan Database

1.  Buka aplikasi manajemen database (seperti phpMyAdmin atau Terminal).
2.  Buat database baru atau impor langsung file `schema.sql`.
      * File `schema.sql` akan otomatis membuat database bernama `toko_buku_db` dan tabel `buku`.

### 2\. Konfigurasi Koneksi

Buka file `inc/config.php` dan sesuaikan konfigurasi database dengan kredensial lokal Anda:

```php
const DB_HOST = 'localhost';
const DB_USER = 'root';       // Ganti dengan username database Anda
const DB_PASS = '';           // Ganti dengan password database Anda
const DB_NAME = 'toko_buku_db';
```

### 3\. Menjalankan Server

Buka terminal (Command Prompt/Terminal), arahkan ke direktori proyek ini, lalu jalankan perintah:

```bash
php -S localhost:8000
```

### 4\. Akses Aplikasi

Buka browser dan kunjungi URL berikut:
`http://localhost:8000/index.php`

## 4\. Contoh Skenario Uji Singkat

Berikut adalah skenario untuk menguji fitur CRUD aplikasi:

1.  **Tambah Data (Create)**

      * Klik tombol **"+ Tambah Produk"**.
      * Isi form: Judul, Penulis, Kategori (Pilih Fiksi/Non-Fiksi/Edukasi), Harga, dan Stok.
      * Unggah gambar cover (format JPG/PNG).
      * Klik "Simpan". Pastikan muncul pesan "Buku berhasil ditambahkan\!" dan data muncul di tabel.

2.  **Tampilkan Data (Read)**

      * Buka halaman utama (`index.php`).
      * Pastikan tabel menampilkan Judul, Penulis, Kategori, Harga (dalam format Rupiah), Stok, dan *thumbnail* gambar.

3.  **Ubah Data (Update)**

      * Klik tombol **"Edit"** pada salah satu buku.
      * Ubah data Stok atau Harga.
      * (Opsional) Ganti gambar cover.
      * Klik "Update Data". Pastikan data berubah dan gambar lama terhapus dari folder `uploads/` digantikan gambar baru.

4.  **Hapus Data (Delete)**

      * Klik tombol **"Hapus"** pada salah satu buku.
      * Konfirmasi pada *browser alert* ("Hapus buku ini?").
      * Pastikan data hilang dari tabel dan file gambar terkait terhapus dari penyimpanan.
