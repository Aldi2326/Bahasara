@extends('layouts.app')

@section('title', 'Peta Bahasa & Sastra')

@section('content')
<div class="mt-5 pt-5">
    <div style="position: relative;">

        <!-- Filter -->
        <form action="{{ route('peta.index') }}" method="GET" id="filterForm">
            <div class="search-control d-flex flex-wrap gap-3">

                <!-- Multi-select Bahasa -->
                <div class="dropdown" style="margin-right: 10px;">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownBahasa"
                        data-bs-toggle="dropdown" aria-expanded="false">-- Pilih Bahasa --</button>
                    <ul class="dropdown-menu p-2" style="max-height: 250px; overflow-y: auto;" id="bahasaListDropdown">
                        <li>
                            <label class="dropdown-item d-flex align-items-center gap-2">
                                <input class="form-check-input bahasa-checkbox" type="checkbox" name="bahasa[]"
                                    value="Semua Bahasa"
                                    {{ !empty($selectedBahasa) && in_array('Semua Bahasa', $selectedBahasa) ? 'checked' : '' }}>
                                <span>Semua Bahasa</span>
                            </label>
                        </li>
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
        <div id="map" style="height: 680px; box-shadow:0 4px 10px rgba(0,0,0,0.2); border-radius:12px;"></div>

        <!-- Legend -->
        <div id="legendCard" class="legend-card shadow">
            <div class="legend-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-2 m-0">Keterangan Peta</h6>
                <button id="toggleLegendBtn" class="toggle-btn" title="Sembunyikan Legend">−</button>
            </div>
            <div id="legendContent" class="legend-content">
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
</div>

<!-- CSS -->
<style>
:root { --radius-smooth: 12px; }
.btn, .dropdown-menu, .form-check-input, .search-control { border-radius: var(--radius-smooth) !important; }
.search-control { position: absolute; top: 15px; left: calc(var(--bs-gutter-x,1.5rem)); z-index:1000; padding:10px; }
.legend-card { position:absolute; bottom:15px; left:15px; background:rgba(255,255,255,0.95); backdrop-filter:blur(6px); border-radius:var(--radius-smooth); padding:12px 16px; width:220px; z-index:500; box-shadow:0 4px 10px rgba(0,0,0,0.25); border-left:4px solid #0d6efd; transition:all 0.3s ease; }
.legend-header { display:flex; justify-content:space-between; align-items:center; }
.toggle-btn { background:#e9ecef; border:1px solid #d1d5db; width:28px; height:28px; font-weight:bold; font-size:16px; cursor:pointer; color:#333; transition:background 0.25s ease, transform 0.2s ease; border-radius:var(--radius-smooth); }
.toggle-btn:hover { background:#dbeafe; transform:scale(1.05); }
.legend-item { display:flex; align-items:center; margin-bottom:6px; font-size:0.9rem; }
.legend-color { width:18px; height:18px; border-radius:4px; margin-right:8px; border:1px solid rgba(0,0,0,0.1); }
.legend-card.collapsed .legend-content { max-height:0; overflow:hidden; opacity:0; transition:all 0.3s ease; }
.legend-content { max-height:500px; opacity:1; transition:all 0.3s ease; }
.leaflet-control-zoom a { background:rgba(255,255,255,0.95)!important; border-radius:var(--radius-smooth)!important; box-shadow:0 4px 10px rgba(0,0,0,0.25); color:#000!important; font-weight:bold; transition:all 0.25s ease; }
.leaflet-control-zoom a:hover { background:#dbeafe!important; transform:scale(1.05); }
.leaflet-popup-content-wrapper { background:rgba(255,255,255,0.95)!important; backdrop-filter:blur(4px); color:#000; border-radius:var(--radius-smooth); box-shadow:0 4px 12px rgba(0,0,0,0.3); }
.leaflet-popup-tip { background:rgba(255,255,255,0.95)!important; }
</style>

<!-- Script Leaflet -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Auto-submit filter
    document.querySelectorAll('.bahasa-checkbox, .wilayah-checkbox').forEach(cb => cb.addEventListener('change', () => document.getElementById('filterForm').submit()));

    // Toggle legend
    const legendCard = document.getElementById("legendCard");
    const toggleLegendBtn = document.getElementById("toggleLegendBtn");
    toggleLegendBtn.addEventListener("click", () => {
        legendCard.classList.toggle("collapsed");
        toggleLegendBtn.textContent = legendCard.classList.contains("collapsed") ? '+' : '−';
        toggleLegendBtn.title = legendCard.classList.contains("collapsed") ? "Tampilkan Legend" : "Sembunyikan Legend";
    });

    const wilayahData = @json($allWilayah);
    const bahasaList = @json($bahasaList);

    const jambiBounds = L.latLngBounds(L.latLng(-2.85,101.0), L.latLng(0.60,104.9));
    const map = L.map('map', { zoomControl:false });
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution:'&copy; OpenStreetMap contributors' }).addTo(map);
    map.fitBounds(jambiBounds);
    L.control.zoom({ position:'bottomright' }).addTo(map);

    wilayahData.forEach(w => {
        if(w.file_geojson){
            fetch('/'+w.file_geojson).then(res=>res.json()).then(data=>{
                L.geoJSON(data, { style:{ color:"#FF6B6B", weight:2, opacity:1, fillOpacity:0 } }).addTo(map);
            });
        }
    });

    bahasaList.forEach(b => {
        if(b.lat && b.lng){
            const colors = { 'Bahasa Melayu Jambi':'red','Bahasa Bajau Tungkal Satu':'yellow','Bahasa Banjar':'blue','Bahasa Bugis':'green','Bahasa Kerinci':'orange','Bahasa Minangkabau':'violet','Bahasa Jawa':'grey' };
            const iconUrl = `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${colors[b.nama_bahasa]||'black'}.png`;
            const customIcon = L.icon({ iconUrl, shadowUrl:'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png', iconSize:[30,45], iconAnchor:[15,45], popupAnchor:[0,-40], shadowSize:[45,45] });

            L.marker([b.lat,b.lng],{ icon:customIcon }).addTo(map).bindPopup(`
                <div style="background:linear-gradient(135deg,#ffffff 0%,#f9fafb 100%); padding:12px 16px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15); font-family:'Poppins',sans-serif; width:230px;">
                    <div style="border-bottom:1px solid #eee; padding-bottom:6px; margin-bottom:6px;">
                        <strong style="font-size:16px; color:#1e40af;">${b.nama_bahasa}</strong>
                    </div>
                    <div style="font-size:13px; color:#374151; line-height:1.4;">
                        📍 <b>Koordinat:</b> ${b.lat.toFixed(4)}, ${b.lng.toFixed(4)}<br>
                        🏠 <b>Alamat:</b> ${b.alamat}
                    </div>
                    <a href="{{ url('detail/bahasa') }}/${b.id}" style="display:inline-block;margin-top:10px;padding:6px 12px;background:#2563eb;color:#fff;font-size:13px;border-radius:8px;text-decoration:none;">
                        🔎 Lihat Detail
                    </a>
                </div>`);
        }
    });
});
</script>
@endsection
