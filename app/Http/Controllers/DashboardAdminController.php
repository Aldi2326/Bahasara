<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardAdminController extends Controller
{
    /**
     * Tampilkan dashboard dengan jumlah entitas.
     */
    public function index()
    {
        // Daftar item yang ingin dihitung.
        // Key = label yang dipakai di view. Value = model class atau table name (pilihan).
        $items = [
            'bahasa' => ['model' => \App\Models\Bahasa::class, 'tables' => ['bahasas', 'bahasa']],
            'wilayah' => ['model' => \App\Models\Wilayah::class, 'tables' => ['wilayahs', 'wilayah', 'regions', 'region']],
            'aksara' => ['model' => \App\Models\Aksara::class, 'tables' => ['aksaras', 'aksara']],
            // contoh "jumlah lain" — kamu bisa tambahkan/ubah sesuai nama model atau nama tabel di DB
            'sastra' => ['model' => \App\Models\Sastra::class, 'tables' => ['sastra', 'sastras']],
            // tambahkan entri lain bila perlu
        ];

        $counts = [];

        foreach ($items as $key => $meta) {
            $count = 0;

            // 1) Coba pakai Model (jika kelas model ada)
            if (isset($meta['model']) && class_exists($meta['model'])) {
                try {
                    $count = $meta['model']::count();
                } catch (\Throwable $e) {
                    // kalau model ada tapi error (mis. koneksi), coba fallback ke table
                    $count = 0;
                }
            }

            // 2) Jika belum berhasil (atau model tidak ada), coba pakai nama tabel yang umum
            if ($count === 0 && !empty($meta['tables'])) {
                foreach ($meta['tables'] as $table) {
                    if (Schema::hasTable($table)) {
                        try {
                            $count = DB::table($table)->count();
                            break;
                        } catch (\Throwable $e) {
                            $count = 0;
                        }
                    }
                }
            }

            // 3) Jika masih 0 tetapi mungkin memang 0, simpan nilainya
            $counts[$key] = $count;
        }

        // Kirim ke view (atau bisa juga return JSON untuk API)
        return view('pages.admin.dashboard.index', compact('counts'));
    }
}
