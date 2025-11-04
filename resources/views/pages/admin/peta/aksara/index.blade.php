@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Aksara</h4>
        <a href="{{ route('aksara.create') }}" class="btn bg-danger text-white">
            Tambah Data
        </a>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-4 flex justify-between items-center">
        <form action="{{ route('aksara.index') }}" method="GET"
            class="flex items-center space-x-2 w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-input w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Cari nama aksara...">
            <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
        </form>
    </div>

    @php
        $sortField = request('sort_by') ?? 'nama_aksara';
        $sortOrder = request('order') ?? 'asc';
    @endphp

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-default-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">
                        <a href="{{ route('aksara.index', ['sort_by' => 'nama_wilayah', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                            class="text-gray-600 hover:text-blue-600">
                            Nama Wilayah
                            {!! $sortField === 'nama_wilayah'
                                ? ($sortOrder === 'asc'
                                    ? '<i class="bi bi-sort-alpha-up"></i>'
                                    : '<i class="bi bi-sort-alpha-down"></i>')
                                : '<i class="bi bi-arrow-down-up"></i>' !!}
                        </a>
                    </th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">
                        <a href="{{ route('aksara.index', ['sort_by' => 'nama_aksara', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                            class="text-gray-600 hover:text-blue-600">
                            Nama Aksara
                            {!! $sortField === 'nama_aksara'
                                ? ($sortOrder === 'asc'
                                    ? '<i class="bi bi-sort-alpha-up"></i>'
                                    : '<i class="bi bi-sort-alpha-down"></i>')
                                : '<i class="bi bi-arrow-down-up"></i>' !!}
                        </a>
                    </th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">
                        <a href="{{ route('aksara.index', ['sort_by' => 'status', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                            class="text-gray-600 hover:text-blue-600">
                            Status
                            {!! $sortField === 'status'
                                ? ($sortOrder === 'asc'
                                    ? '<i class="bi bi-sort-alpha-up"></i>'
                                    : '<i class="bi bi-sort-alpha-down"></i>')
                                : '<i class="bi bi-arrow-down-up"></i>' !!}
                        </a>
                    </th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">Deskripsi</th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">Dokumentasi</th>
                    <th class="px-6 py-3 text-start text-sm text-default-500">Koordinat</th>
                    <th class="px-6 py-3 text-center text-sm text-default-500">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($aksara as $index => $item)
                    <tr class="odd:bg-white even:bg-default-100 hover:bg-default-200/50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-sm text-default-800">
                            {{ $item->wilayah->nama_wilayah ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_aksara }}</td>
                        <td class="px-6 py-4 text-sm text-default-800">
                            @if ($item->status == 'aktif')
                                <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">Aktif</span>
                            @else
                                <span class="px-2 py-1 rounded bg-red-500 text-white text-xs">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; max-width: 400px;">
                            {!! Str::limit($item->deskripsi, 10) !!}
                        </td>
                        <td class="px-6 py-4 text-sm text-default-800">
                            @if ($item->dokumentasi)
                                @if (Str::endsWith($item->dokumentasi, ['.mp4', '.mov', '.avi']))
                                    <video src="{{ asset('storage/' . $item->dokumentasi) }}" width="120" controls class="rounded-md shadow"></video>
                                @else
                                    <img src="{{ asset('storage/' . $item->dokumentasi) }}" alt="dokumentasi" width="100" class="rounded-md shadow">
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->koordinat ?? '-' }}</td>

                        <!-- Aksi -->
                        <td class="px-6 py-4 text-sm text-center font-medium flex justify-center space-x-3">
                            <a href="{{ route('aksara.show', $item->id) }}" class="text-green-600 hover:text-green-800" title="Lihat">
                                <i class="bi bi-eye fs-5"></i>
                            </a>
                            <a href="{{ route('aksara.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>

                            <form action="{{ route('aksara.destroy', $item->id) }}" method="POST" class="inline delete-form">
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
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-default-500">
                            Belum ada data aksara untuk wilayah ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

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
                text: 'Data yang dihapus tidak bisa dikembalikan!',
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
