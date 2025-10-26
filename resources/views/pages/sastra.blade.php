@extends('layouts.app')

@section('title', 'Peta Sastra di Provinsi Jambi')

@section('content')
<div class="mt-5 pt-5">
    <div style="position: relative;">
        <!-- Floating Control: Dropdown + Search -->
        <div class="search-control d-flex flex-wrap gap-3">
            <!-- Custom Multi-Select Sastra -->
            <div class="dropdown" style="margin-right: 10px;">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownSastra" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    -- Pilih Sastra --
                </button>
                <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;"
                    aria-labelledby="dropdownSastra" id="sastraListDropdown">
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input sastra-checkbox" type="checkbox"
                                value="Semua Sastra">
                            <span>Semua Sastra</span>
                        </label>
                    </li>
                    @foreach ($sastraList as $s)
                    <li>
                        <label class="dropdown-item d-flex align-items-center gap-2">
                            <input class="form-check-input sastra-checkbox" type="checkbox"
                                value="{{ $s->nama_sastra }}">
                            <span>{{ $s->nama_sastra }}</span>
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

        <!-- 🔹 LEGEND PETA -->
        <div id="legendCard" class="legend-card shadow">
            <h6 class="fw-bold mb-2">Keterangan Peta</h6>
            <div class="legend-item"><span class="legend-color" style="background:#FF0000"></span> Puisi Rakyat</div>
            <div class="legend-item"><span class="legend-color" style="background:#008000"></span> Cerita Rakyat</div>
            <div class="legend-item"><span class="legend-color" style="background:#0000FF"></span> Syair / Pantun</div>
            <div class="legend-item"><span class="legend-color" style="background:#FFA500"></span> Teks Keagamaan</div>
            <div class="legend-item"><span class="legend-color" style="background:#800080"></span> Naskah Kuno</div>
        </div>
    </div>
</div>

<!-- Script untuk handle pilihan -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sastraCheckboxes = document.querySelectorAll('.sastra-checkbox');
        const wilayahCheckboxes = document.querySelectorAll('.wilayah-checkbox');
        const sastraBtn = document.getElementById('dropdownSastra');
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

        sastraCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                updateButtonLabel(sastraCheckboxes, sastraBtn, '-- Pilih Sastra --');
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
        var sastraList = @json($sastraList);

        var jambiBounds = L.latLngBounds(
            L.latLng(-2.85, 101.0),
            L.latLng(0.60, 104.9)
        );

        var map = L.map('map', {
            zoomControl: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.fitBounds(jambiBounds);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // 🔹 Marker Sastra
        sastraList.forEach(function(s) {
            if (s.lat && s.lng) {
                let iconUrl = '';

                if (s.jenis_sastra === 'Puisi Rakyat') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png';
                } else if (s.jenis_sastra === 'Cerita Rakyat') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png';
                } else if (s.jenis_sastra === 'Syair' || s.jenis_sastra === 'Pantun') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png';
                } else if (s.jenis_sastra === 'Teks Keagamaan') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png';
                } else if (s.jenis_sastra === 'Naskah Kuno') {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-violet.png';
                } else {
                    iconUrl = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-grey.png';
                }

                const customIcon = L.icon({
                    iconUrl: iconUrl,
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([s.lat, s.lng], { icon: customIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="background:white; padding:8px; border-radius:4px;">
                            <strong>${s.nama_sastra}</strong><br>
                            Jenis: ${s.jenis_sastra}<br>
                            Wilayah: ${s.wilayah.nama_wilayah}<br>
                            <a href="/detail/sastra/${s.id}" class="btn btn-sm btn-primary mt-1">Lihat Detail</a>
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
                    })
                    .catch(err => console.error("Error loading GeoJSON:", err));
            }
        });
    });
</script>
@endsection
