<?php
// index.php — Halaman Beranda
require 'includes/koneksi.php';
require 'includes/functions.php';

$pageTitle = 'Beranda';

// Ambil statistik untuk ditampilkan di beranda
$totalBuku     = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM buku"));
$totalStokSemua = totalStok($koneksi);
$kategoriList  = getKategori($koneksi);
$totalKategori = count($kategoriList);

// Ambil 5 buku terbaru
$bukuTerbaru = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY created_at DESC LIMIT 5");

require 'includes/header.php';
?>

<!-- Hero Section -->
<div class="hero">
    <div style="font-size:3rem; margin-bottom:0.5rem;">📚</div>
    <h1>Sistem Pendataan Buku</h1>
    <p>Kelola koleksi buku perpustakaan dengan mudah dan efisien.</p>
    <a href="tambah.php" class="hero-btn">➕ Tambah Buku Baru</a>
</div>

<!-- Statistik -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $totalBuku ?></div>
        <div class="stat-label">📖 Total Judul Buku</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= formatAngka($totalStokSemua) ?></div>
        <div class="stat-label">📦 Total Stok Buku</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $totalKategori ?></div>
        <div class="stat-label">🏷️ Kategori Tersedia</div>
    </div>
</div>

<!-- Buku Terbaru -->
<div class="card">
    <div class="top-bar">
        <h2 style="font-size:1.2rem; color:#2b6cb0;">📋 Buku Terbaru Ditambahkan</h2>
        <a href="daftar.php" class="btn btn-tambah">Lihat Semua →</a>
    </div>

    <?php if (mysqli_num_rows($bukuTerbaru) > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($buku = mysqli_fetch_assoc($bukuTerbaru)): ?>
                    <?php
                        // Percabangan: tentukan kelas stok
                        if ($buku['stok'] == 0) {
                            $kelasStok = 'stok-empty';
                            $labelStok = '❌ Habis';
                        } elseif ($buku['stok'] <= 3) {
                            $kelasStok = 'stok-warn';
                            $labelStok = '⚠️ ' . $buku['stok'];
                        } else {
                            $kelasStok = 'stok-ok';
                            $labelStok = '✅ ' . $buku['stok'];
                        }
                    ?>
                    <tr>
                        <td data-label="Judul"><strong><?= sanitasi($buku['judul']) ?></strong></td>
                        <td data-label="Pengarang"><?= sanitasi($buku['pengarang']) ?></td>
                        <td data-label="Kategori"><span class="badge"><?= sanitasi($buku['kategori']) ?></span></td>
                        <td data-label="Stok"><span class="<?= $kelasStok ?>"><?= $labelStok ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>Belum ada data buku. <a href="tambah.php">Tambah sekarang</a>.</p>
        </div>
    <?php endif; ?>
</div>

<?php require 'includes/footer.php'; ?>
