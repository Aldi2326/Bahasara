@extends('layouts.admin.app')
@section('title', 'Pengguna')

@section('content')
    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">
        <!-- Header -->
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Pengguna</h4>
            <a href="{{ route('pengguna.create') }}"
                class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md flex items-center gap-2">
                Tambah Pengguna
            </a>
        </div>

        <!-- Search Bar -->
        <div
            class="px-6 py-4 border-b border-gray-200 bg-white flex flex-col md:flex-row justify-between items-center gap-3">
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

        <!-- Alert -->
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

        <!-- Table -->
        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 w-[50px]">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 w-[100px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($user as $index => $admin)
                        <tr class="hover:bg-gray-50 transition">
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
                                    <!-- Edit -->
                                    <a href="{{ route('pengguna.edit', $admin->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Edit">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>

                                    <!-- Delete -->
                                    @if (!($user->id === auth()->id() && $user->role === 'super_admin'))
                                        <form method="POST" action="{{ route('pengguna.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Hapus</button>
                                        </form>
                                        @endi
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada data pengguna yang tersedia.
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
        document.addEventListener('DOMContentLoaded', () => {
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
        });
    </script>
@endsection
