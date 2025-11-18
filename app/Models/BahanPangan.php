<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanPangan extends Model
{
    use HasFactory;
    protected $table = 'harga_eceran';
    protected $fillable = [
        'id_kabupaten_kota',
        'id_komoditas',
        'harga',
        'tanggal_survey',
    ];    
}
