<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    protected $table = 'bahasa';

    protected $fillable = [
        'wilayah_id',
        'nama_bahasa_id',
        'alamat',
        'status',
        'jumlah_penutur',
        'deskripsi',
        'koordinat',
    ];

    // Relasi: Bahasa milik satu NamaBahasa
    public function namaBahasa()
    {
        return $this->belongsTo(NamaBahasa::class, 'nama_bahasa_id');
    }

    // Relasi: Bahasa milik satu Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
