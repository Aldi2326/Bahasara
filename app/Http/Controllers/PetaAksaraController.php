<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Aksara;
use App\Models\NamaAksara;
use Illuminate\Http\Request;

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

        // 1️⃣ Jika filter aksara ada dan bukan “Semua Aksara”
        if (!empty($selectedAksara) && !in_array('Semua Aksara', $selectedAksara)) {
            $aksaraQuery->whereHas('namaAksara', function ($q) use ($selectedAksara) {
                $q->whereIn('nama_aksara', $selectedAksara);
            });
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
        $aksaraList = $aksaraQuery->with(['namaAksara', 'wilayah'])->get()->map(function ($a) {
            if ($a->koordinat) {
                [$lat, $lng] = explode(',', $a->koordinat);
                $a->lat = (float) trim($lat);
                $a->lng = (float) trim($lng);
            } else {
                $a->lat = null;
                $a->lng = null;
            }

            // Ambil nama aksara & wilayah dari relasi agar JS tidak menerima object
            $a->nama_aksara = $a->namaAksara->nama_aksara ?? $a->nama_aksara ?? 'Tidak diketahui';
            $a->wilayah = $a->wilayah->nama_wilayah ?? 'Tidak diketahui';
            $a->alamat = $a->alamat ?? ($a->wilayah->alamat ?? 'Alamat tidak tersedia');
            $a->warna_pin = $a->namaAksara->warna_pin ?? '#1E90FF';
            return $a;
        });

        $namaAksaraAll = NamaAksara::all();
        

        // Kirim semua ke view
        return view('pages.aksara', compact(
            'wilayah',
            'aksaraList',
            'allWilayah',
            'allAksara',
            'selectedAksara',
            'selectedWilayah',
            'namaAksaraAll'
        ));
    }

    public function show($id)
    {
        $aksara = Aksara::with('wilayah')->findOrFail($id);

        return view('pages.detail-aksara', compact('aksara'));
    }
}