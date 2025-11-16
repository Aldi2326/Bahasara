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
                    <th class="px-4 py-3 w-[100px]">Aksi</th>
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

                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <form action="{{ route('kontak.destroy', $kontak->id) }}" 
                                      method="POST" 
                                      class="inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" 
                                            class="text-red-600 hover:text-red-800 btn-delete"
                                            title="Hapus Pesan">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-5 text-center text-gray-500 italic">
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", function () {
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
