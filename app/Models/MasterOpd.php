<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterOpd extends Model
{
    protected $table = 'master_opd';

    protected $fillable = [
        'kode_opd',
        'nama_opd',
    ];

    public function unitKerja()
    {
        return $this->hasMany(MasterUnitKerja::class, 'opd_id');
    }
}
