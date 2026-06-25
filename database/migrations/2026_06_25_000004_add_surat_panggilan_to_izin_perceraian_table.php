<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->string('surat_panggilan_istri', 255)->nullable()->after('tanggal_pemanggilan');
            $table->string('surat_panggilan_suami', 255)->nullable()->after('surat_panggilan_istri');
        });
    }

    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['surat_panggilan_istri', 'surat_panggilan_suami']);
        });
    }
};
