<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDataset extends Model
{
    use HasFactory;

    /**
     * Secara eksplisit tentukan nama tabel.
     *
     * @var string
     */
    protected $table = 'tbl_agenda_datasets';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Pastikan semua kolom non-timestamp (kecuali PK 'id') ada di sini.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'datasets_id', 'tanggal', 'bulan', 'tahun', 'judul_rilis',
        'deskripsi', 'metadata', 'db_datasets', 'status',
    ];

    // Karena Primary Key Anda adalah 'id' (default Laravel),
    // Anda tidak perlu mendefinisikan $primaryKey di sini.
}
