@extends('layouts.admin.app')
@section('title', 'Edit Sastra')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Sastra</h4>
    </div>

    <div class="p-6">
        <form id="editSastraForm" class="flex flex-col gap-4" action="{{ route('sastra.update', $sastra->id) }}" method="POST" enctype="multipart/form-data">
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
                <label for="nama_sastra_id" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                <div class="md:col-span-3">
                    <select name="nama_sastra_id" id="nama_sastra_id" class="form-select" required>
                        <option value="">-- Pilih Sastra --</option>
                        @foreach ($namaSastraList as $ns)
                        <option value="{{ $ns->id }}" {{ $sastra->nama_sastra_id == $ns->id ? 'selected' : '' }}>
                            {{ $ns->nama_sastra }}
                        </option>
                        @endforeach
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
                <label for="jenis" class="text-default-800 text-sm font-medium">Jenis Sastra</label>
                <div class="md:col-span-3">
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="lisan" {{ $sastra->jenis == 'lisan' ? 'selected' : '' }}>Lisan</option>
                        <option value="tulisan" {{ $sastra->jenis == 'tulisan' ? 'selected' : '' }}>Tulisan</option>
                        <option value="lainnya" {{ $sastra->jenis == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea id="froala-editor" name="deskripsi" required>{{ old('deskripsi', $sastra->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Dokumentasi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                <div class="md:col-span-3">
                    <input type="file" name="dokumentasi" id="dokumentasi" class="form-input" accept="image/*,video/*">
                    <p class="mt-1 text-xs text-default-500">Unggah file foto (.jpg, .png) atau video (.mp4, .mov, dll). Maksimal 20MB.</p>
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
                        Klik pada peta untuk memilih ulang lokasi. Koordinat otomatis diperbarui.
                    </p>
                </div>
            </div>

            <!-- Tombol -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2 flex gap-4">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white">Simpan Data</button>
                    <a href="{{ route('sastra.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Leaflet Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ======== Leaflet Map ========
        let koordinatString = "{{ $sastra->koordinat }}";
        let defaultLat = -1.610122, defaultLng = 103.613120;
        let lat = defaultLat, lng = defaultLng;

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

        // ======== SweetAlert Konfirmasi ========
        const form = document.getElementById('editSastraForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Simpan Data?',
                text: "Perubahan akan disimpan permanen.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#4B5563',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
