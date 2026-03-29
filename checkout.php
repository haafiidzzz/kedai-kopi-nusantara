<?php
session_start();
include 'includes/config.php';

// Jika keranjang kosong, redirect ke halaman produk
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header('Location: produk.php?pesan=keranjang_kosong');
    exit;
}

// Inisialisasi variabel
$error = '';
$success = '';
$keranjang = $_SESSION['keranjang'];

// Hitung total harga
$total_harga = 0;
foreach ($keranjang as $item) {
    $total_harga += $item['harga'] * $item['jumlah'];
}

// Proses form ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_pelanggan = htmlspecialchars(trim($_POST['nama_pelanggan'] ?? ''));
    $telepon = htmlspecialchars(trim($_POST['telepon'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $alamat = htmlspecialchars(trim($_POST['alamat'] ?? ''));
    $catatan = htmlspecialchars(trim($_POST['catatan'] ?? ''));

    // Validasi input
    if (empty($nama_pelanggan)) {
        $error = 'Nama pembeli harus diisi!';
    } elseif (strlen($nama_pelanggan) < 3) {
        $error = 'Nama pembeli minimal 3 karakter!';
    } elseif (empty($telepon)) {
        $error = 'Nomor telepon harus diisi!';
    } elseif (!preg_match('/^(\+62|62|0)[0-9]{9,12}$/', $telepon)) {
        $error = 'Nomor telepon tidak valid! Format: 0812345678 atau +6281234567890';
    } elseif (empty($email)) {
        $error = 'Email harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } elseif (empty($alamat)) {
        $error = 'Alamat harus diisi!';
    } elseif (strlen($alamat) < 10) {
        $error = 'Alamat minimal 10 karakter!';
    }

    // Jika tidak ada error, proses checkout
    if (empty($error)) {
        // Mulai transaksi database
        mysqli_begin_transaction($conn);

        try {
            // Generate kode pesanan unik
            $kode_pesanan = 'PES-' . date('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 4));

            // Insert data pesanan ke tabel pesanan
            // Menyesuaikan dengan kolom: id, kode_pesanan, nama_pelanggan, telepon, email, alamat, catatan, total_harga, status, created_at
            $query_pesanan = "INSERT INTO pesanan 
                            (kode_pesanan, nama_pelanggan, telepon, email, alamat, catatan, total_harga, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";

            $stmt = mysqli_prepare($conn, $query_pesanan);
            if (!$stmt) {
                throw new Exception('Persiapan query gagal: ' . mysqli_error($conn));
            }

            mysqli_stmt_bind_param(
                $stmt,
                'ssssssi',
                $kode_pesanan,
                $nama_pelanggan,
                $telepon,
                $email,
                $alamat,
                $catatan,
                $total_harga
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception('Gagal menyimpan pesanan: ' . mysqli_stmt_error($stmt));
            }

            $pesanan_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            // Insert detail pesanan untuk setiap item di keranjang
            $query_detail = "INSERT INTO detail_pesanan 
                           (pesanan_id, produk_id, nama_kopi, harga, jumlah, subtotal) 
                           VALUES (?, ?, ?, ?, ?, ?)";

            $stmt_detail = mysqli_prepare($conn, $query_detail);
            if (!$stmt_detail) {
                throw new Exception('Persiapan query detail gagal: ' . mysqli_error($conn));
            }

            foreach ($keranjang as $item) {
                $subtotal = $item['harga'] * $item['jumlah'];

                mysqli_stmt_bind_param(
                    $stmt_detail,
                    'iissii',
                    $pesanan_id,
                    $item['id'],
                    $item['nama'],
                    $item['harga'],
                    $item['jumlah'],
                    $subtotal
                );

                if (!mysqli_stmt_execute($stmt_detail)) {
                    throw new Exception('Gagal menyimpan detail pesanan: ' . mysqli_stmt_error($stmt_detail));
                }

                // Update stok produk - kurangi sesuai jumlah yang dibeli
                $query_update_stok = "UPDATE produk SET stok = stok - ? WHERE id = ?";
                $stmt_stok = mysqli_prepare($conn, $query_update_stok);

                if (!$stmt_stok) {
                    throw new Exception('Persiapan update stok gagal: ' . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmt_stok, 'ii', $item['jumlah'], $item['id']);

                if (!mysqli_stmt_execute($stmt_stok)) {
                    throw new Exception('Gagal update stok produk: ' . mysqli_stmt_error($stmt_stok));
                }

                mysqli_stmt_close($stmt_stok);
            }

            mysqli_stmt_close($stmt_detail);

            // Commit transaksi
            mysqli_commit($conn);

            // Kosongkan keranjang dari SESSION
            unset($_SESSION['keranjang']);

            // Simpan info pembayaran ke session
            $_SESSION['pembayaran'] = [
                'kode_pesanan' => $kode_pesanan,
                'total_harga' => $total_harga,
                'nama_pelanggan' => $nama_pelanggan
            ];

            // Redirect ke halaman pembayaran QRIS
            header('Location: pembayaran.php');
            exit;

        } catch (Exception $e) {
            // Rollback jika ada error
            mysqli_rollback($conn);
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Kedai Kopi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="checkout-container">
        <h1>Checkout Pesanan</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="checkout-wrapper">
            <!-- Form Checkout -->
            <div class="checkout-form">
                <h2>Data Pengiriman</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pembeli *</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan" 
                               value="<?php echo htmlspecialchars($_POST['nama_pelanggan'] ?? ''); ?>" 
                               placeholder="Masukkan nama lengkap" required>
                        <p class="info-text">Minimal 3 karakter</p>
                    </div>

                    <div class="form-group">
                        <label for="telepon">Nomor Telepon/WhatsApp *</label>
                        <input type="text" id="telepon" name="telepon" 
                               value="<?php echo htmlspecialchars($_POST['telepon'] ?? ''); ?>" 
                               placeholder="08123456789 atau +6281234567890" required>
                        <p class="info-text">Format: 08xx atau +628xx</p>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                               placeholder="contoh@email.com" required>
                        <p class="info-text">Email yang valid untuk konfirmasi</p>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap *</label>
                        <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap pengiriman" required><?php echo htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>
                        <p class="info-text">Minimal 10 karakter, termasuk jalan, nomor rumah, kelurahan, kecamatan</p>
                    </div>

                    <div class="form-group">
                        <label for="catatan">Catatan (Opsional)</label>
                        <textarea id="catatan" name="catatan" placeholder="Tambahkan catatan khusus untuk pesanan Anda"><?php echo htmlspecialchars($_POST['catatan'] ?? ''); ?></textarea>
                        <p class="info-text">Contoh: tanpa gula, ditambah es batu, dll</p>
                    </div>

                    <button type="submit" class="btn-submit">Konfirmasi Pesanan</button>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="order-summary">
                <h3>Ringkasan Pesanan</h3>

                <div class="order-summary-items">
                    <?php foreach ($keranjang as $item): ?>
                        <div class="summary-item">
                            <div class="summary-item-left">
                                <strong><?php echo htmlspecialchars($item['nama']); ?></strong>
                                <small><?php echo $item['jumlah']; ?>x @ Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></small>
                            </div>
                            <div class="summary-item-right">
                                <strong>Rp<?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="summary-total">
                    <span>Total Harga:</span>
                    <span>Rp<?php echo number_format($total_harga, 0, ',', '.'); ?></span>
                </div>

                <div class="info-box">
                    <p>Catatan Penting:</p>
                    <ul>
                        <li>Periksa kembali data pengiriman Anda</li>
                        <li>Konfirmasi pesanan akan dikirim via email dan telepon setelah checkout</li>
                        <li>Stok produk akan otomatis berkurang setelah checkout berhasil</li>
                        <li>Pesanan akan diproses dalam 1x24 jam</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>