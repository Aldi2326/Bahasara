<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\Wilayah;
use App\Models\NamaBahasa;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    public function index(Request $request)
    {
        $query = Bahasa::with('wilayah', 'namaBahasa')
            ->select('bahasa.*')
            ->join('wilayah', 'bahasa.wilayah_id', '=', 'wilayah.id');

        // 🔍 Pencarian (optional)
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('namaBahasa', function ($q) use ($request) {
                $q->where('nama_bahasa', 'like', '%' . $request->search . '%');
            })
                ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%')
                ->orWhere('bahasa.deskripsi', 'like', '%' . $request->search . '%');
        }

        // 🔽 Sorting
        $sortBy = $request->get('sort_by', 'deskripsi');
        $order = $request->get('order', 'asc');

        $allowedSorts = ['deskripsi', 'status', 'nama_wilayah', 'jumlah_penutur'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'nama_wilayah') {
                $query->orderBy('wilayah.nama_wilayah', $order);
            } else {
                $query->orderBy('bahasa.' . $sortBy, $order);
            }
        }

        // 🔄 Ambil data
        $bahasa = $query->get();

        return view('pages.admin.peta.bahasa.index', compact('bahasa', 'sortBy', 'order'));
    }


    public function create()
    {
        // Ambil semua data wilayah
        $wilayahList = Wilayah::all();
        $namaBahasaList = NamaBahasa::all();

        // Kirim data ke view
        return view('pages.admin.peta.bahasa.create', compact('wilayahList', 'namaBahasaList'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_bahasa_id' => 'required|exists:nama_bahasa,id',
            'alamat' => 'required',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov',
            'koordinat' => 'required|string'
        ]);

        // Upload dokumentasi jika ada
        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/bahasa', 'public');
        }

        Bahasa::create($data);

        return redirect()->route('bahasa.index')->with('success', 'Data bahasa berhasil disimpan.');
    }

    public function edit($id)
    {
        $bahasa = Bahasa::findOrFail($id);
        $wilayahList = Wilayah::orderBy('nama_wilayah')->get();
        $namaBahasaList = NamaBahasa::orderBy('nama_bahasa')->get();

        return view('pages.admin.peta.bahasa.edit', compact('bahasa', 'wilayahList', 'namaBahasaList'));
    }

    /**
     * Update data bahasa yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_bahasa_id' => 'required|exists:nama_bahasa,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov',
            'koordinat' => 'required|string',
        ]);

        $bahasa = Bahasa::findOrFail($id);

        $data = $request->only([
            'wilayah_id',
            'nama_bahasa_id',
            'alamat',
            'status',
            'jumlah_penutur',
            'deskripsi',
            'koordinat'
        ]);

        if ($request->hasFile(key: 'dokumentasi')) {
            if ($bahasa->dokumentasi && \Storage::disk('public')->exists($bahasa->dokumentasi)) {
                \Storage::disk('public')->delete($bahasa->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/bahasa', 'public');
        }

        $bahasa->update($data);

        return redirect()->route('bahasa.index')->with('success', 'Data bahasa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bahasa = Bahasa::findOrFail($id);
        $bahasa->delete();

        return redirect()->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil dihapus.');
    }

    public function show($id)
    {
        $bahasa = Bahasa::with('namaBahasa')->findOrFail($id);
        return view('pages.admin.peta.bahasa.show', compact('bahasa'));
    }

}
