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

        return view('pages.peta', compact('wilayah', 'bahasaList'));
    }



    public function show($id)
    {
        $bahasa = Bahasa::with('wilayah')->findOrFail($id);

        return view('pages.detail-bahasa', compact('bahasa'));
    }
}
