<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aksara extends Model
{
    protected $table = 'aksara';
    protected $fillable = ['nama_aksara', 'jumlah_penutur', 'wilayah_id','status','deskripsi'];

    // Relasi: Aksara milik 1 Wilayah
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
}
