@extends('layouts.admin.app')
@section('title', 'Edit Pengguna')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Pengguna</h4>
    </div>

    <div class="p-6">
        {{-- ⚠️ Notifikasi error validasi --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-800 text-red-800 px-4 py-3 rounded-lg mb-4 shadow-sm">
                <strong class="font-semibold">Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Notifikasi sukses --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-800 text-green-800 px-4 py-3 rounded-lg mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <form id="formEditPengguna" class="flex flex-col gap-4"
              method="POST"
              action="{{ route('pengguna.update', $user->id) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Pengguna -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="name" class="text-default-800 text-sm font-medium">Nama Pengguna</label>
                <div class="md:col-span-3">
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-input @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama pengguna" required>
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="email" class="text-default-800 text-sm font-medium">Email</label>
                <div class="md:col-span-3">
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-input @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email pengguna" required>
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Role -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="role" class="text-default-800 text-sm font-medium">Role Pengguna</label>
                <div class="md:col-span-3">
                    <select name="role" id="role"
                        class="form-select @error('role') border-red-500 @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="pegawai" {{ old('role', $user->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                    </select>
                    @error('role')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="password" class="text-default-800 text-sm font-medium">Password (Opsional)</label>
                <div class="md:col-span-3">
                    <input type="password" name="password" id="password"
                           class="form-input @error('password') border-red-500 @enderror"
                           placeholder="Kosongkan jika tidak ingin mengganti">
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="grid grid-cols-4 items-center gap-6 mt-6">
                <div class="md:col-start-2">
                    <button type="button" id="btnUpdate" class="btn bg-info text-white">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnUpdate = document.getElementById('btnUpdate');
        const form = document.getElementById('formEditPengguna');

        btnUpdate.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Simpan perubahan data pengguna?',
                text: "Data lama akan diperbarui dengan informasi baru.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan',
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
