<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara_tambahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_perceraian_id')->constrained('izin_perceraian')->cascadeOnDelete();
            $table->enum('pihak', ['penggugat', 'tergugat']);
            $table->string('pertanyaan', 500);
            $table->text('jawaban')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara_tambahan');
    }
};
