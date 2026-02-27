@extends('layouts.admin.app')
@section('title', 'Detail Pengumuman')

@section('content')
<div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('pengumuman.index') }}" class="text-sm font-medium text-default-700">Pengumuman</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Detail Pengumuman</p>
    </div>
<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Detail Pengumuman</h4>
        <a href="{{ route('pengumuman.index') }}" class="btn bg-gray-600 text-white flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="p-6 space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Judul -->
            <div>
                <h5 class="text-sm text-default-500">Judul Pengumuman</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ $pengumuman->judul ?? '-' }}
                </p>
            </div>

            <!-- Tanggal -->
            <div>
                <h5 class="text-sm text-default-500">Tanggal Pengumuman</h5>
                <p class="text-base font-semibold text-default-800">
                    {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}
                </p>
            </div>

            <!-- Isi -->
            <div class="md:col-span-2">
                <h5 class="text-sm text-default-500">Isi Pengumuman</h5>
                <div class="text-base text-default-800 leading-relaxed">
                    {!! $pengumuman->isi !!}
                </div>
            </div>

            <!-- Dokumentasi -->
            <div class="md:col-span-2">
                <h5 class="text-sm text-default-500">Dokumentasi</h5>

                @if ($pengumuman->dokumentasi)
                    @php
                        $file = $pengumuman->dokumentasi;
                        $isVideo = Str::endsWith($file, ['.mp4', '.mov', '.avi']);
                    @endphp

                    @if ($isVideo)
                        <video controls class="rounded-md shadow mt-2 w-[350px]">
                            <source src="{{ asset('storage/' . $file) }}">
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $file) }}" 
                             alt="Dokumentasi" 
                             class="rounded-md shadow mt-2 w-[250px]">
                    @endif
                @else
                    <p class="text-default-500">Tidak ada dokumentasi.</p>
                @endif
            </div>

        </div>

        <div class="pt-4 border-t border-default-200 flex justify-end space-x-3">

            <!-- Edit -->
            <a href="{{ route('pengumuman.edit', $pengumuman->id) }}" 
               class="btn bg-blue-600 text-white flex items-center gap-2">
                <i class="bi bi-pencil-square"></i> Edit
            </a>

            <!-- Hapus -->
            <form id="deleteForm" 
                  action="{{ route('pengumuman.destroy', $pengumuman->id) }}" 
                  method="POST" class="inline">
                @csrf
                @method('DELETE')

                <button type="button" id="btnDelete" 
                        class="btn bg-red-600 text-white flex items-center gap-2">
                    <i class="bi bi-trash3"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btnDelete').addEventListener('click', function (e) {
    e.preventDefault();
    Swal.fire({
        title: 'Yakin ingin menghapus pengumuman ini?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
});
</script>
@endsection
