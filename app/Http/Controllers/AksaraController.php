<?php

namespace App\Http\Controllers;

use App\Models\Aksara;
use App\Models\Wilayah;
use App\Models\NamaAksara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AksaraController extends Controller
{
    public function index(Request $request)
    {
        $query = Aksara::with('wilayah', 'namaAksara');

        // 🔍 Pencarian
        if ($request->filled('search')) {
            $query->whereHas('namaAksara', fn($q) => $q->where('nama_aksara', 'like', '%' . $request->search . '%'))
                ->orWhereHas('wilayah', fn($q) => $q->where('nama_wilayah', 'like', '%' . $request->search . '%'))
                ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // 🔽 Sorting
        $sortBy = $request->get('sort_by', 'deskripsi');
        $order = $request->get('order', 'asc');
        $allowedSorts = ['deskripsi', 'status', 'nama_wilayah'];

        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'nama_wilayah') {
                $query->join('wilayah', 'aksara.wilayah_id', '=', 'wilayah.id')
                    ->orderBy('wilayah.nama_wilayah', $order)
                    ->select('aksara.*');
            } else {
                $query->orderBy($sortBy, $order);
            }
        }

        $aksara = $query->get();
        return view('pages.admin.peta.aksara.index', compact('aksara', 'sortBy', 'order'));
    }

    public function create()
    {
        $wilayahList = Wilayah::all();
        $namaAksaraList = NamaAksara::all();
        return view('pages.admin.peta.aksara.create', compact('wilayahList', 'namaAksaraList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara_id' => 'required|exists:nama_aksara,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        Aksara::create($data);
        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil disimpan.');
    }

    public function edit($id)
    {
        $aksara = Aksara::findOrFail($id);
        $wilayahList = Wilayah::orderBy('nama_wilayah')->get();
        $namaAksaraList = NamaAksara::orderBy('nama_aksara')->get();
        return view('pages.admin.peta.aksara.edit', compact('aksara', 'wilayahList', 'namaAksaraList'));
    }

    public function update(Request $request, $id)
    {
        $aksara = Aksara::findOrFail($id);

        $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_aksara_id' => 'required|exists:nama_aksara,id',
            'alamat' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'koordinat' => 'required|string',
            'lokasi' => 'required|string',
        ]);

        $data = $request->only([
            'wilayah_id',
            'nama_aksara_id',
            'alamat',
            'status',
            'deskripsi',
            'koordinat',
            'lokasi',
        ]);

        if ($request->hasFile('dokumentasi')) {
            // Hapus file lama jika ada
            if ($aksara->dokumentasi && Storage::disk('public')->exists($aksara->dokumentasi)) {
                Storage::disk('public')->delete($aksara->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/aksara', 'public');
        }

        $aksara->update($data);
        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $aksara = Aksara::findOrFail($id);

        if ($aksara->dokumentasi && Storage::disk('public')->exists($aksara->dokumentasi)) {
            Storage::disk('public')->delete($aksara->dokumentasi);
        }

        $aksara->delete();
        return redirect()->route('aksara.index')->with('success', 'Data aksara berhasil dihapus.');
    }

    public function show($id)
    {
        $aksara = Aksara::findOrFail($id);
        return view('pages.admin.peta.aksara.show', compact('aksara'));
    }
}