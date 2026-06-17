<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'alamat',
        'status_peg',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'gelar_depan',
        'gelar_belakang',
        'jabatan',
        'kode_unit',
        'unit_kerja',
        'opd',
        'id_gol',
        'status_menikah',
        'nama_pasangan',
        'tgl_menikah',
        'pekerjaan',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'id_gol');
    }

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date:Y-m-d',
            'tgl_menikah' => 'date:Y-m-d',
        ];
    }
}
