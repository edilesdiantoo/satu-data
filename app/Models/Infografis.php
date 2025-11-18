<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    use HasFactory;
    protected $table = 'tbl_infografis';
    protected $fillable = ['id_user','id_sektor','judul','gambar','status'];
}
