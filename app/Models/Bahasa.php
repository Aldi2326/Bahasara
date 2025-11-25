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
        'lokasi',
    ];

    /**
     * Setiap bahasa dimiliki oleh satu nama bahasa
     */
    public function namaBahasa()
    {
        return $this->belongsTo(NamaBahasa::class, 'nama_bahasa_id');
    }

    /**
     * Setiap bahasa berada pada satu wilayah
     */
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
