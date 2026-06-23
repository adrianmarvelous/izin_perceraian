<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusIzinPerceraian extends Model
{
    protected $table = 'status_izin_perceraian';

    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'integer',
    ];

    public function izinPerceraian()
    {
        return $this->hasMany(IzinPerceraian::class, 'status_izin_perceraian_id');
    }
}
