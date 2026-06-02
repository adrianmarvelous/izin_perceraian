<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OPDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opdList = [
            ['name' => 'Sekretariat Daerah', 'username' => 'setda'],
            ['name' => 'Sekretariat DPRD', 'username' => 'setwan'],
            ['name' => 'Dinas Pendidikan dan Kebudayaan', 'username' => 'disdikbud'],
            ['name' => 'Dinas Kepemudaan, Olahraga dan Pariwisata', 'username' => 'disporapar'],
            ['name' => 'Dinas Kesehatan, Pengendalian Penduduk dan Keluarga Berencana', 'username' => 'dinkesp2kb'],
            ['name' => 'Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak', 'username' => 'dinsosp3a'],
            ['name' => 'Dinas Pekerjaan Umum, Penataan Ruang, Perumahan Rakyat dan Kawasan Pemukiman', 'username' => 'puprperkim'],
            ['name' => 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'username' => 'dpmptsp'],
            ['name' => 'Dinas Koperasi, Usaha Kecil dan Menengah, Perindustrian dan Perdagangan', 'username' => 'diskopukmperindag'],
            ['name' => 'Dinas Ketahanan Pangan dan Pertanian', 'username' => 'dkoppangtan'],
            ['name' => 'Dinas Lingkungan Hidup', 'username' => 'dlh'],
            ['name' => 'Dinas Kependudukan dan Pencatatan Sipil', 'username' => 'disdukcapil'],
            ['name' => 'Dinas Perhubungan', 'username' => 'dishub'],
            ['name' => 'Dinas Komunikasi dan Informatika', 'username' => 'diskominfo'],
            ['name' => 'Dinas Perpustakaan dan Kearsipan', 'username' => 'dispusip'],
            ['name' => 'RSUD dr. Wahidin Sudiro Husodo', 'username' => 'rsud'],
            ['name' => 'Satuan Polisi Pamong Praja', 'username' => 'satpolpp'],
            ['name' => 'Inspektorat', 'username' => 'inspektorat'],
            ['name' => 'Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah', 'username' => 'bapperida'],
            ['name' => 'Badan Pengelolaan Keuangan dan Pendapatan Daerah', 'username' => 'bpkpd'],
            ['name' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia', 'username' => 'bkpsdm'],
            ['name' => 'Badan Kesatuan Bangsa dan Politik', 'username' => 'kesbangpol'],
            ['name' => 'Kecamatan Magersari', 'username' => 'kecmagersari'],
            ['name' => 'Kecamatan Prajuritkulon', 'username' => 'kecprajuritkulon'],
            ['name' => 'Kecamatan Kranggan', 'username' => 'kecranggan'],
        ];

        foreach ($opdList as $opd) {
            $user = User::firstOrCreate(
                ['username' => $opd['username']],
                [
                    'name' => trim($opd['name']),
                    'email' => $opd['username'] . '@opd.mojokerto.go.id',
                    'password' => Hash::make('password'),
                ]
            );
            $user->assignRole('opd');
        }
    }
}
