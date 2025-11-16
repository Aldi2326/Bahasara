@extends('layouts.app')

@section('title', 'Pengumuman')

@section('content')
<div class="container mt-5" style="padding-top: 80px; padding-bottom: 50px;">

    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Pengumuman</h2>
            <p class="text-muted">Informasi terbaru yang dapat Anda lihat.</p>
        </div>
    </div>

    <div class="row g-4" id="announcementContainer">

        {{-- Konten 1 --}}
        <a href="{{ route('pengumuman-user.show', 1) }}" class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </a>

        {{-- Konten 2 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 3 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 4 (tampil) --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 5 (tampil) --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 6 (tampil) --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 7 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 8 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>
        {{-- Konten 9--}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 10 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

        {{-- Konten 11 --}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>
        {{-- Konten 12--}}
        <div class="col-md-6 col-lg-4 mt-4 announcement-item hidden-item" style="display: none;">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('assets/img/tudung-lingkup.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Rapat Koordinasi</h5>
                    <p class="card-text text-muted">Seluruh anggota diwajibkan hadir dalam rapat koordinasi akhir tahun.</p>
                </div>
                <div class="card-footer bg-white">
                    <small class="text-muted"><i class="bi bi-calendar"></i> 05 Januari 2025</small>
                </div>
            </div>
        </div>

    </div>

    {{-- Tombol Tampilkan Lebih Banyak --}}
    <div class="text-center mt-4">
        <button id="loadMoreBtn"
            class="px-4 py-2"
            style="background:#1b81ae; color:white; border-radius:8px; border:none;">
            Tampilkan Lebih Banyak
        </button>
    </div>

</div>

<script>
    document.getElementById('loadMoreBtn').addEventListener('click', function() {
        document.querySelectorAll('.hidden-item').forEach(item => {
            item.style.display = 'block';
        });
        this.style.display = 'none';
    });
</script>

@endsection