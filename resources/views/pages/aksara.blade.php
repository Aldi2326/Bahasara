@extends('layouts.app')

@section('title', 'Peta Aksara di Provinsi Jambi')

@section('content')
    <div class="mt-5 pt-5">
        <div style="position: relative;">
            <!-- Floating Control: Dropdown -->
            <form action="{{ route('peta.aksara') }}" method="GET" id="filterForm">
                <div class="search-control d-flex flex-wrap gap-3">

                    <!-- Custom Multi-Select Aksara -->
                    <div class="dropdown" style="margin-right: 10px;">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownAksara"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            -- Pilih Aksara --
                        </button>

                        <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                            aria-labelledby="dropdownAksara" id="aksaraListDropdown">
                            <li>
                                <label class="dropdown-item d-flex align-items-center gap-2">
                                    <input class="form-check-input aksara-checkbox" type="checkbox" name="aksara[]"
                                        value="Semua Aksara"
                                        {{ !empty($selectedAksara) && in_array('Semua Aksara', $selectedAksara) ? 'checked' : '' }}>
                                    <span>Semua Aksara</span>
                                </label>
                            </li>

                            {{-- Loop semua aksara --}}
                            @foreach ($allAksara as $b)
                                <li>
                                    <label class="dropdown-item d-flex align-items-center gap-2">
                                        <input class="form-check-input aksara-checkbox" type="checkbox" name="aksara[]"
                                            value="{{ $b->nama_aksara }}"
                                            {{ !empty($selectedAksara) && in_array($b->nama_aksara, $selectedAksara) ? 'checked' : '' }}>
                                        <span>{{ $b->nama_aksara }}</span>
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

            <!-- 🔹 LEGEND PETA -->
            <div id="legendCard" class="legend-card shadow">
                <h6 class="fw-bold mb-2">Keterangan Peta</h6>
                <div class="legend-item"><span class="legend-color" style="background:#FF0000"></span> Aksara Incung</div>
                <div class="legend-item"><span class="legend-color" style="background:#FFD700"></span> Aksara Arab Melayu
                </div>

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
            document.querySelectorAll('.aksara-checkbox, .wilayah-checkbox').forEach(cb => {
                cb.addEventListener('change', () => {
                    document.getElementById('filterForm').submit();
                });
            });

            // --- Data dari backend ---
            var wilayahData = @json($allWilayah); // ⬅️ gunakan semua wilayah, bukan $wilayah hasil filter
            var aksaraList = @json($aksaraList);

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

            // --- Marker aksara (berdasarkan filter) ---
            aksaraList.forEach(function(a) {
                if (a.lat && a.lng) {
                    let iconUrl = '';

                    switch (a.nama_aksara) {
                        case 'Aksara Incung':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png';
                            break;
                        case 'Aksara Arab Melayu':
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png';
                            break;
                        default:
                            iconUrl =
                                'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-grey.png';
                    }

                    const customIcon = L.icon({
                        iconUrl: iconUrl,
                        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                        iconSize: [30, 45],
                        iconAnchor: [15, 45],
                        popupAnchor: [0, -40],
                        shadowSize: [45, 45]
                    });

                    const marker = L.marker([a.lat, a.lng], {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindPopup(`
                <div style="
                    background: linear-gradient(135deg, #ffffff 0%, #fafaf9 100%);
                    padding: 14px 16px;
                    border-radius: 12px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
                    font-family: 'Poppins', sans-serif;
                    animation: fadeInPopup 0.4s ease-in-out;
                    width: 240px;
                ">
                    <div style="border-bottom: 1px solid #eee; padding-bottom: 6px; margin-bottom: 6px;">
                        <strong style="font-size: 16px; color: #b45309;">${a.nama_aksara}</strong>
                    </div>
                    <div style="font-size: 13px; color: #374151; line-height: 1.5;">
                            ✍️ <b>Koordinat:</b> ${a.lat.toFixed(4)}, ${a.lng.toFixed(4)}<br>
                            🗺️ <b>Wilayah:</b> ${a.nama_wilayah ? a.nama_wilayah : '-'}
                    </div>

                    <a href="{{ url('detail/aksara') }}/${a.id}"
                        style="
                            display: inline-block;
                            margin-top: 10px;
                            padding: 6px 12px;
                            background: linear-gradient(90deg, #f59e0b, #b45309);
                            color: #fff;
                            font-size: 13px;
                            font-weight: 500;
                            text-decoration: none;
                            border-radius: 6px;
                            transition: all 0.25s ease;
                        "
                        onmouseover="this.style.background='linear-gradient(90deg, #d97706, #92400e)'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.background='linear-gradient(90deg, #f59e0b, #b45309)'; this.style.transform='scale(1)';"
                    >
                        🔍 Lihat Detail
                    </a>
                </div>

                <style>
                    @keyframes fadeInPopup {
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                </style>
            `);
                }
            });
        });
    </script>
@endsection
