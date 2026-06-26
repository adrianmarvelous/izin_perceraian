<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcaraJawaban extends Model
{
    protected $table = 'berita_acara_jawaban';

    protected $fillable = [
        'izin_perceraian_id',
        'pihak',
        'kode',
        'jawaban',
    ];

    public function izinPerceraian()
    {
        return $this->belongsTo(IzinPerceraian::class, 'izin_perceraian_id');
    }
}
