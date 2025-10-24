@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Edit Data Sastra</h4>
        </div>
        <div class="p-6">
            <form class="flex flex-col gap-4" method="POST" action="{{ route('sastra.update', $sastra->id) }}">
                @csrf
                @method('PUT')

                <!-- Nama Wilayah -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="wilayah_id" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                    <div class="md:col-span-3">
                        <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach ($wilayahList as $wilayah)
                                <option value="{{ $wilayah->id }}"
                                    {{ $sastra->wilayah_id == $wilayah->id ? 'selected' : '' }}>
                                    {{ $wilayah->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Nama Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_sastra" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                    <div class="md:col-span-3">
                        <input type="text" value="{{ $sastra->nama_sastra }}" name="nama_sastra" id="nama_sastra"
                            class="form-input" placeholder="Contoh: Gurindam Dua Belas" required>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                    <div class="md:col-span-3">
                        <textarea name="alamat" id="alamat" rows="3" class="form-input" required>{{ $sastra->alamat }}</textarea>
                    </div>
                </div>

                <!-- Jenis Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="jenis_sastra" class="text-default-800 text-sm font-medium">Jenis Sastra</label>
                    <div class="md:col-span-3">
                        <select name="jenis_sastra" id="jenis_sastra" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="lisan" {{ $sastra->jenis == 'lisan' ? 'selected' : '' }}>Lisan</option>
                            <option value="tulisan" {{ $sastra->jenis == 'tulisan' ? 'selected' : '' }}>Tulisan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Koordinat -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            value="{{ $sastra->koordinat }}" required>
                    </div>
                </div>

                <!-- Peta Interaktif -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label class="text-default-800 text-sm font-medium">Peta Lokasi</label>
                    <div class="md:col-span-3">
                        <div id="map" style="height: 400px; border-radius: 8px; z-index: 1;"></div>
                        <p class="mt-2 text-xs text-default-500">
                            Klik peta untuk memilih ulang lokasi. Koordinat otomatis diperbarui.
                        </p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi sastra..."
                            required>{{ old('deskripsi', $sastra->deskripsi) }}</textarea>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="submit" class="btn bg-info text-white">Simpan Data</button>
                    </div>
                </div>
            </form>

            {{-- Leaflet Map --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Ambil koordinat awal dari database
                    let koordinatString = "{{ $sastra->koordinat }}";
                    let defaultLat = -1.610122,
                        defaultLng = 103.613120; // default Jambi
                    let lat = defaultLat,
                        lng = defaultLng;

                    // Jika data koordinat ada
                    if (koordinatString && koordinatString.includes(',')) {
                        let parts = koordinatString.split(',');
                        lat = parseFloat(parts[0]);
                        lng = parseFloat(parts[1]);
                    }

                    // Inisialisasi peta
                    var map = L.map('map').setView([lat, lng], 8);

                    // Tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    var marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup("Koordinat Awal:<br>" + lat + ", " + lng)
                        .openPopup();

                    // Klik peta → ubah marker & isi input koordinat
                    map.on('click', function(e) {
                        let newLat = e.latlng.lat.toFixed(6);
                        let newLng = e.latlng.lng.toFixed(6);
                        let newCoord = newLat + ', ' + newLng;

                        // Update input
                        document.getElementById('koordinat').value = newCoord;

                        // Ganti marker
                        if (marker) map.removeLayer(marker);
                        marker = L.marker([newLat, newLng]).addTo(map)
                            .bindPopup("Koordinat Baru:<br>" + newCoord)
                            .openPopup();
                    });
                });
            </script>
        @endsection
