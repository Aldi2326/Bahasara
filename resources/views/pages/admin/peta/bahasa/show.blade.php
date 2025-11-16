@extends('layouts.admin.app')
@section('title', 'Detail Bahasa')

@section('content')
<div class="card overflow-hidden print:border-0 print:shadow-none">
    <div class="card-header flex justify-between items-center print:hidden">
        <h4 class="card-title">Detail Data Bahasa</h4>
    </div>

    <div class="p-6 space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nama Wilayah -->
            <div>
                <h5 class="text-sm text-default-500">Nama Wilayah</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ $bahasa->wilayah->nama_wilayah ?? '-' }}
                </p>
            </div>

            <!-- Nama Bahasa -->
            <div>
                <h5 class="text-sm text-default-500">Nama Bahasa</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ $bahasa->namaBahasa->nama_bahasa ?? '-' }}
                </p>
            </div>

            <!-- Status Bahasa -->
            <div>
                <h5 class="text-sm text-default-500">Status Bahasa</h5>
                @switch($bahasa->status)
                @case('Aman')
                <span class="px-3 py-1 rounded text-white text-sm font-medium" style="background-color: #22C55E;">Aman</span>
                @break
                @case('Rentan')
                <span class="px-3 py-1 rounded text-black text-sm font-medium" style="background-color: #EAB308;">Rentan</span>
                @break
                @case('Pasti Terancam Punah')
                <span class="px-3 py-1 rounded text-white text-sm font-medium" style="background-color: #F59E0B;">Pasti Terancam Punah</span>
                @break
                @case('Sangat Terancam Punah')
                <span class="px-3 py-1 rounded text-white text-sm font-medium" style="background-color: #EF4444;">Sangat Terancam Punah</span>
                @break
                @case('Kritis')
                <span class="px-3 py-1 rounded text-white text-sm font-medium" style="background-color: #7F1D1D;">Kritis</span>
                @break
                @default
                <span class="px-3 py-1 rounded text-black text-sm font-medium" style="background-color: #94A3B8;">Tidak Diketahui</span>
                @endswitch
            </div>


            <!-- Jumlah Penutur -->
            <div>
                <h5 class="text-sm text-default-500">Jumlah Penutur</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ number_format($bahasa->jumlah_penutur) }} Penutur
                </p>
            </div>

            <!-- Alamat -->
            <div>
                <h5 class="text-sm text-default-500">Alamat</h5>
                <p class="text-base font-bold text-default-800 leading-relaxed">
                    {!! $bahasa->alamat ?? '-' !!}
                </p>
            </div>

            <!-- Koordinat -->
            <div>
                <h5 class="text-sm text-default-500">Koordinat</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ $bahasa->koordinat ?? '-' }}
                </p>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mt-6">
            <h5 class="text-sm text-default-500 mb-2">Deskripsi</h5>
            <p class="text-base text-default-800 leading-relaxed">
                {!! $bahasa->deskripsi ?? '-' !!}
            </p>
        </div>

        <!-- Tombol Aksi -->
        <div class="pt-6 border-t border-default-200 flex flex-wrap justify-between items-center gap-3 print:hidden">
            <!-- Tombol Kembali -->
            <div>
                <a href="{{ route('bahasa.index') }}"
                    class="btn bg-blue-600 text-white flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Tombol Edit & Hapus -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('bahasa.edit', $bahasa->id) }}"
                    class="btn bg-blue-600  text-white flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                <form id="deleteForm" action="{{ route('bahasa.destroy', $bahasa->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="btnDelete"
                        class="btn bg-red-600 text-white flex items-center gap-2">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Print Styling -->
<style>
    @media print {
        .print\:hidden {
            display: none !important;
        }

        .btn,
        form,
        .border-t {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }

        body {
            background: white;
            color: black;
            -webkit-print-color-adjust: exact;
        }

        @page {
            margin: 20mm;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteBtn = document.getElementById('btnDelete');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin ingin menghapus data ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC2626',
                    cancelButtonColor: '#4B5563',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteForm').submit();
                    }
                });
            });
        }
    });
</script>
@endsection