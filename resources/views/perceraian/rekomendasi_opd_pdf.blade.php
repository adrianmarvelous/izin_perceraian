<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekomendasi ke OPD</title>
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
        .header-surat .label { width: 120px; }
        .tujuan { margin-bottom: 15px; }
        .isi-section { text-align: justify; margin-bottom: 12px; }
        .data-pegawai table { border-collapse: collapse; width: 70%; margin-left: 20px; margin-bottom: 10px; }
        .data-pegawai td { padding: 1px 5px; vertical-align: top; }
        .data-pegawai .lbl { width: 100px; }
        .ttd { width: 100%; margin-top: 40px; }
        .ttd td { vertical-align: top; }
        .ttd-right { width: 50%; text-align: center; }
        .ttd-left { width: 50%; }
        ol { padding-left: 25px; }
        ol li { margin-bottom: 10px; text-align: justify; }
        .isi-section ol { padding-left: 25px; }
        .isi-section ul { padding-left: 25px; }
        .isi-section p { margin-bottom: 8px; }
    </style>
</head>
<body>
    @php
        $pegawai = $perceraian->pegawai;
        $golongan = $pegawai->golongan;
        $golText = $golongan ? $golongan->gol_ruang : '-';
        $pangkat = $golongan ? $golongan->pangkat : '';
        $jk = $pegawai->jk ?? 'L';
        $pihakLawanTeks = $jk === 'L' ? 'istrinya' : 'suaminya';
        $namaPasangan = $perceraian->nama_pasangan ?? '-';
        $sebagaiPasangan = $jk === 'L' ? 'Istri' : 'Suami';
    @endphp

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

    {{-- Header Surat --}}
    <div class="header-surat">
        <table>
            <tr><td class="label">Nomor</td><td>: {{ $perceraian->nomor_surat ?? 'R.800.1.10.4/31/417.603.3/2026' }}</td></tr>
            <tr><td>Sifat</td><td>: Rahasia</td></tr>
            <tr><td>Lampiran</td><td>: 3 (tiga) Lampiran</td></tr>
            <tr><td>Perihal</td><td>: <strong>Rekomendasi Penerbitan Izin Untuk Melakukan Perceraian PNS</strong></td></tr>
        </table>
    </div>

    <div class="tujuan">
        Yth. Sdr. Kepala {{ $pegawai->opd ?? 'OPD Terkait' }}<br>
        di<br>
        <strong>M O J O K E R T O</strong>
    </div>

    <div class="isi-section">
        Menindaklanjuti Surat Saudara perihal Permohonan Izin Melakukan Perceraian PNS a.n. {{ $pegawai->nama ?? '-' }}, hasil mediasi, serta merujuk Peraturan Wali Kota Nomor 35 Tahun 2025 tentang Perubahan Atas Peraturan Wali Kota Nomor 33 Tahun 2023 tentang Pendelegasian Wewenang Menetapkan dan Pemberian Kuasa Menandatangani Surat Keputusan Serta Surat-Surat Lainnya di Bidang Kepegawaian, bersama ini kami sampaikan beberapa hal sebagai berikut :
    </div>

    <ol>
        <li>
            Bahwa berdasarkan hasil mediasi antara:
            <div class="data-pegawai" style="margin-top:8px;">
                <table>
                    <tr>
                        <td class="lbl" style="vertical-align:top;">a. Pihak {{ $sebagaiPasangan === 'Istri' ? 'Penggugat (Istri)' : 'Penggugat (Suami)' }} :</td>
                        <td></td>
                    </tr>
                    <tr><td style="padding-left:20px;">Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
                    <tr><td style="padding-left:20px;">NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
                    <tr><td style="padding-left:20px;">Pangkat</td><td>: {{ $golText }} - {{ $pangkat }}</td></tr>
                    <tr><td style="padding-left:20px;">Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }}</td></tr>
                    <tr><td style="padding-left:20px;">pada</td><td>: {{ $pegawai->opd ?? '-' }}</td></tr>
                </table>
            </div>
            <div style="margin-top:5px;">
                <table>
                    <tr>
                        <td class="lbl" style="vertical-align:top;">b. Pihak {{ $sebagaiPasangan === 'Istri' ? 'Tergugat (Suami)' : 'Tergugat (Istri)' }} :</td>
                        <td></td>
                    </tr>
                    <tr><td style="padding-left:20px;">Nama</td><td>: {{ $namaPasangan }}</td></tr>
                    <tr><td style="padding-left:20px;">Pekerjaan</td><td>: -</td></tr>
                    <tr><td style="padding-left:20px;">Alamat</td><td>: -</td></tr>
                </table>
            </div>
            <div style="margin-top:8px;">
                disimpulkan informasi bahwa <strong>kedua belah pihak tidak dapat dirukunkan kembali.</strong>
            </div>
        </li>
        <li>
            Bersadarkan ketentuan Surat Edaran Kepala Badan Administrasi Kepegawaian Negara Nomor: 48/SE/1990 tentang Petunjuk Pelaksanaan Peraturan Pemerintah Nomor 45 Tahun 1990 tentang Perubahan Atas Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan Dan Perceraian Bagi Pegawai Negeri Sipil dan hasil proses mediasi, kasus tersebut telah memenuhi kriteria untuk dapat diterbitkan Surat Izin Perceraian PNS, yakni <strong>Salah satu pihak meninggalkan pihak lain selama dua tahun berturut-turut tanpa izin pihak lain dan tanpa alasan yang sah serta tanpa memberikan nafkah lahir maupun batin atau karena hal lain diluar kemampuannya.</strong>
        </li>
        <li>
            Bahwa merujuk pada Peraturan Wali Kota Mojokerto Nomor 35 Tahun 2025 Tentang Perubahan Atas Peraturan Wali Kota Nomor 33 Tahun 2023 Tentang Pendelegasian Wewenang Menetapkan dan Pemberian Kuasa Menandatangani Surat Keputusan Serta Surat-Surat Lainnya di Bidang Kepegawaian, maka Surat Izin untuk melakukan perceraian dapat <strong>diterbitkan oleh Kepala Perangkat Daerah masing-masing.</strong>
        </li>
    </ol>

    <div class="isi-section" style="margin-top:15px;">
        Demikian yang dapat disampaikan, atas perhatiannya diucapkan terima kasih.
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
