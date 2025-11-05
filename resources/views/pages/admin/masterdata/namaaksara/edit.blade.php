@extends('layouts.admin.app')
@section('title', 'aksara')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Nama aksara</h4>
    </div>

    <div class="p-6">
        
        <form class="flex flex-col gap-4" method="POST" action="{{ route('nama-aksara.store') }}" enctype="multipart/form-data">
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

            <!-- Nama aksara -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_aksara" class="text-default-800 text-sm font-medium">Nama aksara</label>
                <div class="md:col-span-3">
                    <input type="text" name="nama_aksara" id="nama_aksara" class="form-input"
                        placeholder="Contoh: aksara Melayu" required>
                </div>
            </div>

            <!-- Warna Pinpoint -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="warna_pin" class="text-default-800 text-sm font-medium">Warna Pinpoint</label>
                <div class="md:col-span-3 flex items-center gap-4">
                    <input type="color" name="warna_pin" id="warna_pin" class="w-16 h-10 cursor-pointer border rounded"
                        value="#2563eb">

                    <!-- Preview ikon pinpoint -->
                    <div id="pin-preview" class="flex items-center gap-2">
                        <svg id="pin-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#2563eb">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5
                            c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                        </svg>
                    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorInput = document.getElementById('warna_pin');
        const pinIcon = document.getElementById('pin-icon');

        colorInput.addEventListener('input', () => {
            pinIcon.setAttribute('fill', colorInput.value);
        });
    });
</script>
@endsection
