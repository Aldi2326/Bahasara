@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Data Sastra</h4>
            <a href="{{ route('sastra.create', ['wilayah_id' => $wilayahId]) }}" class="btn bg-danger text-white">Tambah Data</a>
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

        @php
            // ambil parameter sort
            $sortField = request('sort_by') ?? '';
            $sortOrder = request('order') === 'asc' ? 'desc' : 'asc';

            // fungsi ikon urut (dibedakan antara numeric & alphabet)
            function sortIcon($field, $sortField, $sortOrder)
            {
                $isNumericField = in_array($field, ['no']); // kolom numeric

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

                // default icon (tidak sedang disort)
                return '<i class="bi bi-arrow-down-up"></i>';
            }

            // generate data contoh
            $sastra = collect();
            for ($i = 1; $i <= 10; $i++) {
                $sastra->push([
                    'no' => $i,
                    'nama_sastra' => "Sastra $i",
                    'jenis' => $i % 2 == 0 ? 'Prosa' : 'Puisi',
                    'deskripsi' => "Ini adalah deskripsi untuk sastra ke-$i di wilayah ini.",
                    'koordinat' => "-1.61$i, 103.61$i",
                ]);
            }

            // lakukan sorting manual (langsung di view)
            if ($sortField) {
                $sastra = $sastra->sort(function ($a, $b) use ($sortField, $sortOrder) {
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
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>No</span>
                                            <a href="{{ route('sastra.index', ['sort_by' => 'no', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">{!! sortIcon('no', $sortField, $sortOrder) !!}</a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Nama Sastra</span>
                                            <a href="{{ route('sastra.index', ['sort_by' => 'nama_sastra', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">{!! sortIcon('nama_sastra', $sortField, $sortOrder) !!}</a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Jenis</span>
                                            <a href="{{ route('sastra.index', ['sort_by' => 'jenis', 'order' => $sortOrder]) }}"
                                                class="text-gray-600 hover:text-blue-600">{!! sortIcon('jenis', $sortField, $sortOrder) !!}</a>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500" style="width: 300px;">
                                        <div class="flex items-center gap-1">
                                            <span>Deskripsi</span>
                                            
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">
                                        <div class="flex items-center gap-1">
                                            <span>Koordinat</span>
                                            
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($sastra as $item)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $item['no'] }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item['nama_sastra'] }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item['jenis'] }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                                            {{ $item['deskripsi'] }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item['koordinat'] }}</td>
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
                                            Belum ada data sastra untuk wilayah ini.
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
