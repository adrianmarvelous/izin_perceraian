<?php

namespace Database\Seeders;

use App\Models\Golongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * Mengisi tabel golongan dari file CSV id golongan.csv
     */
    public function run(): void
    {
        $csvPath = public_path('files/id golongan.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('File CSV tidak ditemukan: ' . $csvPath);
            return;
        }

        $rows = array_map(fn($line) => str_getcsv($line, ';'), file($csvPath));
        array_shift($rows); // buang header (Id;GolRuang;Pangkat)

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Golongan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $inserted = 0;
        foreach ($rows as $row) {
            $id = (int) trim($row[0]);
            $golRuang = trim($row[1]);
            $pangkat = trim($row[2]);

            Golongan::create([
                'id' => $id,
                'gol_ruang' => $golRuang,
                'pangkat' => $pangkat,
            ]);
            $inserted++;
        }

        $this->command->info("Berhasil mengisi {$inserted} data golongan dari CSV.");
    }
}
