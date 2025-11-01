@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan validasi:</strong>
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Aksara</h4>
    </div>
    <div class="p-6">

        <form id="formAksara" class="flex flex-col gap-4" method="POST" action="{{ route('aksara.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nama Wilayah -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="wilayah_id" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <select name="wilayah_id" id="wilayah_id" class="form-select" required>
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach ($wilayahList as $wilayah)
                            <option value="{{ $wilayah->id }}" {{ isset($wilayahId) && $wilayahId == $wilayah->id ? 'selected' : '' }}>
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
                        <option value="Aksara Incung">Aksara Incung</option>
                        <option value="Aksara Arab Melayu">Aksara Arab Melayu</option>
                    </select>
                </div>
            </div>

            <!-- Status Aksara -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status" class="text-default-800 text-sm font-medium">Status</label>
                <div class="md:col-span-3">
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi lengkap aksara..." required></textarea>
                    <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan sejarah, fungsi, dan karakteristik aksara</p>
                </div>
            </div>

            <!-- Dokumentasi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                <div class="md:col-span-3">
                    <input type="file" name="dokumentasi" id="dokumentasi" class="form-input" accept="image/*,video/*" required>
                    <p class="mt-1 text-xs text-default-500">Unggah file foto (.jpg, .png) atau video (.mp4, .mov, dll). Maksimal 20MB.</p>
                </div>
            </div>

            <!-- Input Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input" placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" required>
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

            <!-- Tombol Submit -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="button" id="btnSubmit" class="btn bg-info text-white">Simpan Data</button>
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
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi peta Jambi
    var map = L.map('map').setView([-1.610122, 103.613120], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;

    // Klik peta → ambil koordinat
    map.on('click', function (e) {
        var lat = e.latlng.lat.toFixed(6);
        var lng = e.latlng.lng.toFixed(6);
        var koordinat = lat + ', ' + lng;
        document.getElementById('koordinat').value = koordinat;

        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup("Koordinat:<br>" + koordinat).openPopup();
    });

    // SweetAlert Konfirmasi Simpan
    document.getElementById('btnSubmit').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Data Aksara?',
            text: "Pastikan semua data sudah benar sebelum menyimpan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formAksara').submit();
            }
        });
    });
});
</script>
@endsection
