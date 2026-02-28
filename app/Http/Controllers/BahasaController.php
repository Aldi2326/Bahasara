<?php

namespace App\Http\Controllers;

use App\Models\Bahasa;
use App\Models\Wilayah;
use App\Models\NamaBahasa;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    // =========================================================
    //  Tampilkan data bahasa
    // =========================================================
    public function index(Request $request)
    {
        $query = Bahasa::with('wilayah', 'namaBahasa')
            ->join('wilayah', 'bahasa.wilayah_id', '=', 'wilayah.id')
            ->select('bahasa.*');

        // Pencarian
        if ($request->filled('search')) {
            $query->whereHas('namaBahasa', function ($q) use ($request) {
                $q->where('nama_bahasa', 'like', '%' . $request->search . '%');
            })
                ->orWhere('wilayah.nama_wilayah', 'like', '%' . $request->search . '%')
                ->orWhere('bahasa.deskripsi', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama_wilayah');
        $order = $request->get('order', 'asc');

        if ($sortBy === 'nama_wilayah') {
            $query->orderBy('wilayah.nama_wilayah', $order);
        }

        $bahasa = $query->get();

        return view('pages.admin.peta.bahasa.index', compact('bahasa', 'sortBy', 'order'));
    }

    // =========================================================
    //  Tampilkan form tambah
    // =========================================================
    public function create()
    {
        return view('pages.admin.peta.bahasa.create', [
            'wilayahList' => Wilayah::orderBy('nama_wilayah')->get(),
            'namaBahasaList' => NamaBahasa::orderBy('nama_bahasa')->get(),
        ]);
    }

    // =========================================================
    //  Simpan data baru
    // =========================================================
    public function store(Request $request)
    {
        $data = $request->validate([
            // ID (Foreign Key): Pastikan integer dan positif
            'wilayah_id' => 'required|integer|exists:wilayah,id',
            'nama_bahasa_id' => 'required|integer|exists:nama_bahasa,id',

            // String Pendek (VARCHAR 255)
            'alamat' => 'required|string|max:255',
            'status' => 'required|string|max:50', // Status biasanya pendek (misal: "Aktif", "Punah")
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
            'lokasi' => 'required|string|max:255',

            // Integer (Jumlah)
            // max:2147483647 adalah batas tipe data INT di MySQL, tapi min:0 lebih penting.
            'jumlah_penutur' => 'required|numeric|min:0|max:2147483647', 

            // Text Panjang (TEXT)
            // Tipe data TEXT di MySQL max 65,535 karakter. 
            // Saya set 5000 agar aman dan performa terjaga.
            'deskripsi' => 'required|string|max:65535', 

            // URL / Link
            'dokumentasi_yt' => 'nullable|url|max:255',
        ]);

        Bahasa::create($data);

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil disimpan.');
    }

    // =========================================================
    //  Tampilkan form edit
    // =========================================================
    public function edit($id)
    {
        return view('pages.admin.peta.bahasa.edit', [
            'bahasa' => Bahasa::findOrFail($id),
            'wilayahList' => Wilayah::orderBy('nama_wilayah')->get(),
            'namaBahasaList' => NamaBahasa::orderBy('nama_bahasa')->get(),
        ]);
    }

    // =========================================================
    //  Update data
    // =========================================================
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            // ID (Foreign Key): Pastikan integer dan positif
            'wilayah_id' => 'required|integer|exists:wilayah,id',
            'nama_bahasa_id' => 'required|integer|exists:nama_bahasa,id',

            // String Pendek (VARCHAR 255)
            'alamat' => 'required|string|max:255',
            'status' => 'required|string|max:50', // Status biasanya pendek (misal: "Aktif", "Punah")
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
            'lokasi' => 'required|string|max:255',

            // Integer (Jumlah)
            // max:2147483647 adalah batas tipe data INT di MySQL, tapi min:0 lebih penting.
            'jumlah_penutur' => 'required|numeric|min:0|max:2147483647', 

            // Text Panjang (TEXT)
            // Tipe data TEXT di MySQL max 65,535 karakter. 
            // Saya set 5000 agar aman dan performa terjaga.
            'deskripsi' => 'required|string|max:65535', 

            // URL / Link
            'dokumentasi_yt' => 'nullable|url|max:255',
        ]);

        Bahasa::findOrFail($id)->update($data);

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil diperbarui.');
    }

    // =========================================================
    //  Hapus data
    // =========================================================
    public function destroy($id)
    {
        Bahasa::findOrFail($id)->delete();

        return redirect()
            ->route('bahasa.index')
            ->with('success', 'Data bahasa berhasil dihapus.');
    }

    // =========================================================
    //  Detail data
    // =========================================================
    public function show($id)
    {
        return view('pages.admin.peta.bahasa.show', [
            'bahasa' => Bahasa::with('namaBahasa')->findOrFail($id)
        ]);
    }
    
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            // Convert string "1,2,3" menjadi array [1, 2, 3]
            $idsArray = explode(',', $ids);
            
            // Hapus data berdasarkan array ID
            Bahasa::whereIn('id', $idsArray)->delete();
            
            return redirect()->back()->with('success', 'Data terpilih berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}