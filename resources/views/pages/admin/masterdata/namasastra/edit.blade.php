@extends('layouts.admin.app')
@section('title', 'Edit Nama Sastra')

@section('content')
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('nama-sastra.index') }}" class="text-sm font-medium text-default-700">Sastra</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Edit Nama Sastra</p>
    </div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Nama Sastra</h4>
    </div>

    <div class="p-6">
        <form id="editSastraForm" class="flex flex-col gap-4" method="POST" action="{{ route('nama-sastra.update', $namaSastra) }}" enctype="multipart/form-data">
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

            <!-- Nama Sastra -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_sastra" class="text-default-800 text-sm font-medium">Nama Sastra</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama_sastra" id="nama_sastra" class="form-input"
                        value="{{ old('nama_sastra', $namaSastra->nama_sastra) }}" required>
                </div>
            </div>

            <!-- Warna Pinpoint -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="warna_pin" class="text-default-800 text-sm font-medium">Warna Pinpoint</label>
                <div class="md:col-span-3 flex items-center gap-4">
                    <input type="color" name="warna_pin" id="warna_pin" class="w-16 h-10 cursor-pointer border rounded"
                        value="{{ old('warna_pin', $namaSastra->warna_pin) }}">

                    <!-- Preview ikon pinpoint -->
                    <div id="pin-preview" class="flex items-center gap-2">
                        <svg id="pin-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="{{ old('warna_pin', $namaSastra->warna_pin) }}">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5
                            c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">Simpan Data</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ======== SweetAlert2 ======== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorInput = document.getElementById('warna_pin');
        const pinIcon = document.getElementById('pin-icon');
        const form = document.getElementById('editSastraForm');

        // Preview warna pinpoint
        colorInput.addEventListener('input', () => {
            pinIcon.setAttribute('fill', colorInput.value);
        });

        // SweetAlert konfirmasi sebelum submit
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Cegah submit langsung

            Swal.fire({
                title: 'Simpan Data?',
                text: "Perubahan akan disimpan permanen.",
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
