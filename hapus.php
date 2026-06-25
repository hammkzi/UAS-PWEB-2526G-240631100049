<?php
// hapus.php — Proses Hapus Buku (DELETE)
// File ini tidak memiliki tampilan, langsung redirect setelah proses

require 'includes/koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah data ada
    $cek = mysqli_query($koneksi, "SELECT id FROM buku WHERE id = $id");

    if (mysqli_num_rows($cek) > 0) {
        // Percabangan: lakukan penghapusan
        $hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE id = $id");

        if ($hapus) {
            header('Location: daftar.php?pesan=hapus_sukses');
        } else {
            header('Location: daftar.php?pesan=hapus_gagal');
        }
    } else {
        // Data tidak ditemukan
        header('Location: daftar.php');
    }
} else {
    // ID tidak valid
    header('Location: daftar.php');
}

exit;
?>
