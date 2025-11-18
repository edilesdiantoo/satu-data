<?php

namespace App\Models;

use App\Models\Opd;
use Illuminate\Database\Eloquent\Model;
use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Datasets extends Model
{
    use HasFactory;
    use HasVisits;
    use HasUuids;

    // use \Conner\Tagging\Taggable;
    
    protected $table = 'tbl_datasets';
    protected $fillable = ['judul', 'nama_opd', 'diupload_oleh', 'tahun_datasets', 'metadata','sektor','deskripsi','tags','sifat_datasets', 'db_datasets','status','alasan', 'jumlah_unduhan'];

}
