@extends('layouts.admin.app')
@section('title', 'Wilayah')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Wilayah</h4>
    </div>

    <div class="p-6">
        <form id="formWilayah" class="flex flex-col gap-4" method="POST" action="{{ route('wilayah.store') }}" enctype="multipart/form-data">
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
                <label for="nama_wilayah" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama_wilayah" id="nama_wilayah" class="form-input"
                        placeholder="Contoh: Kota Jambi" required>
                </div>
            </div>

            <!-- Upload GeoJSON -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="file_geojson" class="text-default-800 text-sm font-medium">File GeoJSON</label>
                <div class="md:col-span-3">
                    <input type="file" name="file_geojson" id="file_geojson" class="form-input"
                        accept=".geojson,application/geo+json" required>
                    <p class="mt-1 text-xs text-default-500">
                        Hanya file dengan format <b>.geojson</b> (maks 2MB)
                    </p>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="submit"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                        Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ======== SweetAlert2 ======== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formWilayah');

        // ======== SweetAlert konfirmasi sebelum submit ========
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // cegah submit langsung

            Swal.fire({
                title: 'Simpan Data?',
                text: "Pastikan nama wilayah dan file GeoJSON sudah benar sebelum disimpan.",
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
