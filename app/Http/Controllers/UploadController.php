<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads/froala', 'public');

            return response()->json([
                'link' => asset('storage/' . $path) // 🔗 URL gambar dikembalikan ke Froala
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
