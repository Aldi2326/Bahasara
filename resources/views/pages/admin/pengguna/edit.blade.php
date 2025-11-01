@extends('layouts.admin.app')
@section('title', 'Edit Pengguna')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Data Pengguna</h4>
    </div>

    <div class="p-6">
        {{-- ✅ Notifikasi sukses --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ⚠️ Notifikasi error validasi --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                           required>
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
                           required>
                    @error('email')
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

            <!-- Tombol Submit -->
            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="button" id="btnUpdate" class="btn bg-info text-white">Perbarui Data</button>
                    <a href="{{ route('pengguna.index') }}" class="btn bg-gray-300 text-black ml-2">Kembali</a>
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
