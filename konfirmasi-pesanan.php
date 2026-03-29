<?php
session_start();
include 'includes/config.php';

// Ambil kode pesanan dari URL
$kode_pesanan = htmlspecialchars($_GET['kode_pesanan'] ?? '');

if (empty($kode_pesanan)) {
    header('Location: index.php');
    exit;
}

// Ambil data pesanan dari database
// Menyesuaikan dengan kolom: id, kode_pesanan, nama_pelanggan, telepon, email, alamat, catatan, total_harga, status, created_at
$query = "SELECT * FROM pesanan WHERE kode_pesanan = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $kode_pesanan);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pesanan = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Jika pesanan tidak ditemukan
if (!$pesanan) {
    header('Location: index.php');
    exit;
}

// Ambil detail pesanan
$query_detail = "SELECT * FROM detail_pesanan WHERE pesanan_id = ?";
$stmt_detail = mysqli_prepare($conn, $query_detail);
mysqli_stmt_bind_param($stmt_detail, 'i', $pesanan['id']);
mysqli_stmt_execute($stmt_detail);
$result_detail = mysqli_stmt_get_result($stmt_detail);
$detail_pesanan = [];
while ($row = mysqli_fetch_assoc($result_detail)) {
    $detail_pesanan[] = $row;
}
mysqli_stmt_close($stmt_detail);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - Kedai Kopi</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/konfirmasi-pesanan.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="confirmation-container">
        <div class="confirmation-card">
            <div class="success-icon">✓</div>
            <h1>Pesanan Berhasil Dibuat!</h1>
            <p>Terima kasih telah berbelanja di Kedai Kopi kami. Pesanan Anda sedang diproses.</p>

            <div class="kode-pesanan-box">
                <div class="kode-pesanan-label">Kode Pesanan Anda:</div>
                <div class="kode-pesanan"><?php echo htmlspecialchars($pesanan['kode_pesanan']); ?></div>
                <small>Simpan kode pesanan ini untuk referensi Anda</small>
            </div>

            <!-- Data Pengiriman -->
            <div class="info-section">
                <h3>Data Pengiriman</h3>
                <div class="info-row">
                    <span class="info-label">Nama Penerima:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nomor Telepon:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pesanan['telepon']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pesanan['email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pesanan['alamat']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status Pesanan:</span>
                    <span class="info-value">
                        <span class="status-badge">PENDING</span>
                    </span>
                </div>
            </div>

            <!-- Detail Pesanan -->
            <div class="info-section">
                <h3>Detail Pesanan</h3>
                <div class="detail-pesanan">
                    <?php foreach ($detail_pesanan as $item): ?>
                        <div class="item-row">
                            <div>
                                <strong><?php echo htmlspecialchars($item['nama_kopi']); ?></strong>
                                <small><?php echo $item['jumlah']; ?>x @ Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?></small>
                            </div>
                            <div class="item-row-right">
                                <strong>Rp<?php echo number_format($item['subtotal'], 0, ',', '.'); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="total-row">
                    <span>Total Pembayaran:</span>
                    <span>Rp<?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?></span>
                </div>
            </div>

            <!-- Pesan Email -->
            <div class="email-message">
                <strong>📧 Informasi Penting:</strong>
                Kami akan mengirimkan konfirmasi pesanan melalui email ke <?php echo htmlspecialchars($pesanan['email']); ?> 
                dalam waktu maksimal 1 jam. Pastikan email tersebut dapat menerima pesan.
            </div>

            <!-- Tombol Aksi -->
            <div class="action-buttons">
                <a href="produk.php" class="btn btn-secondary">Lanjut Belanja</a>
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>