@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Input Data Bahasa</h4>
        </div>

        <div class="p-6">
            <form id="bahasaForm" class="flex flex-col gap-4" action="{{ route('bahasa.store') }}" method="POST"
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

                <!-- Nama Bahasa -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Bahasa</label>
                    <div class="md:col-span-3">
                        <select name="nama_bahasa_id" id="nama_bahasa_id" class="form-select" required>
                            <option value="">-- Pilih Bahasa --</option>
                            @foreach ($namaBahasaList as $nb)
                                <option value="{{ $nb->id }}"
                                    {{ old('nama_bahasa_id') == $nb->id ? 'selected' : '' }}>
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
                        <textarea id="froala-editor" name="alamat" class="prose" required></textarea>
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
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Masukkan jumlah penutur"
                            required>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="deskripsi" class="prose"></textarea>
                    </div>
                </div>

                <!-- Input Koordinat dan Lokasi -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" step="0.0000001"
                            required>
                        <input type="hidden" name="lokasi" id="lokasi">
                    </div>
                </div>

                <!-- Peta Interaktif -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label class="text-default-800 text-sm font-medium">Peta Lokasi</label>
                    <div class="md:col-span-3">
                        <div id="map" style="height: 400px; border-radius: 8px; z-index: 1;"></div>
                        <p class="mt-2 text-xs text-default-500">
                            Klik pada peta untuk memilih lokasi. Koordinat dan lokasi akan otomatis terisi.
                        </p>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button id="btnSubmit" type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white">Simpan Data</button>
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
                marker = L.marker([lat, lng]).addTo(map)
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
                // Langsung gunakan koordinat sebagai "lokasi" sementara
                setMarker(lat, lng, "Koordinat: " + lat + ", " + lng);
            });

            // ============================
            //  SweetAlert Konfirmasi Submit
            // ============================
            document.getElementById('btnSubmit').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Simpan Data Bahasa?',
                    text: "Pastikan semua data sudah benar sebelum menyimpan.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#4B5563',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('bahasaForm').submit();
                    }
                });
            });
        });
    </script>
@endsection
