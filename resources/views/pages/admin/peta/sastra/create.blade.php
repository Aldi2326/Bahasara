@extends('layouts.admin.app')
@section('title', 'Sastra')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('sastra.index') }}" class="text-sm font-medium text-default-700">Data Sastra</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Input Data Sastra</p>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Input Data Sastra</h4>
        </div>

        <div class="p-6">
            <form id="sastraForm" class="flex flex-col gap-4" action="{{ route('sastra.store') }}" method="POST"
                enctype="multipart/form-data">
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
                        @error('wilayah_id')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nama Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_sastra_id" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                    <div class="md:col-span-3">
                        <select name="nama_sastra_id" id="nama_sastra_id" class="form-select" required>
                            <option value="">-- Pilih Sastra --</option>
                            @foreach ($namaSastraList as $ns)
                                <option value="{{ $ns->id }}"
                                    {{ old('nama_sastra_id', $sastra->nama_sastra_id ?? '') == $ns->id ? 'selected' : '' }}>
                                    {{ $ns->nama_sastra }}
                                </option>
                            @endforeach
                        </select>
                        @error('nama_sastra_id')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Alamat -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="alamat" class="prose"></textarea>
                    </div>
                    @error('alamat')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Sastra -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="jenis" class="text-default-800 text-sm font-medium">Jenis Sastra</label>
                    <div class="md:col-span-3">
                        <select name="jenis" id="jenis" class="form-select" required>
                            <option value="">-- Pilih Jenis Sastra --</option>
                            <option value="lisan">Lisan</option>
                            <option value="tulisan">Tulisan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        @error('jenis')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="deskripsi" class="prose"></textarea>
                    </div>
                    @error('deskripsi')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dokumentasi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                    <div class="md:col-span-3">
                        <input type="file" name="dokumentasi" id="dokumentasi" class="form-input"
                            accept="image/*,video/*,application/pdf" required>
                        <p class="mt-1 text-xs text-default-500">
                            Unggah file jpg, jpeg, png, webp, pdf. Maksimal 2MB.
                        </p>
                        @error('dokumentasi')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="dokumentasi_yt" class="text-default-800 text-sm font-medium">Dokumentasi Youtube
                        (Opsional)</label>
                    <div class="md:col-span-3">
                        <input type="text" name="dokumentasi_yt" id="dokumentasi_yt" class="form-input"
                            placeholder="Masukkan Link Video Youtube">
                        @error('dokumentasi_yt')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                            
                    </div>
                </div>

                <!-- Input Koordinat -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                    <div class="md:col-span-3">
                        <input type="text" name="koordinat" id="koordinat" class="form-input"
                            placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" step="0.0000001"
                            required>
                        <input type="hidden" name="lokasi" id="lokasi">
                        @error('koordinat')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror

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
                        @error('lokasi')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. MATIKAN fitur browser yang mengingat posisi scroll terakhir.
            // Ini PENTING agar browser tidak memaksa layar kembali ke tombol submit.
            if ('scrollRestoration' in history) {
                history.scrollRestoration = 'manual';
            }

            // 2. Gunakan setTimeout agar script jalan SETELAH browser selesai me-render halaman
            setTimeout(function() {
                // Cari elemen error (prioritaskan pesan text merah dulu karena pasti terlihat)
                let errorElement = document.querySelector('.text-red-500');
                
                // Jika tidak ada text merah, cari input yang border merah
                if (!errorElement) {
                    errorElement = document.querySelector('.border-red-500');
                }

                if (errorElement) {
                    // Debugging: Cek di console apakah elemen ketemu
                    console.log("Scroll ke:", errorElement);

                    // 3. Scroll dengan opsi 'center' agar elemen pas di tengah mata
                    errorElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center', 
                        inline: 'nearest'
                    });

                    // 4. Fokus kursor (hanya jika elemennya input biasa)
                    if (['INPUT', 'SELECT', 'TEXTAREA'].includes(errorElement.tagName)) {
                        // preventScroll: true agar tidak bentrok dengan scrollIntoView di atas
                        errorElement.focus({ preventScroll: true }); 
                    }
                } else {
                    // Jika tidak ada error, kembalikan scroll ke paling atas
                    window.scrollTo(0, 0);
                }
            }, 300); // Delay 300ms (0.3 detik) memberi waktu browser "bernapas" dulu

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

            // ================================
            // SweetAlert konfirmasi sebelum submit
            // ================================
            const form = document.getElementById('sastraForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

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
