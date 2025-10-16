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
                            <input class="form-check-input bahasa-checkbox" type="checkbox"
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
        <div id="map" style="height: 680px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-radius:12px;"></div>

        <!-- Card Detail Bahasa -->
        <div id="languageCard" class="language-card shadow d-none">
            <h5 class="fw-bold mb-2" id="cardWilayah"></h5>
            <div id="cardList"></div>
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
                // TODO: Tambahkan aksi filter peta berdasarkan bahasa di sini
            });
        });

        wilayahCheckboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                updateButtonLabel(wilayahCheckboxes, wilayahBtn, '-- Pilih Wilayah --');
                // TODO: Tambahkan aksi filter peta berdasarkan wilayah di sini
            });
        });
    });
</script>

<!-- Custom Style -->
<style>
    .dropdown-menu label {
        cursor: pointer;
    }

    .dropdown-menu input {
        margin-right: 6px;
    }

    .dropdown-toggle::after {
        margin-left: 8px;
    }
</style>




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

    .language-card {
        position: absolute;
        bottom: 15px;
        left: calc(var(--bs-gutter-x, 1.5rem));
        background: white;
        border-radius: 8px;
        padding: 12px;
        width: 320px;
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
    }

    .language-item {
        padding: 8px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
    }

    .language-item:last-child {
        border-bottom: none;
    }

    .language-item:hover {
        background: #f9f9f9;
    }

    .language-name {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .language-desc {
        font-size: 0.85rem;
        color: #555;
        margin-bottom: 0;
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

        var jambiBounds = L.latLngBounds(
            L.latLng(-2.8, 101.1),
            L.latLng(0.5, 104.8)
        );

        var map = L.map('map', {
            center: [-1.6101, 103.6158],
            zoom: 9,
            zoomControl: false,
            maxBounds: jambiBounds,
            maxBoundsViscosity: 1.0
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Kontrol Zoom
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Card element
        var languageCard = document.getElementById("languageCard");
        var cardList = document.getElementById("cardList");
        var cardWilayah = document.getElementById("cardWilayah");

        var selectedLayer = null;
        var wilayahLayers = {};

        // Daftar warna terang
        const brightColors = [
            "#FF6B6B", "#FFD93D", "#6BCB77",
            "#4D96FF", "#A66CFF", "#FF9F1C", "#FF66C4"
        ];

        let angka = 0;

        // 🔹 Tambahkan marker berdasarkan koordinat bahasa
        bahasaList.forEach(function(b) {
            if (b.lat && b.lng) {
                const marker = L.marker([b.lat, b.lng])
                    .addTo(map)
                    .bindPopup(`
                        <strong>${b.nama_bahasa}</strong><br>
                        Koordinat: ${b.lat.toFixed(4)}, ${b.lng.toFixed(4)}
                    `);
            }
        });

        // 🔹 Load GeoJSON per wilayah
        wilayahData.forEach(function(wilayah) {
            if (wilayah.file_geojson) {
                fetch('/' + wilayah.file_geojson)
                    .then(response => response.json())
                    .then(data => {
                        const color = "#FF6B6B";
                        angka++;

                        var geojsonLayer = L.geoJSON(data, {
                            style: {
                                color: color,
                                weight: 2,
                                opacity: 1,
                                fillColor: color,
                                fillOpacity: 0
                            },
                            onEachFeature: function(feature, layer) {
                                layer.on("click", function() {
                                    cardWilayah.textContent = wilayah.nama_wilayah;
                                    cardList.innerHTML = "";
                                    wilayah.bahasa.forEach(function(b) {
                                        var div = document.createElement("div");
                                        div.classList.add("language-item");
                                        div.innerHTML = `
                                            <div class="language-name">${b.nama_bahasa}</div>
                                            <div>Status: ${b.status}</div>
                                            <div>Penutur: ${b.jumlah_penutur.toLocaleString()}</div>
                                        `;
                                        div.addEventListener("click", function() {
                                            window.location.href = "/detail/bahasa/" + b.id;
                                        });
                                        cardList.appendChild(div);
                                    });
                                    languageCard.classList.remove("d-none");
                                });
                            }
                        }).addTo(map);

                        wilayahLayers[wilayah.id] = {
                            layer: geojsonLayer,
                            data: wilayah
                        };
                    })
                    .catch(error => console.error("Error loading GeoJSON:", error));
            }
        });

        // 🔹 Filter Bahasa
        document.getElementById("languageSelect").addEventListener("change", function() {
            var selectedBahasa = this.value;

            Object.values(wilayahLayers).forEach(function(w) {
                w.layer.setStyle({
                    color: "transparent",
                    weight: 2,
                    opacity: 0,
                    fillOpacity: 0
                });
            });

            if (selectedBahasa) {
                Object.values(wilayahLayers).forEach(function(w) {
                    var bahasaMatch = w.data.bahasa.find(b => b.nama_bahasa === selectedBahasa);
                    if (bahasaMatch) {
                        w.layer.setStyle({
                            color: "blue",
                            weight: 3,
                            opacity: 1,
                            fillColor: "blue",
                            fillOpacity: 0.3
                        });
                    }
                });

                // 🔸 Zoom ke marker bahasa yang dipilih
                var selected = bahasaList.find(b => b.nama_bahasa === selectedBahasa);
                if (selected && selected.lat && selected.lng) {
                    map.setView([selected.lat, selected.lng], 10);
                }
            }
        });
    });
</script>
@endsection