<?php
// Tentukan halaman aktif berdasarkan nama file
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar">
    <div class="nav-container">
        <a href="dashboard.php" class="nav-logo">☕ Admin Panel</a>
        <ul class="nav-menu">
            <li>
                <a href="dashboard.php" 
                   <?php echo in_array($current_page, ['dashboard.php']) ? 'class="aktif"' : ''; ?>>
                   Dashboard
                </a>
            </li>
            <li>
                <a href="tambah-produk.php"
                   <?php echo $current_page === 'tambah-produk.php' ? 'class="aktif"' : ''; ?>>
                   Tambah Produk
                </a>
            </li>
            <li>
                <a href="daftar-pesanan.php"
                   <?php echo in_array($current_page, ['daftar-pesanan.php', 'lihat-pesanan.php', 'edit-pesanan.php']) ? 'class="aktif"' : ''; ?>>
                   Daftar Pesanan
                </a>
            </li>
            <li>
                <a href="daftar-reservasi.php"
                   <?php echo $current_page === 'daftar-reservasi.php' ? 'class="aktif"' : ''; ?>>
                    Daftar Reservasi
                </a>
            </li>
            <li><a href="../index.php">Lihat Website</a></li>
            <li><a href="logout.php" class="btn-admin">Logout</a></li>
        </ul>
    </div>
</nav>