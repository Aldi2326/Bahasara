@extends('layouts.app')

@section('title', 'Detail Bahasa')

@section('content')
<div class="container" style="margin-top: 150px; margin-bottom: 200px">
    <div class="card shadow-lg border-0 rounded-3">
        
        <!-- Header -->
        <div class="card-header text-white" style="background-color: #1b81ae;">
            <h3 class="mb-0">Bahasa Incung</h3>
            <small class="opacity-75">Wilayah: Kerinci, Provinsi Jambi</small>
        </div>

        <!-- Body -->
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-muted">Jumlah Penutur</h6>
                    <p class="fs-5 fw-semibold mb-0">± 1.500 orang</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Status Bahasa</h6>
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">
                        Terancam Punah
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="text-muted">Deskripsi</h5>
                <p class="text-justify fs-6">
                    Bahasa Incung adalah bahasa daerah masyarakat Kerinci, Provinsi Jambi. 
                    Keunikannya terletak pada aksara kuno bernama <strong>Aksara Incung</strong> 
                    yang ditemukan pada naskah manuskrip. 
                </p>
                <p class="text-justify fs-6">
                    Saat ini, penggunaan bahasa ini semakin terbatas dan umumnya dipertahankan dalam 
                    upacara adat, kegiatan budaya, serta penelitian akademik. Upaya revitalisasi 
                    dilakukan melalui komunitas lokal dan pendidikan budaya.
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
        // Inisialisasi map
        var map = L.map('map').setView([-2.0833, 101.4], 9); // koordinat Kerinci, zoom level 9

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
        }).addTo(map);

        // Load GeoJSON eksternal
        fetch("{{ asset('geojson/kerinci.geojson') }}")
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    style: {
                        color: "#1b81ae",
                        weight: 2,
                        fillColor: "#1b81ae",
                        fillOpacity: 0.3
                    }
                }).addTo(map);
            });
    });
</script>
@endsection
