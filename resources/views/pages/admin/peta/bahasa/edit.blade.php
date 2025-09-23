@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Bahasa</h4>
    </div>
    <div class="p-6">

        <form class="flex flex-col gap-4" method="POST" action="" enctype="multipart/form-data">
            @csrf

            <!-- Nama Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Bahasa</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama_bahasa" id="nama_bahasa" class="form-input" placeholder="Contoh: Bahasa Melayu Jambi" required>
                </div>
            </div>

            <!-- Status Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status_bahasa" class="text-default-800 text-sm font-medium">Status Bahasa</label>
                <div class="md:col-span-3">
                    <select name="status_bahasa" id="status_bahasa" class="form-select" required>
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

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input" placeholder="Tuliskan deskripsi lengkap bahasa..." required></textarea>
                    <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan lebih detail (mendukung teks panjang)</p>
                </div>
            </div>

            <!-- Upload GeoJSON -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="geojson_file" class="text-default-800 text-sm font-medium">File GeoJSON</label>
                <div class="md:col-span-3">
                    <input type="file" name="geojson_file" id="geojson_file" class="form-input" accept=".geojson,application/geo+json" required>
                    <p class="mt-1 text-xs text-default-500">Hanya file dengan format <b>.geojson</b> (maks 2MB)</p>
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
@endsection
