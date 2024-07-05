<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Kegiatan extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'kegiatan';
    protected $fillable = [
        'nama_kegiatan',
        'gambar',
        'tanggal',
        'waktu',
        'deskripsi',
        'status'
    ];
}
