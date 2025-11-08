@extends('layouts.admin.app')
@section('title', 'Detail Aksara')

@section('content')
<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Detail Aksara</h4>
        <a href="{{ route('aksara.index') }}" class="btn bg-gray-600 text-white flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h5 class="text-sm text-default-500">Nama Aksara</h5>
                <p class="text-base font-semibold text-default-800">{{ $aksara['nama_aksara'] }}</p>
            </div>

            <div>
                <h5 class="text-sm text-default-500">Status</h5>
                @if ($aksara['status'] === 'aktif')
                    <span class="px-3 py-1 rounded bg-green-500 text-white text-sm font-medium">Aktif</span>
                @else
                    <span class="px-3 py-1 rounded bg-red-500 text-white text-sm font-medium">Tidak Aktif</span>
                @endif
            </div>

            <div>
                <h5 class="text-sm text-default-500">Jumlah Penutur</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ number_format($aksara['jumlah_penutur']) }} Penutur
                </p>
            </div>

            <div class="md:col-span-2">
                <h5 class="text-sm text-default-500">Deskripsi</h5>
                <p class="text-base text-default-800 leading-relaxed">
                    {!! $aksara['deskripsi'] !!}
                </p>
            </div>
        </div>

        <div class="pt-4 border-t border-default-200 flex justify-end space-x-3">
            <!-- Tombol Edit -->
            <a href="{{ route('aksara.edit', $aksara->id) }}" 
               class="btn bg-blue-600 text-white flex items-center gap-2">
                <i class="bi bi-pencil-square"></i> Edit
            </a>

            <!-- Tombol Delete -->
            <form action="{{ route('aksara.destroy', $aksara->id) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn bg-red-600 text-white flex items-center gap-2 btn-delete">
                    <i class="bi bi-trash3"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection
