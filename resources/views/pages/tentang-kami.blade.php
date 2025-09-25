@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<main>

    <!-- Hero / Deskripsi -->
    <section class="d-flex align-items-center bg-light" style="min-height: 100vh;" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Teks -->
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="fw-bold mb-4 display-5" style="color: #17678d;">BAHASARA</h1>
                    <p class="lead text-secondary">
                        <strong>Bahasara</strong> adalah platform sistem informasi geografis berbasis web 
                        yang menampilkan data persebaran bahasa dan sastra daerah di Provinsi Jambi. 
                        Website ini dikembangkan sebagai bentuk pelestarian warisan budaya takbenda, 
                        khususnya dalam bidang kebahasaan dan kesastraan.
                    </p>
                    <a href="{{ url('/') }}" 
                       class="btn btn-lg mt-3 px-4" 
                       style="color: #17678d; border: 2px solid #17678d; transition: all 0.3s; background-color: transparent; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);" 
                       onmouseover="this.style.backgroundColor='#17678d'; this.style.color='white';" 
                       onmouseout="this.style.backgroundColor='transparent'; this.style.color='#17678d';">
                       Lihat Peta
                    </a>
                </div>
                <!-- Gambar -->
                <div class="col-lg-6 text-center" data-aos="fade-left">
                    <img src="{{ asset('assets/img/rafiki.png') }}" 
                         alt="Bahasara Illustration" 
                         class="img-fluid w-75">
                </div>
            </div>
        </div>
    </section>

    <!-- Misi -->
    <section id="tahap2" class="py-5 bg-white" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center fw-bold mb-5" style="color: #17678d;">Misi Bahasara</h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <ul class="list-group list-group-flush shadow-sm rounded" style="font-size: 1.1rem;">
                        <li class="list-group-item py-3">📌 Mendokumentasikan bahasa dan sastra daerah di Provinsi Jambi secara digital.</li>
                        <li class="list-group-item py-3">📌 Menyediakan akses informasi bagi peneliti, pelajar, dan masyarakat umum.</li>
                        <li class="list-group-item py-3">📌 Meningkatkan kesadaran masyarakat tentang pentingnya pelestarian budaya lokal.</li>
                        <li class="list-group-item py-3">📌 Mendukung kolaborasi dengan lembaga pendidikan, komunitas, dan pemerintah daerah.</li>
                        <li class="list-group-item py-3">📌 Mengembangkan inovasi teknologi dalam bidang kebudayaan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Tim Pengembang -->
    <section id="tahap3" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center fw-bold mb-5" style="color: #17678d;">Tim Pengembang</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card shadow border-0 text-center h-100">
                        <img src="{{ asset('assets/img/amba2.jpeg') }}" class="card-img-top rounded-top" alt="person">
                        <div class="card-body">
                            <h5 class="card-title mb-1">Aldi Sukma Putra</h5>
                            <p class="text-muted small">Front-End Developer</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card shadow border-0 text-center h-100">
                        <img src="{{ asset('assets/img/amba.jpeg') }}" class="card-img-top rounded-top" alt="person">
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
            <h2 class="text-center fw-bold mb-5" style="color: #17678d;">Statistik Data Bahasara</h2>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4 h-100">
                        <h3 class="fw-bold text-primary mb-2">12</h3>
                        <p class="mb-0 text-muted">Bahasa</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4 h-100">
                        <h3 class="fw-bold text-success mb-2">8</h3>
                        <p class="mb-0 text-muted">Sastra</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0 p-4 h-100">
                        <h3 class="fw-bold text-warning mb-2">5</h3>
                        <p class="mb-0 text-muted">Aksara</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
