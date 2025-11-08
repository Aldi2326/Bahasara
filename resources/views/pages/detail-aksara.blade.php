@extends('layouts.app')

@section('title', 'Detail Aksara')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 200px">
    <div class="card shadow-lg border-0 rounded-3">

        <!-- Header -->
        <div class="card-header text-white" style="background-color: #1b81ae;">
            <h3 class="mb-0">{{ $aksara->nama_aksara }}</h3>
            <small class="opacity-75">Wilayah: {{ $aksara->wilayah->nama_wilayah }}, Provinsi Jambi</small>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- STATUS -->
            <div class="mb-4" data-aos="fade-right" data-aos-duration="700">
                <h6 class="text-muted">Status Aksara</h6>
                <span
                    class="badge 
                        @if ($aksara->status == 'Aktif') bg-success 
                        @elseif($aksara->status == 'Tidak Aktif') bg-warning text-dark 
                        @else bg-secondary @endif 
                        fs-6 px-3 py-2 rounded-pill">
                    {{ $aksara->status }}
                </span>
            </div>

            <!-- PETA SEBARAN -->
            <div class="mb-4" data-aos="zoom-in" data-aos-duration="1000">
                <h5 class="text-muted">Peta</h5>
                <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>
        </div>
        <!-- DESKRIPSI -->
        <div class="mb-5" data-aos="fade-up" data-aos-duration="800">
            <h5 class="text-muted">Deskripsi</h5>
            <p class="text-justify fs-6">
                {!! $aksara->deskripsi ?? 'Tidak ada deskripsi.' !!}
            </p>
        </div>

        <!-- DOKUMENTASI -->
        <div class="mb-5" data-aos="zoom-in" data-aos-duration="800">
            <h5 class="text-muted mb-3">Dokumentasi</h5>

            @if ($aksara->dokumentasi)
            @php
            $ext = pathinfo($aksara->dokumentasi, PATHINFO_EXTENSION);
            @endphp

            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
            <div class="doc-container">
                <img src="{{ asset('storage/' . $aksara->dokumentasi) }}"
                    alt="Dokumentasi {{ $aksara->nama_aksara }}"
                    class="img-fluid rounded shadow-sm doc-item">
            </div>
            @elseif (in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'webm']))
            <div class="doc-container">
                <video controls class="w-100 rounded shadow-sm doc-item">
                    <source src="{{ asset('storage/' . $aksara->dokumentasi) }}" type="video/{{ $ext }}">
                    Browser Anda tidak mendukung pemutaran video.
                </video>
            </div>
            @else
            <p class="text-muted fst-italic">Format dokumentasi tidak didukung.</p>
            @endif
            @else
            <p class="text-muted fst-italic">Tidak ada dokumentasi tersedia.</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer text-end">
            <a href="{{ url('aksara') }}" class="btn text-white" style="background-color: #1b81ae;">
                ← Kembali
            </a>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        AOS.init();

        var map = L.map('map').setView([-1.6101, 103.6158], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
        }).addTo(map);

        fetch("/{{ $aksara->wilayah->file_geojson }}")
            .then(response => response.json())
            .then(data => {
                var layer = L.geoJSON(data, {
                    style: {
                        color: "#1b81ae",
                        weight: 2,
                        fillColor: "#1b81ae",
                        fillOpacity: 0.3
                    }
                }).addTo(map);
                map.fitBounds(layer.getBounds());
            });
    });
</script>

<style>
    /* Dokumentasi agar proporsional dan tidak terpotong */
    .doc-container {
        overflow: hidden;
        border-radius: 10px;
        max-width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
        padding: 8px;
    }

    .doc-item {
        width: auto;
        max-width: 100%;
        max-height: 400px;
        height: auto;
        object-fit: contain;
        /* Menjaga agar gambar/video tidak terpotong */
        transition: transform 0.5s ease, box-shadow 0.3s ease;
    }

    .doc-container:hover .doc-item {
        transform: scale(1.03);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }
</style>
@endsection