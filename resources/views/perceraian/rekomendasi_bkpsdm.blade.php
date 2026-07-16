@extends('layouts.sneat')

@section('title', 'Rekomendasi BKPSDM')

@section('content')
@php
    $pegawai = $perceraian->pegawai;
    $golongan = $pegawai->golongan;
    $golText = $golongan ? $golongan->gol_ruang : '-';
    $pangkat = $golongan ? $golongan->pangkat : '';
    $jk = $pegawai->jk ?? 'L';
    $pihakLawan = $jk === 'L' ? 'Suami' : 'Istri';
    $sebutanLawan = $jk === 'L' ? 'istrinya' : 'suaminya';
    $namaPasangan = $perceraian->nama_pasangan ?? '-';
    $nomorSurat = $perceraian->nomor_surat ?? 'R.800.1.6.2/ /417.603.3/2025';
    $tglSk = now()->locale('id')->translatedFormat('d F Y');
    $tahun = now()->format('Y');
@endphp

<style>
    .sk-body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        line-height: 1.5;
        color: #000;
        padding: 30px 40px;
    }
    .sk-body table.kop {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 5px;
    }
    .sk-body table.kop td {
        padding: 2px 5px;
        vertical-align: top;
    }
    .sk-body .hr-garis { border: none; border-top: 3px solid #000; margin: 4px 0; }
    .sk-body .hr-garis2 { border: none; border-top: 1px solid #000; margin: 0 0 20px 0; }
    .sk-body .header-surat table {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 15px;
    }
    .sk-body .header-surat td {
        padding: 1px 3px;
        vertical-align: top;
    }
    .sk-body .header-surat .label {
        width: 80px;
    }
    .sk-body .tujuan {
        margin-bottom: 15px;
    }
    .sk-body .isi {
        text-align: justify;
        margin-bottom: 10px;
    }
    .sk-body .data-table {
        border-collapse: collapse;
        width: 100%;
        margin-left: 20px;
        margin-bottom: 10px;
    }
    .sk-body .data-table td {
        padding: 1px 5px;
        vertical-align: top;
    }
    .sk-body .data-table .lbl {
        width: 120px;
    }
    .sk-body .nomor-lampiran {
        margin-bottom: 15px;
    }
    .sk-body .nomor-lampiran table {
        border-collapse: collapse;
        width: 100%;
    }
    .sk-body .nomor-lampiran td {
        padding: 1px 3px;
        vertical-align: top;
    }
    .sk-body .nomor-lampiran .label {
        width: 80px;
    }
    .btn-pdf-container {
        margin: 20px 0;
        text-align: center;
    }
    @media print {
        .btn-pdf-container, .card-footer, .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-body { padding: 0 !important; }
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body sk-body">
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

                {{-- Nomor & Lampiran --}}
                <div class="nomor-lampiran">
                    <table>
                        <tr><td class="label">Nomor</td><td>: {{ $nomorSurat }}</td></tr>
                        <tr><td>Sifat</td><td>: Rahasia</td></tr>
                        <tr><td>Lampiran</td><td>: 3 (tiga) Lampiran</td></tr>
                        <tr><td>Perihal</td><td>: <strong>Rekomendasi Penerbitan Izin Untuk Melakukan Perceraian PNS</strong></td></tr>
                    </table>
                </div>

                <div class="tujuan" style="text-align:right;">
                    <p>Mojokerto, {{ $tglSk }}</p>
                </div>

                <div class="tujuan">
                    <p>Yth. Sdr. Kepala {{ $pegawai->opd ?? '-' }}</p>
                    <p>di</p>
                    <p><strong>MOJOKERTO</strong></p>
                </div>

                {{-- Isi Surat --}}
                <div class="isi">
                    <p>Menindaklanjuti Surat Saudara Nomor: {{ $perceraian->nomor_surat ?? '800.1.13.1/ /417.502.1/' . $tahun }} perihal Permohonan Izin Melakukan Perceraian PNS a.n. {{ $pegawai->nama ?? '-' }}, hasil mediasi, serta merujuk Peraturan Wali Kota Nomor 35 Tahun 2025 tentang Perubahan Atas Peraturan Wali Kota Nomor 33 Tahun 2023 tentang Pendelegasian Wewenang Menetapkan dan Pemberian Kuasa Menandatangani Surat Keputusan Serta Surat-Surat Lainnya di Bidang Kepegawaian, bersama ini kami sampaikan beberapa hal sebagai berikut:</p>
                </div>

                <div class="isi">
                    <p>1. Bahwa berdasarkan hasil mediasi antara:</p>
                </div>

                {{-- Data Penggugat --}}
                <table class="data-table">
                    <tr><td colspan="2"><strong>a. Pihak Penggugat ({{ $jk === 'L' ? 'Suami' : 'Istri' }}):</strong></td></tr>
                    <tr><td class="lbl">Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
                    <tr><td>NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
                    <tr><td>Pangkat</td><td>: {{ $pangkat ? $pangkat . ' (' . $golText . ')' : '(' . $golText . ')' }}</td></tr>
                    <tr><td>Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }} pada {{ $pegawai->opd ?? '-' }}</td></tr>
                </table>

                <div class="isi" style="margin-left:20px;">dengan</div>

                {{-- Data Tergugat --}}
                <table class="data-table">
                    <tr><td colspan="2"><strong>b. Pihak Tergugat ({{ ucfirst($pihakLawan) }}):</strong></td></tr>
                    <tr><td class="lbl">Nama</td><td>: {{ $namaPasangan }}</td></tr>
                    <tr><td>Pekerjaan</td><td>: -</td></tr>
                </table>

                <div class="isi" style="margin-left:20px;">
                    disimpulkan informasi bahwa kedua belah pihak tidak dapat dirukunkan kembali.
                </div>

                <div class="isi">
                    <p>2. Bersadarkan ketentuan Surat Edaran Kepala Badan Administrasi Kepegawaian Negara Nomor: 48/SE/1990 tentang Petunjuk Pelaksanaan Peraturan Pemerintah Nomor 45 Tahun 1990 tentang Perubahan Atas Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan Dan Perceraian Bagi Pegawai Negeri Sipil dan hasil proses mediasi, kasus tersebut telah memenuhi kriteria untuk dapat diterbitkan Surat Izin Perceraian PNS, yakni:</p>
                    <p style="margin-left:20px;">Salah satu pihak meninggalkan pihak lain selama dua tahun berturut-turut tanpa izin pihak lain dan tanpa alasan yang sah serta tanpa memberikan nafkah lahir maupun batin atau karena hal lain diluar kemampuannya.</p>
                </div>

                <div class="isi">
                    <p>3. Bahwa merujuk pada Peraturan Wali Kota Mojokerto Nomor 35 Tahun 2025 Tentang Perubahan Atas Peraturan Wali Kota Nomor 33 Tahun 2023 Tentang Pendelegasian Wewenang Menetapkan dan Pemberian Kuasa Menandatangani Surat Keputusan Serta Surat-Surat Lainnya di Bidang Kepegawaian, maka Surat Izin untuk melakukan perceraian dapat diterbitkan oleh Kepala Perangkat Daerah masing-masing.</p>
                </div>

                <div class="isi">
                    <p>Demikian yang dapat disampaikan, atas perhatiannya diucapkan terima kasih.</p>
                </div>

                {{-- Tanda Tangan --}}
                <table style="width:100%;margin-top:30px;">
                    <tr>
                        <td style="width:55%;"></td>
                        <td style="width:45%;text-align:center;">
                            <p>Kepala Badan Kepegawaian dan Pengembangan</p>
                            <p>Sumber Daya Manusia</p>
                            <p>Kota Mojokerto</p>
                            <br><br><br>
                            <p style="font-weight:bold;text-decoration:underline;">MURAJI, S.T., M.Si.</p>
                            <p>Pembina Utama Muda (IV/c)</p>
                            <p>NIP. 19681115 199202 1 002</p>
                        </td>
                    </tr>
                </table>

            </div>

            <div class="card-footer no-print">
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
