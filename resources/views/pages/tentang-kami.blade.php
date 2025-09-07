@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<main>

   <!-- Tahap 1: Deskripsi -->
<section class="d-flex align-items-center bg-light" style="height:100vh;" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center">
            <!-- Teks -->
            <div class="col-md-6 text-start text-md-start" data-aos="fade-right">
                <h1 class="fw-bold mb-4">BAHASARA</h1>
                <p class="lead">
                    Bahasara adalah platform sistem informasi geografis berbasis web yang menampilkan data persebaran
                    bahasa dan sastra daerah di Provinsi Jambi. Website ini dikembangkan sebagai bentuk pelestarian
                    warisan budaya takbenda, khususnya dalam bidang kebahasaan dan kesastraan.
                </p>
                <a href="url('peta')" class="btn btn-primary mt-4">Selengkapnya</a>
            </div>
            <!-- Gambar -->
            <div class="col-md-6 text-center " data-aos="fade-left">
                <img src="{{ asset('assets/img/rafiki.png') }}" 
                     alt="Bahasara Illustration" 
                     class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Tahap 2: Misi Bahasara -->
<section id="tahap2" class="d-flex align-items-center bg-light" style="min-height:100vh;" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Misi Bahasara dalam Mendukung Pelestarian Budaya</h2>
        <div class="row justify-content-center">
            <div class="col-md-10" data-aos="fade-up" data-aos-delay="200">
                <ul style="font-size: 1.1rem; line-height:1.8;">
                    <li>Mendokumentasikan bahasa dan sastra daerah di Provinsi Jambi secara digital.</li>
                    <li>Menyediakan akses informasi bagi peneliti, pelajar, dan masyarakat umum.</li>
                    <li>Meningkatkan kesadaran masyarakat tentang pentingnya pelestarian budaya lokal.</li>
                    <li>Mendukung kolaborasi dengan lembaga pendidikan, komunitas, dan pemerintah daerah.</li>
                    <li>Mengembangkan inovasi teknologi dalam bidang kebudayaan.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Tahap 3: Tim -->
<section id="tahap3" class="d-flex align-items-center text-black" style="height:100vh;" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Tim Pengembang</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="card shadow-sm border-0 text-center h-100">
                    <img src="{{ asset('assets/img/amba2.jpeg') }}" class="card-img-top" alt="person">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Aldi Sukma Putra</h5>
                        <p class="text-muted small">Front-End Developer</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="card shadow-sm border-0 text-center h-100">
                    <img src="{{ asset('assets/img/amba.jpeg') }}" class="card-img-top" alt="person">
                    <div class="card-body">
                        <h5 class="card-title mb-1">Cagivamito Tadashi Hutabarat</h5>
                        <p class="text-muted small">Back-End Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
@endsection
