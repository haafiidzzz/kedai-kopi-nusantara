<?php
// ⭐ PENTING: Ini harus di paling atas!
session_start();
include 'includes/config.php';

// Inisialisasi keranjang kalau belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// TAMBAH ke keranjang
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {
    $id    = (int)$_GET['id'];
    $produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id AND stok > 0"));

    if ($produk) {
        if (isset($_SESSION['keranjang'][$id])) {
            // Kalau sudah ada, tambah jumlahnya
            $jumlah_baru = $_SESSION['keranjang'][$id]['jumlah'] + 1;
            // Jangan melebihi stok
            if ($jumlah_baru <= $produk['stok']) {
                $_SESSION['keranjang'][$id]['jumlah'] = $jumlah_baru;
            }
        } else {
            // Kalau belum ada, tambah baru
            $_SESSION['keranjang'][$id] = [
                'id'        => $produk['id'],
                'nama'      => $produk['nama_kopi'],
                'harga'     => $produk['harga'],
                'foto'      => $produk['foto'],
                'jumlah'    => 1,
                'stok'      => $produk['stok']
            ];
        }
    }
    header('Location: keranjang.php');
    exit;
}

// KURANGI jumlah
if (isset($_GET['aksi']) && $_GET['aksi'] == 'kurang') {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]['jumlah']--;
        if ($_SESSION['keranjang'][$id]['jumlah'] <= 0) {
            unset($_SESSION['keranjang'][$id]);
        }
    }
    header('Location: keranjang.php');
    exit;
}

// HAPUS item
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = (int)$_GET['id'];
    unset($_SESSION['keranjang'][$id]);
    header('Location: keranjang.php');
    exit;
}

// Hitung total
$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}
?>
<?php include 'includes/header.php'; ?>

<div class="container" style="padding-top: 40px; padding-bottom: 60px;">
    <h1 style="color: var(--coklat-tua); margin-bottom: 30px;">🛒 Keranjang Belanja</h1>

    <?php if (empty($_SESSION['keranjang'])): ?>
        <div style="text-align:center; padding: 80px 20px;">
            <div style="font-size: 4rem;">🛒</div>
            <h3 style="color: var(--coklat-tua); margin: 15px 0 10px;">Keranjang masih kosong</h3>
            <p style="color: var(--abu);">Yuk pilih kopi favoritmu!</p>
            <a href="produk.php" class="btn-hero" style="margin-top: 20px; display:inline-block;">
                Lihat Menu Kopi ☕
            </a>
        </div>

    <?php else: ?>
        <div class="keranjang-wrapper">

            <!-- DAFTAR ITEM -->
            <div class="keranjang-items">
                <?php foreach ($_SESSION['keranjang'] as $id => $item): ?>
                <div class="keranjang-item">
                    <?php if ($item['foto']): ?>
                        <img src="assets/uploads/<?php echo htmlspecialchars($item['foto']); ?>" 
                             alt="<?php echo htmlspecialchars($item['nama']); ?>">
                    <?php else: ?>
                        <div class="foto-placeholder-sm">☕</div>
                    <?php endif; ?>

                    <div class="item-info">
                        <h3><?php echo htmlspecialchars($item['nama']); ?></h3>
                        <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?> / item</p>
                    </div>

                    <div class="item-qty">
                        <a href="keranjang.php?aksi=kurang&id=<?php echo $id; ?>" 
                           class="qty-btn">−</a>
                        <span><?php echo $item['jumlah']; ?></span>
                        <a href="keranjang.php?aksi=tambah&id=<?php echo $id; ?>" 
                           class="qty-btn">+</a>
                    </div>

                    <div class="item-subtotal">
                        Rp <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?>
                    </div>

                    <a href="keranjang.php?aksi=hapus&id=<?php echo $id; ?>" 
                       class="item-hapus"
                       onclick="return confirm('Hapus item ini?')">✕</a>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- RINGKASAN -->
            <div class="keranjang-summary">
                <h3>📋 Ringkasan Pesanan</h3>
                <div class="summary-list">
                    <?php foreach ($_SESSION['keranjang'] as $item): ?>
                    <div class="summary-item">
                        <span><?php echo htmlspecialchars($item['nama']); ?> x<?php echo $item['jumlah']; ?></span>
                        <span>Rp <?php echo number_format($item['harga'] * $item['jumlah'], 0, ',', '.'); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>
                <a href="checkout.php" class="btn-full" style="display:block; text-align:center; text-decoration:none; margin-top:20px;">
                    🛒 Lanjut Checkout →
                </a>
                <a href="produk.php" class="back-link">← Tambah produk lagi</a>
            </div>

        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>