@extends('layouts.admin.app')
@section('title', 'Pengguna')
@section('content')
<div class="card overflow-hidden">
    <div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    <!-- Header -->
                    <div class="card-header flex justify-between items-center">
                        <h4 class="card-title">Pengguna</h4>
                        <a href="{{ route('pengguna.create') }}" class="btn bg-danger text-white">
                            Tambah Pengguna
                        </a>
                    </div>

                    <!-- Alert jika ada pesan error -->
                    @if (session('error'))
                        <div class="alert alert-danger m-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Tabel Data -->
                    <table class="min-w-full divide-y divide-default-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">No</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Email</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Role</th>
                                <th scope="col" class="px-6 py-3 text-center text-sm text-default-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($admins as $index => $admin)
                                <tr class="odd:bg-white even:bg-default-100 hover:bg-default-200/50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-default-800">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $admin->name }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $admin->email }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800 capitalize">{{ $admin->role }}</td>

                                    <td class="px-6 py-4 text-sm font-medium flex justify-center gap-3">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('pengguna.edit', $admin->id) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Edit">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </a>

                                        <!-- Tombol Delete (SweetAlert Konfirmasi) -->
                                        <form action="{{ route('pengguna.destroy', $admin->id) }}" method="POST"
                                              class="form-delete inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete text-red-600 hover:text-red-800" title="Hapus">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-sm text-default-500">
                                        Tidak ada data pengguna.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach((btn) => {
            btn.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Hapus pengguna ini?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
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
