@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center">
      <h4 class="card-title">Data Sastra</h4>
      <a href="/admin/peta/sastra/tambah" class="btn bg-danger text-white">Tambah Data</a>
    </div>

    <div>
      <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-default-200">
              <thead>
                <tr>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">No</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama Sastra</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Jenis</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500" style="width: 300px;">Deskripsi</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Koordinat</th>
                  <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">1</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Gurindam Dua Belas</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Tulisan</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; word-wrap: break-word;">
                    Karya sastra berbentuk syair berisi nasihat moral dan ajaran kehidupan. Gurindam ini berkembang di Jambi dan Riau, sangat dikenal dalam tradisi sastra Melayu.
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">-1.610100, 103.615800</td>
                  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                    <a class="text-primary hover:text-primary-700" href="#">Edit</a> | 
                    <a class="text-danger hover:text-danger-700" href="#">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">2</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Pantun Melayu</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Lisan</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; word-wrap: break-word;">
                    Pantun Melayu Jambi merupakan sastra lisan yang sering digunakan dalam acara adat maupun pergaulan sehari-hari, sarat makna, berisi nasihat, sindiran, maupun hiburan.
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">-1.720200, 103.523400</td>
                  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                    <a class="text-primary hover:text-primary-700" href="#">Edit</a> | 
                    <a class="text-danger hover:text-danger-700" href="#">Delete</a>
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
