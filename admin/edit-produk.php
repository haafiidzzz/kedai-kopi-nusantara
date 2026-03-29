<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = (int)$_GET['id'];
$produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id"));

if (!$produk) {
    header('Location: dashboard.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kopi = bersihkan($conn, $_POST['nama_kopi']);
    $harga     = bersihkan($conn, $_POST['harga']);
    $stok      = bersihkan($conn, $_POST['stok']);
    $deskripsi = bersihkan($conn, $_POST['deskripsi']);
    $kategori  = bersihkan($conn, $_POST['kategori']);
    $foto_nama = $produk['foto']; // pakai foto lama dulu

    // Proses upload foto baru (kalau ada)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto        = $_FILES['foto'];
        $ekstensi_ok = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi    = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

        if (!in_array($ekstensi, $ekstensi_ok)) {
            $error = 'Format foto harus JPG, PNG, atau WEBP!';
        } elseif ($foto['size'] > 2 * 1024 * 1024) {
            $error = 'Ukuran foto maksimal 2MB!';
        } else {
            // Hapus foto lama
            if ($produk['foto'] && file_exists('../assets/uploads/' . $produk['foto'])) {
                unlink('../assets/uploads/' . $produk['foto']);
            }
            $foto_nama = time() . '_' . uniqid() . '.' . $ekstensi;
            move_uploaded_file($foto['tmp_name'], '../assets/uploads/' . $foto_nama);
        }
    }

    if (!$error) {
        $query = "UPDATE produk SET 
                    nama_kopi = '$nama_kopi',
                    harga     = '$harga',
                    stok      = '$stok',
                    deskripsi = '$deskripsi',
                    kategori  = '$kategori',
                    foto      = '$foto_nama'
                  WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            $success = 'Produk berhasil diupdate!';
            $produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id"));
        } else {
            $error = 'Gagal update: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'admin-navbar.php'; ?>

<div class="container" style="padding-top: 40px; max-width: 700px;">
    <div class="form-card">
        <h2>✏️ Edit Produk</h2>
        <p style="color:var(--abu); margin-bottom:25px;">
            Update informasi produk kopi
        </p>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Kopi *</label>
                <input type="text" name="nama_kopi" 
                       value="<?= $produk['nama_kopi'] ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="harga" 
                           value="<?= $produk['harga'] ?>" required min="0">
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok" 
                           value="<?= $produk['stok'] ?>" required min="0">
                </div>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    $kategories = ['Arabika','Robusta','Espresso','Manual Brew','Cold Brew','Blend'];
                    foreach ($kategories as $kat):
                    ?>
                    <option value="<?= $kat ?>" 
                        <?= $produk['kategori'] == $kat ? 'selected' : '' ?>>
                        <?= $kat ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4"><?= $produk['deskripsi'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <?php if ($produk['foto']): ?>
                <div style="margin-bottom: 10px;">
                    <img src="../assets/uploads/<?= $produk['foto'] ?>" 
                         style="width:120px; height:120px; object-fit:cover; border-radius:10px;">
                    <p style="font-size:0.85rem; color:var(--abu); margin-top:5px;">
                        Foto saat ini — upload baru untuk mengganti
                    </p>
                </div>
                <?php endif; ?>
                <div class="upload-area">
                    <input type="file" name="foto" accept="image/*" 
                           id="fotoInput" style="display:none">
                    <div id="uploadPlaceholder" 
                         onclick="document.getElementById('fotoInput').click()">
                        <span style="font-size:2rem">📷</span>
                        <p>Klik untuk ganti foto</p>
                        <small>JPG, PNG, WEBP • Maks 2MB</small>
                    </div>
                    <img id="previewFoto" src="" alt="Preview" 
                         style="display:none; max-width:100%; border-radius:10px;">
                </div>
            </div>

            <div style="display:flex; gap:15px; margin-top:10px;">
                <button type="submit" class="btn-full">💾 Update Produk</button>
                <a href="dashboard.php" 
                   style="flex:1; text-align:center; padding:13px; 
                          border:2px solid var(--coklat); color:var(--coklat); 
                          border-radius:10px; text-decoration:none; font-weight:bold;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('fotoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewFoto').src = e.target.result;
            document.getElementById('previewFoto').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
        }
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>