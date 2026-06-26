<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcaraTambahan extends Model
{
    protected $table = 'berita_acara_tambahan';

    protected $fillable = [
        'izin_perceraian_id',
        'pihak',
        'pertanyaan',
        'jawaban',
    ];

    public function izinPerceraian()
    {
        return $this->belongsTo(IzinPerceraian::class, 'izin_perceraian_id');
    }
}
