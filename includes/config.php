<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '/kedai-kopi');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kedai_kopi');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

function bersihkan($conn, $data) {
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}
?>