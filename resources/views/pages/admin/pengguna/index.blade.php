@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="card overflow-hidden">
        <div>
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="overflow-hidden">
                        <div class="card-header flex justify-between items-center">
                            <h4 class="card-title">Pengguna</h4>
                            <a href="{{ route('users.create') }}" class="btn bg-danger text-white">
                                Tambah Pengguna
                            </a>
                        </div>


                        <table class="min-w-full divide-y divide-default-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">No</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Email</th>
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500">Password</th>
                                    <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd:bg-white even:bg-default-100">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                        1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                        Biawak
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                        Biawakuhuy@gmail.com
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                        biawakuhuy123123
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <form action="" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
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
