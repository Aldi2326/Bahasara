@extends('layouts.admin.app')
@section('title', 'Wilayah')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">Daftar Wilayah</h4>
      <a href="/admin/wilayah/tambah" class="btn bg-danger text-white">Tambah Wilayah</a>
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
                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">1</td>
                  <td class="px-6 py-4 text-sm text-default-800">Kabupaten Bungo</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="{{ asset('storage/geojson/Bungo.geojson') }}" class="text-primary hover:underline" target="_blank">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800 space-x-2">
                    <a href="/admin/peta/bahasa" class="text-green-600 hover:underline">+ Bahasa</a>
                    <a href="/admin/peta/aksara" class="text-purple-600 hover:underline">+ Aksara</a>
                    <a href="/admin/peta/sastra" class="text-orange-600 hover:underline">+ Sastra</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="/admin/wilayah/edit" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">2</td>
                  <td class="px-6 py-4 text-sm text-default-800">Kabupaten Merangin</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="{{ asset('storage/geojson/Merangin.geojson') }}" class="text-primary hover:underline" target="_blank">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800 space-x-2">
                    <a href="#" class="text-green-600 hover:underline">+ Bahasa</a>
                    <a href="#" class="text-purple-600 hover:underline">+ Aksara</a>
                    <a href="#" class="text-orange-600 hover:underline">+ Sastra</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">3</td>
                  <td class="px-6 py-4 text-sm text-default-800">Kabupaten Kerinci</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="{{ asset('storage/geojson/Kerinci.geojson') }}" class="text-primary hover:underline" target="_blank">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800 space-x-2">
                    <a href="#" class="text-green-600 hover:underline">+ Bahasa</a>
                    <a href="#" class="text-purple-600 hover:underline">+ Aksara</a>
                    <a href="#" class="text-orange-600 hover:underline">+ Sastra</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- end card -->
@endsection
