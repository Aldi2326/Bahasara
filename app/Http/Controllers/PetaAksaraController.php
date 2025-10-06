<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Aksara;

class PetaAksaraController extends Controller
{
    public function index()
    {
        $wilayah = Wilayah::with('aksara')->get();

        // Ambil daftar aksara unik berdasarkan nama_aksara
        $aksaraList = Aksara::select('nama_aksara')
            ->groupBy('nama_aksara')
            ->get();

        return view('pages.aksara', compact('wilayah', 'aksaraList'));
    }

    public function show($id)
    {
        $aksara = Aksara::with('wilayah')->findOrFail($id);

        return view('pages.detail-aksara', compact('aksara'));
    }

}
