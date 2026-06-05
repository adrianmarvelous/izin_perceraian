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
        Schema::create('master_opd', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unit', 50);
            $table->string('unit_kerja', 255);
            $table->timestamps();

            $table->unique('kode_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_opd');
    }
};
