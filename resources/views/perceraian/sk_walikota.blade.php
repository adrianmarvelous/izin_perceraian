@extends('layouts.sneat')

@section('title', 'SK Wali Kota - Izin Perceraian')

@section('content')
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

    // Default konten SK
    $defaultMenimbang = '<ol type="a" style="margin:0;padding-left:20px;">
    <li>Bahwa alasan-alasan yang dikemukakan oleh ' . $sebutan . '. ' . $pegawai->nama . ' untuk melakukan perceraian itu dapat diterima oleh akal sehat dan tidak bertentangan dengan peraturan perundang-undangan yang berlaku;</li>
    <li>Pihak ' . ucfirst($pihakLawan) . ' (' . $namaPasangan . ') dan Pihak ' . ($jk === 'L' ? 'Istri' : 'Suami') . ' (' . $pegawai->nama . ') sudah tidak lagi tinggal serumah selama ... (........) Tahun berturut-turut yang dibuktikan dengan surat pernyataan dari Kepala Kelurahan / Kepala Desa yang disahkan oleh Camat;</li>
    <li>Pihak ' . ucfirst($pihakLawan) . ' (' . $namaPasangan . ') tidak memberikan nafkah baik lahir maupun batin;</li>
    <li>Kedua belah pihak telah bersepakat untuk berpisah yang dibuktikan dengan surat pernyataan;</li>
    <li>Atasan langsung yang bersangkutan pada ' . $pegawai->opd . ' telah memanggil kedua belah pihak (' . ucfirst($pihakLawan) . ' dan ' . ($jk === 'L' ? 'Istri' : 'Suami') . ') untuk dilakukan mediasi, nasihat, dan bimbingan agar hubungan baik terjalin kembali, namun gagal.</li>
</ol>';

    $defaultMengingat = '<ol style="margin:0;padding-left:20px;">
    <li>Undang-Undang Nomor 1 Tahun 1974 tentang Perkawinan (Lembaran Negara Republik Indonesia Tahun 1974 Nomor 1, Tambahan Lembaran Negara Nomor 3019) sebagaimana telah diubah dengan Undang-Undang Nomor 16 Tahun 2019 tentang Perubahan Atas Undang-Undang Nomor 1 Tahun 1974 tentang Perkawinan (Lembaran Negara Republik Indonesia Tahun 2019 Nomor 186, Tambahan Lembaran Negara Republik Indonesia Nomor 6401);</li>
    <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara;</li>
    <li>Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran Negara Republik Indonesia Nomor 5587) sebagaimana telah diubah beberapa kali terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang Perubahan Kedua atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58, Tambahan Lembaran Negara Republik Indonesia Nomor 5679);</li>
    <li>Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan Dan Perceraian Bagi Pegawai Negeri Sipil (Lembaran Negara Tahun 1983 Nomor 13, Tambahan Lembaran Negara Nomor 3250) jo Peraturan Pemerintah nomor 45 tahun 1990;</li>
</ol>';

    $defaultMemperhatikan = 'Surat Edaran Kepala Badan Administrasi Kepegawaian Negara Nomor: 48/SE/1990, tentang Petunjuk Pelaksanaan Peraturan Pemerintah Republik Indonesia Nomor 45 Tahun 1990.';

    $defaultKedua = 'Keputusan ini mulai berlaku sejak tanggal ditetapkan.';

    $defaultKetiga = '<p>Apabila dikemudian hari ternyata terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan sebagaimana mestinya.</p>
<p>ASLI Keputusan ini diberikan kepada Pegawai Negeri Sipil yang bersangkutan untuk diketahui dan dipergunakan sebagaimana mestinya.</p>';
@endphp

<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
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
    .sk-body .judul {
        text-align: center;
        font-weight: bold;
        font-size: 14pt;
        margin-bottom: 5px;
    }
    .sk-body .sub-judul {
        text-align: center;
        font-weight: bold;
        font-size: 12pt;
        margin-bottom: 5px;
        text-decoration: underline;
    }
    .sk-body .no-surat {
        text-align: center;
        font-size: 12pt;
        margin-bottom: 10px;
    }
    .sk-body .tentang {
        text-align: center;
        font-weight: bold;
        font-size: 12pt;
        margin-bottom: 15px;
        text-decoration: underline;
    }
    .sk-body .rahmat {
        text-align: center;
        font-style: italic;
        font-weight: bold;
        font-size: 11pt;
        margin-bottom: 15px;
    }
    .sk-body .content-table {
        width: 100%;
        border-collapse: collapse;
        margin-left: 10px;
    }
    .sk-body .content-table td {
        padding: 1px 5px;
        vertical-align: top;
    }
    .sk-body .content-table .lbl {
        width: 100px;
    }
    .sk-body .indent {
        margin-left: 20px;
        text-align: justify;
    }
    .sk-body .memutuskan {
        text-align: center;
        font-weight: bold;
        font-size: 12pt;
        margin: 15px 0;
    }
    .sk-body .tembusan {
        margin-top: 20px;
    }
    .sk-body .tembusan p {
        margin: 1px 0;
    }
    .sk-body .paraf {
        margin-top: 20px;
        border: 1px solid #000;
        padding: 10px;
        font-size: 10pt;
    }
    .sk-body .paraf table {
        width: 100%;
        border-collapse: collapse;
    }
    .sk-body .paraf td {
        padding: 2px 10px;
        vertical-align: top;
    }
    .btn-pdf-container {
        margin: 20px 0;
        text-align: center;
    }
    .no-break {
        page-break-inside: avoid !important;
    }
    .note-editor .note-editable {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
        line-height: 1.5;
    }
    @media print {
        .btn-pdf-container, .card-footer, .no-print { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-body { padding: 0 !important; }
        .note-editor { display: none !important; }
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body sk-body">

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
                </table>

                <form id="formSkKonten" method="POST" action="{{ route('perceraian.sk.simpan-konten', $perceraian) }}">
                    @csrf

                    <table style="width:100%;">
                        <tr>
                            <td style="vertical-align: top;width:10%">Membaca</td>
                            <td style="vertical-align: top;width:4%">:</td>
                            <td style="vertical-align: top;">
                                <div class="no-break">
                                <p style="margin:0;text-align:justify;">Laporan Hasil Mediasi Nomor: {{ $perceraian->nomor_surat ?? 'R.800.1.10.4/ /417.603.3/2026' }} tanggal {{ $perceraian->created_at ? $perceraian->created_at->locale('id')->translatedFormat('d F Y') : '........................' }} tentang Pertimbangan Izin Perceraian ASN yang diajukan oleh:</p>
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
                                <table class="content-table">
                                    <tr><td class="lbl">1. Nama</td><td>: {{ $namaPasangan }}</td></tr>
                                    <tr><td>2. Pekerjaan</td><td>: {{ $perceraian->pegawai->pekerjaan ?? '-' }}</td></tr>
                                    <tr><td>3. Agama</td><td>: -</td></tr>
                                    <tr><td>4. Alamat</td><td>: -</td></tr>
                                </table>
                                <br>
                                <textarea id="sk_membaca" name="sk_membaca" class="form-control sk-summernote">{!! old('sk_membaca', $perceraian->sk_membaca) ?: '' !!}</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Menimbang</td>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <textarea id="sk_menimbang" name="sk_menimbang" class="form-control sk-summernote">{!! old('sk_menimbang', $perceraian->sk_menimbang) ?: $defaultMenimbang !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Mengingat</td>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <div class="no-break">
                                <textarea id="sk_mengingat" name="sk_mengingat" class="form-control sk-summernote">{!! old('sk_mengingat', $perceraian->sk_mengingat) ?: $defaultMengingat !!}</textarea>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">Memperhatikan</td>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <textarea id="sk_memperhatikan" name="sk_memperhatikan" class="form-control sk-summernote">{!! old('sk_memperhatikan', $perceraian->sk_memperhatikan) ?: $defaultMemperhatikan !!}</textarea>
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
                                <textarea id="sk_pertama" name="sk_pertama" class="form-control sk-summernote">{!! old('sk_pertama', $perceraian->sk_pertama) ?: '' !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">KEDUA</td>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <textarea id="sk_kedua" name="sk_kedua" class="form-control sk-summernote">{!! old('sk_kedua', $perceraian->sk_kedua) ?: $defaultKedua !!}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">KETIGA</td>
                            <td style="vertical-align: top;">:</td>
                            <td>
                                <textarea id="sk_ketiga" name="sk_ketiga" class="form-control sk-summernote">{!! old('sk_ketiga', $perceraian->sk_ketiga) ?: $defaultKetiga !!}</textarea>
                            </td>
                        </tr>
                    </table>

                    <div class="text-center mt-3 no-print">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan Konten
                        </button>
                    </div>
                </form>

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
            </div>

            <div class="card-footer no-print">
                <div class="d-flex gap-2">
                    <form action="{{ route('perceraian.sk.simpan', $perceraian) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Terbitkan SK Walikota ini? Status akan berubah menjadi Rekomendasi dari Walikota.')">
                            <i class="bx bx-check"></i> Simpan &amp; Terbitkan
                        </button>
                    </form>
                    <a href="{{ route('perceraian.sk.pdf', $perceraian) }}" class="btn btn-primary">
                        <i class="bx bx-printer"></i> Print PDF
                    </a>
                    <a href="{{ route('perceraian.dokumen', $perceraian) }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
<script>
$(function () {
    $('.sk-summernote').summernote({
        height: 200,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['undo', 'redo', 'codeview']],
        ],
        placeholder: 'Tulis konten di sini...'
    });

    $('#formSkKonten').on('submit', function () {
        $('.sk-summernote').each(function () {
            $(this).summernote('code');
        });
    });
});
</script>
@endpush
