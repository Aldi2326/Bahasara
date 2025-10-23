@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')

    @php
        // Fungsi untuk toggle arah urutan sorting
        function nextOrder($currentOrder)
        {
            return $currentOrder === 'asc' ? 'desc' : 'asc';
        }
    @endphp

    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Daftar Bahasa</h4>
            <a href="{{ route('bahasa.create') }}" class="btn bg-danger text-white">Tambah Data</a>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-4 flex justify-between items-center">
            <form action="{{ route('bahasa.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input w-full border rounded-md px-3 py-2 text-sm"
                    placeholder="Cari nama bahasa atau wilayah...">
                <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
            </form>

        </div>

        <div>
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-default-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>No</span>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Nama Wilayah</span>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Nama Bahasa</span>
                                            <a href="?sort_by=nama_bahasa&order={{ nextOrder($order) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                @if ($sortBy === 'nama_bahasa' && $order === 'asc')
                                                    <i class="bi bi-sort-alpha-up"></i>
                                                @elseif ($sortBy === 'nama_bahasa' && $order === 'desc')
                                                    <i class="bi bi-sort-alpha-down"></i>
                                                @else
                                                    <i class="bi bi-arrow-down-up"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Alamat</span>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Status</span>
                                            <a href="?sort_by=status&order={{ nextOrder($order) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                @if ($sortBy === 'status' && $order === 'asc')
                                                    <i class="bi bi-sort-alpha-up"></i>
                                                @elseif ($sortBy === 'status' && $order === 'desc')
                                                    <i class="bi bi-sort-alpha-down"></i>
                                                @else
                                                    <i class="bi bi-arrow-down-up"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Jumlah Penutur</span>
                                            <a href="?sort_by=jumlah_penutur&order={{ nextOrder($order) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                @if ($sortBy === 'jumlah_penutur' && $order === 'asc')
                                                    <i class="bi bi-sort-numeric-up"></i>
                                                @elseif ($sortBy === 'jumlah_penutur' && $order === 'desc')
                                                    <i class="bi bi-sort-numeric-down"></i>
                                                @else
                                                    <i class="bi bi-arrow-down-up"></i>
                                                @endif
                                            </a>
                                        </div>
                                    </th>

                                    <th class="px-6 py-3 text-start text-sm text-default-500">Deskripsi
                                    </th>
                                    <th>Koordinat</th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bahasa as $key => $item)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $key + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            {{ $item->wilayah ? $item->wilayah->nama_wilayah : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_bahasa }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->alamat }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            @if ($item->status === 'aktif')
                                                <h1 class="px-2 py-1 rounded bg-green-500 text-white">Aktif</h1>
                                            @else
                                                <h1 class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</h1>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            {{ number_format($item->jumlah_penutur) }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800"
                                            style="white-space:normal;word-wrap:break-word;">
                                            {{ $item->deskripsi }}
                                        </td>

                                        <td>{{ $item->koordinat ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-end font-medium flex space-x-3">
                                            <a href="{{ route('bahasa.show', $item->id) }}"
                                                class="text-green-600 hover:underline">Show</a>
                                            <a href="{{ route('bahasa.edit', $item->id) }}"
                                                class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('bahasa.destroy', $item->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin hapus?')"
                                                    class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data bahasa.
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
@endsection
