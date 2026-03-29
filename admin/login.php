<?php
session_start();
include '../includes/config.php';

// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = bersihkan($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Kedai Kopi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">
        <div class="login-logo">☕</div>
        <h2>Admin Login</h2>
        <p>Kedai Kopi Nusantara</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" 
                       placeholder="Masukkan username"
                       required autocomplete="off">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" 
                       placeholder="Masukkan password"
                       required>
            </div>
            <button type="submit" class="btn-full">Masuk →</button>
        </form>

        <a href="../index.php" class="back-link">← Kembali ke Beranda</a>
    </div>
</div>

</body>
</html>