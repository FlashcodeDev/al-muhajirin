<?php

namespace App\Models;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriKeuangan extends Model
{
    use HasFactory;
    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'nama',
        'tipe',
    ];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }
}
