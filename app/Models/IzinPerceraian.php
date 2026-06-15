<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinPerceraian extends Model
{
    protected $table = 'izin_perceraian';

    protected $fillable = [
        'pegawai_id',
        'nama_pasangan',
        'sebagai',
        'status',
        'catatan',
        'tanggal_pemanggilan',
        'berita_acara_pemanggilan',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'tanggal_pemanggilan' => 'date',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPerceraian::class, 'izin_perceraian_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
