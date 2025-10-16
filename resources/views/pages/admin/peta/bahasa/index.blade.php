@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')

@php
    // --- Data Bahasa Hardcode ---
    $bahasa = [
        ['nama_bahasa' => 'Bahasa Jambi', 'status' => 'aktif', 'jumlah_penutur' => 50000, 'deskripsi' => 'lorem100 Bahasa daerah yang digunakan di Kota Jambi.'],
        ['nama_bahasa' => 'Bahasa Kerinci', 'status' => 'aktif', 'jumlah_penutur' => 75000, 'deskripsi' => 'Bahasa yang digunakan oleh masyarakat Kerinci.'],
        ['nama_bahasa' => 'Bahasa Melayu', 'status' => 'aktif', 'jumlah_penutur' => 120000, 'deskripsi' => 'Bahasa dengan penutur tersebar di berbagai daerah.'],
        ['nama_bahasa' => 'Bahasa Batin', 'status' => 'tidak aktif', 'jumlah_penutur' => 8000, 'deskripsi' => 'Bahasa minoritas di daerah Sarolangun.'],
        ['nama_bahasa' => 'Bahasa Bajau', 'status' => 'aktif', 'jumlah_penutur' => 16000, 'deskripsi' => 'Bahasa masyarakat pesisir dan nelayan.'],
        ['nama_bahasa' => 'Bahasa Kubu', 'status' => 'tidak aktif', 'jumlah_penutur' => 5000, 'deskripsi' => 'Bahasa suku Anak Dalam (Kubu).'],
        ['nama_bahasa' => 'Bahasa Rantau Panjang', 'status' => 'aktif', 'jumlah_penutur' => 21000, 'deskripsi' => 'Bahasa lokal yang digunakan di Rantau Panjang.'],
        ['nama_bahasa' => 'Bahasa Penghulu', 'status' => 'aktif', 'jumlah_penutur' => 15000, 'deskripsi' => 'Bahasa komunitas kecil di wilayah barat Jambi.'],
        ['nama_bahasa' => 'Bahasa Bangko', 'status' => 'aktif', 'jumlah_penutur' => 27000, 'deskripsi' => 'Bahasa dari daerah Bangko dan sekitarnya.'],
        ['nama_bahasa' => 'Bahasa Tungkal', 'status' => 'aktif', 'jumlah_penutur' => 45000, 'deskripsi' => 'Bahasa yang digunakan di Kuala Tungkal dan sekitarnya.'],
    ];

    // --- Sorting Logic ---
    $sortBy = request('sort_by');
    $order = request('order', 'asc');

    if ($sortBy) {
        usort($bahasa, function ($a, $b) use ($sortBy, $order) {
            if ($sortBy === 'status') {
                $aVal = $a[$sortBy] === 'aktif' ? 1 : 0;
                $bVal = $b[$sortBy] === 'aktif' ? 1 : 0;
            } elseif ($sortBy === 'no') {
                static $counter = 0;
                $aVal = ++$counter;
                $bVal = $aVal + 1;
            } else {
                $aVal = $a[$sortBy];
                $bVal = $b[$sortBy];
            }
            if ($aVal == $bVal) return 0;
            return $order === 'asc' ? ($aVal <=> $bVal) : ($bVal <=> $aVal);
        });
    }

    function nextOrder($currentOrder) {
        return $currentOrder === 'asc' ? 'desc' : 'asc';
    }
@endphp

<div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Daftar Bahasa</h4>
        <a href="#" class="btn bg-danger text-white">Tambah Data</a>
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
                                        <a href="?sort_by=no&order={{ nextOrder($order) }}" class="text-gray-600 hover:text-blue-600">
                                            @if ($sortBy === 'no' && $order === 'asc')
                                                <i class="bi bi-sort-numeric-up"></i>
                                            @elseif ($sortBy === 'no' && $order === 'desc')
                                                <i class="bi bi-sort-numeric-down"></i>
                                            @else
                                                <i class="bi bi-arrow-down-up"></i>
                                            @endif
                                        </a>
                                    </div>
                                </th>

                                <th class="px-6 py-3 text-start text-sm text-default-500">
                                    <div class="flex items-center gap-1">
                                        <span>Nama Bahasa</span>
                                        <a href="?sort_by=nama_bahasa&order={{ nextOrder($order) }}" class="text-gray-600 hover:text-blue-600">
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
                                        <span>Status</span>
                                        <a href="?sort_by=status&order={{ nextOrder($order) }}" class="text-gray-600 hover:text-blue-600">
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
                                        <a href="?sort_by=jumlah_penutur&order={{ nextOrder($order) }}" class="text-gray-600 hover:text-blue-600">
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

                                <th class="px-6 py-3 text-start text-sm text-default-500" style="width:300px;">Deskripsi</th>
                                <th class="px-6 py-3 text-start text-sm text-default-500">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bahasa as $key => $item)
                                <tr class="odd:bg-white even:bg-default-100">
                                    <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $key + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ $item['nama_bahasa'] }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800">
                                        @if ($item['status'] === 'aktif')
                                            <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-default-800">{{ number_format($item['jumlah_penutur']) }}</td>
                                    <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                                        {{ $item['deskripsi'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-end font-medium flex space-x-3">
                                        <a href="{{ url('/admin/peta/bahasa', $key) }}" class="text-green-600 hover:underline">Show</a>
                                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                                        <form method="POST" class="inline">
                                            <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
