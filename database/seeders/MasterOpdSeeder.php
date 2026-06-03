<?php

namespace Database\Seeders;

use App\Models\MasterOpd;
use App\Models\MasterUnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterOpdSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * Mengisi master_opd dan master_unit_kerja dari file CSV master opd.
     */
    public function run(): void
    {
        $csvPath = public_path('files/master opd.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('File CSV tidak ditemukan: ' . $csvPath);
            return;
        }

        // Baca CSV
        $rows = array_map(fn($line) => str_getcsv($line, ';'), file($csvPath));
        array_shift($rows); // buang header (kode;namaunit;instansi)

        // --- Hapus data lama ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        MasterUnitKerja::truncate();
        MasterOpd::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // --- 1. Kumpulkan distinct instansi beserta kode_opd terpendek ---
        $opdInstansiMap = []; // nama instansi => kode_opd terpendek
        foreach ($rows as $row) {
            $kode = trim($row[0]);
            $instansi = isset($row[2]) ? trim($row[2]) : '';

            if ($instansi === '' || $instansi === 'NULL' || $instansi === null) {
                continue;
            }

            if (!isset($opdInstansiMap[$instansi]) || strlen($kode) < strlen($opdInstansiMap[$instansi])) {
                $opdInstansiMap[$instansi] = $kode;
            }
        }

        // Insert OPD
        foreach ($opdInstansiMap as $namaOpd => $kodeOpd) {
            MasterOpd::create([
                'kode_opd' => $kodeOpd,
                'nama_opd' => $namaOpd,
            ]);
        }

        $this->command->info('Berhasil mengisi ' . count($opdInstansiMap) . ' data master OPD dari CSV.');

        // --- 2. Insert master_unit_kerja ---
        $opdLookup = MasterOpd::pluck('id', 'nama_opd');

        $inserted = 0;
        foreach ($rows as $row) {
            $kode = trim($row[0]);
            $namaunit = trim($row[1]);
            $instansi = isset($row[2]) ? trim($row[2]) : '';

            if ($instansi === 'NULL') {
                $instansi = null;
            }

            $opdId = null;
            if ($instansi && $instansi !== '' && isset($opdLookup[$instansi])) {
                $opdId = $opdLookup[$instansi];
            }

            MasterUnitKerja::create([
                'kode_unit' => $kode,
                'nama_unit' => $namaunit,
                'opd_id' => $opdId,
            ]);
            $inserted++;
        }

        $this->command->info("Berhasil mengisi {$inserted} data master unit kerja dari CSV.");
    }
}
