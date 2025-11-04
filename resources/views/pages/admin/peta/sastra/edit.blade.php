@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Sastra</h4>
    </div>
    <div class="p-6">
        <form id="sastraForm" class="flex flex-col gap-4" method="POST" action="{{ route('sastra.update', $sastra->id) }}">
            @csrf
            @method('PUT')
            @if ($errors->any())
            <div class="bg-red-50 border border-red-800 text-red-800 px-4 py-3 rounded-lg mb-4 shadow-sm">
                <strong class="font-semibold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Nama Wilayah -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="wilayah_id" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach ($wilayahList as $wilayah)
                        <option value="{{ $wilayah->id }}" {{ $sastra->wilayah_id == $wilayah->id ? 'selected' : '' }}>
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
                    <select name="nama_sastra" id="nama_sastra" class="form-select" required>
                        <option value="">-- Pilih Sastra --</option>
                        <option value="Puisi Rakyat" {{ $sastra->nama_sastra == 'Puisi Rakyat' ? 'selected' : '' }}>Puisi Rakyat</option>
                        <option value="Cerita Rakyat" {{ $sastra->nama_sastra == 'Cerita Rakyat' ? 'selected' : '' }}>Cerita Rakyat</option>
                        <option value="Syair/Pantun" {{ $sastra->nama_sastra == 'Syair/Pantun' ? 'selected' : '' }}>Syair/Pantun</option>
                        <option value="Teks Keagamaan" {{ $sastra->nama_sastra == 'Teks Keagamaan' ? 'selected' : '' }}>Teks Keagamaan</option>
                        <option value="Naskah Kuno" {{ $sastra->nama_sastra == 'Naskah Kuno' ? 'selected' : '' }}>Naskah Kuno</option>
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                <div class="md:col-span-3">
                    <textarea id="froala-editor" name="alamat" required>{{ old('alamat', $sastra->alamat) }}</textarea>
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
                        <option value="lainnya" {{ $sastra->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input" value="{{ $sastra->koordinat }}" required>
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
                    <textarea id="froala-editor" name="deskripsi" required>{{ old('deskripsi', $sastra->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="button" id="btnUpdate" class="btn bg-info text-white">Simpan Perubahan</button>
                </div>
            </div>
        </form>

        {{-- Leaflet Map --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let koordinatString = "{{ $sastra->koordinat }}";
                let defaultLat = -1.610122,
                    defaultLng = 103.613120;
                let lat = defaultLat,
                    lng = defaultLng;

                if (koordinatString && koordinatString.includes(',')) {
                    let parts = koordinatString.split(',');
                    lat = parseFloat(parts[0]);
                    lng = parseFloat(parts[1]);
                }

                var map = L.map('map').setView([lat, lng], 8);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                var marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Koordinat Awal:<br>" + lat + ", " + lng)
                    .openPopup();

                map.on('click', function(e) {
                    let newLat = e.latlng.lat.toFixed(6);
                    let newLng = e.latlng.lng.toFixed(6);
                    let newCoord = newLat + ', ' + newLng;

                    document.getElementById('koordinat').value = newCoord;

                    if (marker) map.removeLayer(marker);
                    marker = L.marker([newLat, newLng]).addTo(map)
                        .bindPopup("Koordinat Baru:<br>" + newCoord)
                        .openPopup();
                });
            });
        </script>

        {{-- SweetAlert Konfirmasi Update --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById("btnUpdate").addEventListener("click", function(e) {
                Swal.fire({
                    title: 'Yakin ingin memperbarui data?',
                    text: "Pastikan semua data sudah benar sebelum disimpan.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Update!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("sastraForm").submit();
                    }
                });
            });
        </script>
    </div>
</div>
@endsection