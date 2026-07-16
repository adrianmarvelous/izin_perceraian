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
            text-decoration: underline;
        }
        .no-surat {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 10px;
        }
        .tentang {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 15px;
            text-decoration: underline;
        }
        .rahmat {
            text-align: center;
            font-style: italic;
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 15px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
            text-decoration: underline;
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
            text-indent: -15px;
            padding-left: 35px;
        }
        .memutuskan {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 15px 0;
        }
        .isi-keputusan {
            text-align: justify;
            margin-left: 20px;
        }
        .isi-keputusan p {
            margin: 3px 0;
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
    </style>
</head>
<body>
    {{-- Kop --}}
    <table class="kop" style="text-align:center;">
        <tr>
            <td rowspan="5" style="width:15%;"><img src="{{ public_path('img/logo pemerintah kota mojokerto.png') }}" width="80" alt=""></td>
            <td style="font-size:18px;font-weight:bold;">WALI KOTA MOJOKERTO</td>
        </tr>
        <tr><td style="font-size:8pt;">Jalan Bhayangkara No.42, Kecamatan Kranggan, Kota Mojokerto, 61313</td></tr>
        <tr><td style="font-size:8pt;">Telepon (0321) 399600, Faksimile (0321) 399600</td></tr>
    </table>
    <hr class="hr-garis">
    <hr class="hr-garis2">

    {{-- Judul --}}
    <div class="judul">KEPUTUSAN</div>
    <div class="sub-judul">WALI KOTA MOJOKERTO</div>
    <div class="no-surat">NOMOR : {{ $nomorSk }}</div>
    <div class="tentang">TENTANG<br>PEMBERIAN IZIN PERCERAIAN</div>
    <div class="rahmat">DENGAN RAHMAT TUHAN YANG MAHA ESA<br>WALI KOTA MOJOKERTO</div>

    {{-- Membaca --}}
    <div class="section-title">Membaca</div>
    <div class="indent">
        : Laporan Hasil Mediasi Nomor: {{ $perceraian->nomor_surat ?? 'R.800.1.10.4/ /417.603.3/2026' }} tanggal {{ $perceraian->created_at ? $perceraian->created_at->locale('id')->translatedFormat('d F Y') : '........................' }} tentang Pertimbangan Izin Perceraian ASN yang diajukan oleh:
    </div>

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

    {{-- Menimbang --}}
    <div class="section-title" style="margin-top:15px;">Menimbang</div>
    <div class="menimbang">
        <p>a. Bahwa alasan-alasan yang dikemukakan oleh {{ $sebutan }}. {{ $pegawai->nama ?? '-' }} untuk melakukan perceraian itu dapat diterima oleh akal sehat dan tidak bertentangan dengan peraturan perundang-undangan yang berlaku;</p>
        <p>b. Pihak {{ ucfirst($pihakLawan) }} ({{ $namaPasangan }}) dan Pihak {{ $jk === 'L' ? 'Istri' : 'Suami' }} ({{ $pegawai->nama ?? '-' }}) sudah tidak lagi tinggal serumah selama ... (........) Tahun berturut-turut yang dibuktikan dengan surat pernyataan dari Kepala Kelurahan / Kepala Desa yang disahkan oleh Camat;</p>
        <p>c. Pihak {{ ucfirst($pihakLawan) }} ({{ $namaPasangan }}) tidak memberikan nafkah baik lahir maupun batin;</p>
        <p>d. Kedua belah pihak telah bersepakat untuk berpisah yang dibuktikan dengan surat pernyataan;</p>
        <p>e. Atasan langsung yang bersangkutan pada {{ $pegawai->opd ?? '-' }} telah memanggil kedua belah pihak ({{ ucfirst($pihakLawan) }} dan {{ $jk === 'L' ? 'Istri' : 'Suami' }}) untuk dilakukan mediasi, nasihat, dan bimbingan agar hubungan baik terjalin kembali, namun gagal.</p>
    </div>

    {{-- Mengingat --}}
    <div class="section-title">Mengingat</div>
    <div class="mengingat">
        <p>1. Undang-Undang Nomor 1 Tahun 1974 tentang Perkawinan (Lembaran Negara Republik Indonesia Tahun 1974 Nomor 1, Tambahan Lembaran Negara Nomor 3019) sebagaimana telah diubah dengan Undang-Undang Nomor 16 Tahun 2019 tentang Perubahan Atas Undang-Undang Nomor 1 Tahun 1974 tentang Perkawinan (Lembaran Negara Republik Indonesia Tahun 2019 Nomor 186, Tambahan Lembaran Negara Republik Indonesia Nomor 6401);</p>
        <p>2. Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara;</p>
        <p>3. Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2014 Nomor 244, Tambahan Lembaran Negara Republik Indonesia Nomor 5587) sebagaimana telah diubah beberapa kali terakhir dengan Undang-Undang Nomor 9 Tahun 2015 tentang Perubahan Kedua atas Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2015 Nomor 58, Tambahan Lembaran Negara Republik Indonesia Nomor 5679);</p>
        <p>4. Peraturan Pemerintah Nomor 10 Tahun 1983 tentang Izin Perkawinan Dan Perceraian Bagi Pegawai Negeri Sipil (Lembaran Negara Tahun 1983 Nomor 13, Tambahan Lembaran Negara Nomor 3250) jo Peraturan Pemerintah nomor 45 tahun 1990;</p>
    </div>

    {{-- Memperhatikan --}}
    <div class="section-title">Memperhatikan</div>
    <div class="memperhatikan">
        <p>: Surat Edaran Kepala Badan Administrasi Kepegawaian Negara Nomor: 48/SE/1990, tentang Petunjuk Pelaksanaan Peraturan Pemerintah Republik Indonesia Nomor 45 Tahun 1990.</p>
    </div>

    {{-- Memutuskan --}}
    <div class="memutuskan">MEMUTUSKAN:</div>

    <div class="section-title">Menetapkan</div>
    <div class="section-title" style="text-transform:uppercase;text-align:center;">Pertama</div>
    <div class="isi-keputusan">
        <p>Memberikan Izin kepada:</p>
        <table class="content-table">
            <tr><td class="lbl">1. Nama</td><td>: {{ $pegawai->nama ?? '-' }}</td></tr>
            <tr><td>2. NIP</td><td>: {{ $pegawai->nip ?? '-' }}</td></tr>
            <tr><td>3. Golongan</td><td>: {{ $golText }}</td></tr>
            <tr><td>4. Jabatan</td><td>: {{ $pegawai->jabatan ?? '-' }}</td></tr>
            <tr><td>5. Unit Kerja</td><td>: {{ $pegawai->opd ?? '-' }}</td></tr>
            <tr><td>6. Agama</td><td>: {{ $pegawai->agama ?? '-' }}</td></tr>
        </table>
        <p style="margin-top:5px;">Dikabulkan untuk melakukan perceraian dengan {{ $sebutanLawan }}:</p>
        <table class="content-table">
            <tr><td class="lbl">1. Nama</td><td>: {{ $namaPasangan }}</td></tr>
            <tr><td>2. Pekerjaan</td><td>: -</td></tr>
            <tr><td>3. Agama</td><td>: -</td></tr>
            <tr><td>4. Alamat</td><td>: -</td></tr>
        </table>
    </div>

    <div class="section-title" style="text-transform:uppercase;text-align:center;margin-top:15px;">Kedua</div>
    <div class="isi-keputusan">
        <p>Keputusan ini mulai berlaku sejak tanggal ditetapkan.</p>
    </div>

    <div class="section-title" style="text-transform:uppercase;text-align:center;margin-top:15px;">Ketiga</div>
    <div class="isi-keputusan">
        <p>Apabila dikemudian hari ternyata terdapat kekeliruan dalam keputusan ini, akan diadakan perbaikan sebagaimana mestinya.</p>
    </div>

    <div class="isi-keputusan" style="margin-top:15px;">
        <p>ASLI Keputusan ini diberikan kepada Pegawai Negeri Sipil yang bersangkutan untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
    </div>

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
