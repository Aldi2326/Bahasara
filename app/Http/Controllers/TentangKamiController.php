<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TentangKamiController extends Controller
{
    public function index()
    {
        $counts = [
            'bahasa' => \App\Models\Bahasa::count(),
            'sastra' => \App\Models\Sastra::count(),
            'aksara' => \App\Models\Aksara::count(),
        ];

        return view('pages.tentang-kami', compact('counts'));
    }
}
