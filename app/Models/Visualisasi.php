<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visualisasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_visualisasi';

    protected $fillable = ['judul', 'deskripsi', 'url', 'gambar', 'sektor', 'kategori'];
}
