@extends('layouts.admin.app')
@section('title', 'Pengumuman')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Pengumuman</p>
    </div>

    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">

        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Pengumuman</h4>
            <div class="flex gap-2">
                <button type="button" id="btn-bulk-delete" style="display: none;"
                    class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
                </button>

                <a href="{{ route('pengumuman.create') }}"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                    Tambah Pengumuman
                </a>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
            <form action="{{ route('pengumuman.index') }}" method="GET" class="flex items-center w-full md:w-1/3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
                    placeholder="Cari judul atau isi pengumuman...">
                <button type="submit"
                    class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md h-[38px]">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap w-10">
                            <input type="checkbox" id="select_all_ids" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>

                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3 w-[250px]">
                            <div class="flex justify-center items-center gap-1">
                                <span>Judul</span>
                                @php
                                    $nextOrder = $sortBy === 'judul' && $sortDir === 'asc' ? 'desc' : 'asc';
                                @endphp
                                <a href="{{ route('pengumuman.index', [
                                    'search' => request('search'),
                                    'sort_by' => 'judul',
                                    'sort_dir' => $nextOrder,
                                ]) }}"
                                    class="text-gray-600 hover:text-blue-600">
                                    @if ($sortBy === 'judul' && $sortDir === 'asc')
                                        <i class="bi bi-sort-alpha-down"></i>
                                    @elseif ($sortBy === 'judul' && $sortDir === 'desc')
                                        <i class="bi bi-sort-alpha-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up"></i>
                                    @endif
                                </a>
                            </div>
                        </th>
                        <th class="px-4 py-3 w-[250px]">
                            <div class="flex justify-center items-center gap-1">
                                <span>Tanggal</span>
                                @php
                                    $nextOrder = $sortBy === 'tanggal' && $sortDir === 'asc' ? 'desc' : 'asc';
                                @endphp
                                <a href="{{ route('pengumuman.index', [
                                    'search' => request('search'),
                                    'sort_by' => 'tanggal',
                                    'sort_dir' => $nextOrder,
                                ]) }}"
                                    class="text-gray-600 hover:text-blue-600">
                                    @if ($sortBy === 'tanggal' && $sortDir === 'asc')
                                        <i class="bi bi-sort-numeric-down"></i>
                                    @elseif ($sortBy === 'tanggal' && $sortDir === 'desc')
                                        <i class="bi bi-sort-numeric-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down-up"></i>
                                    @endif
                                </a>
                            </div>
                        </th>
                        <th class="px-4 py-3 w-[350px]">Isi Pengumuman</th>
                        <th class="px-4 py-3 w-[200px]">Dokumentasi</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($pengumuman as $index => $item)
                        <tr class="hover:bg-gray-50 transition" id="tr_{{ $item->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids" class="checkbox_ids rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $item->id }}">
                            </td>

                            <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 text-gray-800">
                                {{ $item->judul }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 truncate max-w-[220px]" title="{{ strip_tags($item->isi) }}">
                                {{ Str::limit(strip_tags($item->isi), 40) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->dokumentasi)
                                    @if (Str::endsWith($item->dokumentasi, ['.mp4', '.mov', '.avi']))
                                        <video src="{{ asset('storage/' . $item->dokumentasi) }}" width="90" controls
                                            class="rounded shadow mx-auto"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $item->dokumentasi) }}" alt="dokumentasi"
                                            width="80" class="rounded shadow mx-auto">
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('pengumuman.show', $item->id) }}"
                                        class="text-green-600 hover:text-green-800" title="Lihat">
                                        <i class="bi bi-eye fs-5"></i>
                                    </a>

                                    <a href="{{ route('pengumuman.edit', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>

                                    <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-800 btn-delete"
                                            title="Hapus" data-title="{{ $item->judul }}">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada pengumuman yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-bulk-delete" action="{{ route('pengumuman.bulk_delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk_delete_ids">
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. Single Delete Script (Bawaan) ---
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const title = this.dataset.title;
                    Swal.fire({
                        title: `Hapus pengumuman "${title}"?`,
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // --- 2. Bulk Delete Script (Baru) ---
            const selectAllCheckbox = document.getElementById('select_all_ids');
            const allCheckboxes = document.querySelectorAll('.checkbox_ids');
            const bulkDeleteBtn = document.getElementById('btn-bulk-delete');
            const countSelectedSpan = document.getElementById('count-selected');

            // Fungsi Update Tombol
            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.checkbox_ids:checked').length;
                countSelectedSpan.textContent = checkedCount;

                if (checkedCount > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            // Logic Select All
            selectAllCheckbox.addEventListener('change', function() {
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });

            // Logic Checkbox Per Baris
            allCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    }
                    if (document.querySelectorAll('.checkbox_ids:checked').length === allCheckboxes.length) {
                        selectAllCheckbox.checked = true;
                    }
                    updateBulkDeleteButton();
                });
            });

            // Logic Action Tombol Bulk Delete
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();

                const allIds = [];
                document.querySelectorAll('.checkbox_ids:checked').forEach(checkbox => {
                    allIds.push(checkbox.value);
                });

                if (allIds.length === 0) return;

                Swal.fire({
                    title: 'Hapus data terpilih?',
                    text: `Anda akan menghapus ${allIds.length} pengumuman. Data tidak bisa dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('bulk_delete_ids').value = allIds.join(',');
                        document.getElementById('form-bulk-delete').submit();
                    }
                });
            });
        });
    </script>
@endsection