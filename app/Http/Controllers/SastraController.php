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
    $query = Sastra::with('wilayah')
        ->select('sastra.*')
        ->join('wilayah', 'sastra.wilayah_id', '=', 'wilayah.id');

    // 🔍 Pencarian (opsional)
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('sastra.nama_sastra', 'like', '%' . $search . '%')
              ->orWhere('wilayah.nama_wilayah', 'like', '%' . $search . '%');
        });
    }

    // 🔽 Sorting
    $sortBy = $request->get('sort_by', 'nama_sastra');
    $order = $request->get('order', 'asc');

    $allowedSorts = ['id', 'nama_wilayah', 'jenis', 'nama_sastra'];
    if (in_array($sortBy, $allowedSorts)) {
        if ($sortBy === 'nama_wilayah') {
            $query->orderBy('wilayah.nama_wilayah', $order);
        } else {
            $query->orderBy('sastra.' . $sortBy, $order);
        }
    }

    $sastra = $query->get();

    return view('pages.admin.peta.sastra.index', compact('sastra', 'sortBy', 'order'));
}

public function petaSastra()
{
    // Ambil semua wilayah (beserta file geojson-nya)
    $wilayah = \App\Models\Wilayah::select('id', 'nama_wilayah', 'file_geojson')->get();

    // Ambil semua data sastra, pastikan koordinat dipisah jadi lat & lng
    $sastraList = \App\Models\Sastra::with('wilayah')
        ->get()
        ->map(function ($item) {
            if (!empty($item->koordinat)) {
                $koordinat = explode(',', $item->koordinat);
                $item->lat = (float) $koordinat[0];
                $item->lng = (float) $koordinat[1];
            } else {
                $item->lat = null;
                $item->lng = null;
            }
            return $item;
        });

    return view('pages.sastra', compact('wilayah', 'sastraList'));
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
    public function show($id)
    {
        // Ambil data dari tabel sastra berdasarkan ID
        $sastra = sastra::find($id);

        // Jika tidak ditemukan, tampilkan error 404
        if (!$sastra) {
            abort(404, 'Data sastra tidak ditemukan.');
        }

        // Kirim data ke view
        return view('pages.admin.peta.sastra.show', compact('sastra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sastra = Sastra::findOrFail($id);
        $wilayahList = Wilayah::all();
        return view('pages.admin.peta.sastra.edit', compact('sastra','wilayahList'));
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
