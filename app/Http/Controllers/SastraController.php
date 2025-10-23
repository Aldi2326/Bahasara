<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sastra;
use App\Models\Wilayah;


class SastraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sastra::with('wilayah');

        // 🔍 Pencarian (optional)
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_sastra', 'like', '%' . $request->search . '%')
                ->orWhereHas('wilayah', function ($q) use ($request) {
                    $q->where('nama_wilayah', 'like', '%' . $request->search . '%');
                });
        }

        // 🔽 Sorting
        $sortBy = $request->get('sort_by', 'nama_sastra');
        $order = $request->get('order', 'asc');

        // Pastikan kolom yang boleh diurutkan
        $allowedSorts = ['id', 'jenis', 'jumlah_penutur'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $order);
        }

        // 🔄 Ambil data
        $sastra = $query->get();

        return view('pages.admin.peta.sastra.index', compact('sastra', 'sortBy', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wilayahList = Wilayah::all();
        return view('pages.admin.peta.sastra.create', compact('wilayahList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_sastra' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'jenis' => 'required|string',
        'deskripsi' => 'required|string',
        'koordinat' => 'required|string',
        'wilayah_id' => 'required|integer',
    ]);

    // Simpan data ke database
    Sastra::create([
        'nama_sastra' => $request->nama_sastra,
        'alamat' => $request->alamat,
        'jenis' => $request->jenis,
        'deskripsi' => $request->deskripsi,
        'koordinat' => $request->koordinat,
        'wilayah_id' => $request->wilayah_id,
    ]);

    return redirect()->route('sastra.index')->with('success', 'Data sastra berhasil disimpan!');
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
    public function edit($id)
    {
        $sastra = Sastra::findOrFail($id);
        return view('pages.admin.peta.sastra.edit', compact('sastra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sastra = Sastra::findOrFail($id);
        $sastra->update($request->all());

        return redirect()->route('sastra.index', ['wilayah_id' => $sastra->wilayah_id])
            ->with('success', 'Data sastra berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sastra = Sastra::findOrFail($id);
        $wilayahId = $sastra->wilayah_id;
        $sastra->delete();

        return redirect()->route('sastra.index', ['wilayah_id' => $wilayahId])
            ->with('success', 'Data sastra berhasil dihapus.');
    }
}
