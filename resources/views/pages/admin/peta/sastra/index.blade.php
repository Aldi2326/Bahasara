@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Data Sastra</h4>
            <a href="{{ route('sastra.create', ['wilayah_id' => $wilayahId]) }}" class="btn bg-danger text-white">Tambah
                Data</a>
        </div>

        <div>
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-default-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">No</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama Sastra
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500"
                                        style="width: 300px;">Deskripsi</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Koordinat</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sastra as $key => $item)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 text-sm font-medium text-default-800">{{ $key + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->nama_sastra }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->jenis }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->deskripsi }}</td>
                                        <td class="px-6 py-4 text-sm text-default-800">{{ $item->koordinat }}</td>
                                        
                                        <td class="px-6 py-4 text-sm text-end font-medium space-x-3 flex">
                                            <a href="{{ route('sastra.edit', $item->id) }}"
                                                class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('sastra.destroy', $item->id) }}" method="POST"
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
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-default-500">
                                            Belum ada data bahasa untuk wilayah ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end card -->
@endsection
