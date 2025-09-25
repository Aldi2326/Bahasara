@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Wilayah</h4>
    </div>
    <div class="p-6">

        <form class="flex flex-col gap-4" method="POST" action="{{ route('wilayah.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nama Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama_wilayah" id="nama_bahasa" class="form-input" placeholder="Contoh: Kota Jambi" required>
                </div>
            </div>

            <!-- Upload GeoJSON -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="geojson_file" class="text-default-800 text-sm font-medium">File GeoJSON</label>
                <div class="md:col-span-3">
                    <input type="file" name="file_geojson" id="geojson_file" class="form-input" accept=".geojson,application/geo+json" required>
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
