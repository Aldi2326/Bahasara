@extends('layouts.admin.app')
@section('title', 'Pengguna')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Input Data Pengguna</h4>
        </div>

        <div class="p-6">

            {{-- ✅ Notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ⚠️ Notifikasi error --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formPengguna" method="POST" action="{{ route('pengguna.store') }}" class="flex flex-col gap-6">
                @csrf

                {{-- Nama & Email --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium">Nama Pengguna</label>
                        <input type="text" name="name" class="form-input w-full" required>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" class="form-input w-full" required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" id="password" name="password" class="form-input w-full pr-10" required>

                        <p class="text-xs text-gray-500 mt-1">
                            <b>Password minimal 8 karakter, mengandung huruf besar, huruf kecil, angka, dan simbol.</b>
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-input w-full" required>
                    </div>
                </div>

                {{-- Role --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium">Role</label>
                        <select name="role" class="form-input w-full" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                        </select>
                    </div>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white">
                        Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* ===== PASSWORD REALTIME VALIDATION ===== */
        const passwordInput = document.getElementById('password');

        passwordInput.addEventListener('input', function() {
            const v = this.value;
            toggle('rule-length', v.length >= 8);
            toggle('rule-upper', /[A-Z]/.test(v));
            toggle('rule-lower', /[a-z]/.test(v));
            toggle('rule-number', /[0-9]/.test(v));
            toggle('rule-symbol', /[^A-Za-z0-9]/.test(v));
        });

        function toggle(id, valid) {
            const el = document.getElementById(id);
            el.classList.toggle('text-green-600', valid);
            el.classList.toggle('text-gray-400', !valid);
        }

        /* ===== SWEETALERT SUBMIT ===== */
        document.getElementById('formPengguna').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan pengguna?',
                text: 'Pastikan data sudah benar.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal'
            }).then(r => {
                if (r.isConfirmed) this.submit();
            });
        });
    </script>
@endsection
