<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcaraPemeriksa extends Model
{
    protected $table = 'berita_acara_pemeriksa';

    protected $fillable = [
        'izin_perceraian_id',
        'pihak',
        'urutan',
        'nama',
        'nip',
        'jabatan',
    ];

    public function izinPerceraian()
    {
        return $this->belongsTo(IzinPerceraian::class, 'izin_perceraian_id');
    }
}
