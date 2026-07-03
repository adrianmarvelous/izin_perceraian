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
            $table->text('laporan_fakta')->nullable()->after('status')
                  ->comment('Konten bagian II. Fakta dan data yang disajikan');
            $table->text('laporan_analisis')->nullable()->after('laporan_fakta')
                  ->comment('Konten bagian III. Analisis dan Pembahasan');
            $table->text('laporan_kesimpulan')->nullable()->after('laporan_analisis')
                  ->comment('Konten bagian IV. Kesimpulan');
            $table->text('laporan_saran')->nullable()->after('laporan_kesimpulan')
                  ->comment('Konten bagian V. Saran Tindak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn(['laporan_fakta', 'laporan_analisis', 'laporan_kesimpulan', 'laporan_saran']);
        });
    }
};
