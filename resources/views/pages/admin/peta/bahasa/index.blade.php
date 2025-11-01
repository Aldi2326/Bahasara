@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')

    @php
        function nextOrder($currentOrder)
        {
            return $currentOrder === 'asc' ? 'desc' : 'asc';
        }
    @endphp

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Daftar Bahasa</h4>
            <a href="{{ route('bahasa.create') }}" class="btn bg-danger text-white">Tambah Data</a>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-4 flex justify-between items-center">
            <form action="{{ route('bahasa.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input w-full border rounded-md px-3 py-2 text-sm"
                    placeholder="Cari nama bahasa atau wilayah...">
                <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
            </form>
        </div>

        <div>
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
                                            <a href="?sort_by=nama_wilayah&order={{ nextOrder($order) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                @if ($sortBy === 'nama_wilayah' && $order === 'asc')
                                                    <i class="bi bi-sort-alpha-up"></i>
                                                @elseif ($sortBy === 'nama_wilayah' && $order === 'desc')
                                                    <i class="bi bi-sort-alpha-down"></i>
                                                @else
                                                    <i class="bi bi-arrow-down-up"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Nama Bahasa</span>
                                            <a href="?sort_by=nama_bahasa&order={{ nextOrder($order) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                @if ($sortBy === 'nama_bahasa' && $order === 'asc')
                                                    <i class="bi bi-sort-alpha-up"></i>
                                                @elseif ($sortBy === 'nama_bahasa' && $order === 'desc')
                                                    <i class="bi bi-sort-alpha-down"></i>
                                                @else
                                                    <i class="bi bi-arrow-down-up"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">Alamat</th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Status Bahasa</th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Jumlah Penutur</th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Deskripsi</th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Koordinat</th>
                                    <th class="px-6 py-3 text-center text-sm text-default-500">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bahasa as $key => $item)
                                    <tr class="odd:bg-white even:bg-default-100 hover:bg-default-200/50 transition">
                                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $key + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            {{ $item->wilayah ? $item->wilayah->nama_wilayah : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_bahasa }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->alamat }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            @if ($item->status === 'aktif')
                                                <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 rounded bg-red-500 text-white text-xs">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            {{ number_format($item->jumlah_penutur) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800"
                                            style="white-space:normal;word-wrap:break-word;">
                                            {{ Str::limit(strip_tags($item->deskripsi), 80) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->koordinat ?? '-' }}</td>

                                        <!-- Kolom Aksi -->
                                        <td class="px-6 py-4 text-sm text-center font-medium flex justify-center space-x-3">
                                            <a href="{{ route('bahasa.show', $item->id) }}" class="text-green-600 hover:text-green-800" title="Lihat">
                                                <i class="bi bi-eye fs-5"></i>
                                            </a>
                                            <a href="{{ route('bahasa.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                                <i class="bi bi-pencil-square fs-5"></i>
                                            </a>

                                            <!-- Tombol Hapus dengan SweetAlert -->
                                            <form action="{{ route('bahasa.destroy', $item->id) }}" method="POST" class="delete-form inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-btn text-red-600 hover:text-red-800" title="Hapus">
                                                    <i class="bi bi-trash fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-gray-500">Tidak ada data bahasa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-form');
                    
                    Swal.fire({
                        title: 'Yakin hapus data ini?',
                        text: "Data yang dihapus tidak dapat dikembalikan.",
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
