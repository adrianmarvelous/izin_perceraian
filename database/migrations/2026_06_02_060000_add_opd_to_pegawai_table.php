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
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('opd', 255)->nullable()->after('unit_kerja');
        });

        // Isi kolom opd berdasarkan unit_kerja
        // Jika unit_kerja mengandung ' - ', ambil setelahnya
        // Jika tidak, gunakan unit_kerja langsung
        DB::statement("
            UPDATE pegawai
            SET opd = CASE
                WHEN unit_kerja LIKE '% - %' THEN TRIM(SUBSTRING_INDEX(unit_kerja, ' - ', -1))
                ELSE unit_kerja
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn('opd');
        });
    }
};
