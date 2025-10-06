<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Sastra;

class PetaSastraController extends Controller
{
    public function index()
    {
        $wilayah = Wilayah::with('sastra')->get();

        // Ambil daftar sastra unik berdasarkan nama_sastra
        $sastraList = Sastra::select('nama_sastra')
            ->groupBy('nama_sastra')
            ->get();

        return view('pages.sastra', compact('wilayah', 'sastraList'));
    }

    public function show($id)
    {
        $sastra = Sastra::with('wilayah')->findOrFail($id);

        return view('pages.detail-sastra', compact('sastra'));
    }
}
