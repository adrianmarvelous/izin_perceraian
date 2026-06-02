<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPerceraian extends Model
{
    protected $table = 'dokumen_perceraian';

    protected $fillable = [
        'izin_perceraian_id',
        'nama_dokumen',
        'kode',
        'wajib',
        'kondisi_wajib',
        'status',
        'link',
        'file',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'wajib' => 'boolean',
            'status' => 'boolean',
        ];
    }

    public function izin()
    {
        return $this->belongsTo(IzinPerceraian::class, 'izin_perceraian_id');
    }
}
