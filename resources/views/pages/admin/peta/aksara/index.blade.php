@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Daftar Aksara</h4>
            <a href="{{ route('aksara.create') }}" class="btn bg-danger text-white">
                Tambah Data
            </a>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-4 flex justify-between items-center">
            <form action="{{ route('aksara.index') }}" method="GET"
                class="flex items-center space-x-2 w-full md:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input w-full border rounded-md px-3 py-2 text-sm"
                    placeholder="Cari nama aksara...">
                <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
            </form>
        </div>

        @php
            $sortField = request('sort_by') ?? 'nama_aksara';
            $sortOrder = request('order') ?? 'asc';
        @endphp

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-default-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">
                            <a href="{{ route('aksara.index', ['sort_by' => 'nama_wilayah', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                class="text-gray-600 hover:text-blue-600">
                                Nama Wilayah
                                {!! $sortField === 'nama_wilayah'
                                    ? ($sortOrder === 'asc'
                                        ? '<i class="bi bi-sort-alpha-up"></i>'
                                        : '<i class="bi bi-sort-alpha-down"></i>')
                                    : '<i class="bi bi-arrow-down-up"></i>' !!}
                            </a>
                        </th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">
                            <a href="{{ route('aksara.index', ['sort_by' => 'nama_aksara', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                class="text-gray-600 hover:text-blue-600">
                                Nama Aksara
                                {!! $sortField === 'nama_aksara'
                                    ? ($sortOrder === 'asc'
                                        ? '<i class="bi bi-sort-alpha-up"></i>'
                                        : '<i class="bi bi-sort-alpha-down"></i>')
                                    : '<i class="bi bi-arrow-down-up"></i>' !!}
                            </a>
                        </th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">
                            <a href="{{ route('aksara.index', ['sort_by' => 'status', 'order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}"
                                class="text-gray-600 hover:text-blue-600">
                                Status
                                {!! $sortField === 'status'
                                    ? ($sortOrder === 'asc'
                                        ? '<i class="bi bi-sort-alpha-up"></i>'
                                        : '<i class="bi bi-sort-alpha-down"></i>')
                                    : '<i class="bi bi-arrow-down-up"></i>' !!}
                            </a>
                        </th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">Deskripsi</th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">Dokumentasi</th>
                        <th class="px-6 py-3 text-start text-sm text-default-500">Koordinat</th>
                        <th class="px-6 py-3 text-start text-sm text-default-500 text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($aksara as $index => $item)
                        <tr class="odd:bg-white even:bg-default-100">
                            <!-- Nomor urut -->
                            <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $index + 1 }}</td>

                            <!-- Nama Wilayah -->
                            <td class="px-6 py-4 text-sm text-default-800">
                                {{ $item->wilayah->nama_wilayah ?? '-' }}
                            </td>

                            <!-- Nama Aksara -->
                            <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_aksara }}</td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-sm text-default-800">
                                @if ($item->status == 'aktif')
                                    <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</span>
                                @endif
                            </td>

                            <!-- Deskripsi -->
                            <td class="px-6 py-4 text-sm text-default-800"
                                style="white-space: normal; word-wrap: break-word; max-width: 400px;">
                                {{ Str::limit($item->deskripsi, 150) }}
                            </td>

                            <!-- Dokumentasi -->
                            <td class="px-6 py-4 text-sm text-default-800">
                                @if ($item->dokumentasi)
                                    @if (Str::endsWith($item->dokumentasi, ['.mp4', '.mov', '.avi']))
                                        <video src="{{ asset('storage/' . $item->dokumentasi) }}" width="120"
                                            controls class="rounded-md shadow"></video>
                                    @else
                                        <img src="{{ asset('storage/' . $item->dokumentasi) }}" alt="dokumentasi"
                                            width="100" class="rounded-md shadow">
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Koordinat -->
                            <td class="px-6 py-4 text-sm text-default-800">
                                {{ $item->koordinat ?? '-' }}
                            </td>

                            <!-- Action -->
                            <td class="px-6 py-4 text-sm text-center font-medium flex gap-2 justify-center">
                                <a href="{{ route('aksara.show', $item->id) }}"
                                                class="text-green-600 hover:underline">Show</a>
                                <a href="{{ route('aksara.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('aksara.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-default-500">
                                Belum ada data aksara untuk wilayah ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
