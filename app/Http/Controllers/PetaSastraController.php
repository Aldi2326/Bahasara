<?php

namespace App\Http\Controllers;

use App\Models\NamaSastra;
use App\Models\Wilayah;
use App\Models\Sastra;

use Illuminate\Http\Request;

class PetaSastraController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter & pencarian dari request
        $selectedSastra = $request->input('sastra', []);
        $selectedWilayah = $request->input('wilayah', []);
        $search = $request->input('search'); // ← tambahkan variabel search

        // Ambil semua data untuk dropdown
        $allWilayah = Wilayah::all();
        $allSastra = Sastra::all()->unique('nama_sastra')->values();

        // Mulai query dasar
        $wilayahQuery = Wilayah::with('sastra');
        $sastraQuery = Sastra::query();

        // ======== LOGIKA FILTER DINAMIS ========

        // Filter Sastra
        if (!empty($selectedSastra) && !in_array('Semua Sastra', $selectedSastra)) {
            $sastraQuery->whereHas('namaSastra', function ($q) use ($selectedSastra) {
                $q->whereIn('nama_sastra', $selectedSastra);
            });
        }

        // Filter Wilayah
        if (!empty($selectedWilayah) && !in_array('Semua Wilayah', $selectedWilayah)) {
            $wilayahQuery->whereIn('nama_wilayah', $selectedWilayah);
            $sastraQuery->whereHas('wilayah', function ($q) use ($selectedWilayah) {
                $q->whereIn('nama_wilayah', $selectedWilayah);
            });
        }

        // ======== FITUR PENCARIAN (SEARCH) ========
        if (!empty($search)) {
            $sastraQuery->where(function ($q) use ($search) {
                // cari lewat relasi namaSastra
                $q->whereHas('namaSastra', function ($ns) use ($search) {
                    $ns->where('nama_sastra', 'like', "%{$search}%");
                })
                    // cari berdasarkan alamat di tabel sastra
                    ->orWhere('alamat', 'like', "%{$search}%")
                    // cari lewat relasi wilayah
                    ->orWhereHas('wilayah', function ($w) use ($search) {
                        $w->where('nama_wilayah', 'like', "%{$search}%");
                    });
            });
        }

        // ===========================================

        // Ambil data hasil filter
        $wilayah = $wilayahQuery->get();

        // Mapping data sastra agar siap dipakai di peta
        $sastraList = $sastraQuery->with(['namaSastra', 'wilayah'])->get()->map(function ($s) {
            if ($s->koordinat) {
                [$lat, $lng] = explode(',', $s->koordinat);
                $s->lat = (float) trim($lat);
                $s->lng = (float) trim($lng);
            } else {
                $s->lat = null;
                $s->lng = null;
            }

            $s->nama_sastra = $s->namaSastra->nama_sastra ?? $s->nama_sastra ?? 'Tidak diketahui';
            $s->wilayah = $s->wilayah->nama_wilayah ?? 'Tidak diketahui';
            $s->alamat = $s->alamat ?? ($s->wilayah->alamat ?? 'Alamat tidak tersedia');
            $s->warna_pin = $s->namaSastra->warna_pin ?? '#1E90FF';
            return $s;
        });

        $namaSastraAll = NamaSastra::all();

        // Kirim semua ke view
        return view('pages.sastra', compact(
            'wilayah',
            'sastraList',
            'allWilayah',
            'allSastra',
            'selectedSastra',
            'selectedWilayah',
            'namaSastraAll'
        ));
    }


    public function show($id)
    {
        $sastra = Sastra::with('wilayah')->findOrFail($id);

        return view('pages.detail-sastra', compact('sastra'));
    }
}
