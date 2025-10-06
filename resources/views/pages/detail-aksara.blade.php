@extends('layouts.app')

@section('title', 'Detail Bahasa')

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
                <div class="row mb-4">
                    <div class="col-md-6 border-end">
                        <h6 class="text-muted">Jumlah Penutur</h6>
                        <p class="fs-5 fw-semibold mb-0">± {{ number_format($aksara->jumlah_penutur) }} orang</p>
                    </div>
                    <div class="col-md-6">
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
                </div>

                <div class="mb-4">
                    <h5 class="text-muted">Deskripsi</h5>
                    <p class="text-justify fs-6">
                        {{ $aksara->deskripsi ?? 'Tidak ada deskripsi.' }}
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
                <a href="{{ url('/') }}" class="btn text-white" style="background-color: #1b81ae;">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([-1.6101, 103.6158], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
            }).addTo(map);

            // load geojson wilayah dari DB
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

                    // zoom ke geojson
                    map.fitBounds(layer.getBounds());
                });
        });
    </script>
@endsection
