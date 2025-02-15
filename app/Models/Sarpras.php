<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpras extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan nama model
    protected $table = 'sarpras';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = ['nama', 'deskripsi', 'image'];
}
