<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->boolean('ms_tms')->default(false)->after('catatan')
                  ->comment('MS/TMS: true=MS (Memenuhi Syarat), false=TMS (Tidak Memenuhi Syarat)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn('ms_tms');
        });
    }
};
