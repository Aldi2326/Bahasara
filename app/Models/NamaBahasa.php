<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NamaBahasa extends Model
{
    use HasFactory;
    protected $table = 'nama_bahasa';
    protected $fillable = [
        'nama_bahasa',
        'warna_pin',
    ];

    // Relasi: Satu NamaBahasa memiliki banyak Bahasa
    public function bahasa()
    {
        return $this->hasMany(Bahasa::class, 'nama_bahasa_id');
    }
}
