<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\Wilayah;
use App\Models\NamaBahasa;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    // =========================================================
    //  Tampilkan data bahasa
    // =========================================================
    public function index(Request $request)
    {
        $query = Bahasa::with('wilayah', 'namaBahasa')
            ->join('wilayah', 'bahasa.wilayah_id', '=', 'wilayah.id')
            ->select('bahasa.*');

        // Pencarian
        if ($request->filled('search')) {
            $query->whereHas('namaBahasa', function ($q) use ($request) {
                $q->where('nama_bahasa', 'like', '%' . $request->search . '%');
            })
                ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%')
                ->orWhere('bahasa.deskripsi', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_wilayah');
        $order = $request->get('order', 'asc');

        if ($sortBy === 'nama_wilayah') {
            $query->orderBy('wilayah.nama_wilayah', $order);
        }

        $bahasa = $query->get();

        return view('pages.admin.peta.bahasa.index', compact('bahasa', 'sortBy', 'order'));
    }

    // =========================================================
    //  Tampilkan form tambah
    // =========================================================
    public function create()
    {
        return view('pages.admin.peta.bahasa.create', [
            'wilayahList' => Wilayah::orderBy('nama_wilayah')->get(),
            'namaBahasaList' => NamaBahasa::orderBy('nama_bahasa')->get(),
        ]);
    }

    // =========================================================
    //  Simpan data baru
    // =========================================================
    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_bahasa_id' => 'required|exists:nama_bahasa,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer',
            'deskripsi' => 'required|string',
            'dokumentasi_yt' => 'nullable|string',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        Bahasa::create($data);

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil disimpan.');
    }

    // =========================================================
    //  Tampilkan form edit
    // =========================================================
    public function edit($id)
    {
        return view('pages.admin.peta.bahasa.edit', [
            'bahasa' => Bahasa::findOrFail($id),
            'wilayahList' => Wilayah::orderBy('nama_wilayah')->get(),
            'namaBahasaList' => NamaBahasa::orderBy('nama_bahasa')->get(),
        ]);
    }

    // =========================================================
    //  Update data
    // =========================================================
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_bahasa_id' => 'required|exists:nama_bahasa,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'dokumentasi_yt' => 'nullable|string',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        Bahasa::findOrFail($id)->update($data);

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil diperbarui.');
    }

    // =========================================================
    //  Hapus data
    // =========================================================
    public function destroy($id)
    {
        Bahasa::findOrFail($id)->delete();

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil dihapus.');
    }

    // =========================================================
    //  Detail data
    // =========================================================
    public function show($id)
    {
        return view('pages.admin.peta.bahasa.show', [
            'bahasa' => Bahasa::with('namaBahasa')->findOrFail($id)
        ]);
    }
}