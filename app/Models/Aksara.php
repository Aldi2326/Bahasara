<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aksara extends Model
{
    protected $table = 'aksara';
    protected $fillable = [
        'wilayah_id',
        'nama_aksara_id',
        'alamat',
        'status',
        'deskripsi',
        'dokumentasi',
        'koordinat',
    ];

    public function namaAksara()
    {
        return $this->belongsTo(NamaAksara::class, 'nama_aksara_id');
    }

    // Relasi: Aksara milik 1 Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
