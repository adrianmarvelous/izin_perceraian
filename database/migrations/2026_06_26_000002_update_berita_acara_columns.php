<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn('berita_acara');
        });

        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->text('berita_acara_penggugat')->nullable()->after('surat_panggilan_suami');
            $table->text('berita_acara_tergugat')->nullable()->after('berita_acara_penggugat');
        });
    }

    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['berita_acara_penggugat', 'berita_acara_tergugat']);
            $table->text('berita_acara')->nullable()->after('surat_panggilan_suami');
        });
    }
};
