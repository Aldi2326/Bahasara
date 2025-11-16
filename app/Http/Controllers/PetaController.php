<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Bahasa;
use App\Models\NamaBahasa;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari request (array)
        $selectedBahasa = $request->input('bahasa', []);
        $selectedWilayah = $request->input('wilayah', []);
        $search = $request->input('search'); // ✅ ambil kata kunci pencarian

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allBahasa = Bahasa::all()->unique('nama_bahasa')->values();

        // Mulai query dasar
        $wilayahQuery = Wilayah::with('bahasa');
        $bahasaQuery = Bahasa::query();

        // ======== LOGIKA FILTER DINAMIS ========

        // 1️⃣ Filter bahasa
        if (!empty($selectedBahasa) && !in_array('Semua Bahasa', $selectedBahasa)) {
            $bahasaQuery->whereHas('namaBahasa', function ($q) use ($selectedBahasa) {
                $q->whereIn('nama_bahasa', $selectedBahasa);
            });
        }

        // 2️⃣ Filter wilayah
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $bahasaQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // 3️⃣ Filter pencarian umum (nama bahasa atau wilayah)
        if (!empty($search)) {
            $bahasaQuery->where(function ($q) use ($search) {
                // cari di relasi namaBahasa
                $q->whereHas('namaBahasa', function ($q1) use ($search) {
                    $q1->where('nama_bahasa', 'LIKE', "%{$search}%");
                })
                    // cari di relasi wilayah
                    ->orWhereHas('wilayah', function ($q2) use ($search) {
                        $q2->where('nama_wilayah', 'LIKE', "%{$search}%");
                    });
            });
        }


        // =======================================

        $wilayah = $wilayahQuery->get();

        $bahasaList = $bahasaQuery->with(['namaBahasa', 'wilayah'])->get()->map(function ($b) {
            if ($b->koordinat) {
                [$lat, $lng] = explode(',', $b->koordinat);
                $b->lat = (float) trim($lat);
                $b->lng = (float) trim($lng);
            } else {
                $b->lat = null;
                $b->lng = null;
            }

            $b->nama_bahasa = $b->namaBahasa->nama_bahasa ?? $b->nama_bahasa ?? 'Tidak diketahui';
            $b->wilayah = $b->wilayah->nama_wilayah ?? 'Tidak diketahui';
            $b->alamat = $b->alamat ?? ($b->wilayah->alamat ?? 'Alamat tidak tersedia');
            $b->warna_pin = $b->namaBahasa->warna_pin ?? '#1E90FF';
            return $b;
        });

        $namaBahasaAll = NamaBahasa::all();

        return view('pages.peta', compact(
            'wilayah',
            'bahasaList',
            'allWilayah',
            'allBahasa',
            'selectedBahasa',
            'selectedWilayah',
            'namaBahasaAll',
            'search', // ✅ dikirim ke view biar bisa tetap tampil di input
        ));
    }


    public function show($id)
    {
        $bahasa = Bahasa::with('wilayah')->findOrFail($id);

        return view('pages.detail-bahasa', compact('bahasa'));
    }
}
