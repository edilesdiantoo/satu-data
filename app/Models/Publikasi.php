<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_publikasi';

    protected $fillable = ['id_user', 'id_sektor', 'cover', 'judul', 'deskripsi', 'file', 'status'];
}
