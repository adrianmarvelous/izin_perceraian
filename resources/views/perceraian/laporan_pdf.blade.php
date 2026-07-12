<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Hasil Mediasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 30px 40px;
        }
        table.kop {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 5px;
        }
        table.kop td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .hr-garis { border: none; border-top: 3px solid #000; margin: 4px 0; }
        .hr-garis2 { border: none; border-top: 1px solid #000; margin: 0 0 15px 0; }
        .header-surat { margin-bottom: 20px; }
        .header-surat table { border-collapse: collapse; width: 100%; }
        .header-surat td { padding: 1px 5px; vertical-align: top; }
        .header-surat .label { width: 100px; }
        .tujuan { margin-bottom: 15px; }
        .isi-section { text-align: justify; margin-bottom: 15px; }
        .section-title { font-weight: bold; margin-top: 15px; margin-bottom: 8px; }
        .data-pegawai table { border-collapse: collapse; width: 60%; margin-left: 20px; margin-bottom: 10px; }
        .data-pegawai td { padding: 1px 5px; vertical-align: top; }
        .data-pegawai .lbl { width: 100px; }
        .ttd { width: 100%; margin-top: 40px; }
        .ttd td { vertical-align: top; }
        .ttd-right { width: 50%; text-align: center; }
        .ttd-left { width: 50%; }
        .isi-section ol { padding-left: 25px; }
        .isi-section ul { padding-left: 25px; }
        .isi-section p { margin-bottom: 8px; }
    </style>
</head>
<body>
    {{-- Kop --}}
    <table class="kop" style="text-align:center;">
        <tr>
            <td rowspan="5" style="width:15%;">
                <img src="{{ public_path('img/logo pemerintah kota mojokerto.png') }}" width="80" alt="">
            </td>
            <td style="font-size:18px;font-weight:bold;">PEMERINTAH KOTA MOJOKERTO</td>
        </tr>
        <tr><td style="font-size:16px;font-weight:bold;">BADAN KEPEGAWAIAN DAN PENGEMBANGAN</td></tr>
        <tr><td style="font-size:16px;font-weight:bold;">SUMBER DAYA MANUSIA</td></tr>
        <tr><td style="font-size:8pt;">Jalan Bhayangkara No.42, Kecamatan Kranggan, Kota Mojokerto, 61313</td></tr>
        <tr><td style="font-size:8pt;">Telepon (0321) 399600, Faksimile (0321) 399600</td></tr>
    </table>
    <hr class="hr-garis">
    <hr class="hr-garis2">

    @php
        $pegawai = $perceraian->pegawai;
        $golongan = $pegawai->golongan;
        $golText = $golongan ? $golongan->gol_ruang : '-';
        $pangkat = $golongan ? $golongan->pangkat : '';
        $nomorSurat = $perceraian->nomor_surat ?? 'R.800.1.10.4/31/417.603.3/2026';
        $jk = $pegawai->jk ?? 'L';
        $pihakLawan = $jk === 'L' ? 'Istri' : 'Suami';
        $pihakPegawai = $jk === 'L' ? 'Suami' : 'Istri';
        $pihakLawanTeks = $jk === 'L' ? 'istrinya' : 'suaminya';
        $sebutan = $jk === 'L' ? 'Saudara' : 'Saudari';
        $namaPasangan = $perceraian->nama_pasangan ?? '-';
    @endphp

    {{-- Header Surat --}}
    <div class="header-surat">
        <table>
            <tr><td class="label">Nomor</td><td>: {{ $nomorSurat }}</td></tr>
            <tr><td>Sifat</td><td>: Rahasia</td></tr>
            <tr><td>Lampiran</td><td>: (satu) berkas</td></tr>
            <tr><td>Perihal</td><td>: <strong>Laporan Hasil Mediasi Perceraian ASN</strong></td></tr>
        </table>
    </div>

    <div class="tujuan">
        Yth. Ibu Wali Kota Mojokerto<br>
        di<br>
        <strong>MOJOKERTO</strong>
    </div>

    {{-- Isi --}}
    <div class="isi-section">
        Sehubungan dengan adanya permohonan izin perceraian yang dilakukan oleh ASN sebagai berikut;
    </div>

    <div class="data-pegawai">
        <table>
            <tr><td class="lbl">Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
            <tr><td>NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
            <tr><td>Golongan</td><td>: {{ $golText }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }}</td></tr>
            <tr><td>Unit Kerja</td><td>: {{ $pegawai->opd ?? '-' }}</td></tr>
        </table>
    </div>

    <div class="isi-section">
        terhadap {{ $pihakLawanTeks }} dengan identitas sebagai berikut:
    </div>

    <div class="data-pegawai">
        <table>
            <tr><td class="lbl">Nama</td><td>: {{ $namaPasangan }}</td></tr>
            <tr><td>Pekerjaan</td><td>: -</td></tr>
            <tr><td>Agama</td><td>: -</td></tr>
            <tr><td>Alamat</td><td>: -</td></tr>
        </table>
    </div>

    <div class="isi-section">
        Bersama ini dapat disampaikan beberapa informasi sebagai berikut:
    </div>

    {{-- I. Pokok Persoalan --}}
    <div class="section-title">I. Pokok Persoalan</div>
    <div class="isi-section">
        Surat permohonan izin perceraian a.n. {{ $pegawai->nama ?? '-' }}, telah dilakukan verifikasi proses pembinaan internal ASN yang telah dilaksanakan oleh Unit Kerja/Perangkat Daerah ASN yang bersangkutan, melalui pemanggilan dan wawancara terhadap ASN yang bersangkutan.
    </div>

    {{-- II. Fakta dan Data --}}
    <div class="section-title">II. Fakta dan data yang disajikan</div>
    <div class="isi-section">
        @if ($perceraian->laporan_fakta)
            {!! $perceraian->laporan_fakta !!}
        @else
            <p>Bahwa dari hasil mediasi/pembinaan perceraian sebagaimana tertuang pada Berita Acara Mediasi, dapat diketahui beberapa informasi sebagai berikut;</p>
            <ol>
                <li>Pihak {{ ucfirst($pihakLawan) }} ({{ $namaPasangan }}) dan Pihak {{ ucfirst($pihakPegawai) }} ({{ $pegawai->nama ?? '-' }}) sudah tidak lagi tinggal serumah;</li>
                <li>Kedua belah pihak telah bersepakat untuk berpisah;</li>
                <li>Atasan langsung yang bersangkutan telah memanggil kedua belah pihak untuk dilakukan mediasi, nasihat, dan bimbingan agar hubungan baik terjalin kembali, namun mediasi gagal.</li>
            </ol>
        @endif
    </div>

    {{-- III. Analisis dan Pembahasan --}}
    <div class="section-title">III. Analisis dan Pembahasan</div>
    <div class="isi-section">
        @if ($perceraian->laporan_analisis)
            {!! $perceraian->laporan_analisis !!}
        @else
            <ol>
                <li>{{ $sebutan }}. {{ $pegawai->nama ?? '-' }} telah mengikuti prosedur Kepegawaian sesuai dengan Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan dan Perceraian Bagi Pegawai Negeri Sipil, sebagaimana telah diubah dengan Peraturan Pemerintah Nomor: 45 Tahun 1990, terutama pasal 3 ayat (1) yang menyatakan bahwa "Pegawai Negeri Sipil yang akan Melakukan perceraian wajib memperoleh ijin atau Surat Keterangan lebih dahulu dari Pejabat."</li>
                <li>Berdasarkan fakta dan data pada poin II, telah memenuhi alasan-alasan yang tertuang dalam Surat Edaran Kepala BKN Nomor 8/SE/1983 tentang izin perkawinan dan perceraian.</li>
            </ol>
        @endif
    </div>

    {{-- IV. Kesimpulan --}}
    <div class="section-title">IV. Kesimpulan</div>
    <div class="isi-section">
        @if ($perceraian->laporan_kesimpulan)
            {!! $perceraian->laporan_kesimpulan !!}
        @else
            <ol>
                <li>Bahwa berdasarkan fakta-fakta dan informasi yang dihimpun pada seluruh proses pembinaan/mediasi perceraian, ASN atas nama {{ $pegawai->nama ?? '-' }}, NIP. {{ $pegawai->nip ?? '-' }}, Golongan {{ $golText }}, Jabatan {{ $pegawai->jabatan ?? '-' }}, Unit Kerja {{ $pegawai->opd ?? '-' }}, telah memenuhi kriteria sebagaimana diatur dalam peraturan yang berlaku.</li>
                <li>Bahwa berdasarkan fakta-fakta dan informasi yang dihimpun pada seluruh proses pembinaan/mediasi perceraian, terlihat bahwa kedua belah pihak sudah tidak bisa dirukunkan atau disatukan lagi.</li>
            </ol>
        @endif
    </div>

    {{-- V. Saran Tindak --}}
    <div class="section-title">V. Saran Tindak</div>
    <div class="isi-section">
        @if ($perceraian->laporan_saran)
            {!! $perceraian->laporan_saran !!}
        @else
            <p>Dengan mempelajari alasan-alasan dan keterangan yang didapat pada saat pembinaan, maka kiranya agar dapat diterbitkan Surat Izin Perceraian.</p>
        @endif
    </div>

    {{-- Tanda Tangan --}}
    <table class="ttd">
        <tr>
            <td class="ttd-left"></td>
            <td class="ttd-right">
                <p>Mojokerto, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p>a.n. WALI KOTA MOJOKERTO</p>
                <p>KEPALA BKPSDM</p>
                <br><br><br>
                <p style="font-weight:bold;text-decoration:underline;">MURAJI, S.Sos., M.M.</p>
                <p>Pembina Utama Muda</p>
                <p>NIP. 19681115 199202 1 002</p>
            </td>
        </tr>
    </table>
</body>
</html>
