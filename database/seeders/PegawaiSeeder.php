<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = public_path('files/data pegawai.csv');

        if (!file_exists($csvPath)) {
            $this->command->error('File CSV tidak ditemukan di: ' . $csvPath);
            return;
        }

        $file = fopen($csvPath, 'r');
        // Baca header (dengan BOM)
        $header = fgetcsv($file, 0, ';');
        // Bersihkan BOM dari kolom pertama
        $header[0] = preg_replace('/\x{FEFF}/u', '', $header[0]);

        DB::disableQueryLog();
        $count = 0;
        $chunk = [];

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $data = array_combine($header, $row);

            $chunk[] = [
                'nip'             => $data['NIP'] ?? null,
                'nama'            => $data['NAMA'] ?? null,
                'jk'              => $data['JK'] ?? null,
                'alamat'          => $data['ALAMAT'] ?? null,
                'status_peg'      => $data['STATUS PEG'] ?? null,
                'tempat_lahir'    => $data['TEMPAT LAHIR'] ?? null,
                'tanggal_lahir'   => $this->parseDate($data['TANGGAL LAHIR'] ?? null),
                'agama'           => $data['AGAMA'] ?? null,
                'gelar_depan'     => $this->nullIfEmpty($data['GELAR DEPAN'] ?? null),
                'gelar_belakang'  => $this->nullIfEmpty($data['GELAR BELAKANG'] ?? null),
                'jabatan'         => $data['JABATAN'] ?? null,
                'kode_unit'       => $data['KODE UNIT'] ?? null,
                'unit_kerja'      => $data['UNIT KERJA'] ?? null,
                'opd'             => $this->extractOpd($data['UNIT KERJA'] ?? null),
                'status_menikah'  => $this->nullIfEmpty($data['STATUS MENIKAH'] ?? null),
                'nama_pasangan'   => $this->nullIfEmpty($data['NAMA PASANGAN'] ?? null),
                'tgl_menikah'     => $this->parseDate($data['TGL MENIKAH'] ?? null),
                'pekerjaan'       => $this->nullIfEmpty($data['PEKERJAAN'] ?? null),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];

            $count++;

            // Insert per 500 baris
            if (count($chunk) >= 500) {
                Pegawai::insertOrIgnore($chunk);
                $chunk = [];
            }
        }

        // Sisa chunk terakhir
        if (!empty($chunk)) {
            Pegawai::insertOrIgnore($chunk);
        }

        fclose($file);

        $this->command->info("Berhasil mengimport {$count} data pegawai.");
    }

    private function parseDate(?string $value): ?string
    {
        if (!$value || strtoupper($value) === 'NULL' || empty(trim($value))) {
            return null;
        }
        $value = trim($value);
        // Format: "1966-05-10 00:00:00.000" -> ambil tanggal saja
        // Pastikan nilai benar-benar tanggal (diawali angka tahun)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}/', $value)) {
            return null;
        }
        $date = substr($value, 0, 10);
        return $date !== '0000-00-00' ? $date : null;
    }

    private function nullIfEmpty(?string $value): ?string
    {
        if (!$value || strtoupper(trim($value)) === 'NULL' || empty(trim($value))) {
            return null;
        }
        return trim($value);
    }

    private function extractOpd(?string $unitKerja): ?string
    {
        if (!$unitKerja || strtoupper(trim($unitKerja)) === 'NULL' || empty(trim($unitKerja))) {
            return null;
        }
        $unitKerja = trim($unitKerja);
        // Jika ada ' - ', ambil bagian setelahnya
        $pos = strpos($unitKerja, ' - ');
        if ($pos !== false) {
            return trim(substr($unitKerja, $pos + 3));
        }
        return $unitKerja;
    }
}
