<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sastra extends Model
{
    protected $table = 'sastra';
    protected $fillable = ['nama_sastra', 'wilayah_id','jenis','deskripsi','koordinat'];

    // Relasi: Sastra milik 1 Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
