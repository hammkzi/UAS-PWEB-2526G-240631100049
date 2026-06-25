<?php
// includes/koneksi.php
// Konfigurasi koneksi ke database MySQL

define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // Ganti sesuai username MySQL kamu
define('DB_PASS', '');          // Ganti sesuai password MySQL kamu
define('DB_NAME', 'sistem_buku');

$koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$koneksi) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'>
        <strong>Koneksi database gagal!</strong><br>
        Error: " . mysqli_connect_error() . "<br>
        Pastikan MySQL aktif dan konfigurasi di includes/koneksi.php sudah benar.
    </div>");
}

mysqli_set_charset($koneksi, "utf8");
?>
