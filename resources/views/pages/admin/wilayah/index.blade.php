@extends('layouts.admin.app')
@section('title', 'Wilayah')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">Daftar Wilayah</h4>
      <a href="{{ route('wilayah.create') }}" class="btn bg-danger text-white">Tambah Wilayah</a>
    </div>
    <div>
      <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-default-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Nama Wilayah</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">GeoJSON</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Tambah Data</th>
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
                    <td class="px-6 py-4 text-sm text-default-800">
                      @if($item->file_geojson)
                        <a href="{{ asset($item->file_geojson) }}" 
   download 
   class="text-primary hover:underline">
   Download File
</a>

                      @else
                        <span class="text-gray-400">Tidak ada file</span>
                      @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-default-800 space-x-2">
                      <a href="{{ route('bahasa.index', ['wilayah_id' => $item->id]) }}" class="text-green-600 hover:underline">+ Bahasa</a>

                      {{-- <a href="{{ route('bahasa.create', $item->id) }}" class="text-green-600 hover:underline">+ Bahasa</a>
                      <a href="{{ route('aksara.create', $item->id) }}" class="text-purple-600 hover:underline">+ Aksara</a>
                      <a href="{{ route('sastra.create', $item->id) }}" class="text-orange-600 hover:underline">+ Sastra</a> --}}
                    </td>
                    <td class="px-6 py-4 flex justify-end text-sm text-end font-medium space-x-3">
                      <a href="{{ route('wilayah.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                      <form action="{{ route('wilayah.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus data ini?')">Delete</button>
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
  </div> <!-- end card -->
@endsection
