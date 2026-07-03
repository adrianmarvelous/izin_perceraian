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
        'nomor_surat',
        'surat_permohonan',
        'ms_tms',
        'tanggal_pemanggilan',
        'surat_panggilan_istri',
        'surat_panggilan_suami',
        'berita_acara_penggugat',
        'berita_acara_tergugat',
        'laporan_fakta',
        'laporan_analisis',
        'laporan_kesimpulan',
        'laporan_saran',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'tanggal_pemanggilan' => 'datetime',
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

    public function beritaAcaraTambahan()
    {
        return $this->hasMany(BeritaAcaraTambahan::class, 'izin_perceraian_id');
    }

    public function beritaAcaraJawaban()
    {
        return $this->hasMany(BeritaAcaraJawaban::class, 'izin_perceraian_id');
    }

    public function beritaAcaraPemeriksa()
    {
        return $this->hasMany(BeritaAcaraPemeriksa::class, 'izin_perceraian_id');
    }
}
