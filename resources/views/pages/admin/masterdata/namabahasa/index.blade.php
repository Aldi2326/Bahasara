@extends('layouts.admin.app')
@section('title', 'Nama Bahasa')

@section('content')
<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Nama Bahasa</h4>
        <a href="{{ route('nama-bahasa.create') }}" class="btn bg-danger text-white">Tambah Nama Bahasa</a>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-4 flex justify-between items-center">
        <form action="{{ route('nama-bahasa.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-input w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Cari nama bahasa...">
            <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-default-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                            <th class="px-6 py-3 text-start text-sm text-default-500">Nama Bahasa</th>
                            <th class="px-6 py-3 text-start text-sm text-default-500">Warna Pin</th>
                            <th class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($namaBahasa as $index => $item)
                        <tr class="odd:bg-white even:bg-default-100">
                            <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_bahasa }}</td>
                            <td class="px-6 py-4 text-sm text-default-800">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="{{ $item->warna_pin }}">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5
                                        c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-end text-sm text-end font-medium space-x-3">
                                <a href="{{ route('nama-bahasa.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                <form action="{{ route('nama-bahasa.destroy', $item->id) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:underline btn-delete" data-name="{{ $item->nama_bahasa }}">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-sm text-gray-500">
                                Data Tidak Ada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const nama = this.dataset.name;

            Swal.fire({
                title: `Hapus "${nama}"?`,
                text: "Data yang dihapus tidak bisa dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
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
