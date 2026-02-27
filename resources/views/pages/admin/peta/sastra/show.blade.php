@extends('layouts.admin.app')
@section('title', 'Detail Sastra')

@section('content')
    <div class="flex items-center gap-3 text-sm font-semibold mb-5">
        <a href="{{ route('sastra.index') }}" class="text-sm font-medium text-default-700">Data Sastra</a>
        <i class="i-tabler-chevron-right text-lg flex-shrink-0 text-default-500 rtl:rotate-180"></i>
        <p class="text-sm font-bold text-default-900">Detail Data Sastra</p>
    </div>
    <div class="card overflow-hidden print:border-0 print:shadow-none">
        <div class="card-header flex justify-between items-center print:hidden">
            <h4 class="card-title">Detail Data Sastra</h4>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Wilayah -->
                <div>
                    <h5 class="text-sm text-default-500">Nama Wilayah</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $sastra->wilayah->nama_wilayah ?? '-' }}
                    </p>
                </div>

                <!-- Nama Sastra -->
                <div>
                    <h5 class="text-sm text-default-500">Nama Sastra</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $sastra->namaSastra->nama_sastra ?? '-' }}
                    </p>
                </div>

                <!-- Jenis Sastra -->
                <div>
                    <h5 class="text-sm text-default-500">Jenis Sastra</h5>
                    @php
                        switch (strtolower($sastra->jenis)) {
                            case 'lisan':
                                $badgeColor = 'bg-green-500 text-white';
                                break;
                            case 'tulisan':
                                $badgeColor = 'bg-blue-500 text-white';
                                break;
                            case 'lainnya':
                                $badgeColor = 'bg-yellow-400 text-gray-800';
                                break;
                            default:
                                $badgeColor = 'bg-gray-400 text-white';
                        }
                    @endphp
                    <span class="px-3 py-1 rounded {{ $badgeColor }} text-sm font-medium">
                        {{ ucfirst($sastra->jenis) }}
                    </span>
                </div>

                <!-- Alamat -->
                <div>
                    <h5 class="text-sm text-default-500">Alamat</h5>
                    <p class="text-base font-semibold text-default-800 leading-relaxed">
                        {!! $sastra->alamat ?? '-' !!}
                    </p>
                </div>

                <!-- Koordinat -->
                <div>
                    <h5 class="text-sm text-default-500">Koordinat</h5>
                    <p class="text-base font-semibold text-default-800">
                        {{ $sastra->koordinat ?? '-' }}
                    </p>
                </div>

                <!-- Dokumentasi -->
                <div class="md:col-span-1">
                    <h5 class="text-sm text-default-500">Dokumentasi</h5>
                    @if ($sastra->dokumentasi)
                        @if (Str::endsWith($sastra->dokumentasi, ['.jpg', '.jpeg', '.png', '.gif']))
                            <a href="{{ asset('storage/' . $sastra->dokumentasi) }}" target="_blank">
                                <img src="{{ asset('storage/' . $sastra->dokumentasi) }}" alt="Dokumentasi Sastra"
                                    class="mt-2 rounded-md shadow-sm w-48 h-48 object-cover border border-gray-300 hover:opacity-80 transition">
                            </a>
                        @elseif (Str::endsWith($sastra->dokumentasi, ['.mp4', '.mov']))
                            <video controls class="mt-2 rounded-md shadow-sm w-72 h-48 border border-gray-300">
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

                <div class="mt-6">
                    <h5 class="text-sm text-default-500 mb-2">Deskripsi</h5>
                    <p class="text-base text-default-800 leading-relaxed">
                        {!! $sastra->deskripsi ?? '-' !!}
                    </p>
                </div>

                <div>
                    <h5 class="text-sm text-default-500">Dokumentasi YT</h5>
                    <p class="text-base font-semibold text-default-800">
                        @if (!empty($sastra->dokumentasi_yt))
                            @php
                                $youtubeId = null;

                                if (str_contains($sastra->dokumentasi_yt, 'youtu.be')) {
                                    preg_match('/youtu\.be\/([^\?]+)/', $sastra->dokumentasi_yt, $matches);
                                    $youtubeId = $matches[1] ?? null;
                                } elseif (str_contains($sastra->dokumentasi_yt, 'youtube.com')) {
                                    preg_match('/v=([^\&]+)/', $sastra->dokumentasi_yt, $matches);
                                    $youtubeId = $matches[1] ?? null;
                                }
                            @endphp

                            @if ($youtubeId)
                                <iframe height="300px" src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    class="w-full aspect-video rounded" allowfullscreen>
                                </iframe>
                            @else
                                -
                            @endif
                        @else
                            -
                        @endif
                    </p>
                </div>

            </div>





            <!-- Deskripsi -->


            <!-- Tombol Aksi -->
            <div class="pt-6 border-t border-default-200 flex flex-wrap justify-between items-center gap-3">
                <!-- Tombol Kembali -->
                <div>
                    <a href="{{ route('sastra.index') }}"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Tombol Edit & Hapus -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sastra.edit', $sastra->id) }}"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form id="deleteForm" action="{{ route('sastra.destroy', $sastra->id) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="btnDelete"
                            class="btn bg-red-600 hover:bg-red-700 text-white flex items-center gap-2">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
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
