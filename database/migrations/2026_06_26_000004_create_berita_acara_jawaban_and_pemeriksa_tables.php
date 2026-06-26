<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_acara_jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_perceraian_id')->constrained('izin_perceraian')->cascadeOnDelete();
            $table->enum('pihak', ['penggugat', 'tergugat']);
            $table->string('kode', 50)->comment('q_sehat, q_menikah, q_serumah, q_alasan, q_komunikasi, q_yakin');
            $table->text('jawaban')->nullable();
            $table->timestamps();

            $table->unique(['izin_perceraian_id', 'pihak', 'kode']);
        });

        Schema::create('berita_acara_pemeriksa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_perceraian_id')->constrained('izin_perceraian')->cascadeOnDelete();
            $table->enum('pihak', ['penggugat', 'tergugat']);
            $table->tinyInteger('urutan')->unsigned();
            $table->string('nama', 255);
            $table->string('nip', 50)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->timestamps();

            $table->unique(['izin_perceraian_id', 'pihak', 'urutan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_acara_pemeriksa');
        Schema::dropIfExists('berita_acara_jawaban');
    }
};
