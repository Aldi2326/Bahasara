@extends('layouts.app')

@section('title', 'Detail Aksara')

@section('content')
    <div class="container" style="margin-top: 150px; margin-bottom: 200px">
        <div class="card shadow-lg border-0 rounded-3">

            <!-- Header -->
            <div class="card-header text-white" style="background-color: #1b81ae;">
                <h3 class="mb-0">{{ $aksara->namaaksara->nama_aksara }}</h3>
                <small class="opacity-75">
                    Wilayah: {{ $aksara->wilayah->nama_wilayah }}, Provinsi Jambi
                </small>
            </div>

            <!-- Body -->
            <div class="card-body">

                <!-- STATUS AKSARA -->
                <div class="mb-4" data-aos="fade-left" data-aos-duration="700">
                    <h6 class="text-muted">Status Aksara</h6>
                    <span class="badge text-white fs-6 px-3 py-2 rounded-pill"
                        style="
                        @if (strtolower($aksara->status) == 'aktif') background-color:#22C55E;
                        @elseif (strtolower($aksara->status) == 'terancam punah') background-color:#EAB308;
                        @else background-color:#EF4444; @endif
                    ">
                        {{ $aksara->status }}
                    </span>
                </div>

                <!-- ALAMAT -->
                <div class="mb-4" data-aos="fade-right" data-aos-duration="700">
                    <h6 class="text-muted">Alamat</h6>
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                        <p class="mb-0 text-dark fs-6">
                            {!! $aksara->alamat ?? 'Alamat tidak tersedia.' !!}
                        </p>
                    </div>
                </div>

                <!-- PETA -->
                <div class="mb-4" data-aos="zoom-in" data-aos-duration="1000">
                    <h5 class="text-muted">Peta Sebaran</h5>
                    <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
                </div>

                <!-- DOKUMENTASI -->
                @if ($aksara->dokumentasi)
                    <div class="mb-5 text-center" data-aos="fade-up" data-aos-duration="900">
                        <h5 class="text-muted mb-3">Dokumentasi</h5>

                        @php
                            $filePath = asset('storage/' . $aksara->dokumentasi);
                            $extension = strtolower(pathinfo($aksara->dokumentasi, PATHINFO_EXTENSION));
                        @endphp

                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ $filePath }}" class="img-fluid rounded shadow mb-3"
                                style="max-height:450px; width:auto; object-fit:cover;">
                        @elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'webm']))
                            <video controls class="w-100 rounded shadow mb-3" style="max-height:450px;">
                                <source src="{{ $filePath }}" type="video/{{ $extension }}">
                            </video>
                        @elseif ($extension === 'pdf')
                            <div class="ratio ratio-16x9 shadow mb-3">
                                <iframe src="{{ $filePath }}" class="rounded"></iframe>
                            </div>
                            <a href="{{ $filePath }}" target="_blank" class="btn btn-outline-primary">
                                📂 Buka PDF
                            </a>
                        @else
                            <p class="text-muted">Format dokumentasi tidak dikenali atau tidak dapat ditampilkan.</p>
                            <a href="{{ $filePath }}" class="btn btn-outline-secondary" target="_blank">
                                🔗 Lihat File
                            </a>
                        @endif
                    </div>
                @endif

                <!-- DESKRIPSI -->
                <div class="mb-5" data-aos="fade-up" data-aos-duration="800">
                    <h5 class="text-muted mb-3">Deskripsi</h5>

                    <div class="deskripsi-konten">
                        {!! $aksara->deskripsi ?? 'Tidak ada deskripsi.' !!}
                    </div>
                </div>

                @if (!empty($aksara->dokumentasi_yt))
                    @php
                        $youtubeId = null;

                        if (str_contains($aksara->dokumentasi_yt, 'youtu.be')) {
                            preg_match('/youtu\.be\/([^\?]+)/', $aksara->dokumentasi_yt, $matches);
                            $youtubeId = $matches[1] ?? null;
                        } elseif (str_contains($aksara->dokumentasi_yt, 'youtube.com')) {
                            preg_match('/v=([^\&]+)/', $aksara->dokumentasi_yt, $matches);
                            $youtubeId = $matches[1] ?? null;
                        }
                    @endphp

                    @if ($youtubeId)
                        <div class="mb-5" data-aos="zoom-in" data-aos-duration="900">
                            <h5 class="text-muted mb-3">Video Terkait</h5>

                            <div class="w-full aspect-video">
                                <iframe width="100%" height="500"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" class="w-full h-full rounded"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @endif
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
                maxZoom: 19,
                attribution: '&copy; OSM'
            }).addTo(map);

            fetch("/{{ $aksara->wilayah->file_geojson }}")
                .then(response => response.json())
                .then(data => {
                    var geoLayer = L.geoJSON(data, {
                        style: {
                            color: "#1b81ae",
                            weight: 2,
                            fillColor: "#1b81ae",
                            fillOpacity: 0.25
                        }
                    }).addTo(map);

                    map.fitBounds(geoLayer.getBounds());

                    var center = geoLayer.getBounds().getCenter();

                    const customIcon = L.icon({
                        iconUrl: "https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png",
                        shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
                        iconSize: [30, 45],
                        iconAnchor: [15, 45],
                        popupAnchor: [1, -34]
                    });

                    const marker = L.marker([center.lat, center.lng], {
                        icon: customIcon
                    }).addTo(map);

                    marker.bindPopup(`
                    <div style="background:white; padding:12px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.2); animation: fadeInPopup 0.6s ease;">
                        <h6 style="margin:0; color:#1b81ae;"><strong>{{ $aksara->nama_aksara }}</strong></h6>
                        <small style="color:#555;">Wilayah: {{ $aksara->wilayah->nama_wilayah }}</small><br>
                        <a href="https://www.google.com/maps?q=${center.lat},${center.lng}" target="_blank" style="display:inline-block; margin-top:6px;">
                            📍 Lihat di Google Maps
                        </a>
                    </div>
                `).openPopup();
                });
        });
    </script>

    <style>
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

        .card {
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .15);
        }

        .deskripsi-konten {
            font-size: 1rem;
            line-height: 1.9;
            text-align: justify;
            color: #333;
            padding: 18px 20px;
            background: #fafafa;
            border-radius: 10px;
            border-left: 4px solid #1b81ae;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .05);
        }

        .card-body {
            padding-left: 45px !important;
            padding-right: 45px !important;
        }
    </style>
@endsection
