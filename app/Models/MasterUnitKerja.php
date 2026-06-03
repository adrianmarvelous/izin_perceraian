<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnitKerja extends Model
{
    protected $table = 'master_unit_kerja';

    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'opd_id',
    ];

    public function opd()
    {
        return $this->belongsTo(MasterOpd::class, 'opd_id');
    }
}
