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
            $table->tinyInteger('status_izin_perceraian_id')
                ->unsigned()
                ->nullable()
                ->after('pegawai_id');
            $table->foreign('status_izin_perceraian_id')
                ->references('id')
                ->on('status_izin_perceraian')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->dropForeign(['status_izin_perceraian_id']);
            $table->dropColumn('status_izin_perceraian_id');
        });
    }
};
