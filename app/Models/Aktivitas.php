<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    use HasFactory;
    protected $table = 'tbl_aktivitas';
    protected $fillable = ['nama','id_user', 'pesan', 'status', 'role'];
}
