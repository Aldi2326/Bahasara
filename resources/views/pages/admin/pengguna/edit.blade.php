@extends('layouts.admin.app')
@section('title', 'Edit Pengguna')

@section('content')
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('pengguna.index') }}" class="text-sm font-medium text-default-700">Pengguna</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Edit Data Pengguna</p>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Edit Data Pengguna</h4>
        </div>

        <div class="p-6">

            {{-- ✅ Notifikasi sukses --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-800 text-green-800 px-4 py-3 rounded-lg mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form id="formEditPengguna" class="flex flex-col gap-6" method="POST"
                action="{{ route('pengguna.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama & Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="text-default-800 text-sm font-medium">Nama Pengguna</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            class="form-input w-full @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama pengguna" required>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="text-default-800 text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            class="form-input w-full @error('email') border-red-500 @enderror"
                            placeholder="Masukkan email pengguna" required>
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div style="position: relative;">
                        <label for="password" class="text-default-800 text-sm font-medium">Password (Opsional)</label>
                        <input type="password" name="password" id="password"
                            class="form-input w-full @error('password') border-red-500 @enderror"
                            placeholder="Kosongkan jika tidak ingin mengganti">
                        <span class="toggle-eye" data-target="password"
                            style="
                                position: absolute;
                                right: 10px;
                                top: 40px; 
                                transform: translateY(-50%);
                                cursor: pointer;
                            ">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="20" height="20" style="color: gray;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                            0 8.268 2.943 9.542 7-1.274 4.057-5.064
                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="position: relative;">
                        <label for="password_confirmation" class="text-default-800 text-sm font-medium">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-input w-full @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Ulangi password pengguna">
                        <span class="toggle-eye" data-target="password_confirmation"
                            style="
                                position: absolute;
                                right: 10px;
                                top: 40px; 
                                transform: translateY(-50%);
                                cursor: pointer;
                            ">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="20" height="20" style="color: gray;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                            0 8.268 2.943 9.542 7-1.274 4.057-5.064
                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        @error('password_confirmation')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role (ikut ukuran password) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="role" class="text-default-800 text-sm font-medium">Role Pengguna</label>
                        <select name="role" id="role"
                            class="form-input w-full @error('role') border-red-500 @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai
                            </option>
                        </select>
                        @error('role')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>
                </div>

                <!-- Tombol -->
                <div>
                    <button type="button" id="btnUpdate" class="btn bg-blue-600 hover:bg-blue-700 text-white">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btnUpdate = document.getElementById('btnUpdate');
            const form = document.getElementById('formEditPengguna');

            btnUpdate.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Simpan perubahan data?',
                    text: "Data akan diperbarui.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563EB',
                    cancelButtonColor: '#4B5563',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
