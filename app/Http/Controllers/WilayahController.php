<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayah = Wilayah::all();
        return view('pages.admin.wilayah.index', compact('wilayah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.wilayah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required|string|max:255',
            'file_geojson' => 'nullable|file|mimes:geojson,json',
        ]);

        $data = [
            'nama_wilayah' => $request->nama_wilayah,
        ];

        if ($request->hasFile('file_geojson')) {
            // simpan ke public/wilayah
            $file = $request->file('file_geojson');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('wilayah'), $filename);

            // simpan path relatif ke database
            $data['file_geojson'] = 'wilayah/' . $filename;
        }

        Wilayah::create($data);

        return redirect()->route('wilayah.index')
            ->with('success', 'Wilayah berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('pages.admin.wilayah.edit', compact('wilayah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
