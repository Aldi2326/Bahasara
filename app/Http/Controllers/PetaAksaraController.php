<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Aksara;

class PetaAksaraController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request (array)
        $selectedAksara = $request->input('aksara', []);
        $selectedWilayah = $request->input('wilayah', []);

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allAksara = Aksara::all()->unique('nama_aksara')->values();

        // Mulai query dasar
        $wilayahQuery = Wilayah::with('aksara');
        $aksaraQuery = Aksara::query();

        // ======== LOGIKA FILTER DINAMIS ========

        // 1️⃣ Jika filter aksara ada dan bukan “Semua Sastra”
        if (!empty($selectedAksara) && !in_array('Semua Aksara', $selectedAksara)) {
            $aksaraQuery->whereIn('nama_aksara', $selectedAksara);
        }

        // 2️⃣ Jika filter wilayah ada dan bukan “Semua Wilayah”
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $aksaraQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // =======================================

        // Ambil data hasil filter
        $wilayah = $wilayahQuery->get();

        // Pisahkan koordinat menjadi lat/lng
        $aksaraList = $aksaraQuery->get()->map(function ($b) {
            if ($b->koordinat) {
                [$lat, $lng] = explode(',', $b->koordinat);
                $b->lat = (float) trim($lat);
                $b->lng = (float) trim($lng);
            } else {
                $b->lat = null;
                $b->lng = null;
            }
            return $b;
        });

        // Kirim semua ke view
        return view('pages.aksara', compact(
            'wilayah',
            'aksaraList',
            'allWilayah',
            'allAksara',
            'selectedAksara',
            'selectedWilayah'
        ));
    }

    // public function index()
    // {
    //     $wilayah = Wilayah::with('aksara')->get();

    //     // Ambil daftar aksara unik berdasarkan nama_aksara
    //     $aksaraList = Aksara::select('nama_aksara')
    //         ->groupBy('nama_aksara')
    //         ->get();

    //     return view('pages.aksara', compact('wilayah', 'aksaraList'));
    // }

    public function show($id)
    {
        $aksara = Aksara::with('wilayah')->findOrFail($id);

        return view('pages.detail-aksara', compact('aksara'));
    }

}
