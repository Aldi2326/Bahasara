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
    /* Ambil padding container bootstrap untuk margin kiri/kanan */
    .search-control {
        position: absolute;
        top: 15px;
        left: calc(var(--bs-gutter-x, 1.5rem)); /* gutter container */
        z-index: 1000;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        width: 250px;
    }

    .leaflet-top.leaflet-right {
        right: calc(var(--bs-gutter-x, 1.5rem)); /* tombol layer kanan atas */
        top: 15px;
    }
    .leaflet-bottom.leaflet-right {
        right: calc(var(--bs-gutter-x, 1.5rem)); /* tombol zoom kanan bawah */
        bottom: 15px;
    }
</style>

<!-- Script Leaflet -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map', {
            center: [-1.6101, 103.6158],
            zoom: 8,
            zoomControl: false
        });

        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var petaBahasa = L.layerGroup();
        var petaSastra = L.layerGroup();
        var petaAksara = L.layerGroup();

        L.marker([-1.6122, 103.6158]).bindPopup("Bahasa - Kota Jambi").addTo(petaBahasa);
        L.marker([-2.1342, 102.9502]).bindPopup("Sastra - Kabupaten Bungo").addTo(petaSastra);
        L.marker([-1.4852, 102.4381]).bindPopup("Aksara - Kabupaten Kerinci").addTo(petaAksara);

        var overlayMaps = {
            "Peta Bahasa": petaBahasa,
            "Peta Sastra": petaSastra,
            "Peta Aksara": petaAksara
        };
        L.control.layers(null, overlayMaps, { position: 'topright', collapsed: true }).addTo(map);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        var locations = {
            "Kota Jambi": [-1.6122, 103.6158],
            "Kabupaten Kerinci": [-1.4852, 102.4381],
            "Kabupaten Bungo": [-2.1342, 102.9502],
            "Kabupaten Merangin": [-2.0486, 102.2835],
        };

        for (var name in locations) {
            L.marker(locations[name]).addTo(map).bindPopup("<b>" + name + "</b>");
        }

        document.getElementById('languageSelect').addEventListener('change', function () {
            var selected = this.value;
            if (selected) {
                alert("Filter peta berdasarkan: " + selected);
            }
        });

        document.getElementById('searchInput').addEventListener('keyup', function (e) {
            var query = e.target.value.toLowerCase();
            for (var name in locations) {
                if (name.toLowerCase().includes(query)) {
                    var coords = locations[name];
                    map.setView(coords, 10);
                    break;
                }
            }
        });
    });
</script>
@endsection
