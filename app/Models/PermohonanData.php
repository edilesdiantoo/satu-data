<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanData extends Model
{
    use HasFactory;

    protected $table = 'tbl_permohonan_data';

    protected $fillable = ['id_tracking', 'id_user', 'id_datasets', 'nama', 'email', 'no_tlp', 'judul_datasets', 'opd', 'deskripsi', 'tujuan', 'upload_template', 'status'];
}
