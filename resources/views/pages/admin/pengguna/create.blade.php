@extends('layouts.admin.app') 
@section('title', 'Pengguna') 
@section('content') 
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('pengguna.index') }}" class="text-sm font-medium text-default-700">Pengguna</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Input Data Pengguna</p>
    </div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Pengguna</h4>
    </div>
    <div class="p-6"> {{-- ✅ Notifikasi sukses --}} @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded"> {{ session('success') }} </div>
            @endif {{-- ⚠️ Notifikasi error validasi --}} 
            
            <form id="formPengguna" class="flex flex-col gap-6" method="POST" action="{{ route('pengguna.store') }}"
                enctype="multipart/form-data"> @csrf

                <!-- Nama Pengguna & Email (1 baris) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> <!-- Nama Pengguna -->
                    <div> <label for="name" class="text-default-800 text-sm font-medium">Nama Pengguna</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama pengguna"
                            class="form-input w-full @error('name') border-red-500 @enderror" required> @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div> <label for="email" class="text-default-800 text-sm font-medium">Email</label> <input
                            type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="Masukkan email pengguna"
                            class="form-input w-full @error('email') border-red-500 @enderror" required> @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div> <!-- Password & Konfirmasi Password (1 baris) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6"> <!-- Password -->
                    <div style="position: relative;"> <label for="password"
                            class="text-default-800 text-sm font-medium">Password</label> <input type="password"
                            name="password" id="password" placeholder="Masukkan password pengguna"
                            class="form-input w-full @error('password') border-red-500 @enderror" required
                            style="padding-right:40px"> <span class="toggle-eye" data-target="password"
                            style=" position: absolute; right: 10px; top: 40px; transform: translateY(-50%); cursor: pointer; ">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="20" height="20" style="color: gray;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg> </span> @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div style="position: relative;"> <label for="password_confirmation"
                            class="text-default-800 text-sm font-medium">Konfirmasi Password</label> <input
                            type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi password pengguna"
                            class="form-input w-full @error('password_confirmation') border-red-500 @enderror" required>
                        <span class="toggle-eye" data-target="password_confirmation"
                            style=" position: absolute; right: 10px; top: 40px; transform: translateY(-50%); cursor: pointer; ">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" width="20" height="20" style="color: gray;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg> </span> @error('password_confirmation')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Role (judul di atas, ukuran mengikuti kolom password) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div> <label for="role" class="text-default-800 text-sm font-medium">Role Pengguna</label>
                        <select name="role" id="role"
                            class="form-input w-full @error('role') border-red-500 @enderror" required>
                            <option value="" disabled selected>-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        </select> @error('role')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kolom kosong agar ukuran pas -->
                    <div></div>
                </div>

                <!-- Tombol Submit -->
                <div> <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white"> Simpan Data </button>
                </div>
            </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('formPengguna');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menyimpan data pengguna?',
                text: "Pastikan semua data sudah benar.",
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
