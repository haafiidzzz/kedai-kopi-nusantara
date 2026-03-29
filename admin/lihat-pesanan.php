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

// Ambil detail pesanan
$query_detail = "SELECT * FROM detail_pesanan WHERE pesanan_id = ?";
$stmt_detail = mysqli_prepare($conn, $query_detail);
mysqli_stmt_bind_param($stmt_detail, 'i', $pesanan_id);
mysqli_stmt_execute($stmt_detail);
$result_detail = mysqli_stmt_get_result($stmt_detail);
$detail_pesanan = [];
while ($row = mysqli_fetch_assoc($result_detail)) {
    $detail_pesanan[] = $row;
}
mysqli_stmt_close($stmt_detail);

// Status label dan warna
$status_label = [
    'pending' => 'Pending',
    'dikirim' => 'Dikirim',
    'selesai' => 'Selesai',
    'batal' => 'Batal'
];

$status_colors = [
    'pending' => '#fff3cd',
    'dikirim' => '#cfe2ff',
    'selesai' => '#d1e7dd',
    'batal' => '#f8d7da'
];

$status_text_colors = [
    'pending' => '#856404',
    'dikirim' => '#084298',
    'selesai' => '#0f5132',
    'batal' => '#842029'
];

// Proses update status jika ada request
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = htmlspecialchars($_POST['action']);
    
    if ($action === 'mark_selesai') {
        // Update status ke selesai
        $query_update = "UPDATE pesanan SET status = 'selesai' WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, 'i', $pesanan_id);
        
        if (mysqli_stmt_execute($stmt_update)) {
            mysqli_stmt_close($stmt_update);
            $pesanan['status'] = 'selesai';
            $message = '<div class="alert alert-success">✓ Pesanan berhasil ditandai selesai!</div>';
        }
    } elseif ($action === 'mark_dikirim') {
        // Update status ke dikirim
        $query_update = "UPDATE pesanan SET status = 'dikirim' WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, 'i', $pesanan_id);
        
        if (mysqli_stmt_execute($stmt_update)) {
            mysqli_stmt_close($stmt_update);
            $pesanan['status'] = 'dikirim';
            $message = '<div class="alert alert-success">✓ Pesanan berhasil diubah menjadi dikirim!</div>';
        }
    } elseif ($action === 'mark_pending') {
        // Update status ke pending
        $query_update = "UPDATE pesanan SET status = 'pending' WHERE id = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, 'i', $pesanan_id);
        
        if (mysqli_stmt_execute($stmt_update)) {
            mysqli_stmt_close($stmt_update);
            $pesanan['status'] = 'pending';
            $message = '<div class="alert alert-info">ℹ Pesanan berhasil dikembalikan ke pending!</div>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin-lihat-pesanan.css">
</head>
<body>
    <?php include 'admin-navbar.php'; ?>
    
    <div class="detail-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1 style="margin: 0; color: #333;">Detail Pesanan</h1>
            <a href="daftar-pesanan.php" class="btn btn-back">← Kembali</a>
        </div>

        <?php echo $message; ?>

        <!-- Informasi Umum Pesanan -->
        <div class="detail-card">
            <h2>Informasi Pesanan</h2>

            <div class="detail-row">
                <div class="detail-label">Kode Pesanan:</div>
                <div class="detail-value">
                    <strong><?php echo htmlspecialchars($pesanan['kode_pesanan']); ?></strong>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Status Pesanan:</div>
                <div class="detail-value">
                    <span class="status-badge" 
                          style="background-color: <?php echo $status_colors[$pesanan['status']] ?? '#fff'; ?>; 
                                  color: <?php echo $status_text_colors[$pesanan['status']] ?? '#000'; ?>">
                        <?php echo $status_label[$pesanan['status']] ?? 'Unknown'; ?>
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tanggal Pesanan:</div>
                <div class="detail-value">
                    <?php echo date('d/m/Y H:i:s', strtotime($pesanan['created_at'])); ?>
                </div>
            </div>

            <!-- Action Buttons untuk Update Status -->
            <div class="action-buttons" style="margin-top: 20px;">
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="mark_pending">
                    <button type="submit" class="btn btn-warning" 
                            <?php echo $pesanan['status'] === 'pending' ? 'disabled style="opacity: 0.6; cursor: not-allowed;"' : ''; ?>>
                        ⏳ Pending
                    </button>
                </form>

                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="mark_dikirim">
                    <button type="submit" class="btn btn-info" 
                            <?php echo $pesanan['status'] === 'dikirim' ? 'disabled style="opacity: 0.6; cursor: not-allowed;"' : ''; ?>>
                        🚚 Dikirim
                    </button>
                </form>

                <form method="POST" style="display: inline;">
                    <input type="hidden" name="action" value="mark_selesai">
                    <button type="submit" class="btn btn-success" 
                            <?php echo $pesanan['status'] === 'selesai' ? 'disabled style="opacity: 0.6; cursor: not-allowed;"' : ''; ?>>
                        ✓ Selesai
                    </button>
                </form>
            </div>
        </div>

        <!-- Data Pengiriman -->
        <div class="detail-card">
            <h2>Data Pengiriman</h2>

            <div class="detail-row">
                <div class="detail-label">Nama Pelanggan:</div>
                <div class="detail-value">
                    <?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nomor Telepon:</div>
                <div class="detail-value">
                    <a href="https://wa.me/<?php echo preg_replace('/^0/', '62', $pesanan['telepon']); ?>" 
                       target="_blank" style="color: #25D366; text-decoration: none; font-weight: bold;">
                        📱 <?php echo htmlspecialchars($pesanan['telepon']); ?>
                    </a>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">
                    <a href="mailto:<?php echo htmlspecialchars($pesanan['email']); ?>" 
                       style="color: #0066cc; text-decoration: none;">
                        📧 <?php echo htmlspecialchars($pesanan['email']); ?>
                    </a>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Alamat Pengiriman:</div>
                <div class="detail-value">
                    <?php echo nl2br(htmlspecialchars($pesanan['alamat'])); ?>
                </div>
            </div>

            <?php if (!empty($pesanan['catatan'])): ?>
                <div class="detail-row">
                    <div class="detail-label">Catatan Pesanan:</div>
                    <div class="detail-value">
                        <div class="info-box">
                            <?php echo nl2br(htmlspecialchars($pesanan['catatan'])); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Detail Pesanan (Produk) -->
        <div class="detail-card">
            <h2>Detail Item Pesanan</h2>

            <table class="table-items">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: right;">Harga</th>
                        <th style="text-align: right;">Jumlah</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_pesanan as $item): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($item['nama_kopi']); ?></strong><br>
                                <small style="color: #999;">ID Produk: <?php echo $item['produk_id']; ?></small>
                            </td>
                            <td style="text-align: right;">
                                Rp<?php echo number_format($item['harga'], 0, ',', '.'); ?>
                            </td>
                            <td style="text-align: right;">
                                <?php echo $item['jumlah']; ?> pcs
                            </td>
                            <td style="text-align: right;">
                                <strong>Rp<?php echo number_format($item['subtotal'], 0, ',', '.'); ?></strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-item">
                    <span class="total-label">Total Pembayaran:</span>
                    <span class="total-value">Rp<?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="daftar-pesanan.php" class="btn btn-back">← Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</body>
</html>