<?php

namespace App\Http\Controllers;
use App\Models\Wilayah;
use App\Models\Bahasa;


use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request (array)
        $selectedBahasa = $request->input('bahasa', []);
        $selectedWilayah = $request->input('wilayah', []);

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allBahasa = Bahasa::all()->unique('nama_bahasa')->values();

        // Mulai query dasar
        $wilayahQuery = Wilayah::with('bahasa');
        $bahasaQuery = Bahasa::query();

        // ======== LOGIKA FILTER DINAMIS ========

        // 1️⃣ Jika filter bahasa ada dan bukan “Semua Bahasa”
        if (!empty($selectedBahasa) && !in_array('Semua Bahasa', $selectedBahasa)) {
            $bahasaQuery->whereHas('namaBahasa', function ($q) use ($selectedBahasa) {
                $q->whereIn('nama_bahasa', $selectedBahasa);
            });

        }

        // 2️⃣ Jika filter wilayah ada dan bukan “Semua Wilayah”
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $bahasaQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // =======================================

        // Ambil data hasil filter
        $wilayah = $wilayahQuery->get();

        // Pisahkan koordinat menjadi lat/lng
        $bahasaList = $bahasaQuery->with(['namaBahasa', 'wilayah'])->get()->map(function ($b) {
            if ($b->koordinat) {
                [$lat, $lng] = explode(',', $b->koordinat);
                $b->lat = (float) trim($lat);
                $b->lng = (float) trim($lng);
            } else {
                $b->lat = null;
                $b->lng = null;
            }

            // Ambil nama bahasa & wilayah dari relasi agar JS tidak menerima object
            $b->nama_bahasa = $b->namaBahasa->nama_bahasa ?? $b->nama_bahasa ?? 'Tidak diketahui';
            $b->wilayah = $b->wilayah->nama_wilayah ?? 'Tidak diketahui';
            $b->alamat = $b->alamat ?? ($b->wilayah->alamat ?? 'Alamat tidak tersedia');
            $b->warna_pin = $b->namaBahasa->warna_pin ?? '#1E90FF';
            return $b;
        });


        // Kirim semua ke view
        return view('pages.peta', compact(
            'wilayah',
            'bahasaList',
            'allWilayah',
            'allBahasa',
            'selectedBahasa',
            'selectedWilayah'
        ));
    }

    public function show($id)
    {
        $bahasa = Bahasa::with('wilayah')->findOrFail($id);

        return view('pages.detail-bahasa', compact('bahasa'));
    }
}
