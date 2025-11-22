@extends('layouts.admin.app')
@section('title', 'Detail Aksara')

@section('content')
    <div class="card overflow-hidden print:border-0 print:shadow-none">
        <div class="card-header flex justify-between items-center print:hidden">
            <h4 class="card-title">Detail Data Aksara</h4>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Wilayah -->
                <div>
                    <h5 class="text-sm text-default-500">Nama Wilayah</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $aksara->wilayah->nama_wilayah ?? '-' }}
                    </p>
                </div>

                <!-- Nama Aksara -->
                <div>
                    <h5 class="text-sm text-default-500">Nama Aksara</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $aksara->namaAksara->nama_aksara ?? '-' }}
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <h5 class="text-sm text-default-500">Status</h5>
                    @if (strtolower($aksara->status) === 'aktif')
                        <span class="px-3 py-1 rounded bg-green-500 text-white text-sm font-medium">Aktif</span>
                    @else
                        <span class="px-3 py-1 rounded bg-red-500 text-white text-sm font-medium">Tidak Aktif</span>
                    @endif
                </div>

                <!-- Alamat -->
                <div>
                    <h5 class="text-sm text-default-500">Alamat</h5>
                    <p class="text-base font-bold text-default-800 leading-relaxed">
                        {!! $aksara->alamat ?? '-' !!}
                    </p>
                </div>

                <!-- Koordinat -->
                <div>
                    <h5 class="text-sm text-default-500">Koordinat</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $aksara->koordinat ?? '-' }}
                    </p>
                </div>

            </div>

            <!-- Dokumentasi -->
            <div class="md:col-span-1">
                <h5 class="text-sm text-default-500">Dokumentasi</h5>
                @if ($aksara->dokumentasi)
                    @if (Str::endsWith($aksara->dokumentasi, ['.jpg', '.jpeg', '.png', '.webp', '.gif']))
                        <a href="{{ asset('storage/' . $aksara->dokumentasi) }}" target="_blank">
                            <img src="{{ asset('storage/' . $aksara->dokumentasi) }}" alt="Dokumentasi Aksara"
                                class="mt-2 rounded-md shadow-sm w-48 h-48 object-cover border border-gray-300 hover:opacity-80 transition">
                        </a>
                    @elseif (Str::endsWith($aksara->dokumentasi, '.pdf'))
                        <a href="{{ asset('storage/' . $aksara->dokumentasi) }}" target="_blank"
                            class="mt-2 inline-block text-blue-600 hover:underline">
                            📄 Lihat Dokumen PDF
                        </a>
                    @else
                        <p class="mt-2 text-gray-600">Format file tidak dapat dipratinjau.</p>
                    @endif
                @else
                    <p class="mt-2 text-gray-500">Tidak ada dokumentasi tersedia.</p>
                @endif
            </div>

            <!-- Deskripsi -->
            <div class="mt-6">
                <h5 class="text-sm text-default-500 mb-2">Deskripsi</h5>
                <p class="text-base text-default-800 leading-relaxed">
                    {!! $aksara->deskripsi ?? '-' !!}
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-6 border-t border-default-200 flex flex-wrap justify-between items-center gap-3">
                <div>
                    <a href="{{ route('aksara.index') }}" class="btn bg-blue-600 text-white flex items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('aksara.edit', $aksara->id) }}"
                        class="btn bg-blue-600 text-white flex items-center gap-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form id="deleteForm" action="{{ route('aksara.destroy', $aksara->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="btnDelete" class="btn bg-red-600 text-white flex items-center gap-2">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteBtn = document.getElementById('btnDelete');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus data ini?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC2626',
                        cancelButtonColor: '#4B5563',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm').submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection