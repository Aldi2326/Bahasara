@extends('layouts.admin.app')
@section('title', 'Pesan Masuk')

@section('content')
    <div class="card overflow-hidden shadow-sm rounded-2xl border border-gray-200">

        <!-- Header -->
        <div class="card-header flex justify-between items-center bg-gray-100 px-6 py-4">
            <h4 class="card-title text-lg font-semibold text-gray-800">Daftar Pesan</h4>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 w-[60px]">No</th>
                        <th class="px-4 py-3 w-[160px]">Nama</th>
                        <th class="px-4 py-3 w-[220px]">Email</th>
                        <th class="px-4 py-3 w-[180px]">Subjek</th>
                        <th class="px-4 py-3 w-[320px]">Pesan</th>
                        <th class="px-4 py-3 w-[320px]">Balasan Admin</th>
                        <th class="px-4 py-3 w-[320px]">Status</th>
                        <th class="px-4 py-3 w-[120px]">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($kontaks as $index => $kontak)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 text-gray-800">
                                {{ $kontak->nama }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $kontak->email }}
                            </td>

                            <td class="px-4 py-3 text-gray-700">
                                {{ $kontak->subjek }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 text-left whitespace-normal break-words">
                                {{ $kontak->pesan }}
                            </td>

                            <td class="text-sm text-gray-700">
                                @if ($kontak->reply_message)
                                    {!! nl2br(e(strip_tags($kontak->reply_message))) !!}
                                    <div class="text-xs text-gray-500 mt-1">
                                        Dibalas: {{ $kontak->replied_at ? $kontak->replied_at->format('d M Y H:i') : '-' }}
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Belum ada balasan</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if ($kontak->status)
                                    <i class="fa-solid fa-check-circle text-green-600 fs-5" title="Sudah Dibalas"></i>
                                @else
                                    <i class="fa-solid fa-xmark-circle text-red-600 fs-5" title="Belum Dibalas"></i>
                                @endif
                            </td>


                            <!-- Aksi -->
                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-4">

                                    <!-- Tombol Balas -->
                                    <a href="{{ route('kontak.reply', $kontak->id) }}"
                                        class="text-blue-600 hover:text-blue-800" title="Balas Pesan">
                                        <i class="bi bi-reply fs-5"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST"
                                        class="delete-form inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="text-red-600 hover:text-red-800 btn-delete"
                                            title="Hapus Pesan">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-5 text-center text-gray-500 italic">
                                Belum ada pesan yang tersedia.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-delete").forEach(button => {
                button.addEventListener("click", function() {
                    const form = this.closest("form");

                    Swal.fire({
                        title: 'Hapus pesan ini?',
                        text: 'Pesan yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        });
    </script>
@endsection
