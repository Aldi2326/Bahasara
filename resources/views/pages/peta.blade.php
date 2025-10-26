@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div class="mt-5 pt-5">
    <div style="position: relative;">
        <!-- Floating Control: Dropdown + Search -->
        <div class="search-control d-flex flex-wrap gap-3">
            <!-- Custom Multi-Select Bahasa -->
            <div class="dropdown" style="margin-right: 10px;">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownBahasa" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    -- Pilih Bahasa --
                </button>
                <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                    aria-labelledby="dropdownBahasa" id="bahasaListDropdown">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input bahasa-checkbox" type="checkbox"
                                value="Semua Bahasa">
                            <span>Semua Bahasa</span>
                        </label>
                    </li>
                    @foreach ($bahasaList as $b)
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input bahasa-checkbox" type="checkbox"
                                value="{{ $b->nama_bahasa }}">
                            <span>{{ $b->nama_bahasa }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Custom Multi-Select Wilayah -->
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownWilayah" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    -- Pilih Wilayah --
                </button>
                <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                    aria-labelledby="dropdownWilayah" id="wilayahListDropdown">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input wilayah-checkbox" type="checkbox"
                                value="Semua Wilayah">
                            <span>Semua Wilayah</span>
                        </label>
                    </li>
                    @foreach ($wilayah as $w)
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input wilayah-checkbox" type="checkbox"
                                value="{{ $w->nama_wilayah }}">
                            <span>{{ $w->nama_wilayah }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Peta -->
        <div id="map" style="height: 680px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-radius:12px; position: relative;"></div>

        <!-- 🔹 LEGEND PETA-->
        <div id="legendCard" class="legend-card shadow">
            <h6 class="fw-bold mb-2">Keterangan Peta</h6>
            <div class="legend-item"><span class="legend-color" style="background:#FF0000"></span> Bahasa Melayu Jambi</div>
            <div class="legend-item"><span class="legend-color" style="background:#FFD700"></span> Bahasa Bajau Tungkal Satu</div>
            <div class="legend-item"><span class="legend-color" style="background:#0000FF"></span> Bahasa Banjar</div>
            <div class="legend-item"><span class="legend-color" style="background:#008000"></span> Bahasa Bugis</div>
            <div class="legend-item"><span class="legend-color" style="background:#FFA500"></span> Bahasa Kerinci</div>
            <div class="legend-item"><span class="legend-color" style="background:#8A2BE2"></span> Bahasa Minangkabau</div>
            <div class="legend-item"><span class="legend-color" style="background:#808080"></span> Bahasa Jawa</div>
        </div>
    </div>
</div>

<!-- Script untuk handle pilihan -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bahasaCheckboxes = document.querySelectorAll('.bahasa-checkbox');
        const wilayahCheckboxes = document.querySelectorAll('.wilayah-checkbox');
        const bahasaBtn = document.getElementById('dropdownBahasa');
        const wilayahBtn = document.getElementById('dropdownWilayah');

        function updateButtonLabel(checkboxes, button, placeholder) {
            const checked = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (checked.length === 0) {
                button.textContent = placeholder;
            } else if (checked.length === 1) {
                button.textContent = checked[0];
            } else {
                button.textContent = checked.length + ' dipilih';
            }
        }

        bahasaCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                updateButtonLabel(bahasaCheckboxes, bahasaBtn, '-- Pilih Bahasa --');
            });
        });

        wilayahCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                updateButtonLabel(wilayahCheckboxes, wilayahBtn, '-- Pilih Wilayah --');
            });
        });
    });
</script>

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
        z-index: 1500;
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
        var wilayahData = @json($wilayah);
        var bahasaList = @json($bahasaList);

        // 🔹 Batas geografis provinsi Jambi
        var jambiBounds = L.latLngBounds(
            L.latLng(-2.85, 101.0),
            L.latLng(0.60, 104.9)
        );

        // 🔹 Inisialisasi peta tanpa batas zoom
        var map = L.map('map', {
            zoomControl: false
        });

        // 🔹 Tambahkan tile layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // 🔹 Fokus otomatis ke wilayah Jambi
        map.fitBounds(jambiBounds);

        // 🔹 Zoom control di kanan bawah
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        var wilayahLayers = {};

        // 🔹 Marker Bahasa
        bahasaList.forEach(function(b) {
            if (b.lat && b.lng) {
                let iconUrl = '';

                if (b.nama_bahasa === 'Bahasa Melayu Jambi') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png';
                } else if (b.nama_bahasa === 'Bahasa Bajau Tungkal Satu') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-yellow.png';
                } else if (b.nama_bahasa === 'Bahasa Bajar') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png';
                } else if (b.nama_bahasa === 'Bahasa Bugis') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png';
                } else if (b.nama_bahasa === 'Bahasa Kerinci') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png';
                } else if (b.nama_bahasa === 'Bahasa Minangkabau') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png';
                } else if (b.nama_bahasa === 'Bahasa Jawa') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-grey.png';
                } else {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-black.png';
                }
                
                const customIcon = L.icon({
                    iconUrl: iconUrl,
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([b.lat, b.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="background:white; padding:8px; border-radius:4px;">
                            <strong>${b.nama_bahasa}</strong><br>
                            Koordinat: ${b.lat.toFixed(4)}, ${b.lng.toFixed(4)}
                        </div>
                    `);
            }
        });

        // 🔹 GeoJSON Wilayah
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
    });
</script>
@endsection
