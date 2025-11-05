<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaAksara extends Model
{
    use HasFactory;
    protected $table = 'nama_aksara';
    protected $fillable = [
        'nama_aksara',
        'warna_pin',
    ];

    public function aksara()
    {
        return $this->hasMany(Aksara::class, 'nama_aksara_id');
    }
}
