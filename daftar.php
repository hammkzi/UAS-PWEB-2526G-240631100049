<?php
// daftar.php — Halaman Daftar Buku (READ)
require 'includes/koneksi.php';
require 'includes/functions.php';

$pageTitle = 'Daftar Buku';

// Ambil pesan dari session/redirect
$pesan = '';
if (isset($_GET['pesan'])) {
    // Percabangan: tentukan jenis pesan
    switch ($_GET['pesan']) {
        case 'tambah_sukses':
            $pesan = tampilPesan('Buku berhasil ditambahkan!');
            break;
        case 'edit_sukses':
            $pesan = tampilPesan('Data buku berhasil diperbarui!');
            break;
        case 'hapus_sukses':
            $pesan = tampilPesan('Buku berhasil dihapus!', 'error');
            break;
    }
}

// ===== SEARCH & FILTER (GET) =====
$cari      = isset($_GET['cari'])     ? sanitasi($_GET['cari'])     : '';
$filterKat = isset($_GET['kategori']) ? sanitasi($_GET['kategori']) : '';

// Bangun query dengan filter
$where = "WHERE 1=1";
if ($cari !== '') {
    $cari_aman = mysqli_real_escape_string($koneksi, $cari);
    $where .= " AND (judul LIKE '%$cari_aman%' OR pengarang LIKE '%$cari_aman%' OR penerbit LIKE '%$cari_aman%')";
}
if ($filterKat !== '') {
    $kat_aman = mysqli_real_escape_string($koneksi, $filterKat);
    $where .= " AND kategori = '$kat_aman'";
}

$query      = mysqli_query($koneksi, "SELECT * FROM buku $where ORDER BY created_at DESC");
$totalHasil = mysqli_num_rows($query);

// Ambil semua kategori untuk dropdown filter
$kategoriList = getKategori($koneksi);

require 'includes/header.php';
?>

<h1 class="page-title">📋 Daftar Buku</h1>

<?= $pesan ?>

<!-- Search & Filter Form (GET) -->
<form method="GET" action="daftar.php">
    <div class="search-bar">
        <input
            type="text"
            name="cari"
            placeholder="🔍 Cari judul, pengarang, penerbit..."
            value="<?= htmlspecialchars($cari) ?>"
        >
        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategoriList as $kat): ?>
                <option value="<?= $kat ?>" <?= $filterKat === $kat ? 'selected' : '' ?>>
                    <?= $kat ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-tambah">Cari</button>
        <?php if ($cari !== '' || $filterKat !== ''): ?>
            <a href="daftar.php" class="btn btn-batal" style="width:auto;">Reset</a>
        <?php endif; ?>
    </div>
</form>

<!-- Top bar -->
<div class="top-bar">
    <span style="color:#718096; font-size:0.9rem;">
        Menampilkan <strong><?= $totalHasil ?></strong> buku
        <?= ($cari || $filterKat) ? '(hasil filter)' : '' ?>
    </span>
    <a href="tambah.php" class="btn btn-tambah">➕ Tambah Buku</a>
</div>

<!-- Tabel Buku -->
<?php if ($totalHasil > 0): ?>
<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // Perulangan: tampilkan semua data buku
            while ($buku = mysqli_fetch_assoc($query)):
                // Percabangan: warna stok
                if ($buku['stok'] == 0) {
                    $kelasStok = 'stok-empty';
                    $labelStok = 'Habis';
                } elseif ($buku['stok'] <= 3) {
                    $kelasStok = 'stok-warn';
                    $labelStok = $buku['stok'] . ' (sedikit)';
                } else {
                    $kelasStok = 'stok-ok';
                    $labelStok = $buku['stok'];
                }
            ?>
            <tr>
                <td data-label="#"><?= $no++ ?></td>
                <td data-label="Judul"><strong><?= sanitasi($buku['judul']) ?></strong></td>
                <td data-label="Pengarang"><?= sanitasi($buku['pengarang']) ?></td>
                <td data-label="Penerbit"><?= sanitasi($buku['penerbit']) ?></td>
                <td data-label="Tahun"><?= $buku['tahun_terbit'] ?></td>
                <td data-label="Kategori"><span class="badge"><?= sanitasi($buku['kategori']) ?></span></td>
                <td data-label="Stok"><span class="<?= $kelasStok ?>"><?= $labelStok ?></span></td>
                <td data-label="Aksi">
                    <a href="edit.php?id=<?= $buku['id'] ?>" class="btn btn-edit">✏️ Edit</a>
                    <a href="hapus.php?id=<?= $buku['id'] ?>"
                       class="btn btn-hapus"
                       onclick="return confirm('Yakin hapus buku ini?')">🗑️ Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <div class="card empty-state">
        <div class="empty-icon">🔍</div>
        <p>Tidak ada buku yang ditemukan.</p>
        <?php if ($cari || $filterKat): ?>
            <p><a href="daftar.php">Tampilkan semua buku</a></p>
        <?php else: ?>
            <p><a href="tambah.php">Tambah buku pertama</a></p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require 'includes/footer.php'; ?>
