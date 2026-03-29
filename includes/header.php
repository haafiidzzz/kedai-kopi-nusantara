<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$halaman_aktif = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>☕ Kedai Kopi Nusantara</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        /* ===== HAMBURGER BUTTON ===== */
        .nav-hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            z-index: 200;
        }

        .nav-hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: #fafafa;
            margin: 5px 0;
            transition: transform 0.3s, opacity 0.3s;
        }

        /* Hamburger X animation */
        .nav-hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .nav-hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .nav-hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        /* ===== MOBILE OVERLAY ===== */
        .nav-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 90;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .nav-overlay.active {
            opacity: 1;
        }

        /* ===== MOBILE STYLES ===== */
        @media (max-width: 768px) {
            .nav-hamburger {
                display: block;
            }

            .nav-container {
                flex-direction: row !important;
                height: 60px !important;
                padding: 0 20px !important;
                gap: 0 !important;
            }

            .nav-menu {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                background: #0a0a0a;
                flex-direction: column;
                align-items: stretch !important;
                justify-content: flex-start !important;
                padding: 80px 0 40px;
                z-index: 100;
                transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
                overflow-y: auto;
                flex-wrap: nowrap !important;
                gap: 0 !important;
            }

            .nav-menu.active {
                right: 0;
            }

            .nav-menu li {
                height: auto !important;
                display: block !important;
                border-bottom: 1px solid #1a1a1a;
            }

            .nav-menu a {
                display: block !important;
                padding: 16px 28px !important;
                height: auto !important;
                border-bottom: none !important;
                font-size: 0.82rem !important;
                letter-spacing: 0.08em !important;
                color: #b0b0b0 !important;
                transition: background 0.2s, color 0.2s !important;
            }

            .nav-menu a:hover {
                background: rgba(200, 149, 108, 0.08) !important;
                color: #fafafa !important;
            }

            .nav-menu a.aktif {
                color: #c8956c !important;
                background: rgba(200, 149, 108, 0.05) !important;
                border-left: 3px solid #c8956c !important;
            }

            .nav-overlay {
                display: block;
                pointer-events: none;
            }

            .nav-overlay.active {
                pointer-events: auto;
            }

            /* Mobile menu label */
            .nav-mobile-label {
                display: block !important;
                padding: 20px 28px 12px;
                font-family: 'JetBrains Mono', monospace;
                font-size: 0.65rem;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                color: #c8956c;
            }
        }

        @media (min-width: 769px) {
            .nav-mobile-label {
                display: none !important;
            }

            .nav-overlay {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- Mobile Overlay -->
<div class="nav-overlay" id="navOverlay" onclick="toggleMenu()"></div>

<nav class="navbar">
    <div class="nav-container">
        <a href="<?= BASE_URL ?>/index.php" class="nav-logo">
            Kedai Kopi Nusantara
        </a>

        <!-- Hamburger Button -->
        <button class="nav-hamburger" id="navHamburger" onclick="toggleMenu()" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <ul class="nav-menu" id="navMenu">
            <li class="nav-mobile-label">Menu</li>
            <li>
                <a href="<?= BASE_URL ?>/index.php"
                   class="<?= $halaman_aktif == 'index.php' ? 'aktif' : '' ?>">
                   Home
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/produk.php"
                   class="<?= $halaman_aktif == 'produk.php' ? 'aktif' : '' ?>">
                   Menu Kopi
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/reservasi.php"
                   class="<?= $halaman_aktif == 'reservasi.php' ? 'aktif' : '' ?>">
                   Reservasi
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/kontak.php"
                   class="<?= $halaman_aktif == 'kontak.php' ? 'aktif' : '' ?>">
                   Kontak
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
function toggleMenu() {
    const menu = document.getElementById('navMenu');
    const hamburger = document.getElementById('navHamburger');
    const overlay = document.getElementById('navOverlay');

    menu.classList.toggle('active');
    hamburger.classList.toggle('active');
    overlay.classList.toggle('active');

    // Prevent body scroll when menu is open
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}

// Close menu when clicking a link (mobile)
document.querySelectorAll('.nav-menu a').forEach(link => {
    link.addEventListener('click', () => {
        const menu = document.getElementById('navMenu');
        if (menu.classList.contains('active')) {
            toggleMenu();
        }
    });
});

// Close menu on resize to desktop
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        const menu = document.getElementById('navMenu');
        const hamburger = document.getElementById('navHamburger');
        const overlay = document.getElementById('navOverlay');
        menu.classList.remove('active');
        hamburger.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
});
</script>