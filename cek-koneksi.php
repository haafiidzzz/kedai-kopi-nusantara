<?php
include 'includes/config.php';

if ($conn) {
    echo "✅ Koneksi database berhasil!";
} else {
    echo "❌ Koneksi gagal!";
}
?>