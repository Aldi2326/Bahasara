@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Bahasa</h4>
    </div>

    <div class="p-6">
        <form id="bahasaForm" class="flex flex-col gap-4" action="{{ route('bahasa.store') }}" method="POST">
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

            <!-- Nama Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Bahasa</label>
                <div class="md:col-span-3">
                    <select name="nama_bahasa" id="nama_bahasa" class="form-select" required>
                        <option value="">-- Pilih Bahasa --</option>
                        <option value="Bahasa Melayu Jambi">Bahasa Melayu Jambi</option>
                        <option value="Bahasa Bajau Tungkal Satu">Bahasa Bajau Tungkal Satu</option>
                        <option value="Bahasa Banjar">Bahasa Banjar</option>
                        <option value="Bahasa Bugis">Bahasa Bugis</option>
                        <option value="Bahasa Kerinci">Bahasa Kerinci</option>
                        <option value="Bahasa Minangkabau">Bahasa Minangkabau</option>
                        <option value="Bahasa Jawa">Bahasa Jawa</option>                     
                    </select>
                </div>
            </div>
            
            <!-- Alamat -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                <div class="md:col-span-3">
                    <textarea name="alamat" id="alamat" rows="3" class="form-input" placeholder="Masukkan alamat lengkap lokasi bahasa..." required></textarea>
                </div>
            </div>

            <!-- Status Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status_bahasa" class="text-default-800 text-sm font-medium">Status Bahasa</label>
                <div class="md:col-span-3">
                    <select name="status" id="status_bahasa" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Jumlah Penutur -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="jumlah_penutur" class="text-default-800 text-sm font-medium">Jumlah Penutur</label>
                <div class="md:col-span-3">
                    <input type="number" name="jumlah_penutur" id="jumlah_penutur" class="form-input" placeholder="Contoh: 50000" required>
                </div>
            </div>

            <!-- Input Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input" placeholder="Klik peta atau isi manual, contoh: -1.234567, 103.123456" step="0.0000001" required>
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

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi lengkap bahasa..." required></textarea>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="submit" class="btn bg-info text-white">Simpan Data</button>
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
document.addEventListener("DOMContentLoaded", function () {
    // Inisialisasi Peta
    var map = L.map('map').setView([-1.610122, 103.613120], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker;

    map.on('click', function (e) {
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
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Cegah submit langsung

        Swal.fire({
            title: 'Simpan Data?',
            text: "Pastikan data sudah benar sebelum disimpan.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan!',
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
