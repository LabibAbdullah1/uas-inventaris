<?php

/**
 * SETUP DATABASE & MIGRATION SCRIPT
 * Aplikasi Inventaris Barang (UAS)
 * * Cara Pakai:
 * 1. Taruh file ini di folder root project (sejajar dengan folder public).
 * 2. Buka browser: http://localhost/uas-inventaris/setup_database.php
 */

$host = 'localhost';
$user = 'root';
$pass = ''; // Sesuaikan password database lokal (XAMPP biasanya kosong)
$db_name = 'inventaris';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 1. Koneksi ke MySQL Server
    $conn = new mysqli($host, $user, $pass);

    echo "<div style='font-family: monospace; padding: 20px; line-height: 1.5;'>";
    echo "<h3>🚀 Memulai Migrasi Database...</h3>";

    // 2. Buat Database
    $conn->query("CREATE DATABASE IF NOT EXISTS $db_name");
    echo "✅ Database '<strong>$db_name</strong>' siap.<br>";

    $conn->select_db($db_name);

    // 3. Reset Tabel (Drop jika ada) - Hati-hati data hilang!
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    $conn->query("DROP TABLE IF EXISTS audit_detail");
    $conn->query("DROP TABLE IF EXISTS audit_jadwal");
    $conn->query("DROP TABLE IF EXISTS barang");
    $conn->query("DROP TABLE IF EXISTS kategori");
    $conn->query("DROP TABLE IF EXISTS users");
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    echo "♻️ Tabel lama berhasil dibersihkan.<br>";

    // 4. Buat Tabel USERS
    $sql_users = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_lengkap VARCHAR(100) NOT NULL,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_users);
    echo "✅ Tabel <strong>users</strong> berhasil dibuat.<br>";

    // 5. Buat Tabel KATEGORI
    $sql_kategori = "CREATE TABLE kategori (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_kategori VARCHAR(50) NOT NULL
    )";
    $conn->query($sql_kategori);
    echo "✅ Tabel <strong>kategori</strong> berhasil dibuat.<br>";

    // 6. Buat Tabel BARANG
    $sql_barang = "CREATE TABLE barang (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_barang VARCHAR(100) NOT NULL,
        kategori_id INT NOT NULL,
        jumlah INT NOT NULL,
        kondisi ENUM('Baik', 'Rusak Ringan', 'Rusak Berat') NOT NULL DEFAULT 'Baik',
        keterangan TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE RESTRICT
    )";
    $conn->query($sql_barang);
    echo "✅ Tabel <strong>barang</strong> berhasil dibuat.<br>";

    // 7. Buat Tabel AUDIT JADWAL
    $sql_audit = "CREATE TABLE audit_jadwal (
        id INT AUTO_INCREMENT PRIMARY KEY,
        judul VARCHAR(200) NOT NULL,
        tanggal_mulai DATE NOT NULL,
        tanggal_selesai DATE NOT NULL,
        status ENUM('Aktif', 'Selesai') DEFAULT 'Aktif',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql_audit);
    echo "✅ Tabel <strong>audit_jadwal</strong> berhasil dibuat.<br>";

    // 8. Buat Tabel AUDIT DETAIL
    $sql_audit_detail = "CREATE TABLE audit_detail (
        id INT AUTO_INCREMENT PRIMARY KEY,
        audit_id INT NOT NULL,
        barang_id INT NOT NULL,
        kondisi_awal VARCHAR(50),
        status_fisik ENUM('Belum Dicek', 'Ada Baik', 'Ada Rusak', 'Hilang') DEFAULT 'Belum Dicek',
        catatan TEXT NULL,
        checked_at DATETIME NULL,
        checker_name VARCHAR(100) NULL,
        FOREIGN KEY (audit_id) REFERENCES audit_jadwal(id) ON DELETE CASCADE,
        FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE CASCADE
    )";
    $conn->query($sql_audit_detail);
    echo "✅ Tabel <strong>audit_detail</strong> berhasil dibuat.<br>";

    echo "<hr>";
    echo "<h4>🌱 Seeding Data Dummy...</h4>";

    // 9. Isi Data USER (Admin & User Biasa)
    // Password default: password123
    $pass_hash = password_hash('password123', PASSWORD_DEFAULT);

    $stmt_user = $conn->prepare("INSERT INTO users (nama_lengkap, username, password, role) VALUES (?, ?, ?, ?)");

    $users_data = [
        ['Administrator', 'admin', $pass_hash, 'admin'],
        ['Staff Gudang', 'user', $pass_hash, 'user']
    ];

    foreach ($users_data as $u) {
        $stmt_user->bind_param("ssss", $u[0], $u[1], $u[2], $u[3]);
        $stmt_user->execute();
    }
    echo "👤 User dummy berhasil dibuat (Pass: password123)<br>";

    // 10. Isi Data KATEGORI
    $conn->query("INSERT INTO kategori (id, nama_kategori) VALUES 
        (1, 'Elektronik'),
        (2, 'Furniture'),
        (3, 'Alat Tulis Kantor'),
        (4, 'Perlengkapan Kebersihan'),
        (5, 'Aset Kendaraan')");
    echo "📂 Kategori dummy berhasil dibuat.<br>";

    // 11. Isi Data BARANG (50 Data)
    $sql_insert_barang = "INSERT INTO barang (nama_barang, kategori_id, jumlah, kondisi, keterangan) VALUES 
    ('Laptop ASUS Vivobook', 1, 15, 'Baik', 'Lab Komputer 1'),
    ('Laptop Lenovo Thinkpad', 1, 10, 'Baik', 'Lab Komputer 2'),
    ('PC All-in-One HP', 1, 20, 'Baik', 'Ruang Staff'),
    ('Proyektor Epson EB-X400', 1, 5, 'Baik', 'Digunakan bergantian'),
    ('Proyektor BenQ', 1, 2, 'Rusak Ringan', 'Lensa agak buram'),
    ('Printer Canon iP2770', 1, 4, 'Baik', 'Ruang TU'),
    ('Printer Epson L3110', 1, 3, 'Rusak Berat', 'Head buntu total'),
    ('Scanner Canon LiDE', 1, 2, 'Baik', 'Meja Resepsionis'),
    ('Mouse Logitech B100', 1, 50, 'Baik', 'Cadangan Lab'),
    ('Keyboard Logitech K120', 1, 45, 'Baik', 'Lab Multimedia'),
    ('Monitor LG 24 Inch', 1, 20, 'Baik', 'Lab Jaringan'),
    ('Kabel HDMI 5 Meter', 1, 10, 'Baik', 'Locker Admin'),
    ('Kabel VGA 3 Meter', 1, 15, 'Rusak Ringan', 'Kadang warnanya merah'),
    ('Router TP-Link Archer', 1, 5, 'Baik', 'Server Room'),
    ('Switch Hub Cisco 24 Port', 1, 2, 'Baik', 'Rak Server Lt 2'),
    ('Kamera DSLR Canon 600D', 1, 1, 'Baik', 'Inventaris Humas'),
    ('Tripod Kamera Takara', 1, 1, 'Rusak Ringan', 'Kaki penyangga patah satu'),
    ('Speaker Aktif Simbadda', 1, 2, 'Baik', 'Ruang Rapat Utama'),
    ('Mic Wireless Sony', 1, 4, 'Baik', 'Ruang Seminar'),
    ('AC Daikin 1PK', 1, 10, 'Baik', 'Terpasang di tiap kelas'),
    ('Meja Dosen Kayu Jati', 2, 12, 'Baik', 'Ruang Dosen'),
    ('Kursi Putar Staff', 2, 20, 'Baik', 'Ruang Admin'),
    ('Kursi Kuliah Chitose', 2, 100, 'Baik', 'Gedung A dan B'),
    ('Meja Rapat Oval', 2, 1, 'Baik', 'Ruang Meeting'),
    ('Lemari Arsip Besi', 2, 5, 'Baik', 'Gudang Arsip'),
    ('Rak Buku Perpustakaan', 2, 8, 'Baik', 'Perpus Lt 1'),
    ('Sofa Tamu L', 2, 1, 'Rusak Ringan', 'Kulit sofa sobek dikit'),
    ('Papan Tulis Whiteboard Besar', 2, 15, 'Baik', 'Semua Kelas'),
    ('Meja Resepsionis', 2, 1, 'Baik', 'Lobby Utama'),
    ('Locker Besi 12 Pintu', 2, 4, 'Baik', 'Ruang Ganti'),
    ('Spidol Boardmarker Hitam', 3, 50, 'Baik', 'Stok Lemari TU'),
    ('Spidol Boardmarker Merah', 3, 20, 'Baik', 'Stok Lemari TU'),
    ('Penghapus Papan Tulis', 3, 15, 'Baik', 'Sebagian sudah kotor'),
    ('Kertas A4 Satu Rim', 3, 25, 'Baik', 'Stok Baru Masuk'),
    ('Stapler Besar', 3, 5, 'Baik', 'Meja Staff'),
    ('Perforator (Pembolong Kertas)', 3, 3, 'Rusak Ringan', 'Per agak keras'),
    ('Map Plastik Clear Holder', 3, 30, 'Baik', 'Arsip Mahasiswa'),
    ('Tinta Printer Epson Black', 3, 10, 'Baik', 'Botol Segel'),
    ('Gunting Besar', 3, 5, 'Baik', '-'),
    ('Lakban Hitam', 3, 12, 'Baik', '-'),
    ('Sapu Lantai', 4, 10, 'Baik', 'Pojok Kebersihan'),
    ('Pel Lantai', 4, 8, 'Baik', '-'),
    ('Ember Plastik', 4, 5, 'Rusak Ringan', 'Gagang retak'),
    ('Tempat Sampah Besar', 4, 6, 'Baik', 'Koridor'),
    ('Vacuum Cleaner Portable', 4, 1, 'Rusak Berat', 'Mati total'),
    ('Sepeda Motor Honda Beat', 5, 1, 'Baik', 'Kendaraan Operasional'),
    ('Mobil Avanza Veloz', 5, 1, 'Baik', 'Plat BM 1234 XX'),
    ('Helm Standar', 5, 2, 'Baik', 'Gantungan Kunci'),
    ('Jas Hujan', 5, 2, 'Rusak Ringan', 'Ada bolong kecil'),
    ('Kunci Gembok Rantai', 5, 3, 'Baik', 'Pengaman Gerbang')";

    $conn->query($sql_insert_barang);
    echo "📦 50 Barang dummy berhasil dimasukkan.<br>";

    echo "<hr>";
    echo "<h2 style='color: green;'>🎉 SETUP DATABASE SELESAI!</h2>";
    echo "<p>Silakan buka aplikasi: <a href='public/index.php'>Buka Aplikasi</a></p>";
    echo "</div>";
} catch (mysqli_sql_exception $e) {
    echo "<div style='color: red; font-family: monospace; padding: 20px;'>";
    echo "<h3>❌ Terjadi Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
