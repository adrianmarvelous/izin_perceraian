<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus duplikat NIP, pertahankan record dengan ID terkecil (paling awal)
        DB::statement("
            DELETE p1 FROM pegawai p1
            INNER JOIN pegawai p2
            WHERE p1.id > p2.id
            AND p1.nip = p2.nip
        ");

        // Tambah unique constraint pada NIP
        Schema::table('pegawai', function (Blueprint $table) {
            $table->unique('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropUnique(['nip']);
        });
    }
};
