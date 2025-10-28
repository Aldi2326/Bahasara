@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
    <div class="mt-5 pt-5">
        <div style="position: relative;">
            <!-- Floating Control: Dropdown + Search -->
            <form action="{{ route('peta.index') }}" method="GET" id="filterForm">
                <div class="search-control d-flex flex-wrap gap-3">

                    <!-- Custom Multi-Select Bahasa -->
                    <div class="dropdown" style="margin-right: 10px;">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownBahasa"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            -- Pilih Bahasa --
                        </button>

                        <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                            aria-labelledby="dropdownBahasa" id="bahasaListDropdown">
                            <li>
                                <label class="dropdown-item d-flex align-items-center gap-2">
                                    <input class="form-check-input bahasa-checkbox" type="checkbox" name="bahasa[]"
                                        value="Semua Bahasa"
                                        {{ !empty($selectedBahasa) && in_array('Semua Bahasa', $selectedBahasa) ? 'checked' : '' }}>
                                    <span>Semua Bahasa</span>
                                </label>
                            </li>

                            {{-- Loop semua bahasa --}}
                            @foreach ($allBahasa as $b)
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2">
                                        <input class="form-check-input bahasa-checkbox" type="checkbox" name="bahasa[]"
                                            value="{{ $b->nama_bahasa }}"
                                            {{ !empty($selectedBahasa) && in_array($b->nama_bahasa, $selectedBahasa) ? 'checked' : '' }}>
                                        <span>{{ $b->nama_bahasa }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Custom Multi-Select Wilayah -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownWilayah"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            -- Pilih Wilayah --
                        </button>

                        <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                            aria-labelledby="dropdownWilayah" id="wilayahListDropdown">
                            <li>
                                <label class="dropdown-item d-flex align-items-center gap-2">
                                    <input class="form-check-input wilayah-checkbox" type="checkbox" name="wilayah[]"
                                        value="Semua Wilayah"
                                        {{ !empty($selectedWilayah) && in_array('Semua Wilayah', $selectedWilayah) ? 'checked' : '' }}>
                                    <span>Semua Wilayah</span>
                                </label>
                            </li>

                            {{-- Loop semua wilayah --}}
                            @foreach ($allWilayah as $w)
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2">
                                        <input class="form-check-input wilayah-checkbox" type="checkbox" name="wilayah[]"
                                            value="{{ $w->nama_wilayah }}"
                                            {{ !empty($selectedWilayah) && in_array($w->nama_wilayah, $selectedWilayah) ? 'checked' : '' }}>
                                        <span>{{ $w->nama_wilayah }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </form>


            <!-- Peta -->
            <div id="map"
                style="height: 680px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-radius:12px; position: relative;"></div>

            <!-- 🔹 LEGEND PETA-->
            <div id="legendCard" class="legend-card shadow">
                <h6 class="fw-bold mb-2">Keterangan Peta</h6>
                <div class="legend-item"><span class="legend-color" style="background:#FF0000"></span> Bahasa Melayu Jambi
                </div>
                <div class="legend-item"><span class="legend-color" style="background:#FFD700"></span> Bahasa Bajau Tungkal
                    Satu</div>
                <div class="legend-item"><span class="legend-color" style="background:#0000FF"></span> Bahasa Banjar</div>
                <div class="legend-item"><span class="legend-color" style="background:#008000"></span> Bahasa Bugis</div>
                <div class="legend-item"><span class="legend-color" style="background:#FFA500"></span> Bahasa Kerinci</div>
                <div class="legend-item"><span class="legend-color" style="background:#8A2BE2"></span> Bahasa Minangkabau
                </div>
                <div class="legend-item"><span class="legend-color" style="background:#808080"></span> Bahasa Jawa</div>
            </div>
        </div>
    </div>



    <!-- Custom CSS -->
    <style>
        .search-control {
            position: absolute;
            top: 15px;
            left: calc(var(--bs-gutter-x, 1.5rem));
            z-index: 1000;
            padding: 10px;
            border-radius: 8px;
        }

        .legend-card {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            border-radius: 12px;
            padding: 12px 16px;
            width: 220px;
            z-index: 500;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            border-left: 4px solid #0d6efd;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .legend-color {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            margin-right: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .leaflet-popup-content-wrapper {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(4px);
            color: #000;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .leaflet-popup-tip {
            background-color: rgba(255, 255, 255, 0.95) !important;
        }
    </style>

    <!-- Script Leaflet -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- Auto submit filter form ---
            document.querySelectorAll('.bahasa-checkbox, .wilayah-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    document.getElementById('filterForm').submit();
                });
            });

            // --- Data dari backend ---
            var wilayahData = @json($allWilayah); // ⬅️ gunakan semua wilayah, bukan $wilayah hasil filter
            var bahasaList = @json($bahasaList);

            // --- Peta dasar ---
            var jambiBounds = L.latLngBounds(
                L.latLng(-2.85, 101.0),
                L.latLng(0.60, 104.9)
            );

            var map = L.map('map', {
                zoomControl: false
            });
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            map.fitBounds(jambiBounds);
            L.control.zoom({
                position: 'bottomright'
            }).addTo(map);

            var wilayahLayers = {};

            // --- Tampilkan SEMUA GeoJSON wilayah ---
            wilayahData.forEach(function(wilayah) {
                if (wilayah.file_geojson) {
                    fetch('/' + wilayah.file_geojson)
                        .then(res => res.json())
                        .then(data => {
                            var color = "#FF6B6B";
                            var geojsonLayer = L.geoJSON(data, {
                                style: {
                                    color: color,
                                    weight: 2,
                                    opacity: 1,
                                    fillColor: color,
                                    fillOpacity: 0
                                }
                            }).addTo(map);
                            wilayahLayers[wilayah.id] = {
                                layer: geojsonLayer,
                                data: wilayah
                            };
                        })
                        .catch(err => console.error("Error loading GeoJSON:", err));
                }
            });

            // --- Marker bahasa (berdasarkan filter) ---
            bahasaList.forEach(function(b) {
                if (b.lat && b.lng) {
                    let iconUrl = '';

                    switch (b.nama_bahasa) {
                        case 'Bahasa Melayu Jambi':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png';
                            break;
                        case 'Bahasa Bajau Tungkal Satu':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png';
                            break;
                        case 'Bahasa Banjar':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png';
                            break;
                        case 'Bahasa Bugis':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png';
                            break;
                        case 'Bahasa Kerinci':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png';
                            break;
                        case 'Bahasa Minangkabau':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png';
                            break;
                        case 'Bahasa Jawa':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-grey.png';
                            break;
                        default:
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png';
                    }

                    const customIcon = L.icon({
                        iconUrl: iconUrl,
                        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    L.marker([b.lat, b.lng], {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindPopup(`
                            <div style="background:white; padding:8px; border-radius:4px;">
                                <strong>${b.nama_bahasa}</strong><br>
                                Koordinat: ${b.lat.toFixed(4)}, ${b.lng.toFixed(4)}<br>
                                Alamat: ${b.alamat}<br>
                                <a href="{{ url('detail/bahasa') }}/${b.id}"
                                class="text-blue-600 hover:underline mt-2 inline-block">
                                Lihat Detail
                                </a>
                            </div>
                        `);

                }
            });
        });
    </script>

@endsection
