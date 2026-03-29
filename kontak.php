<?php
include 'includes/config.php';
include 'includes/header.php';
?>
<style>
@media (max-width: 768px) {
    .kontak-grid { grid-template-columns: 1fr !important; gap: 16px !important; }
    .kontak-section { padding: 60px 16px !important; }
    .kontak-header { padding: 48px 16px 40px !important; }
    .kontak-header h1 { font-size: 1.6rem !important; }
    .kontak-map { height: 280px !important; }
    .sosmed-grid { grid-template-columns: 1fr 1fr !important; }
}
@media (max-width: 480px) {
    .kontak-header h1 { font-size: 1.3rem !important; }
    .kontak-cards { gap: 12px !important; }
    .kontak-card { padding: 24px 20px !important; }
    .sosmed-grid { grid-template-columns: 1fr !important; }
}
</style>

<!-- ===== PAGE HEADER ===== -->
<div class="kontak-header" style="text-align: center; padding: 60px 24px 48px; background: #fafafa;">
    <div style="max-width: 600px; margin: 0 auto;">
        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 12px;">Get In Touch</p>
        <h1 style="font-size: 2.2rem; font-weight: 700; color: #1a1a1a; letter-spacing: -0.02em; margin-bottom: 16px;">Hubungi Kami</h1>
        <div style="width: 60px; height: 3px; background: #c8956c; margin: 0 auto 20px;"></div>
        <p style="color: #6b6b6b; font-size: 0.95rem; line-height: 1.7;">
            Punya pertanyaan, saran, atau ingin bekerja sama? Jangan ragu untuk menghubungi kami melalui berbagai channel di bawah ini.
        </p>
    </div>
</div>

<!-- ===== CONTACT CONTENT ===== -->
<section class="kontak-section" style="background: #fafafa; padding: 0 24px 80px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- ===== CONTACT CARDS ===== -->
        <div class="kontak-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 48px;">

            <!-- Card: WhatsApp -->
            <div class="kontak-card" style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.k-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.k-line').style.background='#d4d4d4';">
                <div class="k-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: #f2f1ef; border: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #c8956c; margin-bottom: 6px;">WhatsApp</p>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">+62 812-3456-7890</h3>
                        <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; margin-bottom: 14px;">Chat langsung dengan tim kami untuk pemesanan atau pertanyaan.</p>
                        <a href="https://wa.me/6281234567890" target="_blank" 
                           style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #c8956c; text-decoration: none; letter-spacing: 0.06em; font-weight: 600; transition: color 0.2s;"
                           onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#c8956c';">
                            CHAT SEKARANG →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card: Email -->
            <div class="kontak-card" style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.k-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.k-line').style.background='#d4d4d4';">
                <div class="k-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: #f2f1ef; border: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #c8956c; margin-bottom: 6px;">Email</p>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">info@kedaikopinusantara.id</h3>
                        <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; margin-bottom: 14px;">Kirim email untuk kerjasama, wholesale, atau pertanyaan umum.</p>
                        <a href="mailto:info@kedaikopinusantara.id" 
                           style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #c8956c; text-decoration: none; letter-spacing: 0.06em; font-weight: 600; transition: color 0.2s;"
                           onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#c8956c';">
                            KIRIM EMAIL →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card: Alamat -->
            <div class="kontak-card" style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.k-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.k-line').style.background='#d4d4d4';">
                <div class="k-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: #f2f1ef; border: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #c8956c; margin-bottom: 6px;">Kantor Pusat</p>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Surabaya, Jawa Timur</h3>
                        <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.6; margin-bottom: 14px;">Jl. Kopi Nikmat No. 1, Kec. Sukolilo, Kota Surabaya, Jawa Timur 60111</p>
                        <a href="https://maps.google.com/?q=Surabaya" target="_blank" 
                           style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #c8956c; text-decoration: none; letter-spacing: 0.06em; font-weight: 600; transition: color 0.2s;"
                           onmouseover="this.style.color='#1a1a1a';" onmouseout="this.style.color='#c8956c';">
                            LIHAT DI MAPS →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card: Jam Operasional -->
            <div class="kontak-card" style="background: #fafafa; border: 1px solid #d4d4d4; padding: 32px 28px; position: relative; transition: border-color 0.3s;"
                 onmouseover="this.style.borderColor='#c8956c'; this.querySelector('.k-line').style.background='#c8956c';"
                 onmouseout="this.style.borderColor='#d4d4d4'; this.querySelector('.k-line').style.background='#d4d4d4';">
                <div class="k-line" style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #d4d4d4; transition: background 0.3s;"></div>
                
                <div style="display: flex; align-items: flex-start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: #f2f1ef; border: 1px solid #e8e8e8; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #c8956c; margin-bottom: 6px;">Jam Operasional</p>
                        <h3 style="font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Setiap Hari</h3>
                        <p style="color: #6b6b6b; font-size: 0.82rem; line-height: 1.8;">
                            Senin – Jumat: 08.00 – 22.00 WIB<br>
                            Sabtu – Minggu: 09.00 – 23.00 WIB
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- ===== SOCIAL MEDIA ===== -->
        <div style="background: #1a1a1a; padding: 40px; margin-bottom: 48px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: repeating-linear-gradient(45deg, transparent, transparent 60px, rgba(255,255,255,0.015) 60px, rgba(255,255,255,0.015) 61px); pointer-events: none;"></div>
            
            <div style="position: relative; z-index: 1;">
                <div style="text-align: center; margin-bottom: 32px;">
                    <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; letter-spacing: 0.15em; text-transform: uppercase; color: #c8956c; margin-bottom: 10px;">Follow Us</p>
                    <h2 style="font-size: 1.4rem; font-weight: 700; color: #fafafa; letter-spacing: -0.02em;">Ikuti Kami di Media Sosial</h2>
                </div>

                <div class="sosmed-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; max-width: 800px; margin: 0 auto;">
                    
                    <!-- Instagram -->
                    <a href="https://instagram.com/kedaikopinusantara" target="_blank" 
                       style="display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: 1px solid #3a3a3a; text-decoration: none; transition: border-color 0.3s, background 0.3s;"
                       onmouseover="this.style.borderColor='#c8956c'; this.style.background='rgba(200,149,108,0.08)';"
                       onmouseout="this.style.borderColor='#3a3a3a'; this.style.background='transparent';">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c8956c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                        </svg>
                        <div>
                            <p style="color: #fafafa; font-size: 0.82rem; font-weight: 600; margin: 0;">Instagram</p>
                            <p style="color: #8a8a8a; font-size: 0.72rem; margin: 2px 0 0; font-family: 'JetBrains Mono', monospace;">@kedaikopinusantara</p>
                        </div>
                    </a>

                    <!-- TikTok -->
                    <a href="https://tiktok.com/@kedaikopinusantara" target="_blank" 
                       style="display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: 1px solid #3a3a3a; text-decoration: none; transition: border-color 0.3s, background 0.3s;"
                       onmouseover="this.style.borderColor='#c8956c'; this.style.background='rgba(200,149,108,0.08)';"
                       onmouseout="this.style.borderColor='#3a3a3a'; this.style.background='transparent';">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c8956c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/>
                        </svg>
                        <div>
                            <p style="color: #fafafa; font-size: 0.82rem; font-weight: 600; margin: 0;">TikTok</p>
                            <p style="color: #8a8a8a; font-size: 0.72rem; margin: 2px 0 0; font-family: 'JetBrains Mono', monospace;">@kedaikopinusantara</p>
                        </div>
                    </a>

                    <!-- Twitter/X -->
                    <a href="https://twitter.com/kedaikopinus" target="_blank" 
                       style="display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: 1px solid #3a3a3a; text-decoration: none; transition: border-color 0.3s, background 0.3s;"
                       onmouseover="this.style.borderColor='#c8956c'; this.style.background='rgba(200,149,108,0.08)';"
                       onmouseout="this.style.borderColor='#3a3a3a'; this.style.background='transparent';">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c8956c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z"/>
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/>
                        </svg>
                        <div>
                            <p style="color: #fafafa; font-size: 0.82rem; font-weight: 600; margin: 0;">X / Twitter</p>
                            <p style="color: #8a8a8a; font-size: 0.72rem; margin: 2px 0 0; font-family: 'JetBrains Mono', monospace;">@kedaikopinus</p>
                        </div>
                    </a>

                    <!-- Facebook -->
                    <a href="https://facebook.com/kedaikopinusantara" target="_blank" 
                       style="display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: 1px solid #3a3a3a; text-decoration: none; transition: border-color 0.3s, background 0.3s;"
                       onmouseover="this.style.borderColor='#c8956c'; this.style.background='rgba(200,149,108,0.08)';"
                       onmouseout="this.style.borderColor='#3a3a3a'; this.style.background='transparent';">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#c8956c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                        <div>
                            <p style="color: #fafafa; font-size: 0.82rem; font-weight: 600; margin: 0;">Facebook</p>
                            <p style="color: #8a8a8a; font-size: 0.72rem; margin: 2px 0 0; font-family: 'JetBrains Mono', monospace;">Kedai Kopi Nusantara</p>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <!-- ===== MAP EMBED ===== -->
        <div style="border: 1px solid #d4d4d4; position: relative;">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #c8956c; z-index: 1;"></div>
            <div class="kontak-map" style="height: 400px; background: #e8e8e8; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56291981342!2d112.6654058!3d-7.2756141!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fbf8381ac47f%3A0x3027a76e352be40!2sSurabaya%2C%20Kota%20SBY%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1"
                    style="width: 100%; height: 100%; border: 0; filter: grayscale(80%);" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div style="padding: 20px 24px; background: #fafafa; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e8e8e8;">
                <div>
                    <p style="font-family: 'JetBrains Mono', monospace; font-size: 0.68rem; letter-spacing: 0.1em; text-transform: uppercase; color: #c8956c; margin-bottom: 4px;">Location</p>
                    <p style="color: #1a1a1a; font-size: 0.88rem; font-weight: 600;">Surabaya, Jawa Timur, Indonesia</p>
                </div>
                <a href="https://maps.google.com/?q=Surabaya" target="_blank"
                   style="background: #1a1a1a; color: #fafafa; padding: 10px 24px; text-decoration: none; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.08em; text-transform: uppercase; border: 2px solid #1a1a1a; transition: all 0.25s; font-family: 'DM Sans', sans-serif;"
                   onmouseover="this.style.background='transparent'; this.style.color='#1a1a1a';"
                   onmouseout="this.style.background='#1a1a1a'; this.style.color='#fafafa';">
                    Buka di Google Maps
                </a>
            </div>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>