<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Panggilan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px double #000;
        }
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11pt;
        }
        .content {
            text-align: justify;
        }
        .content p {
            margin-bottom: 10px;
            text-indent: 40px;
        }
        .content .no-indent {
            text-indent: 0;
        }
        .kop {
            text-align: center;
            margin-bottom: 5px;
        }
        .kop h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop p {
            font-size: 11pt;
        }
        .hr-double {
            border: none;
            border-top: 3px double #000;
            margin: 5px 0 20px 0;
        }
        .hr-single {
            border: none;
            border-top: 1px solid #000;
            margin: 3px 0;
        }
        .meta {
            margin-bottom: 20px;
        }
        .meta table {
            border-collapse: collapse;
        }
        .meta td {
            padding: 2px 10px 2px 0;
            vertical-align: top;
        }
        .meta td:first-child {
            width: 100px;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
        .ttd div {
            margin-bottom: 80px;
        }
    </style>
</head>
<body>
    <div class="kop">
        <h3>PEMERINTAH KOTA {{ strtoupper($perceraian->pegawai->opd ?? '...') }}</h3>
        <hr class="hr-double">
    </div>

    <div style="text-align:center; margin-bottom:25px;">
        <h4 style="text-decoration:underline; text-transform:uppercase;">SURAT PANGGILAN</h4>
        <p>Nomor: {{ $perceraian->nomor_surat ?? '...' }}</p>
    </div>

    <div class="meta">
        <table>
            <tr><td>Kepada</td><td>: {{ $pihak === 'istri' ? 'Istri' : 'Suami' }} dari</td></tr>
            <tr><td></td><td><strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong></td></tr>
            <tr><td></td><td>{{ $perceraian->pegawai->nip ?? '-' }}</td></tr>
            <tr><td></td><td>{{ $perceraian->pegawai->jabatan ?? '-' }}</td></tr>
            <tr><td></td><td>{{ $perceraian->pegawai->opd ?? '-' }}</td></tr>
            <tr><td>di</td><td>Tempat</td></tr>
        </table>
    </div>

    <div class="content">
        <p>Sehubungan dengan adanya permohonan izin perceraian yang diajukan oleh <strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong> NIP {{ $perceraian->pegawai->nip ?? '-' }}, dengan ini kami mengundang saudara/i untuk hadir pada:</p>
        <table style="margin:15px 0 15px 40px;">
            <tr><td style="width:120px;">Hari/Tanggal</td><td>: {{ $perceraian->tanggal_pemanggilan ? $perceraian->tanggal_pemanggilan->locale('id')->translatedFormat('l, d F Y') : '-' }}</td></tr>
            <tr><td>Waktu</td><td>: 09.00 WITA - Selesai</td></tr>
            <tr><td>Tempat</td><td>: Kantor {{ $perceraian->pegawai->opd ?? '...' }}</td></tr>
        </table>

        <p>Demikian surat panggilan ini dibuat untuk dilaksanakan sebagaimana mestinya. Atas perhatian dan kehadirannya diucapkan terima kasih.</p>
    </div>

    <div class="ttd">
        <div>
            <p>{{ $perceraian->pegawai->opd ?? '...' }}, {{ $perceraian->tanggal_pemanggilan ? $perceraian->tanggal_pemanggilan->locale('id')->translatedFormat('d F Y') : '...' }}</p>
            <br><br><br>
            <p><strong>{{ $perceraian->pegawai->nama ?? '...' }}</strong></p>
            <p>NIP. {{ $perceraian->pegawai->nip ?? '...' }}</p>
        </div>
    </div>
</body>
</html>
