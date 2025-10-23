<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    protected $table = 'bahasa';
    protected $fillable = [
        'nama_bahasa',
        'wilayah_id',
        'status',
        'jumlah_penutur',
        'deskripsi',
        'koordinat',
        'alamat',
    ];

    // Relasi: Bahasa milik 1 Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
