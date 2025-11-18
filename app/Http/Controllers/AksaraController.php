<?php

namespace App\Http\Controllers;

use App\Models\Aksara;
use App\Models\Wilayah;
use App\Models\NamaAksara;
use Illuminate\Http\Request;

class AksaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Aksara::with('wilayah', 'namaAksara')
            ->select('aksara.*')
            ->join('wilayah', 'aksara.wilayah_id', '=', 'wilayah.id');

        // 🔍 Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('namaAksara', function ($q) use ($request) {
                $q->where('nama_aksara', 'like', '%' . $request->search . '%');
            })
                ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%')
                ->orWhere('aksara.deskripsi', 'like', '%' . $request->search . '%');
        }

        // 🔽 Sorting
        $sortBy = $request->get('sort_by', 'deskripsi');
        $order = $request->get('order', 'asc');

        $allowedSorts = ['deskripsi', 'status', 'nama_wilayah'];
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $wilayahList = Wilayah::all();
        $namaAksaraList = NamaAksara::all();

        return view('pages.admin.peta.aksara.create', compact('wilayahList', 'namaAksaraList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara_id' => 'required|exists:nama_aksara,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        // Upload file dokumentasi jika ada
        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        Aksara::create($data);

        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil disimpan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $aksara = Aksara::findOrFail($id);
        $wilayahList = Wilayah::orderBy('nama_wilayah')->get();
        $namaAksaraList = NamaAksara::orderBy('nama_aksara')->get();

        return view('pages.admin.peta.aksara.edit', compact('aksara', 'wilayahList', 'namaAksaraList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara_id' => 'required|exists:nama_aksara,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        $aksara = Aksara::findOrFail($id);

        $data = $request->only([
            'wilayah_id',
            'nama_aksara_id',
            'alamat',
            'status',
            'deskripsi',
            'koordinat',
            'lokasi',
        ]);

        if ($request->hasFile(key: 'dokumentasi')) {
            if ($aksara->dokumentasi && \Storage::disk('public')->exists($aksara->dokumentasi)) {
                \Storage::disk('public')->delete($aksara->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        $aksara->update($data);

        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $aksara = Aksara::findOrFail($id);

        if ($aksara->dokumentasi && \Storage::disk('public')->exists($aksara->dokumentasi)) {
            \Storage::disk('public')->delete($aksara->dokumentasi);
        }

        $aksara->delete();

        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil dihapus.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $aksara = Aksara::find($id);

        if (!$aksara) {
            abort(404, 'Data aksara tidak ditemukan.');
        }

        return view('pages.admin.peta.aksara.show', compact('aksara'));
    }
}