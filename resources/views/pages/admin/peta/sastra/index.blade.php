@extends('layouts.admin.app')
@section('title', 'Sastra')
@section('content')
  <div class="card overflow-hidden">
    <div class="card-header flex justify-between items-center" >
      <h4 class="card-title">Sastra</h4>
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
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Email</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Subjek</th>
                  <th scope="col" class="px-6 py-3 text-start text-sm text-default-500" style="width: 300px;">Pesan</th>
                  <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">1</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Lindsay Walton</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">lindsay.walton@example.com</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Pertanyaan Website</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; word-wrap: break-word;">
                    Halo admin, saya ingin menanyakan terkait fitur terbaru. Pesan ini agak panjang supaya kelihatan efek wrap text-nya.
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                    <a class="text-primary hover:text-primary-700" href="#">Delete</a>
                  </td>
                </tr>

                <tr class="odd:bg-white even:bg-default-100">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">2</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Courtney Henry</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">courtneyhenry@example.com</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">Saran Fitur</td>
                  <td class="px-6 py-4 text-sm text-default-800" style="white-space: normal; word-wrap: break-word;">
                    Menurut saya, aplikasi ini akan lebih bagus jika ditambah fitur dark mode agar nyaman digunakan di malam hari.
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                    <a class="text-primary hover:text-primary-700" href="#">Delete</a>
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
