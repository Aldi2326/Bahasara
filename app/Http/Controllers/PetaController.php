<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
{
    $wilayah = collect([
        (object)[
            'id' => 1,
            'nama_wilayah' => 'Kabupaten Bungo',
            'geojson' => 'Bungo.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1,
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 1200000,
                    'deskripsi' => 'Bahasa Melayu Jambi adalah bahasa sehari-hari masyarakat Jambi dan masih digunakan secara luas di Bungo.',
                ],
                (object)[
                    'id' => 2,
                    'nama_bahasa' => 'Bahasa Kubu',
                    'status' => 'Terancam Punah',
                    'jumlah_penutur' => 2500,
                    'deskripsi' => 'Bahasa Kubu dituturkan oleh masyarakat Suku Anak Dalam di Bungo.',
                ],
            ]
        ],
        (object)[
            'id' => 2,
            'nama_wilayah' => 'Kabupaten Merangin',
            'geojson' => 'Merangin.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1, // sama ID dengan Bungo
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 900000,
                    'deskripsi' => 'Bahasa Melayu Jambi juga digunakan di Merangin, meskipun penuturnya lebih sedikit.',
                ],
                (object)[
                    'id' => 3,
                    'nama_bahasa' => 'Bahasa Kerinci Dialek Sungai Tenang',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 80000,
                    'deskripsi' => 'Bahasa Kerinci dialek Sungai Tenang masih digunakan sehari-hari di sebagian wilayah Merangin.',
                ],
            ]
        ],
    ]);

    return view('pages.peta', compact('wilayah'));
}

public function sastra()
{
    $wilayah = collect([
        (object)[
            'id' => 1,
            'nama_wilayah' => 'Kabupaten Bungo',
            'geojson' => 'Bungo.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1,
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 1200000,
                    'deskripsi' => 'Bahasa Melayu Jambi adalah bahasa sehari-hari masyarakat Jambi dan masih digunakan secara luas di Bungo.',
                ],
                (object)[
                    'id' => 2,
                    'nama_bahasa' => 'Bahasa Kubu',
                    'status' => 'Terancam Punah',
                    'jumlah_penutur' => 2500,
                    'deskripsi' => 'Bahasa Kubu dituturkan oleh masyarakat Suku Anak Dalam di Bungo.',
                ],
            ]
        ],
        (object)[
            'id' => 2,
            'nama_wilayah' => 'Kabupaten Merangin',
            'geojson' => 'Merangin.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1, // sama ID dengan Bungo
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 900000,
                    'deskripsi' => 'Bahasa Melayu Jambi juga digunakan di Merangin, meskipun penuturnya lebih sedikit.',
                ],
                (object)[
                    'id' => 3,
                    'nama_bahasa' => 'Bahasa Kerinci Dialek Sungai Tenang',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 80000,
                    'deskripsi' => 'Bahasa Kerinci dialek Sungai Tenang masih digunakan sehari-hari di sebagian wilayah Merangin.',
                ],
            ]
        ],
    ]);

    return view('pages.sastra', compact('wilayah'));
}

public function aksara()
{
    $wilayah = collect([
        (object)[
            'id' => 1,
            'nama_wilayah' => 'Kabupaten Bungo',
            'geojson' => 'Bungo.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1,
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 1200000,
                    'deskripsi' => 'Bahasa Melayu Jambi adalah bahasa sehari-hari masyarakat Jambi dan masih digunakan secara luas di Bungo.',
                ],
                (object)[
                    'id' => 2,
                    'nama_bahasa' => 'Bahasa Kubu',
                    'status' => 'Terancam Punah',
                    'jumlah_penutur' => 2500,
                    'deskripsi' => 'Bahasa Kubu dituturkan oleh masyarakat Suku Anak Dalam di Bungo.',
                ],
            ]
        ],
        (object)[
            'id' => 2,
            'nama_wilayah' => 'Kabupaten Merangin',
            'geojson' => 'Merangin.geojson',
            'bahasa' => [
                (object)[
                    'id' => 1, // sama ID dengan Bungo
                    'nama_bahasa' => 'Bahasa Melayu Jambi',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 900000,
                    'deskripsi' => 'Bahasa Melayu Jambi juga digunakan di Merangin, meskipun penuturnya lebih sedikit.',
                ],
                (object)[
                    'id' => 3,
                    'nama_bahasa' => 'Bahasa Kerinci Dialek Sungai Tenang',
                    'status' => 'Aktif',
                    'jumlah_penutur' => 80000,
                    'deskripsi' => 'Bahasa Kerinci dialek Sungai Tenang masih digunakan sehari-hari di sebagian wilayah Merangin.',
                ],
            ]
        ],
    ]);

    return view('pages.aksara', compact('wilayah'));
}



    public function show($id)
    {
        $bahasa = collect([
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
                'nama_bahasa' => 'Bahasa Merangin',
                'status' => 'Terancam Punah',
                'jumlah_penutur' => 2500,
                'deskripsi' => 'Bahasa Merangin dituturkan oleh masyarakat Suku Anak Dalam. Penuturnya semakin sedikit karena terdesak modernisasi.',
                'geojson' => 'Merangin.geojson'
            ],
        ])->firstWhere('id', $id);

        if (!$bahasa) {
            abort(404, 'Data bahasa tidak ditemukan');
        }

        return view('pages.detail-bahasa', compact('bahasa'));
    }
}
