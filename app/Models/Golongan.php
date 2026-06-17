<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $table = 'golongan';

    protected $fillable = [
        'id',
        'gol_ruang',
        'pangkat',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'integer',
    ];
}
