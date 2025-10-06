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
                <input type="hidden" name="wilayah_id" value="{{ $wilayahId }}" id="">

                <!-- Nama Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_sastra" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                    <div class="md:col-span-3">
                        <input type="text" name="nama_sastra" id="nama_sastra" class="form-input"
                            placeholder="Contoh: Gurindam Dua Belas" required>
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

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi sastra..."
                            required></textarea>
                    </div>
                </div>

                <!-- Koordinat -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            placeholder="Klik pada peta untuk mengisi koordinat" readonly required>
                        <p class="mt-1 text-xs text-default-500">Klik titik pada peta di bawah untuk memilih koordinat
                            lokasi.</p>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="submit" class="btn bg-info text-white">Simpan Data</button>
                    </div>
                </div>
            </form>

            <!-- Map Leaflet -->
            <div class="mt-6">
                <h5 class="text-lg font-semibold mb-2">Pilih Lokasi di Peta</h5>
                <div id="map" style="height: 400px; border-radius: 8px;"></div>
            </div>

        </div>
    </div>

    <!-- Leaflet JS & CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi peta
            var map = L.map('map').setView([-1.6101, 103.6158], 7); // Jambi sebagai default

            // Tambah layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker;

            // Event klik pada peta
            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);
                var koordinat = lat + ", " + lng;

                // isi input koordinat
                document.getElementById("koordinat").value = koordinat;

                // hapus marker lama jika ada
                if (marker) {
                    map.removeLayer(marker);
                }

                // tambah marker baru
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Koordinat: " + koordinat).openPopup();
            });
        });
    </script>
@endsection
