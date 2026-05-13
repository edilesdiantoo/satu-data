<?php

namespace App\Models;

use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datasets extends Model
{
    use HasFactory;
    use HasUuids;
    use HasVisits;

    // use \Conner\Tagging\Taggable;

    protected $table = 'tbl_datasets';

    protected $fillable = ['judul', 'nama_opd', 'diupload_oleh', 'tahun_datasets', 'metadata', 'sektor', 'deskripsi', 'tags', 'sifat_datasets', 'db_datasets', 'status', 'alasan', 'jumlah_unduhan'];

    public function agendas()
    {
        // Hubungkan table datasets dengan tbl_agenda_datasets
        return $this->hasMany(AgendaDataset::class, 'datasets_id', 'id');
    }
}
