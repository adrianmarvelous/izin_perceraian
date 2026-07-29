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
            $table->longText('sk_membaca')->nullable()->after('rekomendasi_opd');
            $table->longText('sk_menimbang')->nullable()->after('sk_membaca');
            $table->longText('sk_mengingat')->nullable()->after('sk_menimbang');
            $table->longText('sk_memperhatikan')->nullable()->after('sk_mengingat');
            $table->longText('sk_pertama')->nullable()->after('sk_memperhatikan');
            $table->longText('sk_kedua')->nullable()->after('sk_pertama');
            $table->longText('sk_ketiga')->nullable()->after('sk_kedua');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropColumn([
                'sk_membaca',
                'sk_menimbang',
                'sk_mengingat',
                'sk_memperhatikan',
                'sk_pertama',
                'sk_kedua',
                'sk_ketiga',
            ]);
        });
    }
};
