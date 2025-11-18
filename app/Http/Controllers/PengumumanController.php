<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function indexUser()
    {
        $pengumuman = Pengumuman::latest()->get();
        return view('pages.pengumuman.index', compact('pengumuman'));
    }

    // Halaman detail pengumuman untuk user
    public function showPengumumanUser($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.pengumuman.show', compact('pengumuman'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'tanggal');      // default: tanggal
        $sortDir = $request->input('sort_dir', 'desc');        // default: desc

        $pengumuman = Pengumuman::query()

            // Pencarian
            ->when($search, function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('isi', 'like', "%{$search}%");
            })

            // Sorting
            ->when($sortBy, function ($q) use ($sortBy, $sortDir) {

                // Pastikan hanya kolom yang diperbolehkan yang bisa di-sort
                $allowedSort = ['judul', 'tanggal', 'created_at'];

                if (in_array($sortBy, $allowedSort)) {
                    $q->orderBy($sortBy, $sortDir);
                }
            })

            ->get();

        return view('pages.admin.pengumuman.index', compact('pengumuman', 'search', 'sortBy', 'sortDir'));
    }


    public function create()
    {
        return view('pages.admin.pengumuman.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        $data = $request->only(['judul', 'tanggal', 'isi']);

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi/pengumuman', 'public');
        }

        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.admin.pengumuman.edit', compact('pengumuman'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi' => 'required|string',
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        $data = $request->only(['judul', 'tanggal', 'isi']);

        // Replace file jika upload baru
        if ($request->hasFile('dokumentasi')) {

            if ($pengumuman->dokumentasi && Storage::disk('public')->exists($pengumuman->dokumentasi)) {
                Storage::disk('public')->delete($pengumuman->dokumentasi);
            }

            $data['dokumentasi'] = $request->file('dokumentasi')
                ->store('dokumentasi/pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->dokumentasi && Storage::disk('public')->exists($pengumuman->dokumentasi)) {
            Storage::disk('public')->delete($pengumuman->dokumentasi);
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function show($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.admin.pengumuman.show', compact('pengumuman'));
    }
}