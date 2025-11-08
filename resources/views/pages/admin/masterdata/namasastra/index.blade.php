@extends('layouts.admin.app')
@section('title', 'Nama Sastra')
@section('content')

<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Nama sastra</h4>
        <a href="{{ route('nama-sastra.create') }}" class="btn bg-danger text-white">Tambah Nama sastra</a>
    </div>

    <!-- Search Bar -->
    <div class="px-6 py-4 flex justify-between items-center">
        <form action="{{ route('nama-sastra.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-input w-full border rounded-md px-3 py-2 text-sm"
                placeholder="Cari nama namasastra...">
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

                            <!-- Kolom Nama namasastra dengan tombol urut -->
                            <th class="px-6 py-3 text-start text-sm text-default-500">
                                <div class="flex items-center gap-1">
                                    <span>Nama sastra</span>
                                    @php
                                    $sortOrder = request('sort') === 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ route('nama-sastra.index', ['search' => request('search'), 'sort' => $sortOrder]) }}"
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
                            <th class="px-6 py-3 text-start text-sm text-default-500">
                                <div class="d-flex align-items-center gap-1">
                                    <span>Warna Pin</span>
                                </div>

                            </th>

                            <th class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white even:bg-default-100">
                            <td class="px-6 py-4 text-sm font-medium text-default-800">
                                1
                            </td>
                            <td class="px-6 py-4 text-sm text-default-800">
                                Nama sastra
                            </td>
                            <td class="px-6 py-4 text-sm text-default-800">
                                <div id="pin-preview" class="flex items-center gap-2">
                                    <svg id="pin-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30" fill="#FF0000">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5
                            c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z" />
                                    </svg>
                                </div>
                            </td>
                            <td class="px-6 py-4 flex justify-end text-sm text-end font-medium space-x-3">
                                <a href="{{ route('nama-sastra.edit', 'namaSastra') }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection