@extends('layouts.app')

@section('title', 'Detail Sastra')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 200px">
    <div class="card shadow-lg border-0 rounded-3">
        
        <!-- Header -->
        <div class="card-header text-white" style="background-color: #1b81ae;">
            <h3 class="mb-0">{{ $sastra->nama_sastra }}</h3>
            <small class="opacity-75">Wilayah: {{ $sastra->wilayah->nama_wilayah }}, Provinsi Jambi</small>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Status Sastra</h6>
                    <span
                            class="badge 
                        @if ($sastra->jenis == 'lisan') bg-success 
                        @elseif($sastra->jenis == 'tulisan') bg-warning text-dark 
                        @else bg-secondary @endif 
                        fs-6 px-3 py-2 rounded-pill">
                            {{ $sastra->jenis }}
                        </span>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-muted">Deskripsi</h5>
                <p class="text-justify fs-6">
                        {{ $sastra->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
            </div>

            <!-- Peta Leaflet -->
            <div class="mb-4">
                <h5 class="text-muted">Peta Sebaran</h5>
                <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>
        </div>

        <!-- Footer -->
        <div class="card-footer text-end">
            <a href="/" 
               class="btn text-white" 
               style="background-color: #1b81ae; border: none; color: #fff;" 
               onmouseover="this.style.backgroundColor='#1b81ae'; this.style.color='#fff';" 
               onmouseout="this.style.backgroundColor='#1b81ae'; this.style.color='#fff';">
                ← Kembali
            </a>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil koordinat dari Laravel
        var koordinat = "{{ $sastra->koordinat }}";

        // Default fallback (misalnya pusat Jambi)
        var lat = -1.6;
        var lng = 103.6;
        var zoomLevel = 8;

        if (koordinat) {
            var coords = koordinat.split(",");
            lat = parseFloat(coords[0].trim());
            lng = parseFloat(coords[1].trim());
            zoomLevel = 11; // zoom lebih dekat kalau ada titik
        }

        // Inisialisasi map
        var map = L.map('map').setView([lat, lng], zoomLevel);

        // Tambahkan tile layer OSM
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker jika ada koordinat
        if (koordinat) {
            L.marker([lat, lng]).addTo(map)
        }
    });
</script>

@endsection
