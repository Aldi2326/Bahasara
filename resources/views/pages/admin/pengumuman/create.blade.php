@extends('layouts.admin.app')
@section('title', 'Tambah Pengumuman')

@section('content')
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('pengumuman.index') }}" class="text-sm font-medium text-default-700">Pengumuman</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Tambah Pengumuman</p>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Tambah Pengumuman</h4>
        </div>

        <div class="p-6">
            <form id="pengumumanForm" class="flex flex-col gap-4" method="POST" action="{{ route('pengumuman.store') }}"
                enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-800 text-red-800 px-4 py-3 rounded-lg mb-4 shadow-sm">
                        <strong class="font-semibold">Terjadi kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Judul -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="judul" class="text-default-800 text-sm font-medium">Judul</label>
                    <div class="md:col-span-3">
                        <input type="text" name="judul" id="judul" class="form-input"
                            placeholder="Contoh: Pengumuman Penting" required>
                    </div>
                </div>

                <!-- Tanggal Pengumuman -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="tanggal" class="text-default-800 text-sm font-medium">Tanggal</label>
                    <div class="md:col-span-3">
                        <input type="date" name="tanggal" id="tanggal" class="form-input" required>
                    </div>
                </div>

                <!-- Dokumentasi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="dokumentasi" class="text-default-800 text-sm font-medium">Dokumentasi</label>
                    <div class="md:col-span-3">
                        <input type="file" name="dokumentasi" id="dokumentasi" class="form-input"
                            accept="image/*,video/*" required>
                        <p class="mt-1 text-xs text-default-500"> Unggah file jpg, jpeg, png, webp, pdf. Maksimal 2MB.
                        </p>
                    </div>
                </div>

                <!-- Isi Pengumuman -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="isi" class="text-default-800 text-sm font-medium">Isi Pengumuman</label>
                    <div class="md:col-span-3">
                        <textarea id="froala-editor" name="isi" class="prose"></textarea>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="submit"
                            class="btn bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-md">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // AUTO OPEN DATE PICKER
            const dateInput = document.getElementById("tanggal");
            if (dateInput && dateInput.showPicker) {
                dateInput.addEventListener("focus", () => dateInput.showPicker());
                dateInput.addEventListener("click", () => dateInput.showPicker());
            }

            // SWEETALERT UNTUK SUBMIT
            const form = document.getElementById('pengumumanForm');

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Simpan Pengumuman?',
                    text: "Pastikan data sudah benar sebelum disimpan.",
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
