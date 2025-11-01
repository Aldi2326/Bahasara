@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Input Data Wilayah</h4>
        </div>
        <div class="p-6">
            <form id="formWilayah" class="flex flex-col gap-4" method="POST" action="{{ route('wilayah.store') }}"
                enctype="multipart/form-data">
                @csrf

                <!-- Nama Wilayah -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_wilayah" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                    <div class="md:col-span-3">
                        <input type="text" name="nama_wilayah" id="nama_wilayah" class="form-input"
                            placeholder="Contoh: Kota Jambi" required>
                    </div>
                </div>

                <!-- Upload GeoJSON -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="geojson_file" class="text-default-800 text-sm font-medium">File GeoJSON</label>
                    <div class="md:col-span-3">
                        <input type="file" name="file_geojson" id="geojson_file" class="form-input"
                            accept=".geojson,application/geo+json" required>
                        <p class="mt-1 text-xs text-default-500">
                            Hanya file dengan format <b>.geojson</b> (maks 2MB)
                        </p>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="button" id="btnSubmit" class="btn bg-info text-white">Simpan Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnSubmit = document.getElementById("btnSubmit");
            const form = document.getElementById("formWilayah");

            btnSubmit.addEventListener("click", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah data sudah benar?',
                    text: "Pastikan nama wilayah dan file GeoJSON sudah sesuai!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
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
