@php
    $pegawai = $perceraian->pegawai;
    $golongan = $pegawai->golongan;
    $golText = $golongan ? 'Golongan ' . $golongan->gol_ruang : '-';
    $jk = $pegawai->jk ?? 'L';
    $pihakLawan = $jk === 'L' ? 'Suami' : 'Istri';
    $sebutan = $jk === 'L' ? 'Saudara' : 'Saudari';
    $sebutanLawan = $jk === 'L' ? 'istrinya' : 'suaminya';
    $nomorSk = $perceraian->nomor_surat 
        ? str_replace('R.800.1.10.4/', '800.1.10.4/', $perceraian->nomor_surat)
        : '800.1.10.4/02/417.603.3/2026';
    $namaPasangan = $perceraian->nama_pasangan ?? '-';
    $tglSk = now()->locale('id')->translatedFormat('d F Y');
@endphp

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>SK Wali Kota</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            padding: 30px 40px;
            margin: 0;
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
        .hr-garis2 { border: none; border-top: 1px solid #000; margin: 0 0 20px 0; }
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 5px;
        }
        .sub-judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 5px;
        }
        .no-surat {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 10px;
        }
        .tentang {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 15px;
        }
        .rahmat {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 15px;
        }
        .section-title {
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-left: 10px;
        }
        .content-table td {
            padding: 1px 5px;
            vertical-align: top;
        }
        .content-table .lbl {
            width: 100px;
        }
        .indent {
            margin-left: 20px;
            text-align: justify;
        }
        .menimbang, .mengingat, .memperhatikan {
            text-align: justify;
            margin-left: 20px;
        }
        .menimbang p, .mengingat p, .memperhatikan p {
            margin: 2px 0;
            padding-left: 35px;
        }
        .memutuskan {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 15px 0;
        }
        .ttd {
            margin-top: 30px;
            text-align: right;
        }
        .ttd p {
            margin: 2px 0;
        }
        .tembusan {
            margin-top: 20px;
        }
        .tembusan p {
            margin: 1px 0;
        }
        .paraf {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 10px;
            font-size: 10pt;
        }
        .paraf table {
            width: 100%;
            border-collapse: collapse;
        }
        .paraf td {
            padding: 2px 10px;
            vertical-align: top;
        }
        .page-break {
            page-break-before: always;
        }
        .no-break {
            page-break-inside: avoid !important;
        }
    </style>
</head>
<body>
    <div style="text-align:center;">
        <img src="{{ public_path('img/logo garuda.png') }}" width="80" alt="">
    </div>

    <table>
        <tr>
            <td colspan="3">
                <div class="judul">KEPUTUSAN</div>
                <div class="sub-judul">WALI KOTA MOJOKERTO</div>
                <div class="no-surat">NOMOR : {{ $nomorSk }}</div>
                <div class="tentang">TENTANG<br>PEMBERIAN IZIN PERCERAIAN</div>
                <div class="rahmat">DENGAN RAHMAT TUHAN YANG MAHA ESA<br>WALI KOTA MOJOKERTO</div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;width:10%">Membaca</td>
            <td style="vertical-align: top;width:4%">:</td>
            <td style="vertical-align: top;">
                <div class="no-break">
                <p style="margin:0;text-align:justify;">Laporan Hasil Mediasi Nomor: {{ $perceraian->nomor_surat ?? 'R.800.1.10.4/ /417.603.3/2026' }} tanggal {{ $perceraian->created_at ? $perceraian->created_at->locale('id')->translatedFormat('d F Y') : '........................' }} tentang Pertimbangan Izin Perceraian ASN yang diajukan oleh:</p>
                {{-- Data Pegawai --}}
                <table class="content-table">
                    <tr><td class="lbl">1. Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
                    <tr><td>2. NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
                    <tr><td>3. Golongan</td><td>: {{ $golText }}</td></tr>
                    <tr><td>4. Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }}</td></tr>
                    <tr><td>5. Unit Kerja</td><td>: {{ $pegawai->opd ?? '-' }}</td></tr>
                    <tr><td>6. Agama</td><td>: {{ $pegawai->agama ?? '-' }}</td></tr>
                </table>
                <div class="indent" style="margin-top:5px;">
                    terhadap {{ $sebutanLawan }} dengan identitas sebagai berikut:
                </div>
                {{-- Data Pasangan --}}
                <table class="content-table">
                    <tr><td class="lbl">1. Nama</td><td>: {{ $namaPasangan }}</td></tr>
                    <tr><td>2. Pekerjaan</td><td>: {{ $perceraian->pegawai->pekerjaan ?? '-' }}</td></tr>
                    <tr><td>3. Agama</td><td>: -</td></tr>
                    <tr><td>4. Alamat</td><td>: -</td></tr>
                </table>
                <br>
                <div style="text-align:justify;">{!! $perceraian->sk_membaca !!}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Menimbang</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <div style="text-align:justify;">{!! $perceraian->sk_menimbang !!}</div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Mengingat</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <div class="no-break">
                <div style="text-align:justify;">{!! $perceraian->sk_mengingat !!}</div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">Memperhatikan</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <div style="text-align:justify;">{!! $perceraian->sk_memperhatikan !!}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3"><div class="memutuskan">MEMUTUSKAN:</div></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">PERTAMA</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <p style="margin:0;text-align:justify;">Memberikan Izin kepada:</p>
                <table class="content-table">
                    <tr><td class="lbl">1. Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
                    <tr><td>2. NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
                    <tr><td>3. Golongan</td><td>: {{ $golText }}</td></tr>
                    <tr><td>4. Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }}</td></tr>
                    <tr><td>5. Unit Kerja</td><td>: {{ $pegawai->opd ?? '-' }}</td></tr>
                    <tr><td>6. Agama</td><td>: {{ $pegawai->agama ?? '-' }}</td></tr>
                </table>
                <p style="margin:5px 0 0 0;text-align:justify;">Dikabulkan untuk melakukan perceraian dengan {{ $sebutanLawan }}:</p>
                <table class="content-table">
                    <tr><td class="lbl">1. Nama</td><td>: {{ $namaPasangan }}</td></tr>
                    <tr><td>2. Pekerjaan</td><td>: -</td></tr>
                    <tr><td>3. Agama</td><td>: -</td></tr>
                    <tr><td>4. Alamat</td><td>: -</td></tr>
                </table>
                <br>
                <div style="text-align:justify;">{!! $perceraian->sk_pertama !!}</div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">KEDUA</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <div style="text-align:justify;">{!! $perceraian->sk_kedua !!}</div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top;">KETIGA</td>
            <td style="vertical-align: top;">:</td>
            <td>
                <div style="text-align:justify;">{!! $perceraian->sk_ketiga !!}</div>
            </td>
        </tr>
    </table>

    {{-- Tembusan --}}
    <div class="tembusan">
        <p><strong>Tembusan disampaikan kepada:</strong></p>
        <p>Yth. 1. Sdr. Ketua Pengadilan Agama Mojokerto;</p>
        <p>&emsp;&emsp;2. Sdr. Direktur {{ $pegawai->opd ?? '-' }};</p>
        <p>&emsp;&emsp;3. Sdr. Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota Mojokerto;</p>
        <p>&emsp;&emsp;4. Sdr. {{ $namaPasangan }};</p>
    </div>

    {{-- Tanda Tangan --}}
    <table style="width:100%;margin-top:30px;">
        <tr>
            <td style="width:55%;vertical-align:top;">
                <div class="paraf">
                    <table>
                        <tr><td style="font-weight:bold;text-align:center;" colspan="2">PARAF HIERARKI</td></tr>
                        <tr><td style="width:40%;">Sekretaris Daerah</td><td style="border-bottom:1px solid #000;height:30px;"></td></tr>
                        <tr><td>Kepala BKPSDM</td><td style="border-bottom:1px solid #000;height:30px;"></td></tr>
                        <tr><td style="font-weight:bold;text-align:center;" colspan="2">PARAF KOORDINASI</td></tr>
                        <tr><td>Asisten D</td><td style="border-bottom:1px solid #000;height:30px;"></td></tr>
                        <tr><td>Sekretaris</td><td style="border-bottom:1px solid #000;height:30px;"></td></tr>
                    </table>
                </div>
            </td>
            <td style="width:45%;text-align:center;vertical-align:bottom;">
                <p>Ditetapkan di : Mojokerto</p>
                <p>Pada Tanggal : {{ $tglSk }}</p>
                <br>
                <p style="font-weight:bold;">WALI KOTA MOJOKERTO,</p>
                <br><br><br>
                <p style="font-weight:bold;text-decoration:underline;">IKA PUSPITASARI</p>
            </td>
        </tr>
    </table>
</body>
</html>
