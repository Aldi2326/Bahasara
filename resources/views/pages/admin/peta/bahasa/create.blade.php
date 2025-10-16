@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Input Data Bahasa </h4>
    </div>
    <div class="p-6">

        <form class="flex flex-col gap-4" action="{{ route('bahasa.store') }}" method="POST">
            @csrf
            <input type="hidden" name="wilayah_id" value="{{ $wilayahId }}" id="">

            <!-- Nama Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Wilayah</label>
                <div class="md:col-span-3">
                    <select name="nama_bahasa" id="nama_bahasa" class="form-select" required>
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach ($wilayahList as $wilayah)
                        <option value="{{ $wilayah->id }}"
                            {{ isset($wilayahId) && $wilayahId == $wilayah->id ? 'selected' : '' }}>
                            {{ $wilayah->nama_wilayah }}
                        </option>
                        @endforeach
                    </select>


                </div>
            </div>
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="nama_bahasa" class="text-default-800 text-sm font-medium">Nama Bahasa</label>
                <div class="md:col-span-3">
                    <select name="nama_bahasa" id="nama_bahasa" class="form-select" required>
                        <option value="">-- Pilih Bahasa --</option>
                        <option value="Bahasa Melayu Jambi">Bahasa Melayu Jambi</option>
                        <option value="Bahasa Kerinci">Bahasa Kerinci</option>
                        <option value="Bahasa Bungo">Bahasa Bungo</option>
                        <option value="Bahasa Tebo">Bahasa Tebo</option>
                        <option value="Bahasa Batanghari">Bahasa Batanghari</option>
                        <option value="Bahasa Sarolangun">Bahasa Sarolangun</option>
                        <option value="Bahasa Merangin">Bahasa Merangin</option>
                        <option value="Bahasa Muaro Jambi">Bahasa Muaro Jambi</option>
                        <option value="Bahasa Tanjung Jabung Barat">Bahasa Tanjung Jabung Barat</option>
                        <option value="Bahasa Tanjung Jabung Timur">Bahasa Tanjung Jabung Timur</option>
                        <option value="Bahasa Sungai Penuh">Bahasa Sungai Penuh</option>
                    </select>


                </div>
            </div>

            <!-- Status Bahasa -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="status_bahasa" class="text-default-800 text-sm font-medium">Status Bahasa</label>
                <div class="md:col-span-3">
                    <select name="status" id="status_bahasa" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Jumlah Penutur -->
            <div class="grid grid-cols-4 items-center gap-6">
                <label for="jumlah_penutur" class="text-default-800 text-sm font-medium">Jumlah Penutur</label>
                <div class="md:col-span-3">
                    <input type="number" name="jumlah_penutur" id="jumlah_penutur" class="form-input"
                        placeholder="Contoh: 50000" required>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-4 items-start gap-6">
                <label for="deskripsi" class="text-default-800 text-sm font-medium">Deskripsi</label>
                <div class="md:col-span-3">
                    <textarea name="deskripsi" id="deskripsi" rows="8" class="form-input"
                        placeholder="Tuliskan deskripsi lengkap bahasa..." required></textarea>
                    <p class="mt-1 text-xs text-default-500">Isi dengan penjelasan lebih detail (mendukung teks panjang)
                    </p>
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