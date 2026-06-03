<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Mengubah struktur master_opd: kode_unit → kode_opd, unit_kerja → nama_opd
     */
    public function up(): void
    {
        Schema::table('master_opd', function (Blueprint $table) {
            $table->renameColumn('kode_unit', 'kode_opd');
            $table->renameColumn('unit_kerja', 'nama_opd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_opd', function (Blueprint $table) {
            $table->renameColumn('kode_opd', 'kode_unit');
            $table->renameColumn('nama_opd', 'unit_kerja');
        });
    }
};
