<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
{
    $bahasa = collect([
        // (object)[
        //     'id' => 1,
        //     'nama_bahasa' => 'Aksara Incung',
        //     'status' => 'Tidak Aktif',
        //     'jumlah_penutur' => 500,
        //     'deskripsi' => 'Aksara Incung digunakan di daerah Kerinci. Saat ini sudah jarang digunakan.',
        //     'geojson' => 'Jambi.geojson'
        // ],
        (object)[
            'id' => 2,
            'nama_bahasa' => 'Bahasa Melayu Jambi',
            'status' => 'Aktif',
            'jumlah_penutur' => 1200000,
            'deskripsi' => 'Bahasa Melayu Jambi adalah bahasa sehari-hari masyarakat Jambi dan masih digunakan secara luas.',
            'geojson' => 'Bungo.geojson'
        ],
        (object)[
            'id' => 3,
            'nama_bahasa' => 'Bahasa Kubu',
            'status' => 'Terancam Punah',
            'jumlah_penutur' => 2500,
            'deskripsi' => 'Bahasa Kubu dituturkan oleh masyarakat Suku Anak Dalam. Penuturnya semakin sedikit karena terdesak modernisasi.',
            'geojson' => 'kubu.geojson'
        ],
    ]);

    return view('pages.peta', compact('bahasa'));
}

}
