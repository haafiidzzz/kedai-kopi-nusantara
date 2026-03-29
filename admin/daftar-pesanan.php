<?php
session_start();
include '../includes/config.php';

// Cek apakah user sudah login sebagai admin
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Ambil parameter pencarian dan filter
$search = htmlspecialchars($_GET['search'] ?? '');
$status_filter = htmlspecialchars($_GET['status'] ?? '');
$page = intval($_GET['page'] ?? 1);
$limit = 10;
$offset = ($page - 1) * $limit;

// Proses jika ada request mark as selesai
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_selesai'])) {
    $pesanan_id = intval($_POST['pesanan_id']);
    $query_update = "UPDATE pesanan SET status = 'selesai' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query_update);
    mysqli_stmt_bind_param($stmt, 'i', $pesanan_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect untuk refresh
    header('Location: daftar-pesanan.php' . (!empty($search) ? '?search=' . urlencode($search) : '') . (!empty($status_filter) ? '&status=' . $status_filter : ''));
    exit;
}

// Build query dengan WHERE clause
$where_conditions = [];
if (!empty($search)) {
    $search_param = "%$search%";
    $where_conditions[] = "(kode_pesanan LIKE '$search_param' OR nama_pelanggan LIKE '$search_param' OR telepon LIKE '$search_param')";
}
if (!empty($status_filter)) {
    $where_conditions[] = "status = '$status_filter'";
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Ambil total pesanan untuk pagination
$query_total = "SELECT COUNT(*) as total FROM pesanan $where_clause";
$result_total = mysqli_query($conn, $query_total);
$total_pesanan = mysqli_fetch_assoc($result_total)['total'];
$total_pages = ceil($total_pesanan / $limit);

// Ambil data pesanan
$query = "SELECT * FROM pesanan $where_clause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Format untuk status badge
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

$status_label = [
    'pending' => 'Pending',
    'dikirim' => 'Dikirim',
    'selesai' => 'Selesai',
    'batal' => 'Batal'
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan - Admin Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin-pesanan-list.css">
</head>
<body>
    <?php include 'admin-navbar.php'; ?>

    <div class="admin-container">
        <!-- Statistik -->
        <div class="stats-section">
            <?php
            // Hitung statistik pesanan
            $stats = [];
            $query_stats = "SELECT status, COUNT(*) as jumlah FROM pesanan GROUP BY status";
            $result_stats = mysqli_query($conn, $query_stats);
            while ($row = mysqli_fetch_assoc($result_stats)) {
                $stats[$row['status']] = $row['jumlah'];
            }
            ?>
            <div class="stat-card">
                <p class="stat-label">Total Pesanan</p>
                <div class="stat-number"><?php echo $total_pesanan; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Pending</p>
                <div class="stat-number"><?php echo $stats['pending'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Dikirim</p>
                <div class="stat-number"><?php echo $stats['dikirim'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <p class="stat-label">Selesai</p>
                <div class="stat-number"><?php echo $stats['selesai'] ?? 0; ?></div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="search">Cari Pesanan:</label>
                        <input type="text" id="search" name="search" 
                               placeholder="Kode pesanan, nama, atau telepon" 
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="filter-group">
                        <label for="status">Filter Status:</label>
                        <select id="status" name="status">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="dikirim" <?php echo $status_filter === 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                            <option value="selesai" <?php echo $status_filter === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            <option value="batal" <?php echo $status_filter === 'batal' ? 'selected' : ''; ?>>Batal</option>
                        </select>
                    </div>
                    <div></div>
                    <button type="submit" class="btn-filter">🔍 Cari</button>
                    <a href="daftar-pesanan.php" class="btn-reset">Reset</a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Telepon</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pesanan = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($pesanan['kode_pesanan']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($pesanan['nama_pelanggan']); ?></td>
                                <td><?php echo htmlspecialchars($pesanan['telepon']); ?></td>
                                <td>
                                    <strong>Rp<?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?></strong>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo $pesanan['status']; ?>"
                                          style="background-color: <?php echo $status_colors[$pesanan['status']] ?? '#fff'; ?>; 
                                                  color: <?php echo $status_text_colors[$pesanan['status']] ?? '#000'; ?>">
                                        <?php echo $status_label[$pesanan['status']] ?? 'Unknown'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($pesanan['created_at'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Tombol Lihat -->
                                        <a href="lihat-pesanan.php?id=<?php echo $pesanan['id']; ?>" 
                                           class="btn-small btn-view">👁 Lihat</a>
                                        
                                        <!-- Tombol Selesai (jika status bukan selesai) -->
                                        <?php if ($pesanan['status'] !== 'selesai'): ?>
                                            <form method="POST" style="display: inline;">
                                                <input type="hidden" name="pesanan_id" value="<?php echo $pesanan['id']; ?>">
                                                <button type="submit" name="mark_selesai" class="btn-small btn-edit" 
                                                        style="background-color: #28a745;"
                                                        onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                                                    ✓ Selesai
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="btn-small" 
                                                  style="background-color: #d1e7dd; color: #0f5132; cursor: default;">
                                                ✓ Sudah Selesai
                                            </span>
                                        <?php endif; ?>
                                        
                                        <!-- Tombol Edit -->
                                        <a href="edit-pesanan.php?id=<?php echo $pesanan['id']; ?>" 
                                           class="btn-small btn-edit">✏️ Edit</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>">« First</a>
                            <a href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>">‹ Prev</a>
                        <?php else: ?>
                            <span class="disabled">« First</span>
                            <span class="disabled">‹ Prev</span>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $page - 2);
                        $end = min($total_pages, $page + 2);
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <?php if ($i === $page): ?>
                                <span class="active"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>">Next ›</a>
                            <a href="?page=<?php echo $total_pages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status_filter) ? '&status=' . $status_filter : ''; ?>">Last »</a>
                        <?php else: ?>
                            <span class="disabled">Next ›</span>
                            <span class="disabled">Last »</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-message">
                    <p>Tidak ada pesanan yang ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>