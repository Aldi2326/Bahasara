<?php
namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Bahasa;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    public function index(Request $request)
    {
        $wilayahId = $request->query('wilayah_id'); // ambil dari query string
        $bahasa = Bahasa::where('wilayah_id', $wilayahId)->get();

        return view('pages.admin.peta.bahasa.index', compact('wilayahId', 'bahasa'));
    }

    public function create(Request $request)
    {
        $wilayahId = $request->query('wilayah_id');
        return view('pages.admin.peta.bahasa.create', compact('wilayahId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahasa' => 'required|string|max:255',
            'wilayah_id' => 'required|integer|exists:wilayah,id',
            'status' => 'required|string|max:255',
            'jumlah_penutur' => 'nullable|integer',
            'deskripsi' => 'required|string',
        ]);

        Bahasa::create($request->all());

        return redirect()->route('bahasa.index', ['wilayah_id' => $request->wilayah_id])
            ->with('success', 'Bahasa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bahasa = Bahasa::findOrFail($id);
        return view('pages.admin.peta.bahasa.edit', compact('bahasa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahasa' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'jumlah_penutur' => 'nullable|integer',
            'deskripsi' => 'required|string',
        ]);

        $bahasa = Bahasa::findOrFail($id);
        $bahasa->update($request->all());

        return redirect()->route('bahasa.index', ['wilayah_id' => $bahasa->wilayah_id])
            ->with('success', 'Data bahasa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bahasa = Bahasa::findOrFail($id);
        $wilayahId = $bahasa->wilayah_id;
        $bahasa->delete();

        return redirect()->route('bahasa.index', ['wilayah_id' => $wilayahId])
            ->with('success', 'Data bahasa berhasil dihapus.');
    }
}
