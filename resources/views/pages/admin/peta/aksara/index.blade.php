@extends('layouts.admin.app')
@section('title', 'Aksara')

@section('content')
    @php
        $sortField = request('sort_by', 'nama_aksara');
        $sortOrder = request('order', 'asc');
        $nextOrder = $sortOrder === 'asc' ? 'desc' : 'asc';
    @endphp
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Data Aksara</p>
    </div>

    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Aksara</h4>
            <div class="flex gap-2">
                <button type="button" id="btn-bulk-delete" style="display: none;"
                    class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
                </button>

                <a href="{{ route('aksara.create') }}"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </a>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
            <form action="{{ route('aksara.index') }}" method="GET" class="flex items-center w-full md:w-1/3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
                    placeholder="Cari nama aksara atau wilayah...">
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

                        <th class="px-4 py-3 w-[40px] whitespace-nowrap">No</th>

                        <th class="px-4 py-3 w-[160px] whitespace-nowrap">
                            <a href="{{ route('aksara.index', ['sort_by' => 'nama_wilayah', 'order' => $sortField === 'nama_wilayah' ? $nextOrder : 'asc']) }}"
                                class="flex justify-center items-center gap-1 hover:text-blue-600 whitespace-nowrap">
                                <span>Nama Wilayah</span>
                                {!! $sortField === 'nama_wilayah'
                                    ? ($sortOrder === 'asc'
                                        ? '<i class="bi bi-sort-alpha-up"></i>'
                                        : '<i class="bi bi-sort-alpha-down"></i>')
                                    : '<i class="bi bi-arrow-down-up"></i>' !!}
                            </a>
                        </th>

                        <th class="px-4 py-3 w-[160px] whitespace-nowrap">Nama Aksara</th>
                        <th class="px-4 py-3 w-[200px] whitespace-nowrap">Alamat</th>
                        <th class="px-4 py-3 w-[100px] whitespace-nowrap">Status Aksara</th>
                        <th class="px-4 py-3 w-[220px] whitespace-nowrap">Deskripsi</th>
                        <th class="px-4 py-3 w-[120px] whitespace-nowrap">Dokumentasi</th>
                        <th class="px-4 py-3 w-[120px] whitespace-nowrap">Dokumentasi YT</th>
                        <th class="px-4 py-3 w-[140px] whitespace-nowrap">Koordinat</th>
                        <th class="px-4 py-3 w-[100px] whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($aksara as $index => $item)
                        <tr class="hover:bg-gray-50 transition text-center" id="tr_{{ $item->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids" class="checkbox_ids rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $item->id }}">
                            </td>

                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $item->wilayah->nama_wilayah ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $item->namaAksara->nama_aksara ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700 truncate max-w-[200px]" title="{{ $item->alamat }}">
                                {{ Str::limit(strip_tags($item->alamat), 30) }} </td>
                            <td class="px-4 py-3"> 
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium 
                                    @switch($item->status) 
                                        @case('Aktif') bg-green-500 text-white @break 
                                        @case('Tidak Aktif') bg-red-500 text-white @break 
                                        @case('menunggu') bg-yellow-500 text-white @break 
                                        @case('ditolak') bg-gray-500 text-white @break 
                                        @case('disetujui') bg-blue-500 text-white @break 
                                        @case('proses') bg-orange-500 text-white @break 
                                        @case('selesai') bg-emerald-500 text-white @break 
                                        @default bg-slate-400 text-white 
                                    @endswitch">
                                    {{ $item->status }} 
                                </span> 
                            </td>
                            <td class="px-4 py-3 text-gray-700 truncate max-w-[220px]"
                                title="{{ strip_tags($item->deskripsi) }}">
                                {{ Str::limit(strip_tags($item->deskripsi), 40) }} </td>

                            <td class="px-4 py-3 text-center">
                                @if ($item->dokumentasi)
                                    <img src="{{ asset('storage/' . $item->dokumentasi) }}" alt="dokumentasi"
                                        width="80" class="rounded shadow mx-auto">
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
                                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                            class="w-full aspect-video rounded" allowfullscreen>
                                        </iframe>
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
                                    <a href="{{ route('aksara.show', $item->id) }}"
                                        class="text-green-600 hover:text-green-800" title="Lihat"> <i
                                            class="bi bi-eye fs-5"></i> </a> 
                                    <a href="{{ route('aksara.edit', $item->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Edit"> <i
                                            class="bi bi-pencil-square fs-5"></i> </a>
                                    <form action="{{ route('aksara.destroy', $item->id) }}" method="POST"
                                        class="inline delete-form"> @csrf @method('DELETE') <button type="button"
                                            class="text-red-600 hover:text-red-800 btn-delete" title="Hapus"> <i
                                                class="bi bi-trash fs-5"></i> </button> </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-5 text-center text-gray-500 italic"> Belum ada data aksara
                                yang tersedia. </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <form id="form-bulk-delete" action="{{ route('aksara.bulk_delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk_delete_ids">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. Script Single Delete (Bawaan) ---
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

            // --- 2. Script Bulk Delete (Baru) ---
            const selectAllCheckbox = document.getElementById('select_all_ids');
            const allCheckboxes = document.querySelectorAll('.checkbox_ids');
            const bulkDeleteBtn = document.getElementById('btn-bulk-delete');
            const countSelectedSpan = document.getElementById('count-selected');

            // Fungsi update tombol
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

            // Logic Checkbox per baris
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

            // Logic Klik Tombol Hapus Massal
            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const allIds = [];
                document.querySelectorAll('.checkbox_ids:checked').forEach(checkbox => {
                    allIds.push(checkbox.value);
                });

                if (allIds.length === 0) return;

                Swal.fire({
                    title: 'Hapus data terpilih?',
                    text: `Anda akan menghapus ${allIds.length} data aksara. Data tidak bisa dikembalikan!`,
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