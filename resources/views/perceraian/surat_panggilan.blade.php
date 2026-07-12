<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemanggilan</title>
</head>
<body>
    <table style="text-align:center;width:100%">
        <tr>
            <td rowspan="6" style="width:20%"><img src="{{public_path('img/logo pemerintah kota mojokerto.png')}}" width="100" alt=""></td>
            <td style="width:80%;font-size:24px">PEMERINTAH KOTA MOJOKERTO</td>
        </tr>
        <tr>
            <td style="font-size:24px"><strong>BADAN KEPEGAWAIAN DAN PENGEMBANGAN</strong></td>
        </tr>
        <tr>
            <td style="font-size:24px"><strong>SUMBER DAYA MANUSIA</strong></td>
        </tr>
        <tr>
            <td>Jalan Bhayangkara No.42, Kecamatan Kranggan, Kota Mojokerto, 61313</td>
        </tr>
        <tr>
            <td>Telepon (0321) 399600, Faksimile (0321) 399600</td>
        </tr>
        <tr>
            <td>Laman bkpsdm.mojokertokota.go.id, Pos-el bkpsdm@mojokertokota.go.id</td>
        </tr>
    </table>
    <hr>
    <div style="margin-left: 20px; margin-right: 20px">
        <div>
            <p style="text-align: right">Mojokerto, 26 Maret 2026</p>
        </div>
        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>R.005/_____/417.603.3/2026</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td>Rahasia</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>UNDANGAN</td>
            </tr>
        </table>
        <table style="margin-top: 20px">
            <tr>
                <td style="width: 10%">Yth. Sdr.</td>
                <td>{{ $perceraian->pegawai->nama }}</td>
            </tr>
            <tr>
                <td></td>
                <td>{{ $perceraian->pegawai->jabatan }} pada {{ $perceraian->pegawai->opd }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Kota Mojokerto</td>
            </tr>
            <tr>
                <td>di</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><p style="text-decoration: underline; padding-left: 20px;">M O J O K E R T O</p></td>
            </tr>
        </table>
        <p style="text-indent: 70px;text-align:justify">Menindaklanjuti surat dari {{ $perceraian->pegawai->opd }} Kota Mojokerto tanggal 20 Februari 2026 Nomor: R.800.1/01/417.805.2.1/2026 perihal Berita Acara Pembinaan Perceraian {{ $perceraian->pegawai->status_peg }} an. {{ $perceraian->pegawai->nama }} NIP. {{ $perceraian->pegawai->nip }} Gol: {{ $perceraian->pegawai->golongan->gol_ruang ?? '-' }} Jabatan: {{ $perceraian->pegawai->jabatan }} pada {{ $perceraian->pegawai->opd }} Kota Mojokerto dengan {{ $perceraian->pegawai->jk === 'L' ? 'istrinya' : 'suaminya' }} A.n Sdr. {{ $perceraian->pegawai->nama_pasangan }} Alamat Canggu Permai Blok 8A/4 RT 12 RW 003 Desa Canggu Kecamatan Jetis Kabupaten Mojokerto, maka dengan ini kami mengharap kehadiran Saudara pada:
        </p>
        <table>
            <tr>
                <td>Hari</td>
                <td>:</td>
                <td>{{ $perceraian->tanggal_pemanggilan ? $perceraian->tanggal_pemanggilan->locale('id')->translatedFormat('l') : '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ $perceraian->tanggal_pemanggilan ? $perceraian->tanggal_pemanggilan->locale('id')->translatedFormat('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Jam</td>
                <td>:</td>
                <td>{{ $perceraian->tanggal_pemanggilan ? $perceraian->tanggal_pemanggilan->format('H:i') : '-' }} WIB</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td>Ruang Kepala Bidang Pengembangan Kompetensi dan Penilaian Kinerja Aparatur.</td>
            </tr>
        </table>
        <p style="text-indent: 70px;">Demikian atas perhatian serta kerjasamanya kami sampaikan terima kasih.</p>
        <table style="margin-top: 20px; width: 100%">
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left">KEPALA BADAN KEPEGAWAIAN DAN PENGEMBANGAN</td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left">SUMBER DAYA MANUSIA</td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left">KOTA MOJOKERTO</td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left"></td>
            </tr>
            <tr>
                <td style="height: 40px"></td>
                <td style="text-align: left"></td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left;text-decoration: underline">MURAJI.S.T.,M.Si</td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left">Pembina Utama Muda (IV/c)</td>
            </tr>
            <tr>
                <td style="width: 40%"></td>
                <td style="text-align: left">NIP. 19681115 199202 1 002</td>
            </tr>
        </table>
    </div>
    
</body>
</html>