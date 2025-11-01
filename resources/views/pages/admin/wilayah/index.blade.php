@extends('layouts.admin.app')
@section('title', 'Wilayah')
@section('content')

<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Wilayah</h4>
        <a href="{{ route('wilayah.create') }}" class="btn bg-danger text-white">
            Tambah Wilayah
        </a>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-4 flex justify-between items-center">
        <form action="{{ route('wilayah.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-input w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Cari nama wilayah...">
            <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-default-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                            <th class="px-6 py-3 text-start text-sm text-default-500">
                                <div class="flex items-center gap-1">
                                    <span>Nama Wilayah</span>
                                    @php
                                        $sortOrder = request('sort') === 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ route('wilayah.index', ['search' => request('search'), 'sort' => $sortOrder]) }}"
                                        class="text-gray-600 hover:text-blue-600">
                                        @if (request('sort') === 'asc')
                                            <i class="bi bi-sort-alpha-up"></i>
                                        @elseif(request('sort') === 'desc')
                                            <i class="bi bi-sort-alpha-down"></i>
                                        @else
                                            <i class="bi bi-arrow-down-up"></i>
                                        @endif
                                    </a>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-center text-sm text-default-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wilayah as $index => $item)
                            <tr class="odd:bg-white even:bg-default-100 hover:bg-default-200/50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_wilayah }}</td>
                                <td class="px-6 py-4 text-sm text-center font-medium flex justify-center space-x-3">

                                    <!-- Tombol Edit -->
                                    <a href="{{ route('wilayah.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('wilayah.destroy', $item->id) }}" method="POST" class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 btn-delete" title="Hapus">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">Data wilayah belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".btn-delete");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                const form = this.closest("form");

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data wilayah yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
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
