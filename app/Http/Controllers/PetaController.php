<?php

namespace App\Http\Controllers;
use App\Models\Wilayah;
use App\Models\Bahasa;


use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
{
    $wilayah = Wilayah::with('bahasa')->get();

    // Ambil daftar bahasa unik berdasarkan nama_bahasa
    $bahasaList = Bahasa::select('nama_bahasa')
        ->groupBy('nama_bahasa')
        ->get();

    // Tambahkan titik koordinat secara manual (contoh data)
    $koordinatBahasa = [
        'Bahasa Melayu Jambi' => ['lat' => -1.6101, 'lng' => 103.6158],
        'Bahasa Kerinci' => ['lat' => -2.0833, 'lng' => 101.3833],
        'Bahasa Bungo' => ['lat' => -1.4936, 'lng' => 102.1333],
        'Bahasa Tebo' => ['lat' => -1.3779, 'lng' => 102.3500],
        'Bahasa Batanghari' => ['lat' => -1.7000, 'lng' => 103.1000],
        'Bahasa Sarolangun' => ['lat' => -2.3167, 'lng' => 102.7167],
        'Bahasa Merangin' => ['lat' => -2.1167, 'lng' => 102.2667],
        'Bahasa Muaro Jambi' => ['lat' => -1.6000, 'lng' => 103.7000],
        'Bahasa Tanjung Jabung Barat' => ['lat' => -0.9000, 'lng' => 103.2000],
        'Bahasa Tanjung Jabung Timur' => ['lat' => -1.0833, 'lng' => 103.8667],
        'Bahasa Sungai Penuh' => ['lat' => -2.0833, 'lng' => 101.3833],
    ];

    // Sisipkan koordinat ke setiap elemen $bahasaList
    $bahasaList = $bahasaList->map(function ($b) use ($koordinatBahasa) {
        $nama = $b->nama_bahasa;
        $b->lat = $koordinatBahasa[$nama]['lat'] ?? null;
        $b->lng = $koordinatBahasa[$nama]['lng'] ?? null;
        return $b;
    });

    return view('pages.peta', compact('wilayah', 'bahasaList'));
}




    public function show($id)
    {
        $bahasa = Bahasa::with('wilayah')->findOrFail($id);

        return view('pages.detail-bahasa', compact('bahasa'));
    }
}
