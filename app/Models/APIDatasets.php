<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class APIDatasets extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'tbl_datasets_api';

    protected $fillable = ['judul', 'id_opd', 'id_sektor', 'bearer', 'link_api'];

    public function sektor(): BelongsTo
    {
        return $this->belongsTo(Sektor::class, 'id_sektor', 'id');
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class, 'id_opd', 'id');
    }
}
