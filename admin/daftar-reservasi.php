<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../includes/config.php';

// Cek admin
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Proses terima/tolak/selesai reservasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = htmlspecialchars($_POST['action'] ?? '');
    $reservasi_id = intval($_POST['reservasi_id'] ?? 0);
    $catatan = htmlspecialchars($_POST['catatan'] ?? '');

    if ($reservasi_id > 0) {

        if ($action === 'terima') {

            // Update status menjadi diterima
            mysqli_query($conn, "
                UPDATE reservasi 
                SET status = 'diterima', catatan = '$catatan'
                WHERE id = $reservasi_id
            ");

        } elseif ($action === 'tolak') {

            // Update status menjadi ditolak
            mysqli_query($conn, "
                UPDATE reservasi 
                SET status = 'ditolak', catatan = '$catatan'
                WHERE id = $reservasi_id
            ");

        } elseif ($action === 'selesai') {

            // Update status menjadi selesai
            mysqli_query($conn, "
                UPDATE reservasi 
                SET status = 'selesai'
                WHERE id = $reservasi_id
            ");

        }
    }
}
// Ambil data reservasi
$status_filter = htmlspecialchars($_GET['status'] ?? '');
$where = "WHERE 1=1";
if (!empty($status_filter)) {
    $where = "WHERE status = '$status_filter'";
}

$query = "SELECT * FROM reservasi
          $where ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Hitung statistik
$stats = [];
$status_query = "SELECT status, COUNT(*) as jumlah FROM reservasi GROUP BY status";
$status_result = mysqli_query($conn, $status_query);
while ($row = mysqli_fetch_assoc($status_result)) {
    $stats[$row['status']] = $row['jumlah'];
}
$total_reservasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM reservasi"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin-pesanan-list.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 25px;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <?php include 'admin-navbar.php'; ?>

    <div class="admin-container">
        <!-- Statistik -->
        <div class="stats-section">
            <div class="stat-card">
                <p class="stat-label">Total Reservasi</p>
                <div class="stat-number"><?php echo $total_reservasi; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Pending</p>
                <div class="stat-number"><?php echo $stats['pending'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Diterima</p>
                <div class="stat-number"><?php echo $stats['diterima'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Selesai</p>
                <div class="stat-number"><?php echo $stats['selesai'] ?? 0; ?></div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter-section">
            <form method="GET" action="">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Filter Status:</label>
                        <select name="status">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="diterima" <?php echo $status_filter === 'diterima' ? 'selected' : ''; ?>>Diterima</option>
                            <option value="ditolak" <?php echo $status_filter === 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                            <option value="selesai" <?php echo $status_filter === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                    </div>
                    <div></div>
                    <button type="submit" class="btn-filter">🔍 Filter</button>
                    <a href="daftar-reservasi.php" class="btn-reset">Reset</a>
                </div>
            </form>
        </div>

        <!-- Tabel Reservasi -->
        <div class="table-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Tamu</th>
                            <th>Email</th>
                            <th>Kursi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($reservasi = mysqli_fetch_assoc($result)): 
                            $status_badge = '';
                            if ($reservasi['status'] === 'pending') {
                                $status_badge = '<span class="status-badge status-pending" style="background-color: #fff3cd; color: #856404;">PENDING</span>';
                            } elseif ($reservasi['status'] === 'diterima') {
                                $status_badge = '<span class="status-badge status-dikirim" style="background-color: #cfe2ff; color: #084298;">DITERIMA</span>';
                            } elseif ($reservasi['status'] === 'ditolak') {
                                $status_badge = '<span class="status-badge status-batal" style="background-color: #f8d7da; color: #842029;">DITOLAK</span>';
                            } else {
                                $status_badge = '<span class="status-badge status-selesai" style="background-color: #d1e7dd; color: #0f5132;">SELESAI</span>';
                            }
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><strong><?php echo htmlspecialchars($reservasi['nama_pelanggan']); ?></strong></td>
                                <td><?php echo htmlspecialchars($reservasi['email']); ?></td>
                                <td style="text-align: center; font-weight: bold; color: #8B4513;">
                                    🪑 <?php echo $reservasi['nomor_kursi'] ?? '-'; ?>
                                </td>
                                <td><?php echo $status_badge; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($reservasi['created_at'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if ($reservasi['status'] === 'pending'): ?>
                                            <button onclick="openModal('terima', <?php echo $reservasi['id']; ?>)" 
                                                    class="btn-small btn-view">✓ Terima</button>
                                            <button onclick="openModal('tolak', <?php echo $reservasi['id']; ?>)" 
                                                    class="btn-small btn-edit" style="background-color: #dc3545;">✗ Tolak</button>
                                        <?php elseif ($reservasi['status'] === 'diterima'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="action" value="selesai">
                                                <input type="hidden" name="reservasi_id" value="<?php echo $reservasi['id']; ?>">
                                                <button type="submit" class="btn-small btn-view" 
                                                        onclick="return confirm('Tandai reservasi sebagai selesai?')">
                                                    ✓ Selesai
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span style="color: #999;">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-message">
                    <p>Tidak ada data reservasi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal untuk Terima/Tolak -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle" style="color: #333; margin-bottom: 20px;"></h2>
            
            <form method="POST" id="modalForm">
                <input type="hidden" id="action" name="action">
                <input type="hidden" id="reservasi_id" name="reservasi_id">
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">
                        Catatan (Opsional)
                    </label>
                    <textarea name="catatan" rows="4" 
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"
                              placeholder="Masukkan catatan untuk tamu..."></textarea>
                </div>

                <button type="submit" id="submitBtn" 
                        style="width: 100%; padding: 12px; border: none; border-radius: 5px; 
                               font-weight: bold; cursor: pointer; color: white;">
                    Konfirmasi
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal(action, reservasi_id) {
            const modal = document.getElementById('modal');
            const modalTitle = document.getElementById('modalTitle');
            const actionInput = document.getElementById('action');
            const reservasiInput = document.getElementById('reservasi_id');
            const submitBtn = document.getElementById('submitBtn');

            actionInput.value = action;
            reservasiInput.value = reservasi_id;

            if (action === 'terima') {
                modalTitle.textContent = '✓ Terima Reservasi';
                submitBtn.style.backgroundColor = '#28a745';
                submitBtn.textContent = 'Terima Reservasi';
            } else {
                modalTitle.textContent = '✗ Tolak Reservasi';
                submitBtn.style.backgroundColor = '#dc3545';
                submitBtn.textContent = 'Tolak Reservasi';
            }

            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
            document.getElementById('modalForm').reset();
        }

        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>