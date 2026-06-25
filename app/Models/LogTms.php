<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogTms extends Model
{
    protected $table = 'log_tms';

    protected $fillable = [
        'izin_perceraian_id',
        'alasan',
        'created_by',
    ];

    public function izinPerceraian()
    {
        return $this->belongsTo(IzinPerceraian::class, 'izin_perceraian_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
