@extends('layouts.app')

@section('title', 'Peta Sastra')

@section('content')
<div class="mt-5 pt-4">
    <div style="position: relative;">

        <!-- Filter -->
        <form action="{{ route('peta.sastra') }}" method="GET" class="search-control-input flex gap-2">
            <input
                type="text"
                name="search"
                placeholder="Cari sastra atau wilayah..."
                value="{{ request('search') }}"
                style="width: 260px; padding: 6px; border-radius: 12px; border: 1px solid #ccc;">
            <button type="submit" class="btn"
                    style="background-color: #1b81ae; color: white; border: none; border-radius: 12px; padding: 6px 16px;">
                    Cari
                </button>
        </form>

        <form action="{{ route('peta.sastra') }}" method="GET" id="filterForm">
            <div class="search-control d-flex flex-wrap gap-3">

                <!-- Multi-select Sastra -->
                <div class="dropdown" style="margin-right: 10px;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownSastra"
                        data-bs-toggle="dropdown" aria-expanded="false">-- Pilih Sastra --</button>
                    <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;" id="sastraListDropdown">
                        <li>
                            <label class="dropdown-item d-flex align-items-center gap-2">
                                <input class="form-check-input sastra-checkbox" type="checkbox" name="sastra[]"
                                    value="Semua Sastra">
                                <span>Semua Sastra</span>
                            </label>
                        </li>
                        @foreach ($namaSastraAll as $s)
                        <li>
                            <label class="dropdown-item d-flex align-items-center gap-2">
                                <input class="form-check-input sastra-checkbox" type="checkbox" name="sastra[]"
                                    value="{{ $s->nama_sastra }}"
                                    {{ !empty($selectedSastra) && in_array($s->nama_sastra, $selectedSastra) ? 'checked' : '' }}>
                                <span>{{ $s->nama_sastra }}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Multi-select Wilayah -->
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownWilayah"
                        data-bs-toggle="dropdown" aria-expanded="false">-- Pilih Wilayah --</button>
                    <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;" id="wilayahListDropdown">
                        <li>
                            <label class="dropdown-item d-flex align-items-center gap-2">
                                <input class="form-check-input wilayah-checkbox" type="checkbox" name="wilayah[]"
                                    value="Semua Wilayah"
                                    {{ !empty($selectedWilayah) && in_array('Semua Wilayah', $selectedWilayah) ? 'checked' : '' }}>
                                <span>Semua Wilayah</span>
                            </label>
                        </li>
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
        <div id="map" style="height: 790px; box-shadow:0 4px 10px rgba(0,0,0,0.2);"></div>

        <!-- Legend -->
        <div id="legendCard" class="legend-card shadow">
            <div class="legend-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-2 m-0">Keterangan Peta</h6>
                <button id="toggleLegendBtn" class="toggle-btn" title="Sembunyikan Legend">−</button>
            </div>
            <div id="legendContent" class="legend-content">
                @foreach ($sastraList->unique('nama_sastra') as $s)
                <div class="legend-item">
                    <span class="legend-color" style="background: {{ $s->warna_pin ?? '#1E90FF' }}"></span>
                    {{ $s->nama_sastra }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Copy of CSS and JS dari Peta Bahasa -->
<style>
    :root {
        --radius-smooth: 12px;
    }

    .btn,
    .dropdown-menu,
    .form-check-input,
    .search-control {
        border-radius: var(--radius-smooth) !important;
    }

    .search-control {
        position: absolute;
        top: 60px;
        left: calc(var(--bs-gutter-x, 1.5rem));
        z-index: 1000;
        padding: 10px;
    }

    .search-control-input {
        position: absolute;
        top: 15px;
        left: calc(var(--bs-gutter-x, 1.5rem));
        z-index: 900;
        padding: 10px;
    }

    .legend-card {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(6px);
        border-radius: var(--radius-smooth);
        padding: 12px 16px;
        width: 220px;
        z-index: 500;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        border-left: 4px solid #1b81ae;
        transition: all 0.3s ease;
    }

    .toggle-btn {
        background: #e9ecef;
        border: 1px solid #d1d5db;
        width: 28px;
        height: 28px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        color: #333;
        transition: background 0.25s ease, transform 0.2s ease;
        border-radius: var(--radius-smooth);
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
        background: rgba(255, 255, 255, 0.95) !important;
        border-radius: var(--radius-smooth);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Saat legend-card dalam keadaan collapsed */
    .legend-card.collapsed #legendContent {
        display: none;
        /* Sembunyikan isi legend */
    }

    /* Ubah tampilan tombol saat legend disembunyikan */
    .legend-card.collapsed #toggleLegendBtn {
        transform: rotate(180deg);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.sastra-checkbox, .wilayah-checkbox')
            .forEach(cb => cb.addEventListener('change', () => document.getElementById('filterForm').submit()));

        const legendCard = document.getElementById("legendCard");
        const toggleLegendBtn = document.getElementById("toggleLegendBtn");

        toggleLegendBtn.addEventListener("click", () => {
            legendCard.classList.toggle("collapsed");
            const isCollapsed = legendCard.classList.contains("collapsed");
            toggleLegendBtn.textContent = isCollapsed ? '+' : '−';
            toggleLegendBtn.title = isCollapsed ? 'Tampilkan Legend' : 'Sembunyikan Legend';
        });

        const wilayahData = @json($allWilayah);
        const sastraList = @json($sastraList);

        const jambiBounds = L.latLngBounds(L.latLng(-2.85, 101.0), L.latLng(0.60, 104.9));
        const map = L.map('map', {
            zoomControl: false
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        map.fitBounds(jambiBounds);
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Wilayah
        wilayahData.forEach(w => {
            if (w.file_geojson) {
                fetch('/' + w.file_geojson).then(res => res.json()).then(data => {
                    L.geoJSON(data, {
                        style: {
                            color: "#FF6B6B",
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0
                        }
                    }).addTo(map);
                });
            }
        });

        // Sastra
        sastraList.forEach(s => {
            if (s.lat && s.lng) {
                const warna = s.warna_pin || 'blue';
                const customIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `
                <svg id="pin-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="${warna}">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5
                            c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                        </svg>
            `,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10]
                });

                L.marker([s.lat, s.lng], {
                        icon: customIcon
                    }).addTo(map)
                    .bindPopup(`
                            <div style="background:linear-gradient(135deg,#ffffff 0%,#f9fafb 100%);
                                        padding:12px 16px; border-radius:12px;
                                        box-shadow:0 4px 12px rgba(0,0,0,0.15);
                                        font-family:'Poppins',sans-serif; width:230px;">
                                <div style="border-bottom:1px solid #eee; padding-bottom:6px; margin-bottom:6px;">
                                    <strong style="font-size:16px; color:#1e40af;">${s.nama_sastra.nama_sastra}</strong>
                                </div>
                                <div style="font-size:13px; color:#374151; line-height:1.4;">
                                    📍 <b>Koordinat:</b> ${s.lat.toFixed(4)}, ${s.lng.toFixed(4)}<br>
                                    🏠 <b>Alamat:</b> ${s.alamat}
                                </div>
                                <a href="{{ url('detail/sastra') }}/${s.id}"
                                style="display:inline-block;margin-top:10px;
                                padding:6px 12px;background:#2563eb;color:#fff;
                                font-size:13px;border-radius:8px;text-decoration:none;">
                                    🔎 Lihat Detail
                                </a>
                            </div>
                        `);
            }
        });
    });
</script>
@endsection