@extends('layouts.admin.app')
@section('title', 'Detail Bahasa')

@section('content')
<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Detail Bahasa</h4>
        <a href="{{ route('bahasa.index') }}" class="btn bg-gray-600 text-white flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h5 class="text-sm text-default-500">Nama Bahasa</h5>
                <p class="text-base font-semibold text-default-800">{{ $bahasa['nama_bahasa'] }}</p>
            </div>

            <div>
                <h5 class="text-sm text-default-500">Status Bahasa</h5>
                @if ($bahasa['status'] === 'aktif')
                    <span class="px-3 py-1 rounded bg-green-500 text-white text-sm font-medium">Aktif</span>
                @else
                    <span class="px-3 py-1 rounded bg-red-500 text-white text-sm font-medium">Tidak Aktif</span>
                @endif
            </div>

            <div>
                <h5 class="text-sm text-default-500">Jumlah Penutur</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ number_format($bahasa['jumlah_penutur']) }} Penutur
                </p>
            </div>

            <div class="md:col-span-2">
                <h5 class="text-sm text-default-500">Deskripsi</h5>
                <p class="text-base text-default-800 leading-relaxed">
                    {!! $bahasa['deskripsi'] !!}
                </p>
            </div>
        </div>

        <div class="pt-4 border-t border-default-200 flex justify-end space-x-3">
            <!-- Tombol Edit -->
            <a href="{{ route('bahasa.edit', $bahasa->id) }}" 
               class="btn bg-blue-600 text-white flex items-center gap-2">
                <i class="bi bi-pencil-square"></i> Edit
            </a>

            <!-- Tombol Delete -->
            <form id="deleteForm" action="{{ route('bahasa.destroy', $bahasa->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" id="btnDelete" class="btn bg-red-600 text-white flex items-center gap-2">
                    <i class="bi bi-trash3"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btnDelete').addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Yakin ingin menghapus data ini?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
});
</script>
@endsection
