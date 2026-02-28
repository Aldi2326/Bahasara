@extends('layouts.admin.app')
@section('title', 'Pengguna')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <p class="text-sm font-bold text-default-900">Pengguna</p>
    </div>

    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Pengguna</h4>
            <div class="flex gap-2">
                <button type="button" id="btn-bulk-delete" style="display: none;"
                    class="btn bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2 transition">
                    <i class="bi bi-trash"></i> Hapus Terpilih (<span id="count-selected">0</span>)
                </button>

                <a href="{{ route('pengguna.create') }}"
                    class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                    Tambah Pengguna
                </a>
            </div>
        </div>

        <div class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
            <form action="{{ route('pengguna.index') }}" method="GET" class="flex items-center w-full md:w-1/3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400"
                    placeholder="Cari nama pengguna...">
                <button type="submit"
                    class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md h-[38px]">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        @if (session('error'))
            <div class="px-6 py-4 bg-red-100 text-red-800 border-b border-red-200">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="px-6 py-4 bg-green-100 text-green-800 border-b border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap w-10">
                            <input type="checkbox" id="select_all_ids" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>

                        <th class="px-4 py-3 w-[50px]">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 w-[100px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($user as $index => $admin)
                        <tr class="hover:bg-gray-50 transition" id="tr_{{ $admin->id }}">
                            <td class="px-4 py-3">
                                {{-- LOGIKA: Hanya tampilkan checkbox jika role BUKAN superadmin --}}
                                @if ($admin->role !== 'superadmin')
                                    <input type="checkbox" name="ids" class="checkbox_ids rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $admin->id }}">
                                @else
                                    <i class="bi bi-lock-fill text-gray-400" title="Superadmin tidak bisa dihapus massal"></i>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-800">{{ $admin->name }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $admin->email }}</td>
                            <td class="px-4 py-3 capitalize">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium 
                                    @if ($admin->role === 'superadmin') bg-green-500 text-white
                                    @elseif($admin->role === 'admin') bg-blue-500 text-white
                                    @else bg-purple-500 text-white @endif">
                                    {{ $admin->role }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('pengguna.edit', $admin->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>

                                    {{-- Superadmin tidak bisa menghapus dirinya sendiri jika login sebagai superadmin --}}
                                    @if (!($admin->id === auth()->id() && $admin->role === 'superadmin'))
                                        <form action="{{ route('pengguna.destroy', $admin->id) }}" method="POST"
                                            class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 btn-delete"
                                                title="Hapus" data-name="{{ $admin->name }}">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada data pengguna yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <form id="form-bulk-delete" action="{{ route('pengguna.bulk_delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="ids" id="bulk_delete_ids">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- 1. Script Single Delete (Yang Lama) ---
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');
                    const nama = this.dataset.name;
                    Swal.fire({
                        title: `Hapus pengguna "${nama}"?`,
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
            const allCheckboxes = document.querySelectorAll('.checkbox_ids'); // Hanya memilih yg punya class checkbox_ids (superadmin tidak punya)
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
                    if(document.querySelectorAll('.checkbox_ids:checked').length === allCheckboxes.length){
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
                    text: `Anda akan menghapus ${allIds.length} pengguna. Data tidak bisa dikembalikan!`,
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