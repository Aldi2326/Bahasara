@extends('layouts.admin.app')
@section('title', 'Aksara')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">Daftar Aksara</h4>
      <a href="{{ route('aksara.create')}}" class="btn bg-danger text-white">Tambah Data</a>
    </div>
    <div>
      <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-default-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Nama Aksara</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Status</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Jumlah Pengguna</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500" style="width:300px;">Deskripsi</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">GeoJSON</th>
                  <th class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">1</td>
                  <td class="px-6 py-4 text-sm text-default-800">Aksara Incung</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <span class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</span>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">50</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                    Aksara Incung adalah aksara tradisional masyarakat Kerinci di Provinsi Jambi. 
                    Saat ini aksara ini lebih banyak digunakan untuk kepentingan penelitian dan pelestarian budaya, 
                    sehingga jumlah penggunanya sangat terbatas. Aksara ini ditulis miring dengan gaya khas dan 
                    biasanya ditemukan pada naskah kuno serta ukiran kayu.
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="#" class="text-primary hover:underline">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="/admin/peta/aksara/edit" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">2</td>
                  <td class="px-6 py-4 text-sm text-default-800">Aksara Rencong</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">200</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                    Aksara Rencong dikenal di wilayah Sumatera bagian selatan, termasuk Bengkulu, Lampung, dan 
                    sebagian Jambi. Aksara ini masih diajarkan dalam konteks budaya dan pendidikan tradisional, 
                    meskipun jumlah penggunanya tidak banyak.
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="#" class="text-primary hover:underline">Download File</a>
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
