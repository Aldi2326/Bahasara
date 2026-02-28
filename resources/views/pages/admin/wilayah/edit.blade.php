@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('wilayah.index') }}" class="text-sm font-medium text-default-700">Wilayah</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Edit Data Wilayah</p>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Edit Data Wilayah</h4>
        </div>
        <div class="p-6">

            <form id="formWilayah" class="flex flex-col gap-4" method="POST" action="{{ route('wilayah.update', $wilayah->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Wilayah -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_wilayah" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                    <div class="md:col-span-3">
                        <input value="{{ $wilayah->nama_wilayah }}" type="text" name="nama_wilayah" id="nama_wilayah"
                            class="form-input" placeholder="Contoh: Kota Jambi" required>
                        @error('nama_wilayah')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Upload GeoJSON -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="geojson_file" class="text-default-800 text-sm font-medium">File GeoJSON</label>
                    <div class="md:col-span-3">
                        <input type="file" name="file_geojson" id="geojson_file" class="form-input"
                            accept=".geojson,application/geo+json">
                        <p class="mt-1 text-xs text-default-500">
                            File saat ini: <b>{{ basename($wilayah->file_geojson) }}</b>
                            <br>Biarkan kosong jika tidak ingin mengubah file.
                        </p>
                        @error('file_geojson')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="button" id="btnSubmit" class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">Simpan Data</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnSubmit = document.getElementById("btnSubmit");
            const form = document.getElementById("formWilayah");

            btnSubmit.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    text: "Pastikan data wilayah sudah benar sebelum disimpan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#4B5563',
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
