    @extends('layouts.app')

    @section('title', 'Tentang Kami')

    @section('content')
    <main>

        <!-- Hero / Deskripsi -->
        <section class="d-flex align-items-center position-relative text-dark" style="min-height: 100vh;"
            data-aos="fade-up">
            <!-- Background Image -->
            <div class="position-absolute w-100 h-100"
                style="background: url('{{ asset('assets/img/gentala-arasy.jpg') }}') center/cover no-repeat; 
                    filter: blur(6px); 
                    opacity: 0.6;">
            </div>

            <!-- Overlay -->
            <div class="position-absolute w-100 h-100 bg-dark" style="opacity: 0.3;"></div>

            <!-- Content -->
            <div class="container position-relative">
                <div class="row justify-content-center align-items-center g-5">
                    <!-- Teks -->
                    <div class="col-lg-8 text-center text-white" data-aos="fade-right">
                        <h1 class="fw-bolder mb-4 display-5" style="font-weight: 600;">
                            <span style="color: white;">Tentang</span>
                            <span style="color: #17678d;">BAHASARA</span>
                        </h1>
                        <p class="lead text-white">
                            <strong>Bahasara</strong> adalah platform sistem informasi geografis berbasis web
                            yang menampilkan data persebaran bahasa dan sastra daerah di Provinsi Jambi.
                            Website ini dikembangkan sebagai bentuk pelestarian warisan budaya takbenda,
                            khususnya dalam bidang kebahasaan dan kesastraan.
                        </p>
                        <a href="{{ url('/') }}" class="btn btn-lg mt-3 px-4"
                            style="color: white; border: 2px solid white; transition: all 0.3s; background-color: transparent; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);"
                            onmouseover="this.style.backgroundColor='#17678d'; this.style.color='white'; this.style.borderColor='#17678d';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='white'; this.style.borderColor='white';">
                            Lihat Peta
                        </a>


                    </div>

                </div>
            </div>
        </section>


        <!-- Misi -->
        <section id="misi" class="py-5 bg-white" data-aos="fade-up">
            <div class="container">
                <h2 class="text-center fw-bold mb-5" style="color: black;font-weight: 400;">Misi Bahasara</h2>
                <div class="row justify-content-center g-4">

                    <!-- Card 1 -->
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card shadow border-0 text-center h-100">
                            <img src="{{ asset('assets/img/map-laptop.jpeg') }}" class="card-img-top rounded-top"
                                alt="Misi 1" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="mb-0">Mendokumentasikan bahasa dan sastra daerah di Provinsi Jambi secara
                                    digital.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card shadow border-0 text-center h-100">
                            <img src="{{ asset('assets/img/indonesia-students.jpg') }}" class="card-img-top rounded-top"
                                alt="Misi 2" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="mb-0">Menyediakan akses informasi bagi peneliti, pelajar, dan masyarakat
                                    umum.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card shadow border-0 text-center h-100">
                            <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top rounded-top"
                                alt="Misi 3" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="mb-0">Meningkatkan kesadaran masyarakat tentang pentingnya pelestarian
                                    budaya lokal.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-6 col-lg-4 mt-4" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card shadow border-0 text-center h-100">
                            <img src="{{ asset('assets/img/collaboration.jpg') }}" class="card-img-top rounded-top"
                                alt="Misi 4" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="mb-0">Mendukung kolaborasi dengan lembaga pendidikan, komunitas, dan
                                    pemerintah daerah.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="col-md-6 col-lg-4 mt-4" data-aos="zoom-in" data-aos-delay="500">
                        <div class="card shadow border-0 text-center h-100">
                            <img src="{{ asset('assets/img/jambi-budaya.png') }}" class="card-img-top rounded-top"
                                alt="Misi 5" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <p class="mb-0">Mengembangkan inovasi teknologi dalam bidang kebudayaan.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Tim Pengembang -->
        <section id="tim" class="py-5" style="background-color: #fff;" data-aos="fade-up">
            <div class="container">
                <h2 class="text-center fw-bold mb-5 text-black" style="font-weight: 400;">Tim Pengembang</h2>
                <div class="row justify-content-center g-4">
                    <!-- Card 1 -->
                    <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card shadow border-0 text-center h-100" style="width: 100%; max-width: 260px; margin: 0 auto;">
                            <div style="width: 100%; height: 300px; overflow: hidden;">
                                <img src="{{ asset('assets/img/aldi.jpeg') }}"
                                    class="card-img-top"
                                    alt="Aldi Sukma Putra"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1">Aldi Sukma Putra</h5>
                                <p class="text-muted small">Front-End Developer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card shadow border-0 text-center h-100" style="width: 100%; max-width: 260px; margin: 0 auto;">
                            <div style="width: 100%; height: 300px; overflow: hidden;">
                                <img src="{{ asset('assets/img/mito.jpeg') }}"
                                    class="card-img-top"
                                    alt="Cagivamito Tadashi Hutabarat"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1">Cagivamito Tadashi Hutabarat</h5>
                                <p class="text-muted small">Back-End Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Statistik Data -->
        <section id="statistik" class="py-5 bg-white" data-aos="fade-up">
            <div class="container">
                <h2 class="text-center fw-bolder mb-5" style="color: black; font-weight: 400;">Statistik Data Bahasara
                </h2>
                <div class="row text-center g-4">

                    <!-- Bahasa -->
                    <div class="col-md-4">
                        <div class="card shadow border-0 p-4 h-100">
                            <h3 class="fw-bold text-primary mb-2">{{ $counts['bahasa'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Bahasa</p>
                        </div>
                    </div>

                    <!-- Sastra -->
                    <div class="col-md-4">
                        <div class="card shadow border-0 p-4 h-100">
                            <h3 class="fw-bold text-success mb-2">{{ $counts['sastra'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Sastra</p>
                        </div>
                    </div>

                    <!-- Aksara -->
                    <div class="col-md-4">
                        <div class="card shadow border-0 p-4 h-100">
                            <h3 class="fw-bold text-warning mb-2">{{ $counts['aksara'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Aksara</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>


    </main>
    @endsection