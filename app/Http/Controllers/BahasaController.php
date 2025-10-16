<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\Wilayah;
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
        // Ambil semua data wilayah dari database
        $wilayahList = Wilayah::select('id', 'nama_wilayah')->get();
        return view('pages.admin.peta.bahasa.create', compact('wilayahId', 'wilayahList'));
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

    public function show($id)
{
    $bahasaList = [
        ['nama_bahasa' => 'Bahasa Jambi', 'status' => 'aktif', 'jumlah_penutur' => 50000, 'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates consequuntur consectetur voluptas consequatur excepturi nisi sapiente amet odio maxime cumque exercitationem itaque nihil neque, culpa dignissimos a laboriosam repellendus blanditiis minus sunt aspernatur. Adipisci reiciendis molestias aspernatur, delectus expedita animi quis illum voluptas ipsum totam, voluptatem libero quibusdam quasi dolores autem inventore architecto dolor! Fugiat voluptatem eaque corporis optio, saepe deleniti quis dolorem deserunt iure tempora necessitatibus similique qui adipisci aut officiis aliquid possimus quos consequuntur architecto omnis commodi quam voluptatum enim? Beatae et animi debitis nam dicta. Vero quas cum illum quibusdam iste consequuntur quod eos alias voluptas dolore. Bahasa daerah yang digunakan di Kota Jambi.'],
        ['nama_bahasa' => 'Bahasa Kerinci', 'status' => 'aktif', 'jumlah_penutur' => 75000, 'deskripsi' => 'Bahasa yang digunakan oleh masyarakat Kerinci.'],
        ['nama_bahasa' => 'Bahasa Melayu', 'status' => 'aktif', 'jumlah_penutur' => 120000, 'deskripsi' => 'Bahasa dengan penutur tersebar di berbagai daerah.'],
        ['nama_bahasa' => 'Bahasa Batin', 'status' => 'tidak aktif', 'jumlah_penutur' => 8000, 'deskripsi' => 'Bahasa minoritas di daerah Sarolangun.'],
        ['nama_bahasa' => 'Bahasa Bajau', 'status' => 'aktif', 'jumlah_penutur' => 16000, 'deskripsi' => 'Bahasa masyarakat pesisir dan nelayan.'],
        ['nama_bahasa' => 'Bahasa Kubu', 'status' => 'tidak aktif', 'jumlah_penutur' => 5000, 'deskripsi' => 'Bahasa suku Anak Dalam (Kubu).'],
        ['nama_bahasa' => 'Bahasa Rantau Panjang', 'status' => 'aktif', 'jumlah_penutur' => 21000, 'deskripsi' => 'Bahasa lokal yang digunakan di Rantau Panjang.'],
        ['nama_bahasa' => 'Bahasa Penghulu', 'status' => 'aktif', 'jumlah_penutur' => 15000, 'deskripsi' => 'Bahasa komunitas kecil di wilayah barat Jambi.'],
        ['nama_bahasa' => 'Bahasa Bangko', 'status' => 'aktif', 'jumlah_penutur' => 27000, 'deskripsi' => 'Bahasa dari daerah Bangko dan sekitarnya.'],
        ['nama_bahasa' => 'Bahasa Tungkal', 'status' => 'aktif', 'jumlah_penutur' => 45000, 'deskripsi' => 'Bahasa yang digunakan di Kuala Tungkal dan sekitarnya.'],
    ];

    if (!isset($bahasaList[$id])) {
        abort(404, 'Data bahasa tidak ditemukan.');
    }

    $bahasa = $bahasaList[$id];
    return view('pages.admin.peta.bahasa.show', compact('bahasa'));
}

}
