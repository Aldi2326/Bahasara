@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Input Data Sastra</h4>
        </div>
        <div class="p-6">
            <form class="flex flex-col gap-4" method="POST" action="{{ route('sastra.store') }}">
                @csrf
                
                <!-- Nama Wilayah -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="wilayah_id" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                    <div class="md:col-span-3">
                        <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach ($wilayahList as $wilayah)
                                <option value="{{ $wilayah->id }}"
                                    {{ isset($wilayahId) && $wilayahId == $wilayah->id ? 'selected' : '' }}>
                                    {{ $wilayah->nama_wilayah }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_sastra" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                <div class="md:col-span-3">
                    <select name="nama_sastra" id="nama_sastra" class="form-select" required>
                        <option value="">-- Pilih Sastra --</option>
                        <option value="Puisi Rakyat">Puisi Rakyat</option>
                        <option value="Cerita Rakyat">Cerita Rakyat</option>
                        <option value="Syair/Pantun">Syair/Pantun</option>
                        <option value="Teks Keagamaan">Teks Keagamaan</option>
                        <option value="Naskah Kuno">Naskah Kuno</option>                 
                    </select>
                </div>
            </div>

                <!-- Alamat -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                    <div class="md:col-span-3">
                        <textarea name="alamat" id="alamat" rows="3" class="form-input"
                            placeholder="Masukkan alamat lengkap lokasi sastra..." required></textarea>
                    </div>
                </div>

                <!-- Jenis Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="jenis_sastra" class="text-default-800 text-sm font-medium">Jenis Sastra</label>
                    <div class="md:col-span-3">
                        <select name="jenis" id="jenis_sastra" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="lisan">Lisan</option>
                            <option value="tulisan">Tulisan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Input Koordinat -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" required>
                    </div>
                </div>

                <!-- Peta Interaktif -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label class="text-default-800 text-sm font-medium">Peta Lokasi</label>
                    <div class="md:col-span-3">
                        <div id="map" style="height: 400px; border-radius: 8px; z-index: 1;"></div>
                        <p class="mt-2 text-xs text-default-500">
                            Klik pada peta untuk memilih lokasi. Koordinat akan otomatis terisi.
                        </p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi sastra..."
                            required></textarea>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="submit" class="btn bg-info text-white">Simpan Data</button>
                    </div>
                </div>
            </form>

            {{-- ======== Leaflet Map Script ======== --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Koordinat awal (Pusat Provinsi Jambi)
                    var map = L.map('map').setView([-1.610122, 103.613120], 7);

                    // Tambah tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map);

                    var marker;

                    // Event klik peta
                    map.on('click', function(e) {
                        var lat = e.latlng.lat.toFixed(6);
                        var lng = e.latlng.lng.toFixed(6);
                        var koordinat = lat + ', ' + lng;

                        // Isi input otomatis
                        document.getElementById('koordinat').value = koordinat;

                        // Hapus marker lama jika ada
                        if (marker) {
                            map.removeLayer(marker);
                        }

                        // Tambah marker baru
                        marker = L.marker([lat, lng]).addTo(map)
                            .bindPopup("Koordinat:<br>" + koordinat).openPopup();
                    });
                });
            </script>
        </div>
    </div>
@endsection
