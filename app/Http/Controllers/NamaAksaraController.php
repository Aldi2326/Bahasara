<?php

namespace App\Http\Controllers;

use App\Models\NamaAksara;
use Illuminate\Http\Request;

class NamaAksaraController extends Controller
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
        $query = \App\Models\NamaAksara::query();

        // Jika ada input pencarian, tambahkan filter berdasarkan nama_aksara
        if ($search) {
            $query->where('nama_aksara', 'LIKE', "%{$search}%");
        }

        // Urutkan data berdasarkan nama_aksara
        $query->orderBy('nama_aksara', $sortOrder);

        // Jalankan query dan ambil hasil
        $namaAksara = $query->get();

        // Kirim data ke view
        return view('pages.admin.masterdata.namaaksara.index', compact('namaAksara'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.masterdata.namaaksara.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aksara' => 'required|string|max:255',
            'warna_pin' => 'nullable|string|max:20',
        ]);

        NamaAksara::create($data);

        return redirect()->route('nama-aksara.index')->with('success', 'Data nama aksara berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NamaAksara $namaAksara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NamaAksara $namaAksara)
    {
        // Menampilkan halaman edit dengan data akasara yang dipilih
        return view('pages.admin.masterdata.namaaksara.edit', compact('namaAksara'));
    }

    public function update(Request $request, NamaAksara $namaAksara)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'nama_aksara' => 'required|string|max:255',
            'warna_pin' => 'required|string|max:7', 
        ]);

        // Update data akasara
        $namaAksara->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('nama-aksara.index')->with('success', 'Data aksara berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NamaAksara $namaAksara)
    {
        $namaAksara->delete();

        return redirect()->route('nama-aksara.index')
            ->with('success', 'Nama aksara  berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            $idsArray = explode(',', $ids);
            
            // Hapus data
            NamaAksara::whereIn('id', $idsArray)->delete();
            
            return redirect()->back()->with('success', 'Data terpilih berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
