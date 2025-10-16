@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Daftar Aksara</h4>
            <a href="{{ route('aksara.create', ['wilayah_id' => $wilayahId]) }}" class="btn bg-danger text-white">
                Tambah Data
            </a>
        </div>

        <!-- Search Bar -->
        <div class="px-6 py-4 flex justify-between items-center">
            <form action="{{ route('aksara.index') }}" method="GET" class="flex items-center space-x-2 w-full md:w-1/3">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-input w-full border rounded-md px-3 py-2 text-sm"
                    placeholder="Cari nama aksara...">
                <button type="submit" class="btn bg-blue-600 text-white text-sm px-3 py-2 rounded-md">Cari</button>
            </form>
        </div>

        @php
            // ambil parameter sort
            $sortField = request('sort_by') ?? '';
            $sortOrder = request('order') === 'asc' ? 'desc' : 'asc';

            // fungsi ikon urut
            function sortIcon($field, $sortField, $sortOrder)
            {
                $isNumericField = in_array($field, ['no', 'jumlah_penutur']);

                if ($sortField === $field) {
                    if ($isNumericField) {
                        return $sortOrder === 'asc'
                            ? '<i class="bi bi-sort-numeric-up"></i>'
                            : '<i class="bi bi-sort-numeric-down"></i>';
                    } else {
                        return $sortOrder === 'asc'
                            ? '<i class="bi bi-sort-alpha-up"></i>'
                            : '<i class="bi bi-sort-alpha-down"></i>';
                    }
                }

                return '<i class="bi bi-arrow-down-up"></i>';
            }

            // data dummy contoh (jika belum pakai database)
            $aksara = collect();
            for ($i = 1; $i <= 10; $i++) {
                $aksara->push([
                    'no' => $i,
                    'nama_aksara' => "Aksara $i",
                    'status' => $i % 2 == 0 ? 'aktif' : 'tidak aktif',
                    'jumlah_penutur' => rand(500, 5000),
                    'deskripsi' => "Deskripsi singkat untuk Aksara ke-$i di wilayah ini.",
                ]);
            }

            // sorting manual langsung di view
            if ($sortField) {
                $aksara = $aksara->sort(function ($a, $b) use ($sortField, $sortOrder) {
                    $valA = $a[$sortField] ?? '';
                    $valB = $b[$sortField] ?? '';

                    $isNumeric = is_numeric(str_replace(['-', '.', ','], '', $valA)) && is_numeric(str_replace(['-', '.', ','], '', $valB));

                    if ($isNumeric) {
                        return $sortOrder === 'asc'
                            ? ($valA <=> $valB)
                            : ($valB <=> $valA);
                    } else {
                        return $sortOrder === 'asc'
                            ? strcmp($valA, $valB)
                            : strcmp($valB, $valA);
                    }
                });
            }
        @endphp

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
                                            <a href="{{ route('aksara.index', ['sort_by' => 'no', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                {!! sortIcon('no', $sortField, $sortOrder) !!}
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Nama Aksara</span>
                                            <a href="{{ route('aksara.index', ['sort_by' => 'nama_aksara', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                {!! sortIcon('nama_aksara', $sortField, $sortOrder) !!}
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Status</span>
                                            <a href="{{ route('aksara.index', ['sort_by' => 'status', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                {!! sortIcon('status', $sortField, $sortOrder) !!}
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Jumlah Penutur</span>
                                            <a href="{{ route('aksara.index', ['sort_by' => 'jumlah_penutur', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">
                                                {!! sortIcon('jumlah_penutur', $sortField, $sortOrder) !!}
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500" style="width:300px;">
                                        <div class="flex items-center gap-1">
                                            <span>Deskripsi</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-start text-sm text-default-500">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($aksara as $item)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $item['no'] }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item['nama_aksara'] }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            @if ($item['status'] == 'aktif')
                                                <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">
                                            {{ number_format($item['jumlah_penutur']) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800"
                                            style="white-space:normal;word-wrap:break-word;">
                                            {{ $item['deskripsi'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-end font-medium space-x-3 flex gap-2">
                                            <a href="#" class="text-blue-600 hover:underline">Edit</a>
                                            <form method="POST" class="inline">
                                                <button type="submit" onclick="return confirm('Yakin hapus?')"
                                                    class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-default-500">
                                            Belum ada data aksara untuk wilayah ini.
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
