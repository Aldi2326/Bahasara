@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div class="mt-5">
    <h2 class="text-center fw-bold mb-3">Peta Provinsi Jambi</h2>

    <!-- Map Container -->
    <div style="position: relative;">
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
    var map = L.map('map').setView([-1.6, 103.6], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var languageCard = document.getElementById("languageCard");
    var cardWilayah = document.getElementById("cardWilayah");
    var cardList = document.getElementById("cardList");

    var wilayahData = @json($wilayah);

    wilayahData.forEach(function(w) {
        w.sastra.forEach(function(s) {
            if (s.koordinat) {
                var coords = s.koordinat.split(',');
                var lat = parseFloat(coords[0].trim());
                var lng = parseFloat(coords[1].trim());

                var marker = L.marker([lat, lng]).addTo(map);

                marker.on("click", function() {
                    cardWilayah.textContent = w.nama_wilayah;
                    cardList.innerHTML = `
                        <div class="language-item" data-id="${s.id}">
                            <div class="language-name">${s.nama_sastra}</div>
                            <p class="language-desc">${s.deskripsi}</p>
                        </div>
                    `;
                    languageCard.classList.remove("d-none");

                    // Klik item → redirect detail
                    document.querySelector(".language-item").addEventListener("click", function() {
                        window.location.href = "/detail/sastra/" + this.dataset.id;
                    });
                });
            }
        });
    });
});

</script>




@endsection
