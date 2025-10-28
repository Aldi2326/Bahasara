<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Sastra;

class PetaSastraController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request (array)
        $selectedSastra = $request->input('sastra', []);
        $selectedWilayah = $request->input('wilayah', []);

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allSastra = Sastra::all();

        // Mulai query dasar
        $wilayahQuery = Wilayah::with('sastra');
        $sastraQuery = Sastra::query();

        // ======== LOGIKA FILTER DINAMIS ========

        // 1️⃣ Jika filter sastra ada dan bukan “Semua Sastra”
        if (!empty($selectedSastra) && !in_array('Semua Sastra', $selectedSastra)) {
            $sastraQuery->whereIn('nama_sastra', $selectedSastra);
        }

        // 2️⃣ Jika filter wilayah ada dan bukan “Semua Wilayah”
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $sastraQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // =======================================

        // Ambil data hasil filter
        $wilayah = $wilayahQuery->get();

        // Pisahkan koordinat menjadi lat/lng
        $sastraList = $sastraQuery->get()->map(function ($b) {
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
        return view('pages.sastra', compact(
            'wilayah',
            'sastraList',
            'allWilayah',
            'allSastra',
            'selectedSastra',
            'selectedWilayah'
        ));
    }

    // public function index()
    // {
    //     $wilayah = Wilayah::with('sastra')->get();

    //     $sastraList = Sastra::select('nama_sastra')
    //         ->groupBy('nama_sastra')
    //         ->get();

    //     return view('pages.sastra', compact('wilayah', 'sastraList'));
    // }



    public function show($id)
    {
        $sastra = Sastra::with('wilayah')->findOrFail($id);

        return view('pages.detail-sastra', compact('sastra'));
    }
}
