<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinPerceraian extends Model
{
    protected $table = 'izin_perceraian';

    protected $fillable = [
        'pegawai_id',
        'status_izin_perceraian_id',
        'nama_pasangan',
        'sebagai',
        'status',
        'catatan',
        'ms_tms',
        'tanggal_pemanggilan',
        'berita_acara_pemanggilan',
        'berita_acara_pemanggilan_file',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'tanggal_pemanggilan' => 'date',
            'ms_tms' => 'integer',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function statusIzin()
    {
        return $this->belongsTo(StatusIzinPerceraian::class, 'status_izin_perceraian_id');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPerceraian::class, 'izin_perceraian_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logTms()
    {
        return $this->hasMany(LogTms::class, 'izin_perceraian_id');
    }
}
