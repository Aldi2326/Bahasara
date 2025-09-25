@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="card overflow-hidden">
        <div class="card-header">
            <h4 class="card-title">Pesan</h4>
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
                                    <th scope="col" class="px-6 py-3 text-start text-sm text-default-500"
                                        style="width: 300px;">Pesan</th>
                                    <th scope="col" class="px-6 py-3 text-end text-sm text-default-500">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kontaks as $index => $kontak)
                                    <tr class="odd:bg-white even:bg-default-100">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-default-800">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                            {{ $kontak->nama }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                            {{ $kontak->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-default-800">
                                            {{ $kontak->subjek }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-default-800"
                                            style="white-space: normal; word-wrap: break-word;">
                                            {{ $kontak->pesan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin mau hapus pesan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($kontaks->isEmpty())
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-default-500">
                                            Belum ada pesan.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end card -->
@endsection
