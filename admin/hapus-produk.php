<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$id = (int)$_GET['id'];

// Ambil data produk dulu (untuk hapus foto)
$produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id = $id"));

if ($produk) {
    // Hapus file foto kalau ada
    if ($produk['foto'] && file_exists('../assets/uploads/' . $produk['foto'])) {
        unlink('../assets/uploads/' . $produk['foto']);
    }
    // Hapus dari database
    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");
}

header('Location: dashboard.php');
exit;
?>