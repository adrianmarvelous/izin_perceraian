<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('status_izin_perceraian')->updateOrInsert(
            ['id' => 6],
            [
                'id' => 6,
                'nama' => 'Ditolak',
                'deskripsi' => 'Pengajuan izin perceraian ditolak oleh Walikota',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('status_izin_perceraian')->where('id', 6)->delete();
    }
};
