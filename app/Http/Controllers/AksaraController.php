<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aksara;
use App\Models\Wilayah;

class AksaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Aksara::with('wilayah')
        ->select('aksara.*', 'wilayah.nama_wilayah') // tambahkan nama_wilayah biar bisa ditampilkan
        ->join('wilayah', 'aksara.wilayah_id', '=', 'wilayah.id');

    // 🔍 Pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where(function ($q) use ($request) {
            $q->where('aksara.nama_aksara', 'like', '%' . $request->search . '%')
              ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%');
        });
    }

    // 🔽 Sorting
    $sortBy = $request->get('sort_by', 'nama_aksara');
    $order = $request->get('order', 'asc');

    // Kolom yang boleh diurutkan
    $allowedSorts = ['nama_aksara', 'status', 'nama_wilayah'];

    if (in_array($sortBy, $allowedSorts)) {
        if ($sortBy === 'nama_wilayah') {
            $query->orderBy('wilayah.nama_wilayah', $order);
        } else {
            $query->orderBy('aksara.' . $sortBy, $order);
        }
    }

    // 🔄 Ambil data
    $aksara = $query->get();

    return view('pages.admin.peta.aksara.index', compact('aksara', 'sortBy', 'order'));
}

public function petaAksara()
{
    // Ambil semua wilayah (beserta file geojson-nya)
    $wilayah = \App\Models\Wilayah::select('id', 'nama_wilayah', 'file_geojson')->get();

    // Ambil semua data akasara, pastikan koordinat dipisah jadi lat & lng
    $aksaraList = \App\Models\Aksara::with('wilayah')
        ->get()
        ->map(function ($item): Aksara {
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

    return view('pages.aksara', compact('wilayah', 'aksaraList'));
}

    public function show($id)
    {
        // Ambil data dari tabel akasara berdasarkan ID
        $aksara = Aksara::find($id);

        // Jika tidak ditemukan, tampilkan error 404
        if (!$aksara) {
            abort(404, 'Data aksara tidak ditemukan.');
        }

        // Kirim data ke view
        return view('pages.admin.peta.aksara.show', compact('aksara'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wilayahList = Wilayah::all();
        return view('pages.admin.peta.aksara.create', compact('wilayahList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara' => 'required|string|max:255',
            'status' => 'required|string',
            'deskripsi' => 'required|string',
            'koordinat' => 'required|string|max:255',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480', // max 20MB
        ]);

        $filePath = null;
        if ($request->hasFile('dokumentasi')) {
            $filePath = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        Aksara::create([
            'wilayah_id' => $request->wilayah_id,
            'nama_aksara' => $request->nama_aksara,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'koordinat' => $request->koordinat,
            'dokumentasi' => $filePath,
        ]);

        return redirect()->route('aksara.index')
            ->with('success', 'Data aksara berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aksara = Aksara::findOrFail($id);
        $wilayahList = Wilayah::all();
        return view('pages.admin.peta.aksara.edit', compact('aksara', 'wilayahList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'koordinat' => 'required|string|max:255',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
        ]);

        $aksara = Aksara::findOrFail($id);

        $filePath = $aksara->dokumentasi;
        if ($request->hasFile('dokumentasi')) {
            // Hapus file lama jika ada
            if ($filePath && \Storage::disk('public')->exists($filePath)) {
                \Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        $aksara->update([
            'wilayah_id' => $request->wilayah_id,
            'nama_aksara' => $request->nama_aksara,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'koordinat' => $request->koordinat,
            'dokumentasi' => $filePath,
        ]);

        return redirect()->route('aksara.index', ['wilayah_id' => $aksara->wilayah_id])
            ->with('success', 'Data aksara berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aksara = Aksara::findOrFail($id);
        $wilayahId = $aksara->wilayah_id;

        if ($aksara->dokumentasi && \Storage::disk('public')->exists($aksara->dokumentasi)) {
            \Storage::disk('public')->delete($aksara->dokumentasi);
        }

        $aksara->delete();

        return redirect()->route('aksara.index', ['wilayah_id' => $wilayahId])
            ->with('success', 'Data aksara berhasil dihapus.');
    }
}