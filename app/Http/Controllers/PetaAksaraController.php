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
        // Ambil filter dari request
        $selectedAksara = $request->input('aksara', []);
        $selectedWilayah = $request->input('wilayah', []);
        $search = $request->input('search'); // 🔍 ambil keyword search

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allAksara = Aksara::all()->unique('nama_aksara')->values();

        // Query dasar
        $wilayahQuery = Wilayah::with('aksara');
        $aksaraQuery = Aksara::query();

        // ========== FILTER ==========

        // Filter Aksara
        if (!empty($selectedAksara) && !in_array('Semua Aksara', $selectedAksara)) {
            $aksaraQuery->whereHas('namaAksara', function ($q) use ($selectedAksara) {
                $q->whereIn('nama_aksara', $selectedAksara);
            });
        }

        // Filter Wilayah
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $aksaraQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // ========== SEARCH ==========
        if (!empty($search)) {
            $aksaraQuery->where(function ($q) use ($search) {
                $q->whereHas('namaAksara', function ($na) use ($search) {
                    $na->where('nama_aksara', 'like', "%{$search}%");
                })
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhereHas('wilayah', function ($w) use ($search) {
                        $w->where('nama_wilayah', 'like', "%{$search}%");
                    });
            });
        }

        // ============================

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

            // Format data untuk frontend
            $a->nama_aksara = $a->namaAksara->nama_aksara ?? $a->nama_aksara ?? 'Tidak diketahui';
            $a->wilayah = $a->wilayah->nama_wilayah ?? 'Tidak diketahui';
            $a->alamat = $a->alamat ?? ($a->wilayah->alamat ?? 'Alamat tidak tersedia');
            $a->warna_pin = $a->namaAksara->warna_pin ?? '#1E90FF';
            return $a;
        });

        $namaAksaraAll = NamaAksara::all();

        // Kirim ke view
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
