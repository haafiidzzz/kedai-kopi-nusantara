<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Mobile Responsive Overrides -->
<style>
@media (max-width: 768px) {
    .cerita-grid { grid-template-columns: 1fr !important; gap: 40px !important; }
    .cerita-img { order: -1; }
    .cerita-img img { height: 300px !important; }
    .cerita-deco { display: none !important; }
    .menu-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 16px !important; }
    .cabang-grid { grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
    .gallery-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 10px !important; }
    .reservasi-section { padding: 60px 16px !important; }
    .reservasi-section h2 { font-size: 1.5rem !important; }
}
@media (max-width: 480px) {
    .cerita-section { padding: 60px 16px !important; }
    .cerita-grid { gap: 30px !important; }
    .cerita-img img { height: 240px !important; }
    .cerita-text h2 { font-size: 2rem !important; }
    .cerita-text p { font-size: 0.85rem !important; }
    .cerita-btns { flex-direction: column !important; }
    .cerita-btns a { text-align: center !important; }
    .menu-grid { grid-template-columns: 1fr !important; }
    .menu-section { padding: 60px 16px !important; }
    .menu-section h1 { font-size: 1.6rem !important; }
    .menu-cat-title { font-size: 0.75rem !important; }
    .cabang-grid { grid-template-columns: 1fr !important; }
    .cabang-section { padding: 60px 16px !important; }
    .cabang-section h2 { font-size: 1.5rem !important; }
    .gallery-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .gallery-section { padding: 60px 16px !important; }
    .gallery-section h2 { font-size: 1.6rem !important; }
    .reservasi-section { padding: 48px 16px !important; }
    .reservasi-section h2 { font-size: 1.3rem !important; }
}
</style>

<!-- ===== HERO SECTION ===== -->
<section class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di<br><span>Kedai Kopi Nusantara</span></h1>
        <p>Nikmati cita rasa kopi terbaik dari seluruh penjuru Nusantara.<br>
           Dipilih dengan teliti, diseduh dengan penuh cinta.</p>
        <a href="produk.php" class="btn-hero">Lihat Menu Kami ☕</a>
    </div>
</section>

<!-- ===== CERITA KAMI ===== -->
<section class="cerita-section" style="background: #f2f1ef; padding: 100px 24px; border-bottom: 1px solid #e8e8e8;">
    <div class="container" style="padding: 0;">
        <div class="cerita-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">

            <!-- Left: Text -->
            <div class="cerita-text">
                <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 16px;">Tentang Kami</p>
                <h2 style="font-size: 2.6rem; font-weight: 400; color: #1a1a1a; margin-bottom: 32px; font-family: 'Instrument Serif', serif; font-style: italic; letter-spacing: 0; line-height: 1.15;">Cerita Kami</h2>

                <p style="color: #6b6b6b; font-size: 0.92rem; line-height: 1.8; margin-bottom: 20px;">
                    Kami adalah segerombolan anak muda yang mencintai kopi. Berawal dari nongkrong di warung kopi pinggir jalan, ngobrol soal biji kopi, roasting, dan cara seduh yang pas — kami sadar bahwa kopi bukan cuma minuman, tapi sebuah cerita.
                </p>

                <p style="color: #6b6b6b; font-size: 0.92rem; line-height: 1.8; margin-bottom: 20px;">
                    Dari iseng-iseng bikin website untuk jualan kopi ke teman-teman kampus, ternyata respons yang datang di luar ekspektasi. Satu pelanggan jadi dua, dua jadi sepuluh, dan terus berkembang hingga sekarang.
                </p>

                <p style="color: #6b6b6b; font-size: 0.92rem; line-height: 1.8; margin-bottom: 32px;">
                    Hari ini, <strong style="color: #1a1a1a;">Kedai Kopi Nusantara</strong> hadir dengan 4 cabang di Surabaya — tetap dengan semangat yang sama: menyajikan kopi terbaik Nusantara, dari petani langsung ke cangkir Anda.
                </p>

                <div class="cerita-btns" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="produk.php" style="background: #1a1a1a; color: #fafafa; padding: 12px 28px; text-decoration: none; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.1em; text-transform: uppercase; border: 2px solid #1a1a1a; transition: all 0.25s; font-family: 'DM Sans', sans-serif;"
                       onmouseover="this.style.background='transparent'; this.style.color='#1a1a1a';"
                       onmouseout="this.style.background='#1a1a1a'; this.style.color='#fafafa';">
                        Lihat Menu
                    </a>
                    <a href="reservasi.php" style="background: transparent; color: #1a1a1a; padding: 12px 28px; text-decoration: none; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.1em; text-transform: uppercase; border: 2px solid #d4d4d4; transition: all 0.25s; font-family: 'DM Sans', sans-serif;"
                       onmouseover="this.style.borderColor='#1a1a1a';"
                       onmouseout="this.style.borderColor='#d4d4d4';">
                        Reservasi
                    </a>
                </div>
            </div>

            <!-- Right: Illustration / Image -->
            <div class="cerita-img" style="position: relative;">
                <div style="border: 1px solid #d4d4d4; overflow: hidden; position: relative;">
                    <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600&h=700&fit=crop&crop=center" 
                         alt="Kedai Kopi Nusantara"
                         style="width: 100%; height: 500px; object-fit: cover; display: block; filter: grayscale(30%);">
                    <!-- Overlay -->
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 24px; background: linear-gradient(transparent, rgba(10,10,10,0.7));">
                        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #c8956c; margin-bottom: 4px;">Est. 2024</p>
                        <p style="color: #fafafa; font-size: 0.85rem; font-weight: 500;">Surabaya, Indonesia</p>
                    </div>
                </div>
                <!-- Decorative element -->
                <div class="cerita-deco" style="position: absolute; top: -12px; right: -12px; width: 80px; height: 80px; border: 2px solid #c8956c; z-index: -1;"></div>
            </div>

        </div>
    </div>
</section>

<!-- ===== MENU KAMI ===== -->
<section class="menu-section" style="background: var(--white); padding-bottom: 60px; border-top: 1px solid var(--off-white);">
    <div class="container">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 56px; padding-top: 60px;">
            <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 12px;">From the best Indonesian specialty coffee</p>
            <h2 style="font-size: 2.4rem; font-weight: 400; letter-spacing: 0; color: #1a1a1a; margin-bottom: 16px; font-family: 'Instrument Serif', serif; font-style: italic;">Our Menu</h2>
            <div style="width: 60px; height: 3px; background: #c8956c; margin: 0 auto;"></div>
        </div>

        <!-- Category Grid -->
        <div class="menu-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 48px;">

            <!-- Category 1: Coffee Beans -->
            <div style="text-align: center;">
                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; border: 1px solid #d4d4d4; margin-bottom: 20px; position: relative;"
                     onmouseover="this.querySelector('img').style.transform='scale(1.08)'; this.querySelector('img').style.filter='grayscale(0%)';"
                     onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('img').style.filter='grayscale(15%)';">
                    <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&h=400&fit=crop&crop=center" 
                         alt="Coffee Beans"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s, filter 0.5s; filter: grayscale(15%);">
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #1a1a1a; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px;">Our Beans</h3>
                <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; padding: 0 8px;">Biji kopi grade Specialty Arabica dan Fine Robusta dari perkebunan terbaik Indonesia</p>
            </div>

            <!-- Category 2: Coffee Drinks -->
            <div style="text-align: center;">
                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; border: 1px solid #d4d4d4; margin-bottom: 20px; position: relative;"
                     onmouseover="this.querySelector('img').style.transform='scale(1.08)'; this.querySelector('img').style.filter='grayscale(0%)';"
                     onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('img').style.filter='grayscale(15%)';">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400&h=400&fit=crop&crop=center" 
                         alt="Coffee Drinks"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s, filter 0.5s; filter: grayscale(15%);">
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #1a1a1a; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px;">Coffee Drinks</h3>
                <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; padding: 0 8px;">Dari minuman tradisional berbasis espresso sampai berbagai racikan kopi terkini</p>
            </div>

            <!-- Category 3: Non-Coffee -->
            <div style="text-align: center;">
                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; border: 1px solid #d4d4d4; margin-bottom: 20px; position: relative;"
                     onmouseover="this.querySelector('img').style.transform='scale(1.08)'; this.querySelector('img').style.filter='grayscale(0%)';"
                     onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('img').style.filter='grayscale(15%)';">
                    <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=400&fit=crop&crop=center" 
                         alt="Non-Coffee"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s, filter 0.5s; filter: grayscale(15%);">
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #1a1a1a; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px;">Non-Coffee</h3>
                <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; padding: 0 8px;">Pilihan lain selain kopi, dari teh premium hingga minuman segar untuk semua kalangan</p>
            </div>

            <!-- Category 4: Food & Snack -->
            <div style="text-align: center;">
                <div style="width: 100%; aspect-ratio: 1/1; overflow: hidden; border: 1px solid #d4d4d4; margin-bottom: 20px; position: relative;"
                     onmouseover="this.querySelector('img').style.transform='scale(1.08)'; this.querySelector('img').style.filter='grayscale(0%)';"
                     onmouseout="this.querySelector('img').style.transform='scale(1)'; this.querySelector('img').style.filter='grayscale(15%)';">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=400&fit=crop&crop=center" 
                         alt="Food & Snack"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s, filter 0.5s; filter: grayscale(15%);">
                </div>
                <h3 style="font-size: 0.85rem; font-weight: 700; color: #1a1a1a; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 10px;">Food & Snack</h3>
                <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; padding: 0 8px;">Berbagai makanan ringan dan makanan utama siap menemani secangkir kopimu</p>
            </div>

        </div>

        <div style="text-align:center;">
            <a href="produk.php" class="btn-hero">Lihat Semua Menu →</a>
        </div>
    </div>
</section>

<!-- ===== LOKASI CABANG ===== -->
<section class="cabang-section" style="background: #fafafa; padding: 80px 24px; border-top: 1px solid #e8e8e8;">
    <div class="container" style="padding: 0;">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 56px;">
            <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 12px;">Lokasi</p>
            <h2 style="font-size: 2rem; font-weight: 700; letter-spacing: -0.02em; color: #1a1a1a; margin-bottom: 16px;">Cabang Kami</h2>
            <div style="width: 60px; height: 3px; background: #c8956c; margin: 0 auto;"></div>
        </div>

        <!-- Branch Grid -->
        <div class="cabang-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">

            <!-- Cabang 1 -->
            <div style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.cabang-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.cabang-line').style.background='#d4d4d4';">
                <div class="cabang-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #c8956c; margin-bottom: 8px;">01</p>
                <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; letter-spacing: -0.01em;">Cabang Sepanjang</h3>
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="color: #8a8a8a; font-size: 1rem; flex-shrink: 0; margin-top: 1px;">&#9906;</span>
                    <p style="color: #6b6b6b; font-size: 0.88rem; line-height: 1.6; margin: 0;">Jalan Bebekan Selatan No. 46, Sepanjang</p>
                </div>
            </div>

            <!-- Cabang 2 -->
            <div style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.cabang-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.cabang-line').style.background='#d4d4d4';">
                <div class="cabang-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #c8956c; margin-bottom: 8px;">02</p>
                <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; letter-spacing: -0.01em;">Cabang Lakarsantri</h3>
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="color: #8a8a8a; font-size: 1rem; flex-shrink: 0; margin-top: 1px;">&#9906;</span>
                    <p style="color: #6b6b6b; font-size: 0.88rem; line-height: 1.6; margin: 0;">Jalan Lakarsantri No. 30, Lakarsantri</p>
                </div>
            </div>

            <!-- Cabang 3 -->
            <div style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.cabang-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.cabang-line').style.background='#d4d4d4';">
                <div class="cabang-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #c8956c; margin-bottom: 8px;">03</p>
                <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; letter-spacing: -0.01em;">Cabang Sukolilo</h3>
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="color: #8a8a8a; font-size: 1rem; flex-shrink: 0; margin-top: 1px;">&#9906;</span>
                    <p style="color: #6b6b6b; font-size: 0.88rem; line-height: 1.6; margin: 0;">Jalan Sukolilo No. 45, Sukolilo</p>
                </div>
            </div>

            <!-- Cabang 4 -->
            <div style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.cabang-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.cabang-line').style.background='#d4d4d4';">
                <div class="cabang-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.12em; text-transform: uppercase; color: #c8956c; margin-bottom: 8px;">04</p>
                <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; letter-spacing: -0.01em;">Cabang Keputih</h3>
                <div style="display: flex; align-items: flex-start; gap: 10px;">
                    <span style="color: #8a8a8a; font-size: 1rem; flex-shrink: 0; margin-top: 1px;">&#9906;</span>
                    <p style="color: #6b6b6b; font-size: 0.88rem; line-height: 1.6; margin: 0;">Jalan Keputih Tegal Timur No. 32, Keputih</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== SECTION RESERVASI ===== -->
<section class="reservasi-section" style="background: #1a1a1a; padding: 80px 24px; text-align: center; color: #fafafa; margin: 0; position: relative; overflow: hidden;">
    <!-- Diagonal lines pattern -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: repeating-linear-gradient(45deg, transparent, transparent 80px, rgba(255,255,255,0.02) 80px, rgba(255,255,255,0.02) 81px); pointer-events: none;"></div>
    <!-- Top accent line -->
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, #c8956c, transparent);"></div>
    <div class="container" style="position: relative; z-index: 1; padding: 0;">
        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 16px;">Reservasi</p>
        <h2 style="font-size: 2rem; margin-bottom: 16px; font-weight: 700; letter-spacing: -0.02em; color: #fafafa;">Ingin Reservasi Kursi?</h2>
        <p style="font-size: 0.95rem; margin-bottom: 36px; color: #8a8a8a; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.7;">
            Pesan kursi Anda sekarang dan nikmati pengalaman berbelanja kopi yang lebih nyaman di kedai kami.
        </p>
        <a href="reservasi.php" style="background: #c8956c; color: #0a0a0a; padding: 14px 36px; 
                                       font-size: 0.82rem; font-weight: 700; text-decoration: none; 
                                       border-radius: 0; display: inline-block; transition: all 0.25s;
                                       border: 2px solid #c8956c; letter-spacing: 0.1em; text-transform: uppercase;
                                       font-family: 'DM Sans', sans-serif;"
           onmouseover="this.style.background='transparent'; this.style.color='#c8956c';"
           onmouseout="this.style.background='#c8956c'; this.style.color='#0a0a0a';">
            Buat Reservasi Sekarang →
        </a>
    </div>
    <!-- Bottom accent line -->
    <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, #c8956c, transparent);"></div>
</section>

<!-- ===== GALLERY ===== -->
<section class="gallery-section" style="background: #fafafa; padding: 80px 24px; border-top: 1px solid #e8e8e8;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 48px;">
            <h2 style="font-size: 2.2rem; font-weight: 700; color: #1a1a1a; letter-spacing: -0.02em; margin-bottom: 16px;">GALLERY</h2>
            <div style="width: 60px; height: 4px; background: #c8956c; margin: 0 auto;"></div>
        </div>

        <!-- Gallery Grid 4x2 -->
        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1498804103079-a6351b050096?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1559496417-e7f25cb247f3?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

            <div style="overflow: hidden; aspect-ratio: 1/1;">
                <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400&h=400&fit=crop&crop=center" alt="Gallery"
                     style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(100%); transition: filter 0.5s, transform 0.5s;"
                     onmouseover="this.style.filter='grayscale(0%)'; this.style.transform='scale(1.05)';"
                     onmouseout="this.style.filter='grayscale(100%)'; this.style.transform='scale(1)';">
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>