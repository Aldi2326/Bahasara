@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div class="mt-5">
    <h2 class="text-center fw-bold mb-3">Peta Provinsi Jambi</h2>

    <!-- Map Container -->
    <div style="position: relative;">
        <!-- Floating Control: Dropdown + Search -->
        <div class="search-control">
            <!-- Dropdown Bahasa -->
            <select id="languageSelect" class="form-select form-select-sm mb-2">
                <option value="">-- Pilih Bahasa --</option>
                <option value="bahasa_incung">Bahasa Incung</option>
                <option value="bahasa_melayu">Bahasa Melayu Jambi</option>
                <option value="bahasa_kerinci">Bahasa Kerinci</option>
                <option value="bahasa_batin">Bahasa Batin</option>
            </select>

            <!-- Input Search -->
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari bahasa...">
        </div>

        <!-- Peta -->
        <div id="map" style="height: 680px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-radius:12px;"></div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .search-control {
        position: absolute;
        top: 15px;
        left: calc(var(--bs-gutter-x, 1.5rem));
        z-index: 1000;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        width: 250px;
    }

    .leaflet-top.leaflet-right {
        right: calc(var(--bs-gutter-x, 1.5rem));
        top: 15px;
    }
    .leaflet-bottom.leaflet-right {
        right: calc(var(--bs-gutter-x, 1.5rem));
        bottom: 15px;
    }
</style>

<!-- Script Leaflet -->
<!-- Script Leaflet -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil data bahasa dari controller
        var bahasaData = @json($bahasa);

        // Definisi bounding box untuk Jambi
        var jambiBounds = L.latLngBounds(
            L.latLng(-2.8, 101.1), // Southwest
            L.latLng(0.5, 104.8)   // Northeast
        );

        var map = L.map('map', {
            center: [-1.6101, 103.6158],
            zoom: 8,
            zoomControl: false,
            maxBounds: jambiBounds,
            maxBoundsViscosity: 1.0
        });

        // Base map
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Layer kontrol
        var overlayMaps = {};
        L.control.layers(null, overlayMaps, { position: 'topright', collapsed: true }).addTo(map);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Loop data bahasa untuk load geojson masing-masing
        bahasaData.forEach(function (item) {
            if (item.geojson) {
                fetch('/wilayah/' + item.geojson)
                    .then(response => response.json())
                    .then(data => {
                        var geojsonLayer = L.geoJSON(data, {
                            style: {
                                color: "blue",
                                weight: 2,
                                fillOpacity: 0
                            },
                            onEachFeature: function (feature, layer) {
                                var popupContent = `
                                    <b>${item.nama_bahasa}</b><br>
                                    Status: ${item.status}<br>
                                    Jumlah Penutur: ${item.jumlah_penutur}<br>
                                    <small>${item.deskripsi}</small>
                                `;
                                layer.bindPopup(popupContent);
                            }
                        }).addTo(map);

                        overlayMaps[item.nama_bahasa] = geojsonLayer;
                    })
                    .catch(error => console.error("Error loading GeoJSON:", error));
            }
        });

        // Event dropdown
        document.getElementById('languageSelect').addEventListener('change', function () {
            var selected = this.value.toLowerCase();
            if (selected) {
                var found = bahasaData.find(b => b.nama_bahasa.toLowerCase().includes(selected));
                if (found) {
                    alert("Filter peta berdasarkan: " + found.nama_bahasa);
                }
            }
        });

        // Event search
        document.getElementById('searchInput').addEventListener('keyup', function (e) {
            var query = e.target.value.toLowerCase();
            var found = bahasaData.find(b => b.nama_bahasa.toLowerCase().includes(query));
            if (found) {
                console.log("Ditemukan:", found.nama_bahasa);
            }
        });
    });
</script>

@endsection
