<?php

namespace App\Http\Controllers;

use App\Models\NamaSastra;
use Illuminate\Http\Request;

class NamaSastraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil nilai pencarian dan urutan sort dari request
        $search = $request->input('search');
        $sortOrder = $request->input('sort', 'asc'); // default: ascending

        // Query dasar
        $query = \App\Models\NamaSastra::query();

        // Jika ada input pencarian, tambahkan filter berdasarkan nama_sastra
        if ($search) {
            $query->where('nama_sastra', 'LIKE', "%{$search}%");
        }

        // Urutkan data berdasarkan nama_sastra
        $query->orderBy('nama_sastra', $sortOrder);

        // Jalankan query dan ambil hasil
        $namaSastra = $query->get();

        // Kirim data ke view
        return view('pages.admin.masterdata.namasastra.index', compact('namaSastra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.masterdata.namasastra.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sastra' => 'required|string|max:255',
            'warna_pin' => 'nullable|string|max:20',
        ]);

        NamaSastra::create($data);

        return redirect()->route('nama-sastra.index')->with('success', 'Data nama sastra berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NamaSastra $namaSastra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NamaSastra $namaSastra)
    {
        // Menampilkan halaman edit dengan data sastra yang dipilih
        return view('pages.admin.masterdata.namasastra.edit', compact('namaSastra'));
    }

    public function update(Request $request, NamaSastra $namaSastra)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'nama_sastra' => 'required|string|max:255',
            'warna_pin' => 'required|string|max:7', 
        ]);

        // Update data sastra
        $namaSastra->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('nama-sastra.index')->with('success', 'Data sastra berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NamaSastra $namaSastra)
    {
        $namaSastra->delete();

        return redirect()->route('nama-sastra.index')
            ->with('success', 'Nama sastra  berhasil dihapus.');
    }
}