@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Bahasa</h4>
    </div>

    <div class="p-6">
        <form id="bahasaForm" class="flex flex-col gap-4" action="{{ route('bahasa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                        <option value="{{ $wilayah->id }}"
                            {{ isset($wilayahId) && $wilayahId == $wilayah->id ? 'selected' : '' }}>
                            {{ $wilayah->nama_wilayah }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Nama Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Bahasa</label>
                <div class="md:col-span-3">
                    <select name="nama_bahasa_id" id="nama_bahasa_id" class="form-select" required>
                        <option value="">-- Pilih Bahasa --</option>
                        @foreach ($namaBahasaList as $nb)
                        <option value="{{ $nb->id }}"
                            {{ old('nama_bahasa_id', $bahasa->nama_bahasa_id ?? '') == $nb->id ? 'selected' : '' }}>
                            {{ $nb->nama_bahasa }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                <div class="md:col-span-3">
                    <textarea id="froala-editor" name="alamat" class="prose"></textarea>
                </div>
            </div>

            <!-- Status Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status_bahasa" class="text-default-800 text-sm font-medium">Status Bahasa</label>
                <div class="md:col-span-3">
                    <select name="status" id="status_bahasa" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Aman">Aman</option>
                        <option value="Rentan">Rentan</option>
                        <option value="Pasti Terancam Punah">Pasti Terancam Punah</option>
                        <option value="Sangat Terancam Punah">Sangat Terancam Punah</option>
                        <option value="Kritis">Kritis</option>
                    </select>
                </div>
            </div>

            <!-- Jumlah Penutur -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="jumlah_penutur" class="text-default-800 text-sm font-medium">Jumlah Penutur</label>
                <div class="md:col-span-3">
                    <input type="number" name="jumlah_penutur" id="jumlah_penutur" class="form-input"
                        placeholder="Masukkan jumlah penutur" required>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea id="froala-editor" name="deskripsi" class="prose"></textarea>
                </div>
            </div>

            <!-- Dokumentasi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                <div class="md:col-span-3">
                    <input type="file" name="dokumentasi" id="dokumentasi" class="form-input"
                        accept="image/*,video/*,application/pdf" required>
                    <p class="mt-1 text-xs text-default-500">
                        Unggah file foto (.jpg, .png), video (.mp4, .mov), atau dokumen (.pdf). Maksimal 20MB.
                    </p>
                </div>
            </div>

            <!-- Input Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input"
                        placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" step="0.0000001"
                        required>
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
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white">Simpan Data</button>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- ======== Leaflet Map Script ======== --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

{{-- ======== SweetAlert2 ======== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi Peta
        var map = L.map('map').setView([-1.610122, 103.613120], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);
            var koordinat = lat + ', ' + lng;
            document.getElementById('koordinat').value = koordinat;

            if (marker) map.removeLayer(marker);

            marker = L.marker([lat, lng]).addTo(map)
                .bindPopup("Koordinat:<br>" + koordinat).openPopup();
        });

        // SweetAlert konfirmasi sebelum submit
        const form = document.getElementById('bahasaForm');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Cegah submit langsung

            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan data sudah benar sebelum disimpan.",
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