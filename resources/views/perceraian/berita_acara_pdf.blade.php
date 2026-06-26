<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara {{ ucfirst($pihak) }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 40px;
        }
        .kop {
            text-align: center;
            margin-bottom: 5px;
        }
        .kop h2 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .kop h3 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop p {
            font-size: 9pt;
        }
        .kop a {
            font-size: 9pt;
            color: #000;
            text-decoration: none;
        }
        .hr-kop { border: none; border-top: 3px solid #000; margin: 6px 0 2px 0; }
        .hr-kop-bawah { border: none; border-top: 1px solid #000; margin: 0 0 20px 0; }
        .rahasia {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            margin-bottom: 15px;
        }
        .judul {
            text-align: center;
            margin-bottom: 10px;
        }
        .judul h4 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .judul p {
            font-size: 12pt;
            font-weight: bold;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            border-collapse: collapse;
            width: 100%;
        }
        .info td {
            padding: 2px 5px;
            vertical-align: top;
            font-size: 11pt;
        }
        .info .label { width: 140px; }
        .isi {
            margin-top: 10px;
        }
        .isi .q-item {
            margin-bottom: 12px;
            text-align: justify;
        }
        .isi .q-item .q {
            font-weight: bold;
        }
        .isi .q-item .a {
            margin-left: 20px;
        }
        .demikian {
            margin-top: 25px;
            margin-left: 30px;
            margin-bottom: 40px;
            text-align: justify;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 20px;
        }
        .ttd-table .jabatan {
            margin-bottom: 80px;
        }
        .ttd-table .nama-pejabat {
            font-weight: bold;
            margin-top: 5px;
        }
        .ttd-table .nip {
            font-size: 11pt;
        }
        .ttd-table .pemeriksa-item {
            margin-bottom: 3px;
        }
        .pembatas {
            border-left: 1px solid #000;
        }
    </style>
</head>
<body>

    <table style="text-align:center;width:100%">
        <tr>
            <td rowspan="6" style="width:20%"><img src="{{public_path('img/logo pemerintah kota mojokerto.png')}}" width="100" alt=""></td>
            <td style="width:80%;font-size:24px">PEMERINTAH KOTA MOJOKERTO</td>
        </tr>
        <tr>
            <td style="font-size:24px"><strong>BADAN KEPEGAWAIAN DAN PENGEMBANGAN</strong></td>
        </tr>
        <tr>
            <td style="font-size:24px"><strong>SUMBER DAYA MANUSIA</strong></td>
        </tr>
        <tr>
            <td>Jalan Bhayangkara No.42, Kecamatan Kranggan, Kota Mojokerto, 61313</td>
        </tr>
        <tr>
            <td>Telepon (0321) 399600, Faksimile (0321) 399600</td>
        </tr>
        <tr>
            <td>Laman bkpsdm.mojokertokota.go.id, Pos-el bkpsdm@mojokertokota.go.id</td>
        </tr>
    </table>
    <hr class="hr-kop">
    <hr class="hr-kop-bawah">

    <div class="rahasia">RAHASIA</div>

    <div class="judul">
        <h4>BERITA ACARA MEDIASI</h4>
        <p>NOMOR: {{ $perceraian->nomor_surat ?? '-' }}</p>
    </div>

    @php
        // ---- Helper: angka ke kata Indonesia ----
        $angkaKata = function($n) use (&$angkaKata) {
            $angka = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
            if ($n < 12) return $angka[$n];
            if ($n < 20) return $angka[$n - 10] . ' belas';
            if ($n < 100) {
                $puluh = floor($n / 10);
                $sisa = $n % 10;
                return ($puluh == 1 ? 'sepuluh' : $angka[$puluh] . ' puluh') . ($sisa ? ' ' . $angka[$sisa] : '');
            }
            if ($n < 1000) {
                $ratus = floor($n / 100);
                $sisa = $n % 100;
                $ratusText = $ratus == 1 ? 'seratus' : $angka[$ratus] . ' ratus';
                return $ratusText . ($sisa ? ' ' . $angkaKata($sisa) : '');
            }
            if ($n < 1000000) {
                $ribu = floor($n / 1000);
                $sisa = $n % 1000;
                $ribuText = $ribu == 1 ? 'seribu' : $angkaKata($ribu) . ' ribu';
                return $ribuText . ($sisa ? ' ' . $angkaKata($sisa) : '');
            }
            return $n;
        };

        // ---- Data tanggal ----
        $tglBA = $perceraian->tanggal_pemanggilan ?? now();
        if (!($tglBA instanceof \Carbon\Carbon)) {
            $tglBA = \Carbon\Carbon::parse($tglBA);
        }

        $hariIndo = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $bulanIndo = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];

        $hariNama = $hariIndo[$tglBA->format('l')];
        $bulanNama = $bulanIndo[$tglBA->format('F')];
        $tglAngka = (int)$tglBA->format('d');
        $tahunAngka = (int)$tglBA->format('Y');
        $tglKata = $angkaKata($tglAngka);
        $tahunKata = $angkaKata($tahunAngka);
        $tglFormatted = $tglBA->format('d-m-Y');

        $sebutan = $pihak === 'penggugat' ? 'Saudari' : 'Saudara';

        $column = 'berita_acara_' . $pihak;
        $jawabanData = $perceraian->beritaAcaraJawaban->where('pihak', $pihak)->keyBy('kode');
        $pemeriksaRecords = $perceraian->beritaAcaraPemeriksa->where('pihak', $pihak)->sortBy('urutan');
        $pemeriksaData = collect();
        foreach ($pemeriksaRecords as $rec) {
            $peg = $rec->nip ? \App\Models\Pegawai::where('nip', $rec->nip)->first() : null;
            $pemeriksaData->push((object)[
                'nama' => $peg->nama ?? $rec->nama,
                'nip' => $peg->nip ?? $rec->nip,
                'jabatan' => $peg->jabatan ?? $rec->jabatan,
            ]);
        }

        $labels = [
            'q_sehat' => '1. Sehat',
            'q_menikah' => '2. Lama Menikah',
            'q_serumah' => '3. Tinggal Serumah',
            'q_alasan' => '4. Alasan',
            'q_komunikasi' => '5. Komunikasi',
            'q_yakin' => '6. Yakin Berpisah',
        ];
        $questions = [
            'q_sehat' => '1. Apakah ' . $sebutan . ' dalam kondisi sehat?',
            'q_menikah' => '2. Sudah menikah berapa lama?',
            'q_serumah' => '3. Apakah ' . $sebutan . ' sudah tidak tinggal serumah?',
            'q_alasan' => '4. Apa yang mendasari ' . $sebutan . ' memutuskan untuk mengajukan gugatan perceraian?',
            'q_komunikasi' => '5. Apakah masih ada komunikasi?',
            'q_yakin' => '6. Apakah ' . $sebutan . ' sudah yakin untuk berpisah?',
        ];
    @endphp

    <p style="text-align:justify;margin-bottom:10px;text-indent:30px;">
        Pada hari ini <strong>{{ $hariNama }}</strong>, tanggal <strong>{{ $tglKata }}</strong> bulan <strong>{{ $bulanNama }}</strong> tahun <strong>{{ $tahunKata }}</strong> ({{ $tglFormatted }}), Pemeriksa:
    </p>

    @if ($pemeriksaData->isNotEmpty())
        <table style="margin-bottom:15px;margin-left:100px;border-collapse:collapse;width:70%;">
            @foreach ($pemeriksaData as $i => $p)
                <tr>
                    <td style="width:20px;vertical-align:top;padding:2px 5px;"><strong>{{ $i + 1 }}.</strong></td>
                    <td style="vertical-align:top;padding:2px 5px;">
                        Nama : {{ $p->nama }}<br>
                        NIP : {{ $p->nip ?? '-' }}<br>
                        Jabatan : {{ $p->jabatan ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </table>
    @endif
    <div>
        <p style="text-indent:30px;">Adapun beberapa informasi yang diperoleh dari hasil wawancara adalah sebagai berikut:</p>
    </div>

    <div class="info" style="margin-bottom:15px;margin-left:100px;">
        <table>
            <tr><td class="label">Nama</td><td>: {{ $perceraian->pegawai->nama ?? '-' }}</td></tr>
            <tr><td>NIP</td><td>: {{ $perceraian->pegawai->nip ?? '-' }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $perceraian->pegawai->jabatan ?? '-' }}</td></tr>
            <tr><td>OPD</td><td>: {{ $perceraian->pegawai->opd ?? '-' }}</td></tr>
            <tr><td>Sebagai</td><td>: {{ ucfirst($perceraian->sebagai) }}</td></tr>
        </table>
    </div>

    <div class="isi" style="margin-left:100px;">
        @if ($jawabanData->isNotEmpty())
            @foreach ($labels as $kode => $label)
                @php $jawab = $jawabanData->get($kode); @endphp
                @if ($jawab && $jawab->jawaban)
                <div class="q-item">
                    <div class="q">{{ $questions[$kode] ?? $label }}</div>
                    <div class="a">Jawab: {{ $jawab->jawaban }}</div>
                </div>
                @endif
            @endforeach
        @elseif ($perceraian->$column)
            @php
                $blocks = explode("\n---\n", $perceraian->$column);
                $jawabanList = [];
                foreach ($blocks as $block) {
                    $lines = explode("\n", trim($block));
                    $text = trim(implode("\n", $lines));
                    if ($text && !str_starts_with($text, 'Pemeriksa')) {
                        $jawabanList[] = $text;
                    }
                }
            @endphp
            @foreach ($jawabanList as $jawab)
                @php
                    $parts = explode(':', $jawab, 2);
                    $label = trim($parts[0] ?? '');
                    $value = trim($parts[1] ?? '');
                    $fullQuestion = $questions[array_search($label, $labels) ?: ''] ?? $label;
                @endphp
                <div class="q-item">
                    <div class="q">{{ $fullQuestion }}</div>
                    <div class="a">Jawab: {{ $value ?: '-' }}</div>
                </div>
            @endforeach
        @endif

        @php $tambahans = $perceraian->beritaAcaraTambahan->where('pihak', $pihak); @endphp
        @if ($tambahans->isNotEmpty())
            <div style="margin-top:15px;">
                <strong>Pertanyaan Tambahan:</strong>
                @foreach ($tambahans as $t)
                <div class="q-item">
                    <div class="q">Q: {{ $t->pertanyaan }}</div>
                    <div class="a">A: {{ $t->jawaban ?? '-' }}</div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="demikian">
        Demikian Berita Acara Pemeriksaan ini dibuat untuk dapat digunakan sebagaimana mestinya.
    </div>

    <table class="ttd-table">
        <tr>
            <td>
                <p>Yang diperiksa,</p>
                <br><br><br><br>
                <p class="nama-pejabat">{{ $perceraian->pegawai->nama ?? '_________________' }}</p>
                <p class="nip">NIP. {{ $perceraian->pegawai->nip ?? '' }}</p>
            </td>
            <td class="pembatas">
                <p>Pemeriksa,</p>
                <br>
                @if ($pemeriksaData->isNotEmpty())
                    @foreach ($pemeriksaData as $p)
                        <div class="pemeriksa-item">
                            <p class="nama-pejabat">{{ $p->nama }}</p>
                            <p class="nip">NIP. {{ $p->nip ?? '' }}</p>
                            <br>
                        </div>
                    @endforeach
                @else
                    <br><br><br><br>
                    <p class="nama-pejabat">_________________</p>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
