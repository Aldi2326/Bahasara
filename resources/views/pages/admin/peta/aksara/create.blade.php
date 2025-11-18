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

            <form id="formAksara" class="flex flex-col gap-4" method="POST" action="{{ route('aksara.store') }}"
                enctype="multipart/form-data">
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

                <!-- Nama Aksara -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_aksara" class="text-default-800 text-sm font-medium">Nama Aksara</label>
                    <div class="md:col-span-3">
                        <select name="nama_aksara_id" id="nama_aksara_id" class="form-select" required>
                            <option value="">-- Pilih Aksara --</option>
                            @foreach ($namaAksaraList as $na)
                                <option value="{{ $na->id }}"
                                    {{ old('nama_aksara_id', $aksara->nama_aksara_id ?? '') == $na->id ? 'selected' : '' }}>
                                    {{ $na->nama_aksara }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="alamat" class="proses"></textarea>
                    </div>
                </div>

                <!-- Status Aksara -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="status" class="text-default-800 text-sm font-medium">Status</label>
                    <div class="md:col-span-3">
                        <select name="status" id="status" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="deskripsi" class="prose"></textarea>
                        <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan sejarah, fungsi, dan karakteristik
                            aksara</p>
                    </div>
                </div>

                <!-- Dokumentasi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                    <div class="md:col-span-3">
                        <input type="file" name="dokumentasi" id="dokumentasi" class="form-input"
                            accept="image/*,video/*" required>
                        <p class="mt-1 text-xs text-default-500"> Unggah file jpg, jpeg, png, webp, pdf. Maksimal 2MB.
                        </p>
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

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="button" id="btnSubmit" class="btn bg-blue-600 hover:bg-blue-700 text-white">Simpan
                            Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ============================
            //  Inisialisasi Peta (Jambi)
            // ============================
            var map = L.map('map').setView([-1.610122, 103.613120], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            // ============================
            //  Tambahkan Search Geocoder
            // ============================
            var geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false
                })
                .on('markgeocode', function(e) {

                    let lokasi = e.geocode.center;
                    let lat = lokasi.lat.toFixed(6);
                    let lng = lokasi.lng.toFixed(6);
                    let koordinat = lat + ', ' + lng;

                    // Set koordinat ke input
                    document.getElementById('koordinat').value = koordinat;

                    // Hapus marker lama jika ada
                    if (marker) map.removeLayer(marker);

                    // Buat marker baru
                    marker = L.marker([lat, lng]).addTo(map)
                        .bindPopup("Hasil Pencarian:<br>" + koordinat)
                        .openPopup();

                    // Fokus ke lokasi pencarian
                    map.setView([lat, lng], 13);
                })
                .addTo(map);

            // ============================
            //  Klik Peta → Update Koordinat
            // ============================
            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);
                var koordinat = lat + ', ' + lng;

                // Set ke input form
                document.getElementById('koordinat').value = koordinat;

                // Update marker
                if (marker) map.removeLayer(marker);
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup("Koordinat:<br>" + koordinat).openPopup();
            });

            // ============================
            //  SweetAlert Konfirmasi Submit
            // ============================
            document.getElementById('btnSubmit').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan Data Aksara?',
                    text: "Pastikan semua data sudah benar sebelum menyimpan.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#4B5563',
                    confirmButtonText: 'Ya, simpan!',
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
