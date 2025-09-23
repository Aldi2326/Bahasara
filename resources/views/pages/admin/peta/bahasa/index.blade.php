@extends('layouts.admin.app')
@section('title', 'Bahasa')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">Daftar Bahasa</h4>
      <a href="{{ route('bahasa.create')}}" class="btn bg-danger text-white">Tambah Data</a>
    </div>
    <div>
      <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-default-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 text-start text-sm text-default-500">No</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Nama Bahasa</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Status</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">Jumlah Penutur</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500" style="width:300px;">Deskripsi</th>
                  <th class="px-6 py-3 text-start text-sm text-default-500">GeoJSON</th>
                  <th class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">1</td>
                  <td class="px-6 py-4 text-sm text-default-800">Bahasa Melayu Jambi</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">250.000</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                    Bahasa Melayu Jambi merupakan bahasa daerah utama yang digunakan di wilayah Provinsi Jambi, 
                    terutama di pusat kota dan kabupaten sekitar. Bahasa ini memiliki peran penting dalam 
                    komunikasi sehari-hari, budaya, dan tradisi lokal.
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="#" class="text-primary hover:underline">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="/admin/peta/bahasa/edit" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">2</td>
                  <td class="px-6 py-4 text-sm text-default-800">Bahasa Kerinci</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <span class="px-2 py-1 rounded bg-green-500 text-white">Aktif</span>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">120.000</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                    Bahasa Kerinci digunakan di wilayah Kabupaten Kerinci dan sekitarnya. Bahasa ini memiliki 
                    dialek yang sangat beragam, bahkan antar desa dapat berbeda. Kekayaan variasi dialek 
                    membuat bahasa ini unik dan penting untuk dilestarikan.
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <a href="#" class="text-primary hover:underline">Download File</a>
                  </td>
                  <td class="px-6 py-4 text-sm text-end font-medium space-x-3">
                    <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    <a href="#" class="text-red-600 hover:underline">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 text-sm font-medium text-default-800">3</td>
                  <td class="px-6 py-4 text-sm text-default-800">Bahasa Suku Anak Dalam</td>
                  <td class="px-6 py-4 text-sm text-default-800">
                    <span class="px-2 py-1 rounded bg-red-500 text-white">Tidak Aktif</span>
                  </td>
                  <td class="px-6 py-4 text-sm text-default-800">3.000</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space:normal;word-wrap:break-word;">
                    Bahasa Suku Anak Dalam dipakai oleh komunitas adat terpencil di pedalaman Jambi. Saat ini 
                    bahasa ini terancam punah karena semakin sedikit penuturnya. Dukungan pelestarian sangat 
                    diperlukan agar bahasa ini tidak hilang.
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
