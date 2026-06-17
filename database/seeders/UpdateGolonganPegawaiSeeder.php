<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGolonganPegawaiSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * Mengupdate id_gol di tabel pegawai berdasarkan file CSV nip golongan.csv
     */
    public function run(): void
    {
        $csvPath = public_path('files/nip golongan.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('File CSV tidak ditemukan: ' . $csvPath);
            return;
        }

        $rows = array_map(fn($line) => str_getcsv($line, ';'), file($csvPath));
        array_shift($rows); // buang header (NIPBaru;idgol)

        $updated = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            $nip = trim($row[0]);
            $idGol = trim($row[1]);

            // Lewati jika idgol NULL, kosong, atau bukan angka valid
            if ($idGol === '' || $idGol === 'NULL' || $idGol === null || !ctype_digit($idGol)) {
                $skipped++;
                continue;
            }

            $idGol = (int) $idGol;

            // Lewati jika id_gol tidak ada di tabel golongan
            if (!DB::table('golongan')->where('id', $idGol)->exists()) {
                $skipped++;
                continue;
            }

            $affected = Pegawai::where('nip', $nip)->update(['id_gol' => $idGol]);

            if ($affected > 0) {
                $updated++;
            }
        }

        $this->command->info("Berhasil mengupdate {$updated} data pegawai dengan id_gol dari CSV.");
        if ($skipped > 0) {
            $this->command->warn("{$skipped} baris dilewati karena id_gol bernilai NULL.");
        }
    }
}
