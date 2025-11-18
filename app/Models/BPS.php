<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BPS extends Model
{
    use HasFactory;
    protected $table = 'tbl_bps';
    protected $fillable = ['kategori','sub_kategori','diupload_oleh','judul','slug','link_api'];
}
