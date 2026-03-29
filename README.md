# ☕ Kedai Kopi Nusantara

> Website e-commerce kedai kopi dengan tema **Modern Industrial** — dibangun menggunakan PHP Native, MySQL, HTML/CSS/JS.

![Hero](screenshots/screenshot-hero.png)

---

## 📖 Tentang Project

**Kedai Kopi Nusantara** adalah website prototype untuk sebuah kedai kopi lokal yang menyajikan kopi terbaik dari seluruh penjuru Indonesia. Website ini dibangun sebagai project web development dengan fitur lengkap mulai dari katalog produk, keranjang belanja, checkout, pembayaran QRIS (prototype), reservasi kursi, hingga admin panel.

### Design Philosophy

Website ini menggunakan aesthetic **Modern Industrial** — clean lines, monochrome palette, sharp corners, dan tipografi bold. Terinspirasi dari desain industrial coffee shop dengan sentuhan digital yang modern.

- **Color Palette**: Monochrome (hitam, charcoal, abu-abu) + aksen copper `#c8956c`
- **Typography**: DM Sans (body), JetBrains Mono (angka/kode), Instrument Serif (headline italic)
- **Style**: Sharp corners, no border-radius, grayscale image effects, noise texture overlay

---

## 🖼️ Screenshots

### Homepage
![Homepage](screenshots/screenshot-hero.png)

### Our Menu
![Menu](screenshots/screenshot-menu.png)

### Admin Dashboard
![Dashboard](screenshots/screenshot-dashboard.png)

### Tambah Produk
![Tambah Produk](screenshots/screenshot-tambah-produk.png)

### Daftar Pesanan
![Daftar Pesanan](screenshots/screenshot-daftar-pesanan.png)

---

## ✨ Fitur

### 🛒 Customer Side
- **Homepage** — Hero section, cerita kami, kategori menu, lokasi cabang, reservasi, gallery
- **Menu Kopi** — Katalog produk dengan kategori tag, harga, stok, tombol keranjang
- **Keranjang Belanja** — Tambah/kurang/hapus item, ringkasan pesanan
- **Checkout** — Form data pengiriman dengan validasi
- **Pembayaran QRIS** — Halaman pembayaran prototype dengan QR code dummy & countdown timer
- **Reservasi Kursi** — Pilih nomor kursi yang tersedia, form booking
- **Halaman Kontak** — Info WhatsApp, email, alamat, jam operasional, social media, Google Maps
- **Responsive Design** — Hamburger menu di mobile, layout adaptive untuk semua ukuran layar

### 🔧 Admin Panel
- **Dashboard** — Statistik produk, stok, pesanan pending, notifikasi
- **CRUD Produk** — Tambah, edit, hapus produk dengan upload foto
- **Manajemen Pesanan** — Lihat detail, update status (pending → dikirim → selesai)
- **Manajemen Reservasi** — Terima/tolak reservasi dengan catatan

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP Native (MVC-like structure) |
| Database | MySQL |
| Frontend | HTML5, CSS3, JavaScript |
| Font | Google Fonts (DM Sans, JetBrains Mono, Instrument Serif) |
| Server | Apache (XAMPP) |

---

## 📁 Struktur Folder

```
kedai-kopi/
├── admin/
│   ├── admin-navbar.php
│   ├── dashboard.php
│   ├── tambah-produk.php
│   ├── edit-produk.php
│   ├── hapus-produk.php
│   ├── daftar-pesanan.php
│   ├── lihat-pesanan.php
│   ├── edit-pesanan.php
│   ├── daftar-reservasi.php
│   ├── login.php
│   └── logout.php
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── uploads/
├── includes/
│   ├── config.php (not tracked)
│   ├── header.php
│   └── footer.php
├── index.php
├── produk.php
├── keranjang.php
├── checkout.php
├── pembayaran.php
├── pesanan-berhasil.php
├── konfirmasi-pesanan.php
├── reservasi.php
├── kontak.php
├── .gitignore
└── README.md
```

---

## ⚙️ Instalasi & Setup

### Prasyarat
- [XAMPP](https://www.apachefriends.org/) (PHP 7.4+ & MySQL)
- Web browser modern

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/haafiidzzz/kedai-kopi-nusantara.git
   ```

2. **Pindahkan ke folder htdocs**
   ```bash
   cp -r kedai-kopi-nusantara C:/xampp/htdocs/kedai-kopi
   ```

3. **Buat file konfigurasi database**
   
   Buat file `includes/config.php`:
   ```php
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
   ```

4. **Buat database MySQL**
   
   Buka phpMyAdmin (`http://localhost/phpmyadmin`), buat database `kedai_kopi`, lalu jalankan SQL berikut:

   ```sql
   CREATE TABLE admin (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL,
       password VARCHAR(255) NOT NULL
   );

   CREATE TABLE produk (
       id INT AUTO_INCREMENT PRIMARY KEY,
       nama_kopi VARCHAR(100) NOT NULL,
       harga INT NOT NULL,
       stok INT NOT NULL DEFAULT 0,
       deskripsi TEXT,
       kategori VARCHAR(50),
       foto VARCHAR(255),
       terjual INT DEFAULT 0,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE pesanan (
       id INT AUTO_INCREMENT PRIMARY KEY,
       kode_pesanan VARCHAR(50) NOT NULL,
       nama_pelanggan VARCHAR(100) NOT NULL,
       telepon VARCHAR(20),
       email VARCHAR(100),
       alamat TEXT,
       catatan TEXT,
       total_harga INT NOT NULL,
       status ENUM('pending','dikirim','selesai','batal') DEFAULT 'pending',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE detail_pesanan (
       id INT AUTO_INCREMENT PRIMARY KEY,
       pesanan_id INT NOT NULL,
       produk_id INT NOT NULL,
       nama_kopi VARCHAR(100),
       harga INT,
       jumlah INT,
       subtotal INT
   );

   CREATE TABLE reservasi (
       id INT AUTO_INCREMENT PRIMARY KEY,
       kode_reservasi VARCHAR(50),
       nama_pelanggan VARCHAR(100) NOT NULL,
       telepon VARCHAR(20),
       email VARCHAR(100),
       tanggal DATE,
       jam TIME,
       jumlah_orang INT DEFAULT 1,
       nomor_kursi INT,
       status ENUM('pending','diterima','ditolak','selesai') DEFAULT 'pending',
       catatan TEXT,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   -- Insert admin default (password: admin123)
   INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
   ```

5. **Jalankan XAMPP** (Apache & MySQL), lalu buka `http://localhost/kedai-kopi`

6. **Login Admin**: `http://localhost/kedai-kopi/admin/login.php`
   - Username: `admin`
   - Password: `admin123`

---

## 📱 Responsive

Website fully responsive dengan:
- **Hamburger menu** di mobile (slide-in dari kanan)
- **Adaptive grid** — 4 kolom → 2 kolom → 1 kolom
- **Touch-friendly** — tombol dan interaksi dioptimalkan untuk layar sentuh

---

## 📝 Catatan

- Pembayaran QRIS bersifat **prototype** — QR code dummy, tidak terhubung ke payment gateway asli
- Gambar kategori menu diambil dari [Unsplash](https://unsplash.com) (free to use)
- File `includes/config.php` tidak di-track Git untuk keamanan

---

## 👤 Author

**haafiidzzz** — [GitHub](https://github.com/haafiidzzz)

---

<p align="center">
  <sub>Built with ☕ and love</sub>
</p>
