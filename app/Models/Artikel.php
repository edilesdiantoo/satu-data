<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 'tbl_artikel';
    protected $fillable = ['id_user','id_sektor','judul','gambar','slug','isi','status'];
}
