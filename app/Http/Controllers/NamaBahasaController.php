<?php

namespace App\Http\Controllers;

use App\Models\NamaBahasa;
use Illuminate\Http\Request;

class NamaBahasaController extends Controller
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
        $query = \App\Models\NamaBahasa::query();

        // Jika ada input pencarian, tambahkan filter berdasarkan nama_bahasa
        if ($search) {
            $query->where('nama_bahasa', 'LIKE', "%{$search}%");
        }

        // Urutkan data berdasarkan nama_bahasa
        $query->orderBy('nama_bahasa', $sortOrder);

        // Jalankan query dan ambil hasil
        $namaBahasa = $query->get();

        // Kirim data ke view
        return view('pages.admin.masterdata.namabahasa.index', compact('namaBahasa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.masterdata.namabahasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_bahasa' => 'required|string|max:255',
            'warna_pin' => 'nullable|string|max:20',
        ]);

        NamaBahasa::create($data);

        return redirect()->route('nama-bahasa.index')->with('success', 'Data nama bahasa berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NamaBahasa $namaBahasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NamaBahasa $namaBahasa)
    {
        // Menampilkan halaman edit dengan data bahasa yang dipilih
        return view('pages.admin.masterdata.namabahasa.edit', compact('namaBahasa'));
    }

    public function update(Request $request, NamaBahasa $namaBahasa)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'nama_bahasa' => 'required|string|max:255',
            'warna_pin' => 'required|string|max:7', 
        ]);

        // Update data bahasa
        $namaBahasa->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('nama-bahasa.index')->with('success', 'Data bahasa berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NamaBahasa $namaBahasa)
    {
        $namaBahasa->delete();

        return redirect()->route('nama-bahasa.index')
            ->with('success', 'Nama bahasa  berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            $idsArray = explode(',', $ids);
            
            // Hapus data
            NamaBahasa::whereIn('id', $idsArray)->delete();
            
            return redirect()->back()->with('success', 'Data terpilih berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
