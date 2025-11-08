<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaSastra extends Model
{
    use HasFactory;
    protected $table = 'nama_sastra';
    protected $fillable = [
        'nama_sastra',
        'warna_pin',
    ];

    public function sastra()
    {
        return $this->hasMany(sastra::class, 'nama_sastra_id');
    }
}
