<?php

namespace App\Http\Controllers;

use App\Models\Sastra;
use App\Models\Wilayah;
use App\Models\NamaSastra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SastraController extends Controller
{
    public function index(Request $request)
    {
        $query = Sastra::with('wilayah', 'namaSastra')
            ->select('sastra.*')
            ->join('wilayah', 'sastra.wilayah_id', '=', 'wilayah.id');

        // 🔍 Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('namaSastra', function ($q) use ($request) {
                $q->where('nama_sastra', 'like', '%' . $request->search . '%');
            })
                ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%')
                ->orWhere('sastra.deskripsi', 'like', '%' . $request->search . '%');
        }

        // 🔽 Sorting
        $sortBy = $request->get('sort_by', 'deskripsi');
        $order = $request->get('order', 'asc');
        $allowedSorts = ['deskripsi', 'status', 'nama_wilayah', 'jumlah_penutur'];

        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'nama_wilayah') {
                $query->orderBy('wilayah.nama_wilayah', $order);
            } else {
                $query->orderBy('sastra.' . $sortBy, $order);
            }
        }

        $sastra = $query->get();

        return view('pages.admin.peta.sastra.index', compact('sastra', 'sortBy', 'order'));
    }

    public function create()
    {
        $wilayahList = Wilayah::all();
        $namaSastraList = NamaSastra::all();
        return view('pages.admin.peta.sastra.create', compact('wilayahList', 'namaSastraList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_sastra_id' => 'required|exists:nama_sastra,id',
            'alamat' => 'required|string',
            'jenis' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
            'koordinat' => 'required|string',
        ]);

        // Upload dokumentasi jika ada
        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/sastra', 'public');
        }

        Sastra::create($data);

        return redirect()->route('sastra.index')->with('success', 'Data sastra berhasil disimpan.');
    }

    public function edit($id)
    {
        $sastra = Sastra::findOrFail($id);
        $wilayahList = Wilayah::orderBy('nama_wilayah')->get();
        $namaSastraList = NamaSastra::orderBy('nama_sastra')->get();

        return view('pages.admin.peta.sastra.edit', compact('sastra', 'wilayahList', 'namaSastraList'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'wilayah_id' => 'required|exists:wilayah,id',
            'nama_sastra_id' => 'required|exists:nama_sastra,id',
            'alamat' => 'required|string',
            'jenis' => 'required|string',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
            'koordinat' => 'required|string',
        ]);

        $sastra = Sastra::findOrFail($id);

        $data = $request->only([
            'wilayah_id',
            'nama_sastra_id',
            'alamat',
            'status',
            'deskripsi',
            'koordinat'
        ]);

        if ($request->hasFile(key: 'dokumentasi')) {
            if ($sastra->dokumentasi && \Storage::disk('public')->exists($sastra->dokumentasi)) {
                \Storage::disk('public')->delete($sastra->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/sastra', 'public');
        }

        $sastra->update($data);

        return redirect()->route('sastra.index')->with('success', 'Data sastra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sastra = Sastra::findOrFail($id);

        // Hapus file dokumentasi jika ada
        if ($sastra->dokumentasi && Storage::disk('public')->exists($sastra->dokumentasi)) {
            Storage::disk('public')->delete($sastra->dokumentasi);
        }

        $sastra->delete();

        return redirect()->route('sastra.index')->with('success', 'Data sastra berhasil dihapus.');
    }

    public function show($id)
    {
        $sastra = Sastra::with('namaSastra')->findOrFail($id);
        return view('pages.admin.peta.sastra.show', compact('sastra'));
    }
}
