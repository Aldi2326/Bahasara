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
            'koordinat' => 'required|string'
        ]);

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
            'koordinat' => 'required|string',
        ]);

        $bahasa = Bahasa::findOrFail($id);

        $bahasa->update([
            'wilayah_id' => $request->wilayah_id,
            'nama_bahasa_id' => $request->nama_bahasa_id,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'jumlah_penutur' => $request->jumlah_penutur,
            'deskripsi' => $request->deskripsi,
            'koordinat' => $request->koordinat,
        ]);

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
