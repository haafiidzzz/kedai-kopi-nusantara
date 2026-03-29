<?php
session_start();
include 'includes/config.php';
include 'includes/header.php';
?>
<style>
@media (max-width: 768px) {
    .produk-hero { padding: 60px 16px 40px !important; }
    .produk-hero h1 { font-size: 1.6rem !important; }
    .produk-hero p { font-size: 0.85rem !important; }
    .produk-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 16px !important; }
    .produk-section { padding: 40px 16px 60px !important; }
    .produk-nav-inner { justify-content: flex-start !important; }
}
@media (max-width: 480px) {
    .produk-grid { grid-template-columns: 1fr !important; }
    .produk-hero h1 { font-size: 1.3rem !important; }
    .produk-grid img, .produk-grid .ph-box { height: 180px !important; }
}
</style>
<?php
// Pagination
$page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset   = ($page - 1) * $per_page;

// Total produk
$count_result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM produk"));
$total_produk = $count_result['total'];
$total_pages  = ceil($total_produk / $per_page);

// Ambil semua produk
$query  = "SELECT * FROM produk ORDER BY kategori ASC, created_at DESC LIMIT $per_page OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<!-- ===== CATEGORY NAV BAR ===== -->
<div style="background: #1a1a1a; border-bottom: 1px solid #3a3a3a; position: sticky; top: 64px; z-index: 90;">
    <div class="produk-nav-inner" style="max-width: 1200px; margin: 0 auto; padding: 0 24px; display: flex; align-items: center; justify-content: center; gap: 0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <a href="#" style="padding: 16px 20px; text-decoration: none; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; white-space: nowrap; color: #c8956c; border-bottom: 2px solid #c8956c; font-family: 'DM Sans', sans-serif;">
            Menu Kami
        </a>
    </div>
</div>

<!-- ===== SINGLE PAGE CONTENT ===== -->
<section class="produk-section" style="background: #fafafa; padding: 80px 24px 100px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- ===== TITLE + DESCRIPTION ===== -->
        <div class="produk-hero" style="margin-bottom: 60px;">
            <h1 style="font-size: 2.2rem; font-weight: 300; color: #8a8a8a; letter-spacing: 0.02em; margin-bottom: 16px; line-height: 1.2;">
                MENU KEDAI KOPI NUSANTARA
            </h1>
            <div style="width: 50px; height: 4px; background: #c8956c; margin-bottom: 24px;"></div>
            <p style="color: #6b6b6b; font-size: 0.95rem; line-height: 1.9; text-align: justify;">
                Kedai Kopi Nusantara menyajikan berbagai pilihan kopi terbaik dari seluruh penjuru Indonesia. 
                Dengan pengalaman dan kecintaan kami terhadap dunia kopi, kami berkomitmen menghadirkan cita rasa autentik 
                dari biji-biji pilihan yang bersumber langsung dari petani lokal di berbagai daerah — mulai dari dataran 
                tinggi Gayo di Aceh, lereng Gunung Ijen di Jawa Timur, hingga kebun-kebun kopi di Toraja, Sulawesi Selatan.
                Setiap biji kopi yang kami sajikan telah melalui proses seleksi ketat dan di-roasting dengan penuh perhatian 
                untuk menghasilkan karakter rasa yang khas dan berkualitas tinggi.
            </p>
            
        </div>

        <!-- ===== PRODUCT GRID ===== -->
        <?php if (mysqli_num_rows($result) > 0): ?>

            <div class="produk-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; margin-bottom: 48px;">
                <?php while ($produk = mysqli_fetch_assoc($result)): ?>
                <div style="background: #fafafa; border: 1px solid #d4d4d4; overflow: hidden; transition: border-color 0.3s, transform 0.3s;"
                     onmouseover="this.style.borderColor='#c8956c'; this.style.transform='translateY(-4px)';"
                     onmouseout="this.style.borderColor='#d4d4d4'; this.style.transform='translateY(0)';">
                    
                    <?php if ($produk['foto']): ?>
                        <img src="assets/uploads/<?php echo htmlspecialchars($produk['foto']); ?>"
                             alt="<?php echo htmlspecialchars($produk['nama_kopi']); ?>"
                             style="width: 100%; height: 220px; object-fit: cover; display: block; filter: grayscale(15%); transition: filter 0.4s;"
                             onmouseover="this.style.filter='grayscale(0%)';"
                             onmouseout="this.style.filter='grayscale(15%)';">
                    <?php else: ?>
                        <div style="width: 100%; height: 220px; background: #e8e8e8; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #8a8a8a;">☕</div>
                    <?php endif; ?>

                    <div style="padding: 24px;">
                        <?php if ($produk['kategori']): ?>
                            <span style="display: inline-block; font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.08em; text-transform: uppercase; color: #c8956c; margin-bottom: 10px; border: 1px solid rgba(200,149,108,0.3); padding: 3px 10px;">
                                <?php echo htmlspecialchars($produk['kategori']); ?>
                            </span>
                        <?php endif; ?>

                        <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;"><?php echo htmlspecialchars($produk['nama_kopi']); ?></h3>
                        
                        <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; margin-bottom: 16px;"><?php echo htmlspecialchars(substr($produk['deskripsi'], 0, 80)); ?>...</p>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid #e8e8e8;">
                            <span style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #1a1a1a; font-size: 1rem;">
                                Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                            </span>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; font-weight: 600; padding: 4px 10px; <?php echo $produk['stok'] < 5 ? 'background: rgba(184,134,11,0.1); color: #b8860b;' : 'background: rgba(74,122,74,0.1); color: #4a7a4a;'; ?>">
                                Stok: <?php echo $produk['stok']; ?>
                            </span>
                        </div>

                        <?php if ($produk['stok'] > 0): ?>
                            <a href="keranjang.php?aksi=tambah&id=<?php echo $produk['id']; ?>"
                               style="display: block; width: 100%; margin-top: 16px; padding: 12px; background: #1a1a1a; color: #fafafa; border: 2px solid #1a1a1a; text-align: center; text-decoration: none; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase; transition: all 0.25s; font-family: 'DM Sans', sans-serif; box-sizing: border-box;"
                               onmouseover="this.style.background='transparent'; this.style.color='#1a1a1a';"
                               onmouseout="this.style.background='#1a1a1a'; this.style.color='#fafafa';">
                                Tambah ke Keranjang
                            </a>
                        <?php else: ?>
                            <button disabled style="display: block; width: 100%; margin-top: 16px; padding: 12px; background: #d4d4d4; color: #8a8a8a; border: 2px solid #d4d4d4; text-align: center; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase; cursor: not-allowed; font-family: 'DM Sans', sans-serif;">
                                Stok Habis
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <!-- ===== PAGINATION ===== -->
            <?php if ($total_pages > 1): ?>
                <div style="display: flex; justify-content: center; gap: 4px; flex-wrap: wrap;">

                    <?php if ($page > 1): ?>
                        <a href="produk.php?page=<?php echo $page - 1; ?>"
                           style="padding: 10px 18px; background: #1a1a1a; color: #fafafa; text-decoration: none; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.06em; text-transform: uppercase; border: 1px solid #1a1a1a;">
                            ← Prev
                        </a>
                    <?php endif; ?>

                    <?php
                    $start_page = max(1, $page - 2);
                    $end_page   = min($total_pages, $page + 2);

                    for ($i = $start_page; $i <= $end_page; $i++): ?>
                        <?php if ($i == $page): ?>
                            <span style="padding: 10px 16px; background: #1a1a1a; color: #fafafa; font-weight: 700; font-size: 0.82rem; border: 1px solid #1a1a1a; font-family: 'JetBrains Mono', monospace;"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="produk.php?page=<?php echo $i; ?>"
                               style="padding: 10px 16px; background: transparent; color: #3a3a3a; text-decoration: none; font-weight: 600; font-size: 0.82rem; border: 1px solid #d4d4d4; transition: border-color 0.2s; font-family: 'JetBrains Mono', monospace;"
                               onmouseover="this.style.borderColor='#c8956c'; this.style.color='#c8956c';"
                               onmouseout="this.style.borderColor='#d4d4d4'; this.style.color='#3a3a3a';">
                                <?php echo $i; ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="produk.php?page=<?php echo $page + 1; ?>"
                           style="padding: 10px 18px; background: #1a1a1a; color: #fafafa; text-decoration: none; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.06em; text-transform: uppercase; border: 1px solid #1a1a1a;">
                            Next →
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        <?php else: ?>
            <div style="text-align: center; padding: 80px 24px;">
                <div style="width: 72px; height: 72px; margin: 0 auto 20px; border: 2px solid #d4d4d4; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #8a8a8a;">?</div>
                <h3 style="color: #1a1a1a; margin-bottom: 10px; font-size: 1.1rem;">Produk Tidak Ditemukan</h3>
                <p style="color: #8a8a8a; margin-bottom: 28px; font-size: 0.92rem;">Belum ada produk yang tersedia.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include 'includes/footer.php'; ?>