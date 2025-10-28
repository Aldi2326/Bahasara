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
                                    <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $index => $admin)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                            {{ $admin->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                            {{ $admin->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800 capitalize">
                                            {{ $admin->role }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex gap-3 justify-end">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('pengguna.edit', $admin->id) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                Edit
                                            </a>

                                            <!-- Tombol Delete -->
                                            <form action="{{ route('pengguna.destroy', $admin->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">
                                                    Delete
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
@endsection
