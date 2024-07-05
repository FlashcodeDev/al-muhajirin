<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $fillable = [
        'tanggal',
        'tipe',
        'jumlah',
        'deksripsi',
        'kategori_id'
    ];


    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }

    public function getPlainDeskripsiAttribute()
    {
        return strip_tags($this->attributes['deskripsi']);
    }

    public function getKategoriNamaAttribute()
    {
        return $this->kategori ? $this->kategori->nama : 'Tidak ada';
    }
}
