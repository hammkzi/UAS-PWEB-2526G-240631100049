<?php
// includes/functions.php
// Kumpulan fungsi yang digunakan dalam aplikasi

/**
 * Fungsi 1: Sanitasi input untuk mencegah XSS
 * Membersihkan string dari karakter berbahaya
 */
function sanitasi($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Fungsi 2: Tampilkan pesan notifikasi (sukses / error)
 * Mengembalikan HTML notifikasi
 */
function tampilPesan($pesan, $tipe = 'sukses') {
    $kelas = ($tipe === 'sukses') ? 'alert-sukses' : 'alert-error';
    $ikon  = ($tipe === 'sukses') ? '✅' : '❌';
    return "<div class='alert {$kelas}'>{$ikon} {$pesan}</div>";
}

/**
 * Fungsi 3: Format angka menjadi tampilan lebih rapi
 * Contoh: 1000 → 1.000
 */
function formatAngka($angka) {
    return number_format($angka, 0, ',', '.');
}

/**
 * Fungsi 4: Ambil semua kategori unik dari database
 * Digunakan untuk dropdown filter & form
 */
function getKategori($koneksi) {
    $kategori = [];
    $query = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM buku ORDER BY kategori ASC");
    while ($row = mysqli_fetch_assoc($query)) {
        $kategori[] = $row['kategori'];
    }
    return $kategori;
}

/**
 * Fungsi 5: Hitung total stok buku di database
 */
function totalStok($koneksi) {
    $query = mysqli_query($koneksi, "SELECT SUM(stok) AS total FROM buku");
    $row   = mysqli_fetch_assoc($query);
    return $row['total'] ?? 0;
}
?>
