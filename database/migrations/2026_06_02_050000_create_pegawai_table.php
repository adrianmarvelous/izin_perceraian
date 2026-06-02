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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 30)->index();
            $table->string('nama', 255);
            $table->string('jk', 10);
            $table->text('alamat')->nullable();
            $table->string('status_peg', 50)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('gelar_belakang', 100)->nullable();
            $table->string('s2', 10)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->string('kode_unit', 50)->nullable();
            $table->string('unit_kerja', 255)->nullable();
            $table->string('status_menikah', 50)->nullable();
            $table->string('nama_pasangan', 255)->nullable();
            $table->date('tgl_menikah')->nullable();
            $table->string('pekerjaan', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
