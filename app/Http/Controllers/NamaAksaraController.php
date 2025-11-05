<?php

namespace App\Http\Controllers;

use App\Models\NamaAksara;
use Illuminate\Http\Request;

class NamaAksaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.masterdata.namaaksara.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.masterdata.namaaksara.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NamaAksara $namaAksara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('pages.admin.masterdata.namaaksara.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NamaAksara $namaAksara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NamaAksara $namaAksara)
    {
        //
    }
}
