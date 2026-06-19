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
            $table->tinyInteger('ms_tms')->default(0)->change()
                  ->comment('MS/TMS: 1=MS, 0=Belum ditentukan, -1=TMS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izin_perceraian', function (Blueprint $table) {
            $table->boolean('ms_tms')->default(false)->change()
                  ->comment('MS/TMS: true=MS, false=TMS');
        });
    }
};
