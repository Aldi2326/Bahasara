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
                <option value="">-- Pilih Aksara --</option>
                @foreach($wilayah as $w)
                    @foreach($w->bahasa as $b)
                        <option value="{{ $b->id }}">{{ $b->nama_bahasa }}</option>
                    @endforeach
                @endforeach
            </select>

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
</style>

<!-- Script Leaflet -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    var wilayahData = @json($wilayah);

    var jambiBounds = L.latLngBounds(
        L.latLng(-2.8, 101.1),
        L.latLng(0.5, 104.8)
    );

    var map = L.map('map', {
        center: [-1.6101, 103.6158],
        zoom: 8,
        zoomControl: false,
        maxBounds: jambiBounds,
        maxBoundsViscosity: 1.0
    });

    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // Card element
    var languageCard = document.getElementById("languageCard");
    var cardList = document.getElementById("cardList");
    var cardWilayah = document.getElementById("cardWilayah");

    var selectedLayer = null;
    var wilayahLayers = {};

    // Load GeoJSON per wilayah
    wilayahData.forEach(function (wilayah) {
        if (wilayah.geojson) {
            fetch('/wilayah/' + wilayah.geojson)
                .then(response => response.json())
                .then(data => {
                    var geojsonLayer = L.geoJSON(data, {
                        style: {
                            color: "blue",
                            weight: 2,
                            fillOpacity: 0,
                            opacity: 0
                        },
                        onEachFeature: function (feature, layer) {
                            layer.on("mouseover", function () {
                                if (selectedLayer !== layer) {
                                    layer.setStyle({ opacity: 1 });
                                }
                            });
                            layer.on("mouseout", function () {
                                if (selectedLayer !== layer) {
                                    layer.setStyle({ opacity: 0 });
                                }
                            });
                            layer.on("click", function () {
                                if (selectedLayer && selectedLayer !== layer) {
                                    selectedLayer.setStyle({ opacity: 0 });
                                }
                                selectedLayer = layer;
                                layer.setStyle({ opacity: 1 });

                                cardWilayah.textContent = wilayah.nama_wilayah;
                                cardList.innerHTML = "";
                                wilayah.bahasa.forEach(function (b) {
                                    var div = document.createElement("div");
                                    div.classList.add("language-item");
                                    div.innerHTML = `
                                        <div class="language-name">${b.nama_bahasa}</div>
                                        <div>Status: ${b.status}</div>
                                        <div>Penutur: ${b.jumlah_penutur.toLocaleString()}</div>
                                    `;
                                    div.addEventListener("click", function () {
                                        window.location.href = "/detail/aksara";
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

    // Event select bahasa
    document.getElementById("languageSelect").addEventListener("change", function () {
        var selectedBahasaId = this.value;

        // Reset semua layer
        Object.values(wilayahLayers).forEach(function (w) {
            w.layer.setStyle({ color: "blue", weight: 2, opacity: 0 });
        });

        if (selectedBahasaId) {
            Object.values(wilayahLayers).forEach(function (w) {
                var bahasaMatch = w.data.bahasa.find(b => b.id == selectedBahasaId);
                if (bahasaMatch) {
                    // Highlight wilayah → biru, lebih tebal
                    w.layer.setStyle({ color: "blue", weight: 3, opacity: 1 });
                }
            });
        }
    });
});
</script>



@endsection
