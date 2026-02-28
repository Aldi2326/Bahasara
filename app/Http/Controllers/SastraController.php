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
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'dokumentasi_yt' => 'nullable|url',
            'koordinat' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    // 1. Cek apakah ada koma
                    if (!str_contains($value, ',')) {
                        $fail('Format koordinat salah. Harus dipisah dengan koma (contoh: -6.2088, 106.8456).');
                        return;
                    }

                    // 2. Pecah string menjadi array
                    $parts = explode(',', $value);
                    
                    // 3. Pastikan ada 2 bagian (Lat dan Long)
                    if (count($parts) !== 2) {
                        $fail('Koordinat harus terdiri dari Latitude dan Longitude.');
                        return;
                    }

                    $lat = trim($parts[0]);
                    $lng = trim($parts[1]);

                    // 4. Cek apakah keduanya angka valid
                    if (!is_numeric($lat) || !is_numeric($lng)) {
                        $fail('Koordinat harus berupa angka.');
                        return;
                    }

                    // 5. Validasi Range Latitude (-90 sampai 90)
                    if ($lat < -90 || $lat > 90) {
                        $fail('Latitude tidak valid (harus antara -90 sampai 90).');
                    }

                    // 6. Validasi Range Longitude (-180 sampai 180)
                    if ($lng < -180 || $lng > 180) {
                        $fail('Longitude tidak valid (harus antara -180 sampai 180).');
                    }
                },
            ],
            'lokasi' => 'required|string',
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
            'dokumentasi' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'dokumentasi_yt' => 'nullable|url',
            'koordinat' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    // 1. Cek apakah ada koma
                    if (!str_contains($value, ',')) {
                        $fail('Format koordinat salah. Harus dipisah dengan koma (contoh: -6.2088, 106.8456).');
                        return;
                    }

                    // 2. Pecah string menjadi array
                    $parts = explode(',', $value);
                    
                    // 3. Pastikan ada 2 bagian (Lat dan Long)
                    if (count($parts) !== 2) {
                        $fail('Koordinat harus terdiri dari Latitude dan Longitude.');
                        return;
                    }

                    $lat = trim($parts[0]);
                    $lng = trim($parts[1]);

                    // 4. Cek apakah keduanya angka valid
                    if (!is_numeric($lat) || !is_numeric($lng)) {
                        $fail('Koordinat harus berupa angka.');
                        return;
                    }

                    // 5. Validasi Range Latitude (-90 sampai 90)
                    if ($lat < -90 || $lat > 90) {
                        $fail('Latitude tidak valid (harus antara -90 sampai 90).');
                    }

                    // 6. Validasi Range Longitude (-180 sampai 180)
                    if ($lng < -180 || $lng > 180) {
                        $fail('Longitude tidak valid (harus antara -180 sampai 180).');
                    }
                },
            ],
            'lokasi' => 'required|string',
        ]);

        $sastra = Sastra::findOrFail($id);

        $data = $request->only([
            'wilayah_id',
            'nama_sastra_id',
            'alamat',
            'status',
            'deskripsi',
            'dokumentasi',
            'dokumentasi_yt',
            'koordinat' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) {
                    // 1. Cek apakah ada koma
                    if (!str_contains($value, ',')) {
                        $fail('Format koordinat salah. Harus dipisah dengan koma (contoh: -6.2088, 106.8456).');
                        return;
                    }

                    // 2. Pecah string menjadi array
                    $parts = explode(',', $value);
                    
                    // 3. Pastikan ada 2 bagian (Lat dan Long)
                    if (count($parts) !== 2) {
                        $fail('Koordinat harus terdiri dari Latitude dan Longitude.');
                        return;
                    }

                    $lat = trim($parts[0]);
                    $lng = trim($parts[1]);

                    // 4. Cek apakah keduanya angka valid
                    if (!is_numeric($lat) || !is_numeric($lng)) {
                        $fail('Koordinat harus berupa angka.');
                        return;
                    }

                    // 5. Validasi Range Latitude (-90 sampai 90)
                    if ($lat < -90 || $lat > 90) {
                        $fail('Latitude tidak valid (harus antara -90 sampai 90).');
                    }

                    // 6. Validasi Range Longitude (-180 sampai 180)
                    if ($lng < -180 || $lng > 180) {
                        $fail('Longitude tidak valid (harus antara -180 sampai 180).');
                    }
                },
            ],
            'lokasi',
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
    
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            $idsArray = explode(',', $ids);
            
            // Hapus data (jika ada file gambar/video, sebaiknya dihapus juga di sini menggunakan loop)
            Sastra::whereIn('id', $idsArray)->delete();
            
            return redirect()->back()->with('success', 'Data sastra terpilih berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
