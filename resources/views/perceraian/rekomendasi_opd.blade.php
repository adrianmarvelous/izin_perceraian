@extends('layouts.sneat')

@section('title', 'Rekomendasi ke OPD Asal')

@section('content')
@php
    $pegawai = $perceraian->pegawai;
    $golongan = $pegawai->golongan;
    $golText = $golongan ? $golongan->gol_ruang : '-';
    $pangkat = $golongan ? $golongan->pangkat : '';

    $jk = $pegawai->jk ?? 'L';
    $pihakLawan = $jk === 'L' ? 'Istri' : 'Suami';
    $pihakPegawai = $jk === 'L' ? 'Suami' : 'Istri';
    $pihakLawanTeks = $jk === 'L' ? 'istrinya' : 'suaminya';
    $sebutan = $jk === 'L' ? 'Saudara' : 'Saudari';
    $namaPasangan = $perceraian->nama_pasangan ?? '-';
    $sebagaiTeks = $perceraian->sebagai === 'penggugat' ? 'Penggugat' : 'Tergugat';
    $sebagaiPegawai = $jk === 'L' ? 'Suami' : 'Istri';
    $sebagaiPasangan = $jk === 'L' ? 'Istri' : 'Suami';
@endphp

<style>
    .body-rekomendasi {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        line-height: 1.5;
        color: #000;
        padding: 20px 30px;
    }
    .body-rekomendasi table.kop {
        border-collapse: collapse;
        width: 100%;
        margin-bottom: 5px;
    }
    .body-rekomendasi table.kop td {
        padding: 2px 5px;
        vertical-align: top;
    }
    .body-rekomendasi .hr-garis { border: none; border-top: 3px solid #000; margin: 4px 0; }
    .body-rekomendasi .hr-garis2 { border: none; border-top: 1px solid #000; margin: 0 0 15px 0; }
    .body-rekomendasi .header-surat { margin-bottom: 20px; }
    .body-rekomendasi .header-surat table { border-collapse: collapse; width: 100%; }
    .body-rekomendasi .header-surat td { padding: 1px 5px; vertical-align: top; }
    .body-rekomendasi .header-surat .label { width: 120px; }
    .body-rekomendasi .tujuan { margin-bottom: 15px; }
    .body-rekomendasi .isi-section { text-align: justify; margin-bottom: 12px; }
    .body-rekomendasi .data-pegawai table { border-collapse: collapse; width: 70%; margin-left: 20px; margin-bottom: 10px; }
    .body-rekomendasi .data-pegawai td { padding: 1px 5px; vertical-align: top; }
    .body-rekomendasi .data-pegawai .lbl { width: 100px; }
    .body-rekomendasi ol { padding-left: 25px; }
    .body-rekomendasi ol li { margin-bottom: 10px; text-align: justify; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body body-rekomendasi">

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

                {{-- Isi Surat --}}
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
                <div class="d-flex gap-2 flex-wrap">
                    <form action="{{ route('perceraian.rekomendasi-opd.simpan', $perceraian) }}" method="POST" style="display:inline" id="formKirim">
                        @csrf
                        <button type="button" class="btn btn-success" onclick="konfirmasiKirim()">
                            <i class="bx bx-send"></i> Kirim Rekomendasi
                        </button>
                    </form>
                    <a href="{{ route('perceraian.rekomendasi-opd.pdf', $perceraian) }}" target="_blank" class="btn btn-primary">
                        <i class="bx bx-file-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('perceraian.dokumen', $perceraian) }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function konfirmasiKirim() {
    Swal.fire({
        title: 'Kirim Rekomendasi?',
        text: 'Rekomendasi ini akan dikirim ke OPD Asal dan status pengajuan akan diubah.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#697a8d',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formKirim').submit();
        }
    });
}
</script>
@endpush
