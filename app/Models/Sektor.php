<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory;
    protected $table = 'tbl_sektor';
    protected $fillable = ['id_main_sektor','nama_sektor','icon'];
}
