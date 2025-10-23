<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sastra extends Model
{
    protected $table = 'sastra';

    protected $fillable = [
        'nama_sastra',
        'alamat',
        'jenis',
        'deskripsi',
        'koordinat',
        'wilayah_id',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}

