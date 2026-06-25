<?php
// edit.php — Halaman Edit Buku (UPDATE)
require 'includes/koneksi.php';
require 'includes/functions.php';

$pageTitle = 'Edit Buku';
$pesan     = '';
$errors    = [];

// Ambil ID dari URL (GET)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi ID
if ($id <= 0) {
    header('Location: daftar.php');
    exit;
}

// Ambil data buku berdasarkan ID
$queryBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = $id");
if (mysqli_num_rows($queryBuku) === 0) {
    header('Location: daftar.php');
    exit;
}
$buku = mysqli_fetch_assoc($queryBuku);

// Daftar kategori default
$kategoriDefault = ['Novel', 'Teknologi', 'Self Help', 'Filsafat', 'Sejarah', 'Sains', 'Bisnis', 'Pendidikan', 'Lainnya'];

// ===== PROSES FORM EDIT (POST) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $judul       = sanitasi($_POST['judul'] ?? '');
    $pengarang   = sanitasi($_POST['pengarang'] ?? '');
    $penerbit    = sanitasi($_POST['penerbit'] ?? '');
    $tahun       = sanitasi($_POST['tahun_terbit'] ?? '');
    $stok        = sanitasi($_POST['stok'] ?? '');
    $kategori    = sanitasi($_POST['kategori'] ?? '');
    $kategoriLain = sanitasi($_POST['kategori_lain'] ?? '');

    if ($kategori === 'Lainnya' && $kategoriLain !== '') {
        $kategori = $kategoriLain;
    }

    // Validasi
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

    if (empty($errors)) {
        $j  = mysqli_real_escape_string($koneksi, $judul);
        $p  = mysqli_real_escape_string($koneksi, $pengarang);
        $pb = mysqli_real_escape_string($koneksi, $penerbit);
        $t  = (int)$tahun;
        $s  = (int)$stok;
        $k  = mysqli_real_escape_string($koneksi, $kategori);

        $sql = "UPDATE buku SET
                    judul        = '$j',
                    pengarang    = '$p',
                    penerbit     = '$pb',
                    tahun_terbit = $t,
                    stok         = $s,
                    kategori     = '$k'
                WHERE id = $id";

        if (mysqli_query($koneksi, $sql)) {
            header('Location: daftar.php?pesan=edit_sukses');
            exit;
        } else {
            $pesan = tampilPesan('Gagal memperbarui data: ' . mysqli_error($koneksi), 'error');
        }
    } else {
        // Jika ada error, refresh data dari input POST
        $buku['judul']       = $judul;
        $buku['pengarang']   = $pengarang;
        $buku['penerbit']    = $penerbit;
        $buku['tahun_terbit'] = $tahun;
        $buku['stok']        = $stok;
        $buku['kategori']    = $kategori;
    }
}

// Cek apakah kategori buku ada di list default
$kategoriAdaDiDefault = in_array($buku['kategori'], $kategoriDefault);

require 'includes/header.php';
?>

<h1 class="page-title">✏️ Edit Data Buku</h1>

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
    <form method="POST" action="edit.php?id=<?= $id ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="judul">📖 Judul Buku *</label>
                <input type="text" id="judul" name="judul"
                       value="<?= htmlspecialchars($buku['judul']) ?>" required>
            </div>
            <div class="form-group">
                <label for="pengarang">✍️ Pengarang *</label>
                <input type="text" id="pengarang" name="pengarang"
                       value="<?= htmlspecialchars($buku['pengarang']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="penerbit">🏢 Penerbit *</label>
                <input type="text" id="penerbit" name="penerbit"
                       value="<?= htmlspecialchars($buku['penerbit']) ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun_terbit">📅 Tahun Terbit *</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit"
                       min="1000" max="<?= date('Y') ?>"
                       value="<?= htmlspecialchars($buku['tahun_terbit']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="stok">📦 Stok *</label>
                <input type="number" id="stok" name="stok"
                       min="0"
                       value="<?= htmlspecialchars($buku['stok']) ?>" required>
            </div>
            <div class="form-group">
                <label for="kategori">🏷️ Kategori *</label>
                <select id="kategori" name="kategori" onchange="toggleKategoriLain(this)" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategoriDefault as $k): ?>
                        <option value="<?= $k ?>"
                            <?php
                                // Percabangan: pre-select kategori
                                if ($k === 'Lainnya' && !$kategoriAdaDiDefault) {
                                    echo 'selected';
                                } elseif ($k === $buku['kategori']) {
                                    echo 'selected';
                                }
                            ?>>
                            <?= $k ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Kategori lain -->
        <div class="form-group" id="inputKategoriLain"
             style="display:<?= (!$kategoriAdaDiDefault) ? 'block' : 'none' ?>;">
            <label for="kategori_lain">Kategori Lainnya *</label>
            <input type="text" id="kategori_lain" name="kategori_lain"
                   value="<?= !$kategoriAdaDiDefault ? htmlspecialchars($buku['kategori']) : '' ?>"
                   placeholder="Masukkan kategori baru">
        </div>

        <div class="form-row">
            <button type="submit" class="btn btn-submit">💾 Perbarui Buku</button>
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
