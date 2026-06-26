@extends('layouts.sneat')

@section('title', 'Laporan Hasil Mediasi')

@section('content')
@php
    $pegawai = $perceraian->pegawai;
    $golongan = $pegawai->golongan;
    $golText = $golongan ? $golongan->gol_ruang : '-';
    $pangkat = $golongan ? $golongan->pangkat : '';

    $nomorSurat = $perceraian->nomor_surat ?? 'R.800.1.10.4/31/417.603.3/2026';

    // Suami/Istri berdasarkan jenis kelamin pegawai
    $jk = $pegawai->jk ?? 'L';
    $pihakLawan = $jk === 'L' ? 'Istri' : 'Suami'; // pasangan
    $pihakPegawai = $jk === 'L' ? 'Suami' : 'Istri'; // pegawai
    $pihakLawanTeks = $jk === 'L' ? 'istrinya' : 'suaminya';
    $sebutan = $jk === 'L' ? 'Saudara' : 'Saudari';

    // Data pasangan
    $namaPasangan = $perceraian->nama_pasangan ?? '-';

    // Questions data
    $questions = [
        'q_sehat' => '1. Apakah ' . $sebutan . ' dalam kondisi sehat?',
        'q_menikah' => '2. Sudah menikah berapa lama?',
        'q_serumah' => '3. Apakah ' . $sebutan . ' sudah tidak tinggal serumah?',
        'q_alasan' => '4. Apa yang mendasari ' . $sebutan . ' memutuskan untuk mengajukan gugatan perceraian?',
        'q_komunikasi' => '5. Apakah masih ada komunikasi?',
        'q_yakin' => '6. Apakah ' . $sebutan . ' sudah yakin untuk berpisah?',
    ];
@endphp

<style>
    .laporan-body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        line-height: 1.5;
        color: #000;
        padding: 20px 30px;
    }
    .laporan-body table.kop {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 5px;
    }
    .laporan-body table.kop td {
        padding: 2px 5px;
        vertical-align: top;
    }
    .laporan-body .hr-garis { border: none; border-top: 3px solid #000; margin: 4px 0; }
    .laporan-body .hr-garis2 { border: none; border-top: 1px solid #000; margin: 0 0 15px 0; }
    .laporan-body .header-surat {
        margin-bottom: 20px;
    }
    .laporan-body .header-surat table {
        border-collapse: collapse;
        width: 100%;
    }
    .laporan-body .header-surat td {
        padding: 1px 5px;
        vertical-align: top;
    }
    .laporan-body .header-surat .label {
        width: 100px;
    }
    .laporan-body .tujuan {
        margin-bottom: 15px;
    }
    .laporan-body .isi-section {
        text-align: justify;
        margin-bottom: 15px;
    }
    .laporan-body .section-title {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 8px;
    }
    .laporan-body .data-pegawai table {
        border-collapse: collapse;
        width: 60%;
        margin-left: 20px;
        margin-bottom: 10px;
    }
    .laporan-body .data-pegawai td {
        padding: 1px 5px;
        vertical-align: top;
    }
    .laporan-body .data-pegawai .lbl {
        width: 100px;
    }
    .btn-pdf-container {
        margin: 20px 0;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body laporan-body">

                {{-- Kop --}}
                <table class="kop" style="text-align:center;">
                    <tr>
                        <td rowspan="5" style="width:15%;"><img src="{{ asset('img/logo pemerintah kota mojokerto.png') }}" width="80" alt=""></td>
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
                    Bahwa dari hasil mediasi/pembinaan perceraian sebagaimana tertuang pada Berita Acara Mediasi, dapat diketahui beberapa informasi sebagai berikut;
                    <ol style="margin-top:5px;">
                        <li>Pihak {{ ucfirst($pihakLawan) }} ({{ $namaPasangan }}) dan Pihak {{ ucfirst($pihakPegawai) }} ({{ $pegawai->nama ?? '-' }}) sudah tidak lagi tinggal serumah;</li>
                        <li>Kedua belah pihak telah bersepakat untuk berpisah;</li>
                        <li>Atasan langsung yang bersangkutan telah memanggil kedua belah pihak untuk dilakukan mediasi, nasihat, dan bimbingan agar hubungan baik terjalin kembali, namun mediasi gagal.</li>
                    </ol>
                </div>

                {{-- III. Analisis dan Pembahasan --}}
                <div class="section-title">III. Analisis dan Pembahasan</div>
                <div class="isi-section">
                    <ol>
                        <li>
                            {{ $sebutan }}. {{ $pegawai->nama ?? '-' }} telah mengikuti prosedur Kepegawaian sesuai dengan Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan dan Perceraian Bagi Pegawai Negeri Sipil, sebagaimana telah diubah dengan Peraturan Pemerintah Nomor: 45 Tahun 1990, terutama pasal 3 ayat (1) yang menyatakan bahwa "Pegawai Negeri Sipil yang akan Melakukan perceraian wajib memperoleh ijin atau Surat Keterangan lebih dahulu dari Pejabat."
                        </li>
                        <li>
                            Berdasarkan fakta dan data pada poin II, telah memenuhi alasan-alasan yang tertuang dalam Surat Edaran Kepala BKN Nomor 8/SE/1983 tentang izin perkawinan dan perceraian.
                        </li>
                    </ol>
                </div>

                {{-- IV. Kesimpulan --}}
                <div class="section-title">IV. Kesimpulan</div>
                <div class="isi-section">
                    <ol>
                        <li>
                            Bahwa berdasarkan fakta-fakta dan informasi yang dihimpun pada seluruh proses pembinaan/mediasi perceraian, ASN atas nama {{ $pegawai->nama ?? '-' }}, NIP. {{ $pegawai->nip ?? '-' }}, Golongan {{ $golText }}, Jabatan {{ $pegawai->jabatan ?? '-' }}, Unit Kerja {{ $pegawai->opd ?? '-' }}, telah memenuhi kriteria sebagaimana diatur dalam peraturan yang berlaku.
                        </li>
                        <li>
                            Bahwa berdasarkan fakta-fakta dan informasi yang dihimpun pada seluruh proses pembinaan/mediasi perceraian, terlihat bahwa kedua belah pihak sudah tidak bisa dirukunkan atau disatukan lagi.
                        </li>
                    </ol>
                </div>

                {{-- V. Saran Tindak --}}
                <div class="section-title">V. Saran Tindak</div>
                <div class="isi-section">
                    Dengan mempelajari alasan-alasan dan keterangan yang didapat pada saat pembinaan, maka kiranya agar dapat diterbitkan Surat Izin Perceraian.
                </div>

                {{-- Tanda Tangan --}}
                <table style="width:100%;margin-top:40px;">
                    <tr>
                        <td style="width:50%;"></td>
                        <td style="width:50%;text-align:center;">
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

            </div>

            <div class="card-footer">
                <div class="d-flex gap-2">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bx bx-printer"></i> Cetak / PDF
                    </button>
                    <a href="{{ route('perceraian.dokumen', $perceraian) }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
