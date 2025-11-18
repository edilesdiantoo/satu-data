<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visits'; // Tabel yang digunakan

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url_visited',
        'referrer',
        'visit_date',
    ];

    // Tentukan kolom tanggal yang menggunakan Carbon
    protected $dates = ['visit_date']; 

    // Timestamps otomatis oleh Laravel (created_at, updated_at)
    public $timestamps = true;
}
