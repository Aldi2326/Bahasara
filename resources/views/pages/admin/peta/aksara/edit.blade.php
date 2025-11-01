@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Aksara</h4>
    </div>
    <div class="p-6">
        <form id="formEditAksara" class="flex flex-col gap-4" method="POST" action="{{ route('aksara.update', $aksara->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Wilayah -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="wilayah_id" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach ($wilayahList as $wilayah)
                            <option value="{{ $wilayah->id }}" {{ $aksara->wilayah_id == $wilayah->id ? 'selected' : '' }}>
                                {{ $wilayah->nama_wilayah }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nama Aksara -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_aksara" class="text-default-800 text-sm font-medium">Nama Aksara</label>
                <div class="md:col-span-3">
                    <select name="nama_aksara" id="nama_aksara" class="form-select" required>
                        <option value="">-- Pilih Aksara --</option>
                        <option value="Aksara Incung" {{ $aksara->nama_aksara == 'Aksara Incung' ? 'selected' : '' }}>Aksara Incung</option>
                        <option value="Aksara Arab Melayu" {{ $aksara->nama_aksara == 'Aksara Arab Melayu' ? 'selected' : '' }}>Aksara Arab Melayu</option>
                    </select>
                </div>
            </div>

            <!-- Status Aksara -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status" class="text-default-800 text-sm font-medium">Status Aksara</label>
                <div class="md:col-span-3">
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ $aksara->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $aksara->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi lengkap aksara..." required>{{ old('deskripsi', $aksara->deskripsi) }}</textarea>
                    <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan sejarah, fungsi, dan karakteristik aksara</p>
                </div>
            </div>

            <!-- Dokumentasi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                <div class="md:col-span-3">
                    <input type="file" name="dokumentasi" id="dokumentasi" class="form-input" accept="image/*,video/*">
                    <p class="mt-1 text-xs text-default-500">
                        Unggah file foto (.jpg, .png) atau video (.mp4, .mov, dll). Maksimal 20MB.
                        <br>Biarkan kosong jika tidak ingin mengubah dokumentasi.
                    </p>

                    @if ($aksara->dokumentasi)
                        <div class="mt-3">
                            <p class="text-sm font-medium mb-1">Dokumentasi saat ini:</p>
                            @if (Str::endsWith($aksara->dokumentasi, ['.mp4', '.mov', '.avi']))
                                <video src="{{ asset('storage/' . $aksara->dokumentasi) }}" width="200" controls class="rounded-md shadow"></video>
                            @else
                                <img src="{{ asset('storage/' . $aksara->dokumentasi) }}" alt="Dokumentasi" width="150" class="rounded-md shadow">
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Input Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input" value="{{ old('koordinat', $aksara->koordinat) }}" placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" required>
                </div>
            </div>

            <!-- Peta -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label class="text-default-800 text-sm font-medium">Peta Lokasi</label>
                <div class="md:col-span-3">
                    <div id="map" style="height: 400px; border-radius: 8px; z-index: 1;"></div>
                    <p class="mt-2 text-xs text-default-500">
                        Klik pada peta untuk memperbarui lokasi. Koordinat akan otomatis terisi.
                    </p>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="button" id="btnSimpan" class="btn bg-info text-white">Simpan Perubahan</button>
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
    // Inisialisasi peta dengan koordinat lama
    var initialCoords = "{{ $aksara->koordinat }}".split(',');
    var lat = parseFloat(initialCoords[0]) || -1.610122;
    var lng = parseFloat(initialCoords[1]) || 103.613120;

    var map = L.map('map').setView([lat, lng], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map)
        .bindPopup("Koordinat:<br>" + lat.toFixed(6) + ", " + lng.toFixed(6))
        .openPopup();

    map.on('click', function(e) {
        var newLat = e.latlng.lat.toFixed(6);
        var newLng = e.latlng.lng.toFixed(6);
        var koordinat = newLat + ', ' + newLng;
        document.getElementById('koordinat').value = koordinat;

        map.removeLayer(marker);
        marker = L.marker([newLat, newLng]).addTo(map)
            .bindPopup("Koordinat:<br>" + koordinat)
            .openPopup();
    });

    // SweetAlert konfirmasi edit
    document.getElementById('btnSimpan').addEventListener('click', function() {
        Swal.fire({
            title: 'Simpan Perubahan Data Aksara?',
            text: 'Perubahan akan disimpan ke database.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEditAksara').submit();
            }
        });
    });
});
</script>
@endsection
