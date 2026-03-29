<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kopi  = bersihkan($conn, $_POST['nama_kopi']);
    $harga      = bersihkan($conn, $_POST['harga']);
    $stok       = bersihkan($conn, $_POST['stok']);
    $deskripsi  = bersihkan($conn, $_POST['deskripsi']);
    $kategori   = bersihkan($conn, $_POST['kategori']);
    $foto_nama  = '';

    // Proses upload foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto        = $_FILES['foto'];
        $ekstensi_ok = ['jpg', 'jpeg', 'png', 'webp'];
        $ekstensi    = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $ukuran_max  = 2 * 1024 * 1024; // 2MB

        if (!in_array($ekstensi, $ekstensi_ok)) {
            $error = 'Format foto harus JPG, PNG, atau WEBP!';
        } elseif ($foto['size'] > $ukuran_max) {
            $error = 'Ukuran foto maksimal 2MB!';
        } else {
            $foto_nama = time() . '_' . uniqid() . '.' . $ekstensi;
            $tujuan    = '../assets/uploads/' . $foto_nama;
            move_uploaded_file($foto['tmp_name'], $tujuan);
        }
    }

    if (!$error) {
        $query = "INSERT INTO produk 
                  (nama_kopi, harga, stok, deskripsi, kategori, foto) 
                  VALUES 
                  ('$nama_kopi', '$harga', '$stok', '$deskripsi', '$kategori', '$foto_nama')";

        if (mysqli_query($conn, $query)) {
            $success = 'Produk berhasil ditambahkan!';
        } else {
            $error = 'Gagal menyimpan: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'admin-navbar.php'; ?>

<div class="container" style="padding-top: 40px; max-width: 700px;">
    <div class="form-card">
        <h2>➕ Tambah Produk Kopi</h2>
        <p style="color:var(--abu); margin-bottom:25px;">
            Isi form di bawah untuk menambah produk baru
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
                       placeholder="cth: Kopi Gayo Arabika" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="harga" 
                           placeholder="cth: 75000" required min="0">
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stok" 
                           placeholder="cth: 50" required min="0">
                </div>
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Arabika">Arabika</option>
                    <option value="Robusta">Robusta</option>
                    <option value="Espresso">Espresso</option>
                    <option value="Manual Brew">Manual Brew</option>
                    <option value="Cold Brew">Cold Brew</option>
                    <option value="Blend">Blend</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4" 
                          placeholder="Jelaskan cita rasa, asal biji kopi, dll..."></textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <div class="upload-area" id="uploadArea">
                    <input type="file" name="foto" id="fotoInput" 
                           accept="image/*" style="display:none">
                    <div id="uploadPlaceholder" onclick="document.getElementById('fotoInput').click()">
                        <span style="font-size:2rem">📷</span>
                        <p>Klik untuk pilih foto</p>
                        <small>JPG, PNG, WEBP • Maks 2MB</small>
                    </div>
                    <img id="previewFoto" src="" alt="Preview" 
                         style="display:none; max-width:100%; border-radius:10px;">
                </div>
            </div>

            <div style="display:flex; gap:15px; margin-top:10px;">
                <button type="submit" class="btn-full">
                    💾 Simpan Produk
                </button>
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