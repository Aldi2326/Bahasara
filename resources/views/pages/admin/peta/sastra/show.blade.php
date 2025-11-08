@extends('layouts.admin.app')
@section('title', 'Detail Sastra')

@section('content')
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Detail Sastra</h4>
            <a href="{{ route('sastra.index') }}" class="btn bg-gray-600 text-white flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm text-default-500">Nama Sastra</h5>
                    <p class="text-base font-semibold text-default-800">{{ $sastra->namaSastra->nama_sastra ?? '-' }}</p>
                </div>

                <div>
                    <h5 class="text-sm text-default-500">Jenis Sastra</h5>

                    @php
                        switch (strtolower($sastra->jenis)) {
                            case 'lisan':
                                $badgeColor = 'bg-green-500 text-white'; // hijau
                                break;
                            case 'tulisan':
                                $badgeColor = 'bg-blue-500 text-white'; // biru
                                break;
                            case 'lainnya':
                                $badgeColor = 'bg-yellow-500 text-gray-800'; // kuning
                                break;
                            default:
                                $badgeColor = 'bg-gray-400 text-white'; // fallback
                        }
                    @endphp

                    <span
                        class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                        {{ ucfirst($sastra->jenis) }}
                    </span>
                </div>


                <div class="md:col-span-2">
                    <h5 class="text-sm text-default-500">Dokumentasi</h5>
                    @if ($sastra->dokumentasi)
                        @if (Str::endsWith($sastra->dokumentasi, ['.jpg', '.jpeg', '.png', '.gif']))
                            <a href="{{ asset('storage/' . $sastra->dokumentasi) }}" target="_blank">
                                <img src="{{ asset('storage/' . $sastra->dokumentasi) }}" alt="Dokumentasi sastra"
                                    class="mt-2 rounded-md shadow-sm w-32 h-32 object-cover border border-gray-300 hover:opacity-80 transition">
                            </a>
                        @elseif (Str::endsWith($sastra->dokumentasi, ['.mp4', '.mov']))
                            <video controls class="mt-2 rounded-md shadow-sm w-48 h-32 object-cover border border-gray-300">
                                <source src="{{ asset('storage/' . $sastra->dokumentasi) }}" type="video/mp4">
                                Browser tidak mendukung video.
                            </video>
                        @elseif (Str::endsWith($sastra->dokumentasi, '.pdf'))
                            <a href="{{ asset('storage/' . $sastra->dokumentasi) }}" target="_blank"
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

                <div class="md:col-span-2">
                    <h5 class="text-sm text-default-500">Deskripsi</h5>
                    <p class="text-base text-default-800 leading-relaxed">
                        {!! $sastra['deskripsi'] !!}
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-default-200 flex justify-end space-x-3">
                <!-- Tombol Edit -->
                <a href="{{ route('sastra.edit', $sastra->id) }}"
                    class="btn bg-blue-600 text-white flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                <!-- Tombol Delete -->
                <form id="deleteForm" action="{{ route('sastra.destroy', $sastra->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="btnDelete" class="btn bg-red-600 text-white flex items-center gap-2">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tambahkan Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('btnDelete').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
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
