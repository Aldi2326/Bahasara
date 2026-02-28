<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
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
        $query = \App\Models\Wilayah::query();

        // Jika ada input pencarian, tambahkan filter berdasarkan nama_wilayah
        if ($search) {
            $query->where('nama_wilayah', 'LIKE', "%{$search}%");
        }

        // Urutkan data berdasarkan nama_wilayah
        $query->orderBy('nama_wilayah', $sortOrder);

        // Jalankan query dan ambil hasil
        $wilayah = $query->get();

        // Kirim data ke view
        return view('pages.admin.wilayah.index', compact('wilayah'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.wilayah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'file_geojson' => 'nullable|file|mimes:geojson,json|max:2048',
        ]);

        $data = [
            'nama_wilayah' => $request->nama_wilayah,
        ];

        if ($request->hasFile('file_geojson')) {
            // simpan ke public/wilayah
            $file = $request->file('file_geojson');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('wilayah'), $filename);

            // simpan path relatif ke database
            $data['file_geojson'] = 'wilayah/' . $filename;
        }

        Wilayah::create($data);

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('pages.admin.wilayah.edit', compact('wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $wilayah = Wilayah::findOrFail($id);

        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'file_geojson' => 'nullable|file|mimes:geojson,json|max:2048',
        ]);

        $data = [
            'nama_wilayah' => $request->nama_wilayah,
        ];

        if ($request->hasFile('file_geojson')) {
            // hapus file lama jika ada
            if ($wilayah->file_geojson && file_exists(public_path($wilayah->file_geojson))) {
                unlink(public_path($wilayah->file_geojson));
            }

            // simpan file baru
            $file = $request->file('file_geojson');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('wilayah'), $filename);

            $data['file_geojson'] = 'wilayah/' . $filename;
        }

        $wilayah->update($data);

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wilayah = Wilayah::findOrFail($id);

        // hapus file geojson jika ada
        if ($wilayah->file_geojson && file_exists(public_path($wilayah->file_geojson))) {
            unlink(public_path($wilayah->file_geojson));
        }

        $wilayah->delete();

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            $idsArray = explode(',', $ids);
            
            // Hapus data
            Wilayah::whereIn('id', $idsArray)->delete();
            
            return redirect()->back()->with('success', 'Data wilayah terpilih berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }

}
