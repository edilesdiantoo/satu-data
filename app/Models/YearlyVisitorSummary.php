<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyVisitorSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'visitor_count',
    ];

    // Opsional: Jika nama tabel Anda berbeda dari konvensi Laravel
    // protected $table = 'yearly_visitor_summaries';
}
