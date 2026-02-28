@extends('layouts.admin.app')
@section('title', 'Pesan Masuk')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Umpan Balik</p>
    </div>

    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">

        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Pesan</h4>

            <button type="button" id="btn-bulk-delete" style="display: none;"
                class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2 transition">
                <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
            </button>
        </div>

        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap w-10">
                            <input type="checkbox" id="select_all_ids" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>

                        <th class="px-4 py-3 w-[60px]">No</th>
                        <th class="px-4 py-3 w-[160px]">Nama</th>
                        <th class="px-4 py-3 w-[220px]">Email</th>
                        <th class="px-4 py-3 w-[180px]">Subjek</th>
                        <th class="px-4 py-3 w-[320px]">Pesan</th>
                        <th class="px-4 py-3 w-[320px]">Balasan Admin</th>
                        <th class="px-4 py-3 w-[320px]">Status</th>
                        <th class="px-4 py-3 w-[120px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($kontaks as $index => $kontak)
                        <tr class="hover:bg-gray-50 transition" id="tr_{{ $kontak->id }}">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="ids" class="checkbox_ids rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $kontak->id }}">
                            </td>

                            <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 text-gray-800">
                                {{ $kontak->nama }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $kontak->email }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $kontak->subjek }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 text-left whitespace-normal break-words">
                                {{ $kontak->pesan }}
                            </td>

                            <td class="text-sm text-gray-700">
                                @if ($kontak->reply_message)
                                    {!! nl2br(e(strip_tags($kontak->reply_message))) !!}
                                    <div class="text-xs text-gray-500 mt-1">
                                        Dibalas: {{ $kontak->replied_at ? $kontak->replied_at->format('d M Y H:i') : '-' }}
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Belum ada balasan</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if ($kontak->status)
                                    <i class="fa-solid fa-check-circle text-green-600 fs-5" title="Sudah Dibalas"></i>
                                @else
                                    <i class="fa-solid fa-xmark-circle text-red-600 fs-5" title="Belum Dibalas"></i>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-4">

                                    <a href="{{ route('kontak.reply', $kontak->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Balas Pesan">
                                        <i class="bi bi-reply fs-5"></i>
                                    </a>

                                    <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST"
                                        class="delete-form inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="text-red-600 hover:text-red-800 btn-delete"
                                            title="Hapus Pesan">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada pesan yang tersedia.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <form id="form-bulk-delete" action="{{ route('kontak.bulk_delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk_delete_ids">
    </form>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. Single Delete Script (Bawaan) ---
            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function() {
                    const form = this.closest("form");

                    Swal.fire({
                        title: 'Hapus pesan ini?',
                        text: 'Pesan yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then(result => {
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
                    title: 'Hapus pesan terpilih?',
                    text: `Anda akan menghapus ${allIds.length} pesan. Data tidak bisa dikembalikan!`,
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