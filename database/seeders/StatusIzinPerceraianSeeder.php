<?php

namespace Database\Seeders;

use App\Models\StatusIzinPerceraian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusIzinPerceraianSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'nama' => 'Draft', 'deskripsi' => 'Pengajuan awal masih dalam bentuk draft'],
            ['id' => 2, 'nama' => 'Pengajuan ke BKPSDM', 'deskripsi' => 'Pengajuan izin perceraian telah dikirim ke BKPSDM'],
            ['id' => 3, 'nama' => 'Rekomendasi dari BKPSDM', 'deskripsi' => 'BKPSDM telah memberikan rekomendasi'],
            ['id' => 4, 'nama' => 'Pengajuan ke Walikota', 'deskripsi' => 'Pengajuan izin perceraian telah dikirim ke Walikota'],
            ['id' => 5, 'nama' => 'Rekomendasi dari Walikota', 'deskripsi' => 'Walikota telah memberikan rekomendasi akhir'],
        ];

        foreach ($statuses as $status) {
            StatusIzinPerceraian::updateOrCreate(
                ['id' => $status['id']],
                $status
            );
        }
    }
}
