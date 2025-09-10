<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kontaks = Kontak::all();
        return view('pages.kontak', compact('kontaks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subjek' => 'required',
            'pesan' => 'required',
        ]);

        Kontak::create($request->all());
        return redirect()->route('kontak.index')->with('success', 'Pesan berhasil dikirim!');
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
        //
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
