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
            $table->date('tanggal_pemanggilan')->nullable()->after('catatan')
                  ->comment('Tanggal pemanggilan oleh OPD');
            $table->text('berita_acara_pemanggilan')->nullable()->after('tanggal_pemanggilan')
                  ->comment('Berita acara hasil pemanggilan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['tanggal_pemanggilan', 'berita_acara_pemanggilan']);
        });
    }
};
