@extends('layouts.admin.app')
@section('title', 'Sastra')

@section('content')
    @php
        $sortField = request('sort_by', 'nama_sastra');
        $sortOrder = request('order', 'asc');
        $nextOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
    @endphp
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Data Sastra</p>
    </div>

    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Sastra</h4>
            <div class="flex gap-2">
                <button type="button" id="btn-bulk-delete" style="display: none;"
                    class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
                </button>

                <a href="{{ route('sastra.create') }}"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
            <form action="{{ route('sastra.index') }}" method="GET" class="flex items-center w-full md:w-1/3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
                    placeholder="Cari nama sastra atau wilayah...">
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

                        <th class="px-4 py-3 w-[160px] whitespace-nowrap">
                            <a href="{{ route('sastra.index', ['sort_by' => 'nama_wilayah', 'order' => $sortField === 'nama_wilayah' ? $nextOrder : 'asc']) }}"
                                class="flex justify-center items-center gap-1 hover:text-blue-600">
                                <span class="whitespace-nowrap">Nama Wilayah</span>
                                {!! $sortField === 'nama_wilayah'
                                    ? ($sortOrder === 'asc'
                                        ? '<i class="bi bi-sort-alpha-up"></i>'
                                        : '<i class="bi bi-sort-alpha-down"></i>')
                                    : '<i class="bi bi-arrow-down-up"></i>' !!}
                            </a>
                        </th>

                        <th class="px-4 py-3 whitespace-nowrap">Nama Sastra</th>
                        <th class="px-4 py-3 whitespace-nowrap">Alamat</th>
                        <th class="px-4 py-3 whitespace-nowrap">Jenis Sastra</th>
                        <th class="px-4 py-3 whitespace-nowrap">Deskripsi</th>
                        <th class="px-4 py-3 whitespace-nowrap">Dokumentasi</th>
                        <th class="px-4 py-3 whitespace-nowrap">Dokumentasi YT</th>
                        <th class="px-4 py-3 whitespace-nowrap">Koordinat</th>
                        <th class="px-4 py-3 whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($sastra as $index => $item)
                        <tr class="hover:bg-gray-50 transition text-center" id="tr_{{ $item->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids" class="checkbox_ids rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $item->id }}">
                            </td>

                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 text-gray-800">{{ $item->wilayah->nama_wilayah ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $item->namaSastra->nama_sastra ?? '-' }}</td>

                            <td class="px-4 py-3 text-gray-700 truncate max-w-[200px]" title="{{ $item->alamat }}">
                                {{ Str::limit(strip_tags($item->alamat), 30) }}
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    switch (strtolower($item->jenis)) {
                                        case 'lisan': $badgeColor = 'bg-green-500 text-white'; break;
                                        case 'tulisan': $badgeColor = 'bg-blue-500 text-white'; break;
                                        case 'lainnya': $badgeColor = 'bg-yellow-400 text-gray-800'; break;
                                        default: $badgeColor = 'bg-gray-400 text-white';
                                    }
                                @endphp
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                    {{ ucfirst($item->jenis) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-700 truncate max-w-[220px]" title="{{ strip_tags($item->deskripsi) }}">
                                {{ Str::limit(strip_tags($item->deskripsi), 40) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->dokumentasi)
                                    @if (Str::endsWith($item->dokumentasi, ['.mp4', '.mov', '.avi']))
                                        <video src="{{ asset('storage/' . $item->dokumentasi) }}" width="90" controls class="rounded shadow mx-auto"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $item->dokumentasi) }}" alt="dokumentasi" width="80" class="rounded shadow mx-auto">
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if (!empty($item->dokumentasi_yt))
                                    @php
                                        $youtubeId = null;
                                        if (str_contains($item->dokumentasi_yt, 'youtu.be')) {
                                            preg_match('/youtu\.be\/([^\?]+)/', $item->dokumentasi_yt, $matches);
                                            $youtubeId = $matches[1] ?? null;
                                        } elseif (str_contains($item->dokumentasi_yt, 'youtube.com')) {
                                            preg_match('/v=([^\&]+)/', $item->dokumentasi_yt, $matches);
                                            $youtubeId = $matches[1] ?? null;
                                        }
                                    @endphp
                                    @if ($youtubeId)
                                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" class="w-full aspect-video rounded" allowfullscreen></iframe>
                                    @else
                                        -
                                    @endif
                                @else
                                    -
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-700">{{ $item->koordinat ?? '-' }}</td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('sastra.show', $item->id) }}" class="text-green-600 hover:text-green-800" title="Lihat">
                                        <i class="bi bi-eye fs-5"></i>
                                    </a>
                                    <a href="{{ route('sastra.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>
                                    <form action="{{ route('sastra.destroy', $item->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="group cursor-pointer text-red-600 hover:text-red-800 btn-delete transition-colors" title="Hapus">
                                            <i class="bi bi-trash fs-5 group-hover:text-red-800"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada data sastra yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-bulk-delete" action="{{ route('sastra.bulk_delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk_delete_ids">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. Single Delete Script ---
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus data ini?',
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

            // --- 2. Bulk Delete Script ---
            const selectAllCheckbox = document.getElementById('select_all_ids');
            const allCheckboxes = document.querySelectorAll('.checkbox_ids');
            const bulkDeleteBtn = document.getElementById('btn-bulk-delete');
            const countSelectedSpan = document.getElementById('count-selected');

            function updateBulkDeleteButton() {
                const checkedCount = document.querySelectorAll('.checkbox_ids:checked').length;
                countSelectedSpan.textContent = checkedCount;
                
                if (checkedCount > 0) {
                    bulkDeleteBtn.style.display = 'inline-flex';
                } else {
                    bulkDeleteBtn.style.display = 'none';
                }
            }

            // Select All Logic
            selectAllCheckbox.addEventListener('change', function() {
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkDeleteButton();
            });

            // Individual Checkbox Logic
            allCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    }
                    if(document.querySelectorAll('.checkbox_ids:checked').length === allCheckboxes.length){
                         selectAllCheckbox.checked = true;
                    }
                    updateBulkDeleteButton();
                });
            });

            // Bulk Delete Action
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const allIds = [];
                document.querySelectorAll('.checkbox_ids:checked').forEach(checkbox => {
                    allIds.push(checkbox.value);
                });

                if (allIds.length === 0) return;

                Swal.fire({
                    title: 'Hapus data terpilih?',
                    text: `Anda akan menghapus ${allIds.length} data sastra. Data tidak bisa dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC2626',
                    cancelButtonColor: '#4B5563',
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