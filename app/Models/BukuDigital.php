<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuDigital extends Model
{
    use HasFactory;
    protected $table = 'tbl_buku_digital';
    protected $fillable = ['id_users','id_sektor','judul','cover','url'];
}
