@extends('layouts.admin.app')
@section('title', 'Edit Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Bahasa</h4>
    </div>

    <div class="p-6">
        <form id="editBahasaForm" class="flex flex-col gap-4" action="{{ route('bahasa.update', $bahasa->id) }}" method="POST">
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
                            <option value="{{ $wilayah->id }}" {{ $bahasa->wilayah_id == $wilayah->id ? 'selected' : '' }}>
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
                        <option value="Bahasa Melayu Jambi" {{ $bahasa->nama_bahasa == 'Bahasa Melayu Jambi' ? 'selected' : '' }}>Bahasa Melayu Jambi</option>
                        <option value="Bahasa Bajau Tungkal Satu" {{ $bahasa->nama_bahasa == 'Bahasa Bajau Tungkal Satu' ? 'selected' : '' }}>Bahasa Bajau Tungkal Satu</option>
                        <option value="Bahasa Banjar" {{ $bahasa->nama_bahasa == 'Bahasa Banjar' ? 'selected' : '' }}>Bahasa Banjar</option>
                        <option value="Bahasa Bugis" {{ $bahasa->nama_bahasa == 'Bahasa Bugis' ? 'selected' : '' }}>Bahasa Bugis</option>
                        <option value="Bahasa Kerinci" {{ $bahasa->nama_bahasa == 'Bahasa Kerinci' ? 'selected' : '' }}>Bahasa Kerinci</option>
                        <option value="Bahasa Minangkabau" {{ $bahasa->nama_bahasa == 'Bahasa Minangkabau' ? 'selected' : '' }}>Bahasa Minangkabau</option>
                        <option value="Bahasa Jawa" {{ $bahasa->nama_bahasa == 'Bahasa Jawa' ? 'selected' : '' }}>Bahasa Jawa</option>
                    </select>
                </div>
            </div>

            <!-- Alamat -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="alamat" class="text-default-800 text-sm font-medium">Alamat</label>
                <div class="md:col-span-3">
                     <textarea id="froala-editor" name="alamat" required>{{ old('alamat', $bahasa->alamat) }}</textarea>
                </div>
            </div>

            <!-- Status Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status_bahasa" class="text-default-800 text-sm font-medium">Status Bahasa</label>
                <div class="md:col-span-3">
                    <select name="status" id="status_bahasa" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif" {{ $bahasa->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $bahasa->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Jumlah Penutur -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="jumlah_penutur" class="text-default-800 text-sm font-medium">Jumlah Penutur</label>
                <div class="md:col-span-3">
                    <input type="number" name="jumlah_penutur" id="jumlah_penutur" class="form-input" value="{{ $bahasa->jumlah_penutur }}" required>
                </div>
            </div>

            <!-- Koordinat -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="koordinat" class="text-default-800 text-sm font-medium">Koordinat</label>
                <div class="md:col-span-3">
                    <input type="text" name="koordinat" id="koordinat" class="form-input" value="{{ $bahasa->koordinat }}" required>
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
                    <textarea id="froala-editor" name="deskripsi" required>{{ old('deskripsi', $bahasa->deskripsi) }}</textarea>
                </div>
            </div>

            <!-- Tombol -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2 flex gap-4">
                    <button type="submit" class="btn bg-info text-white">Update Data</button>
                    <a href="{{ route('bahasa.index') }}" class="btn bg-gray-400 text-white">Batal</a>
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
    // ======== Leaflet ========
    let koordinatString = "{{ $bahasa->koordinat }}";
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

    // ======== SweetAlert Konfirmasi Update ========
    const form = document.getElementById('editBahasaForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        Swal.fire({
            title: 'Perbarui Data?',
            text: "Perubahan akan disimpan permanen.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update!',
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
