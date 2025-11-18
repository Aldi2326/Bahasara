<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sastra extends Model
{
    protected $table = 'sastra';

    protected $fillable = [
        'wilayah_id',
        'nama_sastra_id',
        'alamat',
        'jenis',
        'deskripsi',
        'dokumentasi',
        'koordinat',
        'lokasi',
    ];

    public function namaSastra()
    {
        return $this->belongsTo(NamaSastra::class, 'nama_sastra_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}

