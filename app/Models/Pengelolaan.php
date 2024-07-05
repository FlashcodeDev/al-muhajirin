<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengelolaan extends Model
{
    use HasFactory;
    protected $table = 'pengelolaan';
    protected $fillable = [
        'judul',
        'url',
        'deskripsi'
    ];
}
