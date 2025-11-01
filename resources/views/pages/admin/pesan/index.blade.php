@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
<div class="card overflow-hidden">
    <div class="card-header">
        <h4 class="card-title">Pesan</h4>
    </div>

    <div>
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-default-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">No</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Email</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Subjek</th>
                                <th scope="col" class="px-6 py-3 text-start text-sm text-default-500" style="width: 300px;">Pesan</th>
                                <th scope="col" class="px-6 py-3 text-center text-sm text-default-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($kontaks as $index => $kontak)
                                <tr class="odd:bg-white even:bg-default-100 hover:bg-default-200/50 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $kontak->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $kontak->email }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $kontak->subjek }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; word-wrap: break-word;">
                                        {{ $kontak->pesan }}
                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-4 text-sm font-medium text-center">
                                        <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST" class="inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 btn-delete" title="Hapus Pesan">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-default-500">
                                        Belum ada pesan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".btn-delete");

        deleteButtons.forEach(button => {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                const form = this.closest("form");

                Swal.fire({
                    title: 'Yakin ingin menghapus pesan ini?',
                    text: "Pesan yang dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
