<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalJumat extends Model
{
    use HasFactory;
    protected $table = 'jadwal_jumat';
    protected $fillable = [
        'nama_khotib',
        'tanggal'
    ];
}
