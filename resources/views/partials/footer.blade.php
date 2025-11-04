<footer class="bg-white">
    <!-- 🔸 GARIS PEMISAH DARI KONTEN WEBSITE -->
    <div class="footer-divider-top"></div>

    <!-- 🔹 MAIN FOOTER -->
    <section id="ts-footer-main" class="py-5">
        <div class="container">
            <div class="row align-items-start">

                <!-- Brand and Description -->
                <div class="col-md-6 mb-4 mb-md-0">
                    <a href="{{ url('peta') }}" class="brand d-inline-block mb-3">
                        <img src="{{ asset('assets/img/logo-sibaraja.png') }}" 
                             alt="Logo Sibaraja" 
                             style="max-height: 45px;">
                    </a>
                    <p class="text-muted mb-4 footer-desc">
                        <strong>SIBARAJA</strong> merupakan Sistem Informasi Geografis (SIG)
                        yang berfungsi untuk menampilkan Bahasa dan Sastra
                        yang ada di seluruh wilayah Provinsi Jambi. Platform ini
                        memudahkan masyarakat untuk mengenal dan melestarikan
                        kekayaan bahasa dan sastra daerah.
                    </p>
                </div>

                <!-- Navigation -->
                <div class="col-md-2 mb-4 mb-md-0">
                    <h4 class="fw-semibold mb-3">Navigasi</h4>
                    <nav class="nav flex-column footer-nav">
                        <a href="{{ url('/') }}" class="nav-link-footer">Beranda</a>
                        <a href="{{ url('peta') }}" class="nav-link-footer">Pemetaan</a>
                        <a href="{{ url('pengumuman') }}" class="nav-link-footer">Pengumuman</a>
                        <a href="{{ url('tentang-kami') }}" class="nav-link-footer">Tentang Kami</a>
                        <a href="{{ url('kontak') }}" class="nav-link-footer">Hubungi Kami</a>
                    </nav>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <h4 class="fw-bold mb-3">Kontak Kami</h4>
                    <address class="mb-0 text-muted" style="line-height: 1.8; font-size: 0.95rem;">
                        Jalan Arif Rahman Hakim No. 101,<br>
                        Telanaipura, Jambi, Indonesia, 36124<br>
                        <strong>Email:</strong>
                        <a href="mailto:bahasajambi@kemdikbud.go.id" class="text-decoration-none text-primary">
                            bahasajambi@kemdikbud.go.id
                        </a><br>
                        <strong>Telepon:</strong> (0741) 669466
                    </address>
                </div>

            </div>
        </div>
    </section>

    <!-- 🔸 SEPARATOR LINE ANTARA MAIN DAN SUB FOOTER -->
    <div class="footer-divider-sub"></div>

    <!-- 🔹 SUB FOOTER -->
    <section id="ts-footer-sub" class="py-3">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <!-- Copyright -->
            <div class="text-muted mb-3 mb-md-0" style="font-size: 0.9rem;">
                © {{ date('Y') }} <strong>SIBARAJA</strong> | Balai Bahasa Provinsi Jambi
            </div>

            <!-- Social Media -->
            <div class="footer-social">
                <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-link" title="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </section>

    <style>
        /* 🔹 Garis pembatas antar bagian */
        .footer-divider-top {
            border-top: 2px solid #e0e0e0; /* garis tegas antara konten & footer */
        }

        .footer-divider-sub {
            border-top: 1px solid #e5e7eb; /* garis halus antara main footer & sub footer */
        }

        /* ✅ Deskripsi agar multiline */
        .footer-desc {
            font-size: 0.95rem;
            line-height: 1.8;
            max-width: 420px;
            text-align: justify;
        }

        /* ✅ Jarak antar menu navigasi */
        .footer-nav a + a {
            margin-top: 0.5rem;
        }

        .nav-link-footer {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .nav-link-footer:hover {
            color: #000;
            transform: translateX(4px);
        }

        /* ✅ Sosial Media spacing */
        .footer-social a {
            color: #6c757d;
            font-size: 1.2rem;
            margin: 0 10px;
            transition: all 0.2s ease;
        }

        .footer-social a:hover {
            color: #0d6efd;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            footer {
                text-align: center;
            }

            .footer-social {
                margin-top: 10px;
            }

            .footer-social a {
                margin: 0 8px;
            }

            .nav-link-footer:hover {
                transform: none;
            }
        }
    </style>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a2e0e6ad7f.js" crossorigin="anonymous"></script>
</footer>
