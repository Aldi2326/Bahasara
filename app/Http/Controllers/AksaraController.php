<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aksara;

class AksaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wilayahId = $request->query('wilayah_id'); // ambil dari query string
        $aksara = Aksara::where('wilayah_id', $wilayahId)->get();

        return view('pages.admin.peta.aksara.index', compact('wilayahId', 'aksara'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $wilayahId = $request->query('wilayah_id');
        return view('pages.admin.peta.aksara.create', compact('wilayahId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        Aksara::create($request->all());

        return redirect()->route('aksara.index', ['wilayah_id' => $request->wilayah_id])
            ->with('success', 'Aksara berhasil ditambahkan.');
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
        $aksara = Aksara::findOrFail($id);
        return view('pages.admin.peta.aksara.edit', compact('aksara'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_aksara' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'jumlah_penutur' => 'nullable|integer',
            'deskripsi' => 'required|string',
            
        ]);

        $aksara = Aksara::findOrFail($id);
        $aksara->update($request->all());

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
        $aksara->delete();

        return redirect()->route('aksara.index', ['wilayah_id' => $wilayahId])
            ->with('success', 'Data aksara berhasil dihapus.');
    }
}
