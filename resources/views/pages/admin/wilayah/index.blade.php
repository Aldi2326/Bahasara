@extends('layouts.admin.app')
@section('title', 'Wilayah')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Wilayah</p>

    </div>
    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">
        <!-- Header -->
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Wilayah</h4>
            <a href="{{ route('wilayah.create') }}"
                class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                Tambah Data
            </a>
        </div>

        <!-- Search Bar -->
        <div
            class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
            <form action="{{ route('wilayah.index') }}" method="GET" class="flex items-center w-full md:w-1/3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
                    placeholder="Cari nama wilayah...">
                <button type="submit"
                    class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md h-[38px]">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 w-[40px]">No</th>
                        <th class="px-4 py-3 w-[250px]">
                            <div class="flex justify-center items-center gap-1">
                                <span>Nama Wilayah</span>
                                @php
                                    $sortOrder = request('sort') === 'asc' ? 'desc' : 'asc';
                                @endphp
                                <a href="{{ route('wilayah.index', ['search' => request('search'), 'sort' => $sortOrder]) }}"
                                    class="text-gray-600 hover:text-blue-600">
                                    @if (request('sort') === 'asc')
                                        <i class="bi bi-sort-alpha-up"></i>
                                    @elseif (request('sort') === 'desc')
                                        <i class="bi bi-sort-alpha-down"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up"></i>
                                    @endif
                                </a>
                            </div>
                        </th>
                        <th class="px-4 py-3 w-[100px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($wilayah as $index => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $item->nama_wilayah }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('wilayah.edit', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('wilayah.destroy', $item->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 btn-delete"
                                            title="Hapus" data-name="{{ $item->nama_wilayah }}">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada data wilayah yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Konfirmasi Hapus -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const nama = this.dataset.name;
                    Swal.fire({
                        title: `Hapus "${nama}"?`,
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC2626',
                        cancelButtonColor: '#4B5563',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
@endsection
