<?php
session_start();
include 'includes/config.php';

// Cek apakah ada data pembayaran
if (!isset($_SESSION['pembayaran'])) {
    header('Location: produk.php');
    exit;
}

$pembayaran = $_SESSION['pembayaran'];
$kode_pesanan = $pembayaran['kode_pesanan'];
$total_harga = $pembayaran['total_harga'];
$nama_pelanggan = $pembayaran['nama_pelanggan'];

// Proses konfirmasi pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['konfirmasi_bayar'])) {
    // Update status pesanan
    $query = "UPDATE pesanan SET status = 'pending' WHERE kode_pesanan = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $kode_pesanan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Hapus session pembayaran
    unset($_SESSION['pembayaran']);

    // Redirect ke pesanan berhasil
    header('Location: pesanan-berhasil.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - Kedai Kopi Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f2f1ef;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .payment-card {
            background: #fafafa;
            border: 1px solid #d4d4d4;
            max-width: 480px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .payment-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: #c8956c;
        }

        /* Header */
        .payment-header {
            padding: 32px 32px 24px;
            text-align: center;
            border-bottom: 1px solid #e8e8e8;
        }

        .payment-header .label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #c8956c;
            margin-bottom: 10px;
        }

        .payment-header h1 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .payment-header .subtitle {
            color: #8a8a8a;
            font-size: 0.82rem;
        }

        /* Order info */
        .order-info {
            padding: 20px 32px;
            background: #f2f1ef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e8e8e8;
        }

        .order-info .info-left .order-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #8a8a8a;
            margin-bottom: 2px;
        }

        .order-info .info-left .order-code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.78rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .order-info .info-right {
            text-align: right;
        }

        .order-info .info-right .total-label {
            font-size: 0.65rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #8a8a8a;
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 2px;
        }

        .order-info .info-right .total-amount {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        /* QR Section */
        .qr-section {
            padding: 32px;
            text-align: center;
        }

        .qr-wrapper {
            width: 220px;
            height: 220px;
            margin: 0 auto 20px;
            border: 2px solid #d4d4d4;
            padding: 12px;
            background: white;
            position: relative;
        }

        /* Generate a dummy QR pattern using CSS */
        .qr-pattern {
            width: 100%;
            height: 100%;
            position: relative;
            background:
                /* Corner squares */
                linear-gradient(#1a1a1a, #1a1a1a) 0 0 / 42px 42px no-repeat,
                linear-gradient(#fafafa, #fafafa) 6px 6px / 30px 30px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 12px 12px / 18px 18px no-repeat,

                linear-gradient(#1a1a1a, #1a1a1a) calc(100% - 0px) 0 / 42px 42px no-repeat,
                linear-gradient(#fafafa, #fafafa) calc(100% - 6px) 6px / 30px 30px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) calc(100% - 12px) 12px / 18px 18px no-repeat,

                linear-gradient(#1a1a1a, #1a1a1a) 0 calc(100% - 0px) / 42px 42px no-repeat,
                linear-gradient(#fafafa, #fafafa) 6px calc(100% - 6px) / 30px 30px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 12px calc(100% - 12px) / 18px 18px no-repeat,

                /* Random data blocks */
                linear-gradient(#1a1a1a, #1a1a1a) 50px 8px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 62px 8px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 74px 8px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 50px 20px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 68px 20px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 80px 14px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 56px 32px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 68px 32px / 6px 6px no-repeat,

                linear-gradient(#1a1a1a, #1a1a1a) 8px 50px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 20px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 32px 50px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 8px 62px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 26px 68px / 6px 6px no-repeat,

                /* Center blocks */
                linear-gradient(#1a1a1a, #1a1a1a) 56px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 68px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 80px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 92px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 62px 68px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 74px 68px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 86px 68px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 56px 80px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 68px 80px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 92px 80px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 80px 92px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 104px 68px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 116px 56px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 110px 80px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 122px 74px / 6px 6px no-repeat,

                /* More scattered */
                linear-gradient(#1a1a1a, #1a1a1a) 50px 98px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 62px 104px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 74px 98px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 98px 98px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 110px 104px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 122px 98px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 134px 92px / 6px 6px no-repeat,

                /* Bottom right area */
                linear-gradient(#1a1a1a, #1a1a1a) 98px 116px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 110px 122px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 122px 110px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 134px 116px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 140px 128px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 152px 110px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 158px 128px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 146px 140px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 164px 146px / 6px 6px no-repeat,
                linear-gradient(#1a1a1a, #1a1a1a) 170px 158px / 6px 6px no-repeat;
        }

        .qr-center-logo {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            background: #fafafa;
            border: 2px solid #d4d4d4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .qr-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            color: #8a8a8a;
            margin-bottom: 6px;
        }

        .qr-provider {
            font-weight: 700;
            font-size: 0.92rem;
            color: #1a1a1a;
            letter-spacing: 0.02em;
            margin-bottom: 24px;
        }

        /* Timer */
        .timer-section {
            padding: 20px 32px;
            background: #f2f1ef;
            border-top: 1px solid #e8e8e8;
            border-bottom: 1px solid #e8e8e8;
            text-align: center;
        }

        .timer-label {
            font-size: 0.72rem;
            color: #8a8a8a;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-family: 'JetBrains Mono', monospace;
            margin-bottom: 6px;
        }

        .timer-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: 0.05em;
        }

        .timer-value.warning {
            color: #b8860b;
        }

        .timer-value.danger {
            color: #c44;
        }

        /* Steps */
        .steps-section {
            padding: 24px 32px;
            border-bottom: 1px solid #e8e8e8;
        }

        .steps-title {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .step {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 14px;
        }

        .step:last-child { margin-bottom: 0; }

        .step-num {
            width: 24px;
            height: 24px;
            background: #1a1a1a;
            color: #fafafa;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.68rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 0.82rem;
            color: #6b6b6b;
            line-height: 1.5;
            padding-top: 2px;
        }

        /* Actions */
        .actions-section {
            padding: 24px 32px 32px;
        }

        .btn-confirm {
            width: 100%;
            padding: 14px;
            background: #1a1a1a;
            color: #fafafa;
            border: 2px solid #1a1a1a;
            font-weight: 700;
            font-size: 0.82rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.25s;
            font-family: 'DM Sans', sans-serif;
            margin-bottom: 12px;
        }

        .btn-confirm:hover {
            background: transparent;
            color: #1a1a1a;
        }

        .btn-cancel-link {
            display: block;
            text-align: center;
            color: #8a8a8a;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .btn-cancel-link:hover {
            color: #c44;
        }

        /* Prototype badge */
        .proto-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: rgba(200, 149, 108, 0.1);
            border: 1px solid rgba(200, 149, 108, 0.3);
            color: #c8956c;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.6rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 10px;
            font-weight: 600;
        }

        /* Mobile */
        @media (max-width: 480px) {
            body { padding: 16px; }
            .payment-header { padding: 28px 20px 20px; }
            .payment-header h1 { font-size: 1.1rem; }
            .order-info { padding: 16px 20px; flex-direction: column; gap: 12px; align-items: flex-start; }
            .order-info .info-right { text-align: left; }
            .qr-section { padding: 24px 20px; }
            .qr-wrapper { width: 180px; height: 180px; }
            .timer-section { padding: 16px 20px; }
            .steps-section { padding: 20px; }
            .actions-section { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="payment-card">
    <div class="proto-badge">Prototype</div>

    <!-- Header -->
    <div class="payment-header">
        <p class="label">Payment Gateway</p>
        <h1>Pembayaran QRIS</h1>
        <p class="subtitle">Scan QR code di bawah untuk menyelesaikan pembayaran</p>
    </div>

    <!-- Order Info -->
    <div class="order-info">
        <div class="info-left">
            <p class="order-label">Kode Pesanan</p>
            <p class="order-code"><?php echo htmlspecialchars($kode_pesanan); ?></p>
        </div>
        <div class="info-right">
            <p class="total-label">Total Bayar</p>
            <p class="total-amount">Rp <?php echo number_format($total_harga, 0, ',', '.'); ?></p>
        </div>
    </div>

    <!-- QR Code -->
    <div class="qr-section">
        <div class="qr-wrapper">
            <div class="qr-pattern">
                <div class="qr-center-logo">☕</div>
            </div>
        </div>
        <p class="qr-label">Powered by</p>
        <p class="qr-provider">QRIS — Kedai Kopi Nusantara</p>
    </div>

    <!-- Timer -->
    <div class="timer-section">
        <p class="timer-label">Selesaikan pembayaran dalam</p>
        <p class="timer-value" id="timer">15:00</p>
    </div>

    <!-- Steps -->
    <div class="steps-section">
        <p class="steps-title">Cara Pembayaran</p>
        <div class="step">
            <span class="step-num">1</span>
            <span class="step-text">Buka aplikasi e-wallet atau mobile banking Anda (GoPay, OVO, DANA, ShopeePay, dll)</span>
        </div>
        <div class="step">
            <span class="step-num">2</span>
            <span class="step-text">Pilih menu <strong>Scan QR</strong> atau <strong>Bayar dengan QRIS</strong></span>
        </div>
        <div class="step">
            <span class="step-num">3</span>
            <span class="step-text">Arahkan kamera ke QR code di atas dan konfirmasi pembayaran</span>
        </div>
        <div class="step">
            <span class="step-num">4</span>
            <span class="step-text">Klik tombol <strong>"Saya Sudah Bayar"</strong> di bawah setelah pembayaran berhasil</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <form method="POST">
            <button type="submit" name="konfirmasi_bayar" class="btn-confirm">
                Saya Sudah Bayar
            </button>
        </form>
        <a href="index.php" class="btn-cancel-link">Batalkan Pesanan</a>
    </div>
</div>

<!-- Timer Script -->
<script>
(function() {
    let timeLeft = 15 * 60; // 15 menit
    const timerEl = document.getElementById('timer');

    const interval = setInterval(() => {
        timeLeft--;
        const mins = Math.floor(timeLeft / 60).toString().padStart(2, '0');
        const secs = (timeLeft % 60).toString().padStart(2, '0');
        timerEl.textContent = mins + ':' + secs;

        // Warning at 5 min
        if (timeLeft <= 300 && timeLeft > 60) {
            timerEl.className = 'timer-value warning';
        }
        // Danger at 1 min
        if (timeLeft <= 60) {
            timerEl.className = 'timer-value danger';
        }

        if (timeLeft <= 0) {
            clearInterval(interval);
            timerEl.textContent = '00:00';
            timerEl.className = 'timer-value danger';
        }
    }, 1000);
})();
</script>

</body>
</html>