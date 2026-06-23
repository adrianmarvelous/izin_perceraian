<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengajuan Izin Perceraian</title>
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
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11pt;
        }
        .title-section {
            text-align: center;
            margin: 25px 0;
        }
        .title-section h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .info-table td {
            padding: 6px 10px;
            vertical-align: top;
        }
        .info-table .label {
            width: 200px;
            font-weight: bold;
        }
        .info-table .separator {
            width: 20px;
        }
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            margin: 20px 0 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
        }
        .dokumen-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .dokumen-table th,
        .dokumen-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            font-size: 11pt;
        }
        .dokumen-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .dokumen-table .status-yes {
            text-align: center;
            font-weight: bold;
        }
        .dokumen-table .status-no {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .footer .date {
            margin-bottom: 80px;
        }
        .footer .name {
            font-weight: bold;
            text-decoration: underline;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 10px;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 11pt;
        }
        .print-btn {
            display: block;
            text-align: center;
            margin: 20px 0;
        }
        .print-btn button {
            padding: 10px 30px;
            font-size: 14pt;
            cursor: pointer;
            background: #696cff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
        .print-btn button:hover {
            background: #5a5cdb;
        }
        @media print {
            .print-btn { display: none; }
            body { padding: 20px; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body>
    <div class="print-btn">
        <button onclick="window.print()"><i class="bx bx-printer"></i> Cetak / Simpan PDF</button>
    </div>

    <!-- Kop Surat -->
    <div class="header">
        <h1>Pemerintah Kota Mojokerto</h1>
        <h2>Bukti Pengajuan Izin Perceraian</h2>
        <p>Nomor: {{ $perceraian->id }}/PC/{{ $perceraian->created_at->format('m/Y') }}</p>
    </div>

    <div class="title-section">
        <h3>DATA PEMOHON</h3>
    </div>

    <!-- Data Pegawai -->
    <table class="info-table">
        <tr>
            <td class="label">Nama Pegawai</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIP</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->jabatan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Unit Kerja / OPD</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->opd ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->jk == 'L' ? 'Laki-laki' : ($perceraian->pegawai->jk == 'P' ? 'Perempuan' : '-') }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Menikah</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->pegawai->status_menikah ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">DATA PERCERAIAN</div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Pasangan</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->nama_pasangan ?? $perceraian->pegawai->nama_pasangan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Sebagai</td>
            <td class="separator">:</td>
            <td>{{ ucfirst($perceraian->sebagai) }}</td>
        </tr>
        <tr>
            <td class="label">Status Pengajuan</td>
            <td class="separator">:</td>
            <td><span class="status-badge">{{ strtoupper($perceraian->statusIzin?->nama ?? 'Draft') }}</span></td>
        </tr>
        <tr>
            <td class="label">Tanggal Pengajuan</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->created_at->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Catatan</td>
            <td class="separator">:</td>
            <td>{{ $perceraian->catatan ?? '-' }}</td>
        </tr>
    </table>

    @if ($perceraian->dokumen->count() > 0)
    <div class="section-title">KELENGKAPAN DOKUMEN</div>

    <table class="dokumen-table">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Nama Dokumen</th>
                <th style="width:100px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perceraian->dokumen as $i => $dok)
            <tr>
                <td style="text-align:center;">{{ $loop->iteration }}</td>
                <td>{{ $dok->nama_dokumen }}</td>
                <td class="{{ $dok->status ? 'status-yes' : 'status-no' }}">
                    {{ $dok->status ? '✓ LENGKAP' : '✗ BELUM' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <div class="date">{{ $perceraian->created_at->format('d F Y') }}</div>
        <div>Mengetahui,</div>
        <div style="margin-top:5px; font-weight:bold;">{{ $perceraian->pegawai->opd ?? 'Pimpinan OPD' }}</div>
        <br><br>
        <div class="name">{{ Auth::user()->name ?? '-' }}</div>
        <div>{{ Auth::user()->hasRole('admin') ? 'Admin' : 'Operator' }}</div>
    </div>
</body>
</html>
