@extends('layouts.app')

@section('title', 'Detail Sastra')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 200px">
    <div class="card shadow-lg border-0 rounded-3">

        <!-- Header -->
        <div class="card-header text-white" style="background-color: #1b81ae;">
            <h3 class="mb-0">{{ $sastra->nama_sastra }}</h3>
            <small class="opacity-75">
                Wilayah: {{ $sastra->wilayah->nama_wilayah }}, Provinsi Jambi
            </small>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- STATUS -->
            <div class="mb-4" data-aos="fade-right" data-aos-duration="700">
                <h6 class="text-muted">Jenis Sastra</h6>
                <span
                    class="badge 
                    @if ($sastra->jenis == 'lisan') bg-success 
                    @elseif($sastra->jenis == 'tulisan') bg-warning text-dark 
                    @else bg-secondary @endif 
                    fs-6 px-3 py-2 rounded-pill">
                    {{ ucfirst($sastra->jenis) }}
                </span>
            </div>

            <!-- PETA SEBARAN -->
            <div class="mb-4" data-aos="zoom-in" data-aos-duration="1000">
                <h5 class="text-muted">Peta</h5>
                <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>
            <!-- DESKRIPSI -->
            <div class="mb-5" data-aos="fade-up" data-aos-duration="800">
                <h5 class="text-muted">Deskripsi</h5>
                <p class="text-justify fs-6">
                    {!! $sastra->deskripsi ?? 'Tidak ada deskripsi.' !!}
                </p>
            </div>

            <!-- DOKUMENTASI -->
            @if($sastra->gambar)
            <div class="mb-4 text-center" data-aos="fade-up" data-aos-duration="900">
                <h5 class="text-muted mb-3">Dokumentasi</h5>
                <img src="{{ asset('storage/' . $sastra->gambar) }}"
                    alt="{{ $sastra->nama_sastra }}"
                    class="img-fluid rounded shadow"
                    style="max-height: 450px; width: auto; object-fit: cover;">
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer text-end">
            <a href="{{ url('sastra') }}" class="btn text-white" style="background-color: #1b81ae;">
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

        // Ambil koordinat dari database
        var koordinat = "{{ $sastra->koordinat }}";

        // Default ke pusat Provinsi Jambi jika tidak ada koordinat
        var lat = -1.6101;
        var lng = 103.6158;
        var zoomLevel = 8;

        if (koordinat) {
            var coords = koordinat.split(",");
            lat = parseFloat(coords[0].trim());
            lng = parseFloat(coords[1].trim());
            zoomLevel = 11; // zoom lebih dekat jika titik ada
        }

        // Inisialisasi peta
        var map = L.map('map', {
            zoomControl: true,
            dragging: true,
            scrollWheelZoom: true,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false,
            tap: false
        }).setView([lat, lng], zoomLevel);

        // Tambahkan layer OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
        }).addTo(map);

        // Marker tetap (tidak bergerak)
        if (koordinat) {
            const iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png';

            const customIcon = L.icon({
                iconUrl: iconUrl,
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                iconSize: [30, 45],
                iconAnchor: [15, 45],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            // Marker tidak draggable dan tanpa animasi
            const marker = L.marker([lat, lng], {
                icon: customIcon,
                draggable: false
            }).addTo(map);

            marker.bindPopup(`
                <div style="
                    background:white;
                    padding:12px;
                    border-radius:10px;
                    box-shadow:0 4px 12px rgba(0,0,0,0.2);
                    animation: fadeInPopup 0.6s ease;">
                    <h6 style="margin:0; color:#1b81ae;"><strong>{{ $sastra->nama_sastra }}</strong></h6>
                    <small style="color:#555;">Wilayah: {{ $sastra->wilayah->nama_wilayah }}</small><br>
                    <small style="color:#777;">Koordinat: ${lat.toFixed(4)}, ${lng.toFixed(4)}</small><br>
                    <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" 
                       class="text-blue-600 hover:underline" style="display:inline-block;margin-top:6px;">
                        📍 Lihat di Google Maps
                    </a>
                </div>
            `).openPopup();
        }
    });
</script>

<style>
    /* Animasi popup */
    @keyframes fadeInPopup {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Efek card */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection