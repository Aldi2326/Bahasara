<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bahasa;
use App\Models\Aksara;
use App\Models\Sastra;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = ['nama_wilayah', 'file_geojson'];

    // Relasi: Wilayah punya banyak Bahasa
    public function bahasa()
    {
        return $this->hasMany(Bahasa::class, 'wilayah_id');
    }

    // Relasi: Wilayah punya banyak Aksara
    public function aksara()
    {
        return $this->hasMany(Aksara::class, 'wilayah_id');
    }

    // Relasi: Wilayah punya banyak Sastra
    public function sastra()
    {
        return $this->hasMany(Sastra::class, 'wilayah_id');
    }
}
