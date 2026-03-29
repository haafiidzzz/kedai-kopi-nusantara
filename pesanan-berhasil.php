<!DOCTYPE html>
<html>
<head>
<title>Pesanan Berhasil</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<style>
body{
    font-family:'DM Sans', sans-serif;
    background:#f2f1ef;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin: 0;
}

.box{
    background:#fafafa;
    padding:48px 40px;
    text-align:center;
    border: 1px solid #d4d4d4;
    position: relative;
    max-width: 440px;
    width: 90%;
}

.box::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: #c8956c;
}

.box h2 {
    font-size: 1.3rem;
    color: #1a1a1a;
    letter-spacing: -0.02em;
    margin-bottom: 12px;
}

.box p {
    color: #6b6b6b;
    font-size: 0.92rem;
}

.check-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 20px;
    background: rgba(74, 122, 74, 0.08);
    border: 2px solid #4a7a4a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #4a7a4a;
}

.btn{
    display:inline-block;
    margin-top:24px;
    padding:14px 32px;
    background:#1a1a1a;
    color:#fafafa;
    text-decoration:none;
    font-weight:700;
    font-size: 0.82rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 2px solid #1a1a1a;
    transition: all 0.25s;
    font-family: 'DM Sans', sans-serif;
}

.btn:hover {
    background: transparent;
    color: #1a1a1a;
}
</style>
</head>

<body>
<div class="box">
    <div class="check-icon">&#10003;</div>
    <h2>Pesanan Berhasil Dibuat</h2>
    <p>Pesanan telah dipesan, mohon ditunggu.</p>
    <a href="index.php" class="btn">Kembali ke Menu Utama</a>
</div>
</body>
</html>