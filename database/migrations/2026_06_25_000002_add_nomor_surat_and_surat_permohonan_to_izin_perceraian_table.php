<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->string('nomor_surat', 100)->nullable()->after('catatan');
            $table->string('surat_permohonan', 255)->nullable()->after('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['nomor_surat', 'surat_permohonan']);
        });
    }
};
