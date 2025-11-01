@extends('layouts.admin.app')
@section('title', 'Wilayah')
@section('content')

<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Wilayah</h4>
        <a href="{{ route('wilayah.create') }}" class="btn bg-danger text-white">Tambah Nama Aksara</a>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-4 flex justify-between items-center">
        <form action="{{ route('wilayah.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-input w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Cari nama wilayah...">
            <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-default-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-start text-sm text-default-500">
                                <div class="d-flex align-items-center gap-1">
                                    <span>No</span>
                                </div>

                            </th>

                            <!-- Kolom Nama Wilayah dengan tombol urut -->
                            <th class="px-6 py-3 text-start text-sm text-default-500">
                                <div class="flex items-center gap-1">
                                    <span>Nama Wilayah</span>
                                    @php
                                    $sortOrder = request('sort') === 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ route('wilayah.index', ['search' => request('search'), 'sort' => $sortOrder]) }}"
                                        class="text-gray-600 hover:text-blue-600">
                                        @if (request('sort') === 'asc')
                                        <i class="bi bi-sort-alpha-up"></i>
                                        @elseif(request('sort') === 'desc')
                                        <i class="bi bi-sort-alpha-down"></i>
                                        @else
                                        <i class="bi bi-arrow-down-up"></i>
                                        @endif
                                    </a>
                                </div>

                            </th>

                            <th class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wilayah as $index => $item)
                        <tr class="odd:bg-white even:bg-default-100">
                            <td class="px-6 py-4 text-sm font-medium text-default-800">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 text-sm text-default-800">
                                {{ $item->nama_wilayah }}
                            </td>
                            <td class="px-6 py-4 flex justify-end text-sm text-end font-medium space-x-3">
                                <a href="{{ route('wilayah.edit', $item->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('wilayah.destroy', $item->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-sm text-gray-500">
                                Data wilayah belum tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection