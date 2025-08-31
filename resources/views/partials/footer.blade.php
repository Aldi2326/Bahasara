<footer id="ts-footer">
    <section id="ts-footer-main">
        <div class="container">
            <div class="row">
                <!-- Brand and description -->
                <div class="col-md-6">
                    <a href="{{ url('peta') }}" class="brand">
                        <img src="{{ asset('assets/img/Logo-Bahasara.png') }}" alt="">
                    </a>
                    <p class="mb-4">
                        BAHASARA merupakan Sistem Informasi Geografis
                        (SIG) yang berfungsi untuk menampilkan Bahasa
                        dan Sastra yang ada di Provinsi Jambi.
                    </p>
                    <a href="{{ url('kontak') }}" class="btn btn-outline-dark mb-4">Kontak Kami</a>
                </div>

                <!-- Navigation -->
                <div class="col-md-2">
                    <h4>Navigasi</h4>
                    <nav class="nav flex-row flex-md-column mb-4">
                        <a href="{{ url('peta') }}" class="nav-link">Peta</a>
                        <a href="{{ url('tentang-kami') }}" class="nav-link">Tentang Kami</a>
                        <a href="{{ url('kontak') }}" class="nav-link">Kontak</a>
                    </nav>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <h4>Kontak Kami</h4>
                    <address class="ts-text-color-light">
                        Jalan Arif Rahman Hakim No. 101,  <br>
                        Telanaipura Jambi, Indonesia, 36124<br>
                        <strong>Email:</strong>
                        <a href="#" class="btn-link"> bahasajambi@kemdikbud.go.id</a><br>
                        <strong>Telepon:</strong>
                        (0741) 669466
                    </address>
                </div>
            </div>
        </div>
    </section>

    <section id="ts-footer-secondary">
        <div class="container d-flex justify-content-between">
            <div class="ts-copyright">
                (C) 2018 ThemeStarz, All rights reserved
            </div>
            <div class="ts-footer-nav">
                <nav class="nav">
                    <a href="#" class="nav-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-youtube"></i></a>
                </nav>
            </div>
        </div>
    </section>
</footer>
