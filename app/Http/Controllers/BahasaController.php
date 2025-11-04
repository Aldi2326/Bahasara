<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    public function index(Request $request)
{
    $query = Bahasa::with('wilayah')
        ->select('bahasa.*')
        ->join('wilayah', 'bahasa.wilayah_id', '=', 'wilayah.id');

    // 🔍 Pencarian (optional)
    if ($request->has('search') && $request->search != '') {
        $query->where('bahasa.deskripsi', 'like', '%' . $request->search . '%')
            ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%');
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

        // Kirim data ke view
        return view('pages.admin.peta.bahasa.create', compact('wilayahList'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_bahasa' => 'required|string|max:255',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer',
            'alamat' => 'required',
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

        return view('pages.admin.peta.bahasa.edit', compact('bahasa', 'wilayahList'));
    }

    /**
     * Update data bahasa yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahasa' => 'required|string|max:255',
            'wilayah_id' => 'required|exists:wilayah,id',
            'status' => 'required|string',
            'jumlah_penutur' => 'required|integer|min:0',
            'koordinat' => 'required|string',
            'alamat' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $bahasa = Bahasa::findOrFail($id);

        $bahasa->update([
            'nama_bahasa' => $request->nama_bahasa,
            'wilayah_id' => $request->wilayah_id,
            'status' => $request->status,
            'jumlah_penutur' => $request->jumlah_penutur,
            'koordinat' => $request->koordinat,
            'alamat' => $request->alamat,
            'deskripsi' => $request->deskripsi,
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
        // Ambil data dari tabel bahasas berdasarkan ID
        $bahasa = Bahasa::find($id);

        // Jika tidak ditemukan, tampilkan error 404
        if (!$bahasa) {
            abort(404, 'Data bahasa tidak ditemukan.');
        }

        // Kirim data ke view
        return view('pages.admin.peta.bahasa.show', compact('bahasa'));
    }
}
