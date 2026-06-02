<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('izin_perceraian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('nama_pasangan', 255)->nullable();
            $table->enum('sebagai', ['penggugat', 'tergugat'])->nullable();
            $table->enum('status', ['draft', 'pengajuan', 'diproses', 'selesai', 'ditolak'])->default('draft');
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('dokumen_perceraian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('izin_perceraian_id')->constrained('izin_perceraian')->cascadeOnDelete();
            $table->string('nama_dokumen', 255);
            $table->string('kode', 50);
            $table->boolean('wajib')->default(true);
            $table->string('kondisi_wajib')->nullable()->comment('kondisi khusus, misal: pisah_rumah>=2_tahun');
            $table->boolean('status')->default(false)->comment('true=sudah, false=belum');
            $table->string('link', 500)->nullable()->comment('link gdrive untuk dokumentasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_perceraian');
        Schema::dropIfExists('izin_perceraian');
    }
};
