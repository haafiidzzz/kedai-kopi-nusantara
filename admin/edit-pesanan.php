<?php
session_start();
include '../includes/config.php';

// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil ID pesanan dari URL
$pesanan_id = intval($_GET['id'] ?? 0);

if ($pesanan_id === 0) {
    header('Location: daftar-pesanan.php');
    exit;
}

// Ambil data pesanan
$query = "SELECT * FROM pesanan WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $pesanan_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pesanan = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Jika pesanan tidak ditemukan
if (!$pesanan) {
    header('Location: daftar-pesanan.php');
    exit;
}

// Inisialisasi variabel
$error = '';
$success = '';

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = htmlspecialchars(trim($_POST['nama_pelanggan'] ?? ''));
    $telepon = htmlspecialchars(trim($_POST['telepon'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $alamat = htmlspecialchars(trim($_POST['alamat'] ?? ''));
    $status = htmlspecialchars(trim($_POST['status'] ?? ''));
    $catatan = htmlspecialchars(trim($_POST['catatan'] ?? ''));

    // Validasi input
    if (empty($nama_pelanggan)) {
        $error = 'Nama pelanggan harus diisi!';
    } elseif (strlen($nama_pelanggan) < 3) {
        $error = 'Nama pelanggan minimal 3 karakter!';
    } elseif (empty($telepon)) {
        $error = 'Nomor telepon harus diisi!';
    } elseif (!preg_match('/^(\+62|62|0)[0-9]{9,12}$/', $telepon)) {
        $error = 'Nomor telepon tidak valid!';
    } elseif (empty($email)) {
        $error = 'Email harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } elseif (empty($alamat)) {
        $error = 'Alamat harus diisi!';
    } elseif (strlen($alamat) < 10) {
        $error = 'Alamat minimal 10 karakter!';
    } elseif (empty($status)) {
        $error = 'Status harus dipilih!';
    } elseif (!in_array($status, ['pending', 'dikirim', 'selesai', 'batal'])) {
        $error = 'Status tidak valid!';
    }

    // Jika tidak ada error, update database
    if (empty($error)) {
        $query_update = "UPDATE pesanan 
                        SET nama_pelanggan = ?, 
                            telepon = ?, 
                            email = ?,
                            alamat = ?, 
                            status = ?, 
                            catatan = ? 
                        WHERE id = ?";

        $stmt_update = mysqli_prepare($conn, $query_update);
        if (!$stmt_update) {
            $error = 'Error: ' . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param(
                $stmt_update,
                'ssssssi',
                $nama_pelanggan,
                $telepon,
                $email,
                $alamat,
                $status,
                $catatan,
                $pesanan_id
            );

            if (mysqli_stmt_execute($stmt_update)) {
                mysqli_stmt_close($stmt_update);
                $success = 'Pesanan berhasil diperbarui!';
                // Update variabel pesanan dengan data baru
                $pesanan['nama_pelanggan'] = $nama_pelanggan;
                $pesanan['telepon'] = $telepon;
                $pesanan['email'] = $email;
                $pesanan['alamat'] = $alamat;
                $pesanan['status'] = $status;
                $pesanan['catatan'] = $catatan;
            } else {
                $error = 'Error: ' . mysqli_stmt_error($stmt_update);
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan - Admin Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin-edit-pesanan.css">
</head>
<body>
    <?php include 'admin-navbar.php'; ?>
    
    <div class="edit-container">
        <div class="edit-header">
            <h1>Edit Pesanan</h1>
            <a href="lihat-pesanan.php?id=<?php echo $pesanan_id; ?>" class="btn-back">← Kembali</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">✗ <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">✓ <?php echo $success; ?></div>
        <?php endif; ?>

        <div class="form-card">
            <div class="info-box">
                <strong>Kode Pesanan:</strong> <?php echo htmlspecialchars($pesanan['kode_pesanan']); ?><br>
                <strong>Tanggal Pesanan:</strong> <?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?>
            </div>

            <form method="POST" action="">
                <!-- Data Pelanggan -->
                <div class="form-section">
                    <h3>Data Pelanggan</h3>

                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" 
                               value="<?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?>" 
                               required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="text" id="telepon" name="telepon" 
                                   value="<?php echo htmlspecialchars($pesanan['telepon']); ?>" 
                                   placeholder="08xx atau +628xx" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($pesanan['email']); ?>" 
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Pengiriman</label>
                        <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($pesanan['alamat']); ?></textarea>
                    </div>
                </div>

                <!-- Status & Catatan -->
                <div class="form-section">
                    <h3>Status & Catatan</h3>

                    <div class="form-group">
                        <label for="status">Status Pesanan</label>
                        <select id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="pending" <?php echo $pesanan['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="dikirim" <?php echo $pesanan['status'] === 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                            <option value="selesai" <?php echo $pesanan['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="batal" <?php echo $pesanan['status'] === 'batal' ? 'selected' : ''; ?>>Batal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan Internal</label>
                        <textarea id="catatan" name="catatan" placeholder="Catatan khusus untuk pesanan ini"><?php echo htmlspecialchars($pesanan['catatan']); ?></textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-submit">💾 Simpan Perubahan</button>
                    <a href="lihat-pesanan.php?id=<?php echo $pesanan_id; ?>" class="btn btn-cancel">✕ Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>