<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_tms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_perceraian_id')->constrained('izin_perceraian')->cascadeOnDelete();
            $table->text('alasan');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_tms');
    }
};
