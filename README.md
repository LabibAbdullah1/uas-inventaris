# 📦 Inventaris App - Sistem Manajemen Aset Kampus

Sistem Informasi Inventaris Barang berbasis web yang dibangun menggunakan arsitektur **MVC (Model-View-Controller)** secara native (tanpa framework berat). Aplikasi ini dirancang untuk memudahkan pengelolaan aset kampus, pelaporan, dan audit barang secara berkala.

Aplikasi ini dikembangkan untuk memenuhi tugas **UAS Pemrograman Web 1**.

## 🚀 Fitur Unggulan

* **Dashboard Statistik**: Ringkasan total barang dan pengguna sistem secara real-time.
* **Manajemen Barang (CRUD)**: Kelola data inventaris mulai dari penambahan, pembaruan, hingga penghapusan barang.
* **Manajemen Pengguna**: Sistem multi-user dengan role **Admin** (akses penuh) dan **User/Staff** (akses terbatas).
* **Audit & Stock Opname**: Fitur pengecekan fisik barang berkala oleh user dengan pelaporan otomatis ke admin.
* **Laporan PDF**: Export data inventaris ke format PDF siap cetak menggunakan library FPDF.
* **Mode Gelap (Dark Mode)**: Antarmuka modern dengan dukungan tema terang dan gelap otomatis.
* **Keamanan Kredensial**: Menggunakan file `.env` untuk menyembunyikan konfigurasi database sensitif dari publik.

## 🛠️ Teknologi yang Digunakan

* **Bahasa**: PHP 8.x (Native)
* **Database**: MySQL / MariaDB
* **Desain**: Bootstrap 5.3, Inter & JetBrains Mono Fonts
* **Icons**: Bootstrap Icons
* **Library**: FPDF (untuk export PDF), SweetAlert2 (untuk notifikasi)
* **Pola Desain**: MVC (Model-View-Controller)

## 📋 Prasyarat Instalasi

1.  Web Server (XAMPP / Laragon / Herd)
2.  PHP >= 8.0
3.  MySQL / MariaDB

## 🔧 Cara Instalasi

1.  **Clone / Download Project**:
    ```bash
    git clone [https://github.com/username/uas-inventaris.git](https://github.com/username/uas-inventaris.git)
    ```
2.  **Konfigurasi Database**:
    * Buat file `.env` di folder root project.
    * Salin isi dari `.env.example` ke `.env` dan sesuaikan kredensial databasemu.
    ```ini
    DB_HOST=localhost
    DB_NAME=uas_inventaris
    DB_USER=root
    DB_PASS=
    ```
3.  **Migrasi Database**:
    Buka browser dan akses alamat berikut untuk membuat tabel dan mengisi data dummy secara otomatis:
    `http://localhost/uas-inventaris/migration/setup_database.php`

4.  **Jalankan Aplikasi**:
    Buka `http://localhost/uas-inventaris/public/` di browsermu.

## 👤 Akun Demo Default

* **Admin**: `admin` / `password123`
* **User/Staff**: `user` / `password123`

## 👨‍💻 Profil Pengembang

* **Nama**: Labib Abdullah
* **NIM**: 2455201070
* **Prodi**: Teknik Informatika
* **Dosen Pengampu**: Yogo Turnandes, S.Kom., M.Kom.

---
&copy; 2026 **Inventaris App**. Dikembangkan dengan ❤️ oleh Labib Abdullah.