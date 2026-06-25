<?php
// tambah.php — Halaman Tambah Buku (CREATE)
require 'includes/koneksi.php';
require 'includes/functions.php';

$pageTitle = 'Tambah Buku';
$pesan     = '';
$errors    = [];

// Ambil kategori untuk dropdown
$kategoriList = getKategori($koneksi);

// Daftar kategori default
$kategoriDefault = ['Novel', 'Teknologi', 'Self Help', 'Filsafat', 'Sejarah', 'Sains', 'Bisnis', 'Pendidikan', 'Lainnya'];

// ===== PROSES FORM (POST) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil & sanitasi input
    $judul       = sanitasi($_POST['judul'] ?? '');
    $pengarang   = sanitasi($_POST['pengarang'] ?? '');
    $penerbit    = sanitasi($_POST['penerbit'] ?? '');
    $tahun       = sanitasi($_POST['tahun_terbit'] ?? '');
    $stok        = sanitasi($_POST['stok'] ?? '');
    $kategori    = sanitasi($_POST['kategori'] ?? '');
    $kategoriLain = sanitasi($_POST['kategori_lain'] ?? '');

    // Jika pilih "Lainnya", gunakan input manual
    if ($kategori === 'Lainnya' && $kategoriLain !== '') {
        $kategori = $kategoriLain;
    }

    // ===== VALIDASI =====
    if (empty($judul))     $errors[] = 'Judul tidak boleh kosong.';
    if (empty($pengarang)) $errors[] = 'Pengarang tidak boleh kosong.';
    if (empty($penerbit))  $errors[] = 'Penerbit tidak boleh kosong.';
    if (empty($tahun) || !is_numeric($tahun) || $tahun < 1000 || $tahun > date('Y')) {
        $errors[] = 'Tahun terbit tidak valid.';
    }
    if (empty($stok) || !is_numeric($stok) || $stok < 0) {
        $errors[] = 'Stok harus berupa angka positif.';
    }
    if (empty($kategori))  $errors[] = 'Kategori tidak boleh kosong.';

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        $j = mysqli_real_escape_string($koneksi, $judul);
        $p = mysqli_real_escape_string($koneksi, $pengarang);
        $pb = mysqli_real_escape_string($koneksi, $penerbit);
        $t = (int)$tahun;
        $s = (int)$stok;
        $k = mysqli_real_escape_string($koneksi, $kategori);

        $sql = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, stok, kategori)
                VALUES ('$j', '$p', '$pb', $t, $s, '$k')";

        if (mysqli_query($koneksi, $sql)) {
            // Redirect ke daftar dengan pesan sukses
            header('Location: daftar.php?pesan=tambah_sukses');
            exit;
        } else {
            $pesan = tampilPesan('Gagal menyimpan data: ' . mysqli_error($koneksi), 'error');
        }
    }
}

require 'includes/header.php';
?>

<h1 class="page-title">➕ Tambah Buku Baru</h1>

<?= $pesan ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        ❌ Terdapat kesalahan:<br>
        <ul style="margin-top:0.5rem; padding-left:1.5rem;">
            <?php foreach ($errors as $err): ?>
                <li><?= $err ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="tambah.php">

        <div class="form-row">
            <div class="form-group">
                <label for="judul">📖 Judul Buku *</label>
                <input type="text" id="judul" name="judul"
                       placeholder="Masukkan judul buku"
                       value="<?= isset($judul) ? htmlspecialchars($judul) : '' ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="pengarang">✍️ Pengarang *</label>
                <input type="text" id="pengarang" name="pengarang"
                       placeholder="Nama penulis / pengarang"
                       value="<?= isset($pengarang) ? htmlspecialchars($pengarang) : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="penerbit">🏢 Penerbit *</label>
                <input type="text" id="penerbit" name="penerbit"
                       placeholder="Nama penerbit"
                       value="<?= isset($penerbit) ? htmlspecialchars($penerbit) : '' ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="tahun_terbit">📅 Tahun Terbit *</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit"
                       placeholder="Contoh: 2020"
                       min="1000" max="<?= date('Y') ?>"
                       value="<?= isset($tahun) ? htmlspecialchars($tahun) : '' ?>"
                       required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="stok">📦 Stok *</label>
                <input type="number" id="stok" name="stok"
                       placeholder="Jumlah stok buku"
                       min="0"
                       value="<?= isset($stok) ? htmlspecialchars($stok) : '' ?>"
                       required>
            </div>
            <div class="form-group">
                <label for="kategori">🏷️ Kategori *</label>
                <select id="kategori" name="kategori" onchange="toggleKategoriLain(this)" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategoriDefault as $k): ?>
                        <option value="<?= $k ?>" <?= (isset($kategori) && $kategori === $k) ? 'selected' : '' ?>>
                            <?= $k ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Input kategori lain (muncul jika pilih "Lainnya") -->
        <div class="form-group" id="inputKategoriLain" style="display:none;">
            <label for="kategori_lain">Kategori Lainnya *</label>
            <input type="text" id="kategori_lain" name="kategori_lain" placeholder="Masukkan kategori baru">
        </div>

        <div class="form-row">
            <button type="submit" class="btn btn-submit">💾 Simpan Buku</button>
            <a href="daftar.php" class="btn btn-batal" style="text-align:center; line-height:2.5;">❌ Batal</a>
        </div>

    </form>
</div>

<script>
function toggleKategoriLain(sel) {
    var div = document.getElementById('inputKategoriLain');
    var inp = document.getElementById('kategori_lain');
    if (sel.value === 'Lainnya') {
        div.style.display = 'block';
        inp.required = true;
    } else {
        div.style.display = 'none';
        inp.required = false;
    }
}
</script>

<?php require 'includes/footer.php'; ?>
