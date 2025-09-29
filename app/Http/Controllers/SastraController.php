<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sastra;


class SastraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wilayahId = $request->query('wilayah_id'); // ambil dari query string
        $sastra = Sastra::where('wilayah_id', $wilayahId)->get();

        return view('pages.admin.peta.sastra.index', compact('wilayahId', 'sastra'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $wilayahId = $request->query('wilayah_id');
        return view('pages.admin.peta.sastra.create', compact('wilayahId'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        

        Sastra::create($request->all());

        return redirect()->route('sastra.index', ['wilayah_id' => $request->wilayah_id])
            ->with('success', 'Sastra berhasil ditambahkan.');
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
        $sastra = Sastra::findOrFail($id);
        return view('pages.admin.peta.sastra.edit', compact('sastra'));
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
