<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Izin Perceraian</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000;
            padding: 20px 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h2 {
            font-size: 18pt;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11pt;
        }
        .periode {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .text-left { text-align: left; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11pt;
        }
        .footer .ttd {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KOTA MOJOKERTO</h2>
        <h3>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h3>
        <p>Jalan Bhayangkara No.42, Kecamatan Kranggan, Kota Mojokerto, 61313</p>
        <hr style="margin-top:5px;">
    </div>

    <div class="periode">
        <strong>LAPORAN STATISTIK IZIN PERCERAIAN</strong><br>
        Periode: {{ \Carbon\Carbon::parse($startDate)->locale('id')->translatedFormat('d F Y') }} 
        s.d. {{ \Carbon\Carbon::parse($endDate)->locale('id')->translatedFormat('d F Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th class="text-left">Status</th>
                <th style="width:120px">Jumlah</th>
                <th style="width:120px">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($countPerStatus as $id => $item)
                @if ($item['total'] > 0)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{ $item['nama'] }}</td>
                    <td>{{ $item['total'] }}</td>
                    <td>{{ $totalKeseluruhan > 0 ? number_format(($item['total'] / $totalKeseluruhan) * 100, 1) : 0 }}%</td>
                </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight:bold;">
                <td colspan="2" class="text-left">Total</td>
                <td>{{ $totalKeseluruhan }}</td>
                <td>100%</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Mojokerto, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p>a.n. WALI KOTA MOJOKERTO</p>
        <p>KEPALA BKPSDM</p>
        <div class="ttd">
            <p style="font-weight:bold;text-decoration:underline;">MURAJI, S.Sos., M.M.</p>
            <p>Pembina Utama Muda</p>
            <p>NIP. 19681115 199202 1 002</p>
        </div>
    </div>
</body>
</html>
