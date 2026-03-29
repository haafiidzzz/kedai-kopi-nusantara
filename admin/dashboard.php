<?php
session_start();
include '../includes/config.php';

// Proteksi halaman - kalau belum login, balik ke login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil statistik
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM produk"))['total'];
$total_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) as total FROM produk"))['total'];
$produk_terlaris = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_kopi, terjual FROM produk ORDER BY terjual DESC LIMIT 1"));
$stok_tipis = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM produk WHERE stok < 5"))['total'];

// Tambahan: Ambil statistik pesanan (jika ada tabel pesanan)
$total_pesanan = @mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan"))['total'] ?? 0;
$pesanan_pending = @mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan WHERE status = 'pending'"))['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'admin-navbar.php'; ?>

<div class="container" style="padding-top: 40px;">

    <h1 style="color: var(--coklat-tua); margin-bottom: 30px;">
        👋 Halo, <?= $_SESSION['admin'] ?>!
    </h1>

    <!-- KARTU STATISTIK -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3><?= $total_produk ?></h3>
                <p>Total Produk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏪</div>
            <div class="stat-info">
                <h3><?= $total_stok ?? 0 ?></h3>
                <p>Total Stok</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div class="stat-info">
                <h3><?= $produk_terlaris ? $produk_terlaris['nama_kopi'] : '-' ?></h3>
                <p>Produk Terlaris</p>
            </div>
        </div>
        <div class="stat-card <?= $stok_tipis > 0 ? 'stat-warning' : '' ?>">
            <div class="stat-icon"><?= $stok_tipis > 0 ? '⚠️' : '✅' ?></div>
            <div class="stat-info">
                <h3><?= $stok_tipis ?></h3>
                <p>Stok Hampir Habis</p>
            </div>
        </div>

        <!-- TAMBAHAN: Kartu Statistik Pesanan -->
        <div class="stat-card <?= $pesanan_pending > 0 ? 'stat-warning' : '' ?>">
            <div class="stat-icon">📋</div>
            <div class="stat-info">
                <h3><?= $total_pesanan ?></h3>
                <p>Total Pesanan</p>
            </div>
        </div>
        <?php if ($pesanan_pending > 0): ?>
        <div class="stat-card stat-warning">
            <div class="stat-icon">⏳</div>
            <div class="stat-info">
                <h3><?= $pesanan_pending ?></h3>
                <p>Pesanan Pending</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- NOTIFIKASI STOK TIPIS -->
    <?php
    $query_tipis = "SELECT * FROM produk WHERE stok < 5 ORDER BY stok ASC";
    $result_tipis = mysqli_query($conn, $query_tipis);
    if (mysqli_num_rows($result_tipis) > 0):
    ?>
    <div class="alert alert-error" style="margin: 30px 0;">
        <strong>⚠️ Perhatian! Stok hampir habis:</strong>
        <ul style="margin-top: 10px; padding-left: 20px;">
            <?php while($p = mysqli_fetch_assoc($result_tipis)): ?>
                <li><?= $p['nama_kopi'] ?> — sisa <strong><?= $p['stok'] ?></strong> pcs</li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- NOTIFIKASI PESANAN PENDING -->
    <?php
    if ($pesanan_pending > 0):
        $query_pending = "SELECT * FROM pesanan WHERE status = 'pending' ORDER BY created_at ASC LIMIT 5";
        $result_pending = mysqli_query($conn, $query_pending);
    ?>
    <div class="alert alert-info" style="margin: 30px 0; background-color: #d1ecf1; border-color: #bee5eb; color: #0c5460;">
        <strong>📬 Ada <?= $pesanan_pending ?> pesanan pending:</strong>
        <ul style="margin-top: 10px; padding-left: 20px;">
            <?php while($psd = mysqli_fetch_assoc($result_pending)): ?>
                <li>
                    <strong><?= $psd['kode_pesanan'] ?></strong> dari 
                    <strong><?= $psd['nama_pelanggan'] ?></strong> 
                    - Rp<?= number_format($psd['total_harga'], 0, ',', '.') ?>
                </li>
            <?php endwhile; ?>
        </ul>
        <a href="daftar-pesanan.php" style="color: #0c5460; font-weight: bold; text-decoration: underline; margin-top: 10px; display: inline-block;">
            Lihat semua pesanan →
        </a>
    </div>
    <?php endif; ?>

    <!-- TABEL PRODUK -->
    <div class="table-wrapper">
        <div class="table-header">
            <h2>📋 Daftar Produk</h2>
            <a href="tambah-produk.php" class="btn-tambah">+ Tambah Produk</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Kopi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Terjual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY created_at DESC");
                if (mysqli_num_rows($result) > 0):
                    while ($p = mysqli_fetch_assoc($result)):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <?php if ($p['foto']): ?>
                            <img src="../assets/uploads/<?= $p['foto'] ?>" 
                                 class="foto-tabel">
                        <?php else: ?>
                            <div class="foto-tabel-placeholder">☕</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= $p['nama_kopi'] ?></strong></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge-stok <?= $p['stok'] < 5 ? 'badge-tipis' : '' ?>">
                            <?= $p['stok'] ?>
                        </span>
                    </td>
                    <td><?= $p['kategori'] ?? '-' ?></td>
                    <td><?= $p['terjual'] ?></td>
                    <td class="aksi-btn">
                        <a href="edit-produk.php?id=<?= $p['id'] ?>" class="btn-edit">Edit</a>
                        <a href="hapus-produk.php?id=<?= $p['id'] ?>" 
                           class="btn-hapus"
                           onclick="return confirm('Yakin hapus <?= $p['nama_kopi'] ?>?')">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="8" style="text-align:center; color: var(--abu); padding: 30px;">
                        Belum ada produk. <a href="tambah-produk.php">Tambah sekarang!</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>