@extends('layouts.admin.app')
@section('title', 'Edit Pengumuman')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-4">Edit Pengumuman</h4>
    </div>

    <div class="p-6">
        <form class="flex flex-col gap-4" method="POST" action="{{ route('pengumuman.update', $pengumuman->id) }}">
            @csrf
            @method('PUT')

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

            <div class="grid grid-cols-4 items-center gap-6">
                <label for="judul" class="text-default-800 text-sm font-medium">Judul</label>
                <div class="md:col-span-3">
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}" class="form-input" required>
                </div>
            </div>

            <div class="grid grid-cols-4 items-start gap-6">
                <label for="isi" class="text-default-800 text-sm font-medium">Isi Pengumuman</label>
                <div class="md:col-span-3">
                    <textarea name="isi" id="isi" rows="5" class="form-input" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-4 items-center gap-6">
                <div class="md:col-start-2">
                    <button type="submit" class="btn bg-info text-white">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
