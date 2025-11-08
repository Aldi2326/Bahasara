<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NamaSastraController extends Controller
{
    public function index()
    {
        return view('pages.admin.masterdata.namasastra.index');
    }

    public function create()
    {
        return view('pages.admin.masterdata.namasastra.create');
        
    }

    public function store()
    {
        
    }

    public function edit()
    {
        return view('pages.admin.masterdata.namasastra.edit');
    }

    public function update()
    {
        
    }
}
