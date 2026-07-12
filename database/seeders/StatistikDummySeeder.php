<?php

namespace Database\Seeders;

use App\Models\IzinPerceraian;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatistikDummySeeder extends Seeder
{
    public function run(): void
    {
        $pegawaiIds = Pegawai::pluck('id')->toArray();
        if (empty($pegawaiIds)) {
            $this->command->warn('Tidak ada data pegawai. Jalankan PegawaiSeeder terlebih dahulu.');
            return;
        }

        $statuses = [1, 2, 3, 4, 5];
        $sebagaiOptions = ['penggugat', 'tergugat'];
        $namaPasangan = ['Siti Aisyah', 'Muhammad Rizki', 'Dewi Sartika', 'Ahmad Fauzi', 'Ratna Sari'];

        // Buat data dari Januari - Juni 2026
        $data = [];
        for ($i = 1; $i <= 60; $i++) {
            $bulan = rand(1, 6);
            $tgl = rand(1, 25);
            $createdAt = Carbon::create(2026, $bulan, $tgl, rand(8, 16), rand(0, 59));
            $pegawaiId = $pegawaiIds[array_rand($pegawaiIds)];

            $data[] = [
                'pegawai_id' => $pegawaiId,
                'status_izin_perceraian_id' => $statuses[array_rand($statuses)],
                'nama_pasangan' => $namaPasangan[array_rand($namaPasangan)],
                'sebagai' => $sebagaiOptions[array_rand($sebagaiOptions)],
                'created_by' => 1,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        IzinPerceraian::insert($data);
        $this->command->info('60 data dummy izin perceraian berhasil dibuat.');
    }
}
