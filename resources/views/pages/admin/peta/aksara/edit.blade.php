@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-4">Edit Data Aksara</h4>
        </div>
        <div class="p-6">

            <form class="flex flex-col gap-4" method="POST" action="{{ route('aksara.update', $aksara->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Nama Aksara -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="nama_aksara" class="text-default-800 text-sm font-medium">Nama Aksara</label>
                    <div class="md:col-span-3">
                        <input value="{{ $aksara->nama_aksara }}" type="text" name="nama_aksara" id="nama_aksara" class="form-input"
                            placeholder="Contoh: Aksara Incung" required>
                    </div>
                </div>

                <!-- Status Aksara -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="status_aksara" class="text-default-800 text-sm font-medium">Status</label>
                    <div class="md:col-span-3">
                        <select name="status_aksara" id="status_aksara" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif" {{ $aksara->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ $aksara->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Jumlah Pengguna -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <label for="jumlah_pengguna" class="text-default-800 text-sm font-medium">Jumlah Penutur</label>
                    <div class="md:col-span-3">
                        <input type="number" value="{{ $aksara->jumlah_penutur }}" name="jumlah_penutur" id="jumlah_pengguna" class="form-input"
                            placeholder="Contoh: 100">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="grid grid-cols-4 items-start gap-6">
                    <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                    <div class="md:col-span-3">
                        <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input"
                            placeholder="Tuliskan deskripsi lengkap aksara..." required>{{ old('deskripsi', $aksara->deskripsi) }}</textarea>
                        <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan sejarah, fungsi, dan karakteristik
                            aksara</p>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="grid grid-cols-4 items-center gap-6">
                    <div class="md:col-start-2">
                        <button type="submit" class="btn bg-info text-white">Simpan Data</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection
