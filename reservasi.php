<?php
include 'includes/config.php';
include 'includes/header.php';
?>
<style>
@media (max-width: 768px) {
    .reservasi-container { padding-left: 16px !important; padding-right: 16px !important; }
    .reservasi-form-card { padding: 24px 20px !important; }
    .kursi-grid { grid-template-columns: repeat(5, 1fr) !important; gap: 8px !important; }
    .kursi-grid .kursi-box { width: 44px !important; height: 44px !important; font-size: 0.85rem !important; }
    .reservasi-legend { flex-direction: column !important; gap: 10px !important; }
}
@media (max-width: 380px) {
    .kursi-grid { grid-template-columns: repeat(4, 1fr) !important; }
}
</style>
<?php
$error = '';
$success = '';
$nama_pelanggan = '';
$email = '';
$nomor_kursi = 0;

// Ambil kursi yang sedang AKTIF dipesan (status pending atau diterima)
// Langsung dari tabel reservasi, tidak bergantung tabel kursi
$kursi_terpesan = [];
$query_terpesan = "SELECT nomor_kursi FROM reservasi WHERE status IN ('pending', 'diterima')";
$result_terpesan = mysqli_query($conn, $query_terpesan);
if ($result_terpesan) {
    while ($row = mysqli_fetch_assoc($result_terpesan)) {
        $kursi_terpesan[] = $row['nomor_kursi'];
    }
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = htmlspecialchars(trim($_POST['nama_pelanggan'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $nomor_kursi = intval($_POST['nomor_kursi'] ?? 0);

    // Validasi
    if (empty($nama_pelanggan)) {
        $error = 'Nama pelanggan harus diisi!';
    } elseif (strlen($nama_pelanggan) < 3) {
        $error = 'Nama pelanggan minimal 3 karakter!';
    } elseif (empty($email)) {
        $error = 'Email harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } elseif ($nomor_kursi < 1 || $nomor_kursi > 10) {
        $error = 'Pilih nomor kursi yang valid!';
    } elseif (in_array($nomor_kursi, $kursi_terpesan)) {
        $error = 'Kursi nomor ' . $nomor_kursi . ' sudah dipesan orang lain!';
    } else {
        // Generate kode reservasi unik
        $kode_reservasi = 'RES-' . date('YmdHis') . '-' . strtoupper(substr(md5(rand()), 0, 4));
        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
        $jumlah_orang = 1;

        $stmt = mysqli_prepare($conn, "INSERT INTO reservasi 
            (kode_reservasi, nama_pelanggan, telepon, email, tanggal, jam, jumlah_orang, nomor_kursi, status) 
            VALUES (?, ?, '', ?, ?, ?, ?, ?, 'pending')");
        
        mysqli_stmt_bind_param($stmt, 'sssssii', 
            $kode_reservasi, 
            $nama_pelanggan, 
            $email, 
            $tanggal, 
            $jam, 
            $jumlah_orang, 
            $nomor_kursi
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = 'Reservasi berhasil dibuat! Silakan tunggu konfirmasi dari admin.';
            // Refresh daftar kursi terpesan
            $kursi_terpesan[] = $nomor_kursi;
            // Clear form
            $nama_pelanggan = '';
            $email = '';
            $nomor_kursi = 0;
        } else {
            $error = 'Gagal membuat reservasi: ' . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<div class="container reservasi-container" style="padding-top: 0; padding-bottom: 80px; max-width: 860px;">

    <!-- Page Header -->
    <div style="text-align: center; padding: 60px 0 48px;">
        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 12px;">Booking</p>
        <h1 style="font-size: 2.2rem; font-weight: 700; color: #1a1a1a; letter-spacing: -0.02em; margin-bottom: 16px;">Reservasi Kursi</h1>
        <div style="width: 60px; height: 3px; background: #c8956c; margin: 0 auto;"></div>
    </div>

    <?php if (!empty($error)): ?>
        <div style="background: rgba(204,68,68,0.06); color: #c44; padding: 14px 16px; margin-bottom: 20px; border-left: 4px solid #c44; font-size: 0.88rem;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="background: rgba(74,122,74,0.06); color: #4a7a4a; padding: 14px 16px; margin-bottom: 20px; border-left: 4px solid #4a7a4a; font-size: 0.88rem;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="reservasi-form-card" style="background: #fafafa; border: 1px solid #d4d4d4; padding: 40px; margin-bottom: 24px; position: relative;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #c8956c;"></div>

        <h2 style="font-size: 0.85rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: #1a1a1a; border-bottom: 2px solid #1a1a1a; padding-bottom: 12px; margin-bottom: 28px;">Form Reservasi</h2>

        <form method="POST" action="">

            <!-- Nama -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a1a1a; font-size: 0.82rem; letter-spacing: 0.04em; text-transform: uppercase;">
                    Nama Pelanggan <span style="color: #c8956c;">*</span>
                </label>
                <input type="text" name="nama_pelanggan"
                       value="<?php echo htmlspecialchars($nama_pelanggan); ?>"
                       placeholder="Masukkan nama lengkap"
                       style="width: 100%; padding: 12px 14px; border: 1px solid #d4d4d4; font-size: 0.92rem; font-family: 'DM Sans', sans-serif; box-sizing: border-box; background: #fafafa; color: #2a2a2a; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#c8956c'; this.style.boxShadow='0 0 0 3px rgba(200,149,108,0.15)';"
                       onblur="this.style.borderColor='#d4d4d4'; this.style.boxShadow='none';"
                       required>
            </div>

            <!-- Email -->
            <div style="margin-bottom: 28px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #1a1a1a; font-size: 0.82rem; letter-spacing: 0.04em; text-transform: uppercase;">
                    Email <span style="color: #c8956c;">*</span>
                </label>
                <input type="email" name="email"
                       value="<?php echo htmlspecialchars($email); ?>"
                       placeholder="Masukkan email"
                       style="width: 100%; padding: 12px 14px; border: 1px solid #d4d4d4; font-size: 0.92rem; font-family: 'DM Sans', sans-serif; box-sizing: border-box; background: #fafafa; color: #2a2a2a; transition: border-color 0.2s;"
                       onfocus="this.style.borderColor='#c8956c'; this.style.boxShadow='0 0 0 3px rgba(200,149,108,0.15)';"
                       onblur="this.style.borderColor='#d4d4d4'; this.style.boxShadow='none';"
                       required>
            </div>

            <!-- Pilih Kursi -->
            <div style="margin-bottom: 28px;">
                <label style="display: block; margin-bottom: 16px; font-weight: 600; color: #1a1a1a; font-size: 0.82rem; letter-spacing: 0.04em; text-transform: uppercase;">
                    Pilih Nomor Kursi <span style="color: #c8956c;">*</span>
                </label>

                <div class="kursi-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 20px;">
                    <?php for ($i = 1; $i <= 10; $i++):
                        $is_terpesan = in_array($i, $kursi_terpesan);
                    ?>
                        <label style="display: flex; flex-direction: column; align-items: center; gap: 8px; cursor: <?php echo $is_terpesan ? 'not-allowed' : 'pointer'; ?>; opacity: <?php echo $is_terpesan ? '0.4' : '1'; ?>;">
                            <input type="radio" name="nomor_kursi" value="<?php echo $i; ?>"
                                   <?php echo $is_terpesan ? 'disabled' : ''; ?>
                                   <?php echo ($nomor_kursi == $i) ? 'checked' : ''; ?>
                                   style="display: none;"
                                   onchange="document.querySelectorAll('.kursi-box').forEach(b => { b.style.background='#fafafa'; b.style.borderColor='#d4d4d4'; b.style.color='#1a1a1a'; }); this.parentElement.querySelector('.kursi-box').style.background='#1a1a1a'; this.parentElement.querySelector('.kursi-box').style.borderColor='#1a1a1a'; this.parentElement.querySelector('.kursi-box').style.color='#fafafa';">
                            <div class="kursi-box" style="width: 56px; height: 56px; border: 2px solid <?php echo $is_terpesan ? '#e8e8e8' : '#d4d4d4'; ?>;
                                        background: <?php echo $is_terpesan ? '#f2f1ef' : '#fafafa'; ?>; font-weight: 700;
                                        color: <?php echo $is_terpesan ? '#b0b0b0' : '#1a1a1a'; ?>; font-size: 1rem;
                                        display: flex; align-items: center; justify-content: center;
                                        font-family: 'JetBrains Mono', monospace; transition: all 0.2s;">
                                <?php echo $i; ?>
                            </div>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; letter-spacing: 0.06em; text-transform: uppercase; font-weight: 600; color: <?php echo $is_terpesan ? '#b0b0b0' : '#4a7a4a'; ?>;">
                                <?php echo $is_terpesan ? 'Dipesan' : 'Tersedia'; ?>
                            </span>
                        </label>
                    <?php endfor; ?>
                </div>

                <!-- Legend -->
                <div class="reservasi-legend" style="display: flex; gap: 24px; padding: 14px 16px; background: #f2f1ef; border: 1px solid #e8e8e8; font-size: 0.78rem; color: #6b6b6b;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-block; width: 14px; height: 14px; border: 2px solid #1a1a1a;"></span>
                        <span><strong style="color: #1a1a1a;">Tersedia</strong></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-block; width: 14px; height: 14px; background: #e8e8e8; border: 2px solid #e8e8e8;"></span>
                        <span><strong style="color: #b0b0b0;">Dipesan</strong></span>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                    style="width: 100%; padding: 14px; background: #1a1a1a; color: #fafafa; border: 2px solid #1a1a1a;
                           font-weight: 700; font-size: 0.82rem; letter-spacing: 0.1em; text-transform: uppercase;
                           cursor: pointer; transition: all 0.25s; font-family: 'DM Sans', sans-serif; margin-top: 8px;"
                    onmouseover="this.style.background='transparent'; this.style.color='#1a1a1a';"
                    onmouseout="this.style.background='#1a1a1a'; this.style.color='#fafafa';">
                Buat Reservasi
            </button>
        </form>
    </div>

    <!-- Info Box -->
    <div style="background: #f2f1ef; border: 1px solid #e8e8e8; border-left: 4px solid #c8956c; padding: 24px; color: #6b6b6b; font-size: 0.85rem; line-height: 1.7;">
        <h3 style="margin-top: 0; margin-bottom: 12px; color: #1a1a1a; font-size: 0.82rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;">Informasi Penting</h3>
        <ul style="margin: 0; padding-left: 20px;">
            <li style="margin-bottom: 6px;">Reservasi akan dikonfirmasi oleh admin melalui email</li>
            <li style="margin-bottom: 6px;">Kursi akan dipesan selama 24 jam, jika tidak dikonfirmasi akan dibuka kembali</li>
            <li style="margin-bottom: 6px;">Silakan datang 15 menit sebelum waktu yang dijanjikan</li>
            <li>Hubungi kami jika ada perubahan jadwal</li>
        </ul>
    </div>

</div>

<?php include 'includes/footer.php'; ?>