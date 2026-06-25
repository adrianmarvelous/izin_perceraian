<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['berita_acara_pemanggilan', 'berita_acara_pemanggilan_file']);
        });
    }

    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->text('berita_acara_pemanggilan')->nullable()->after('tanggal_pemanggilan');
            $table->string('berita_acara_pemanggilan_file', 255)->nullable()->after('berita_acara_pemanggilan');
        });
    }
};
