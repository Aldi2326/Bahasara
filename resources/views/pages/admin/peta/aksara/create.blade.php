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

                {{-- Nama Wilayah --}}
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

                {{-- Nama Aksara --}}
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

                {{-- Alamat --}}
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="alamat" class="prose"></textarea>
                    </div>
                </div>

                {{-- Status --}}
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

                {{-- Deskripsi --}}
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="deskripsi" class="prose"></textarea>
                        <p class="mt-1 text-xs text-default-500">
                            Isi dengan penjelasan sejarah, fungsi, dan karakteristik aksara
                        </p>
                    </div>
                </div>

                {{-- Dokumentasi --}}
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                    <div class="md:col-span-3">
                        <input type="file" name="dokumentasi" id="dokumentasi" class="form-input" accept="image"
                            required>

                        <p class="mt-1 text-xs text-default-500">
                            Unggah file jpg, jpeg, png, webp, pdf. Maksimal 2MB.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="dokumentasi_yt" class="text-default-800 text-sm font-medium">Dokumentasi Youtube
                        (Opsional)</label>
                    <div class="md:col-span-3">
                        <input type="text" name="dokumentasi_yt" id="dokumentasi_yt" class="form-input"
                            placeholder="Masukkan Link Video Youtube">
                    </div>
                </div>

                {{-- Koordinat --}}
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" required>

                        <input type="hidden" name="lokasi" id="lokasi">
                    </div>
                </div>

                {{-- Peta --}}
                <div class="grid grid-cols-4 items-start gap-6">
                    <label class="text-default-800 text-sm font-medium">Peta Lokasi</label>
                    <div class="md:col-span-3">
                        <div id="map" style="height: 400px; border-radius: 8px; z-index: 1;"></div>
                        <p class="mt-2 text-xs text-default-500">
                            Klik pada peta untuk memilih lokasi. Koordinat akan otomatis terisi.
                        </p>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="button" id="btnSubmit" class="btn bg-blue-600 hover:bg-blue-700 text-white">
                            Simpan Data
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var map = L.map('map').setView([-1.610122, 103.613120], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var marker;
            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            }).addTo(map);

            function setMarker(lat, lng, popupText) {
                if (marker) map.removeLayer(marker);

                marker = L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(popupText)
                    .openPopup();

                map.setView([lat, lng], 15);

                document.getElementById('koordinat').value = lat + ', ' + lng;
                document.getElementById('lokasi').value = popupText;
            }

            geocoder.on('markgeocode', function(e) {
                var lat = e.geocode.center.lat.toFixed(6);
                var lng = e.geocode.center.lng.toFixed(6);
                setMarker(lat, lng, e.geocode.name);
            });

            map.on('click', function(e) {
                var lat = e.latlng.lat.toFixed(6);
                var lng = e.latlng.lng.toFixed(6);
                setMarker(lat, lng, "Koordinat: " + lat + ", " + lng);
            });

            document.getElementById('koordinat').addEventListener('input', function() {
                let nilai = this.value.trim();

                // Format yang diharapkan: "-1.234567, 103.123456"
                let parts = nilai.split(',');

                if (parts.length === 2) {
                    let lat = parseFloat(parts[0]);
                    let lng = parseFloat(parts[1]);

                    // Validasi sederhana
                    if (!isNaN(lat) && !isNaN(lng)) {
                        setMarker(lat, lng, "Koordinat: " + lat + ", " + lng);
                    }
                }
            });

            // ============================
            // SUBMIT + VALIDASI (FIX)
            // ============================
            const form = document.getElementById('formAksara');
            const btnSubmit = document.getElementById('btnSubmit');

            btnSubmit.addEventListener('click', function() {

                // 1️⃣ Trigger validasi HTML5
                if (!form.checkValidity()) {
                    form.reportValidity(); // popup "Isi bidang ini"
                    return;
                }

                // 2️⃣ Kalau valid, konfirmasi
                Swal.fire({
                    title: 'Simpan Data Aksara?',
                    text: 'Pastikan semua data sudah benar sebelum disimpan.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#6B7280',
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
