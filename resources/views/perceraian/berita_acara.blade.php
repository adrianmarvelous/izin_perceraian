@extends('layouts.sneat')

@php
    $col = 'berita_acara_' . $pihak;
    $savedData = $perceraian->$col;
    $isEdit = !is_null($savedData) && $savedData !== '';
@endphp

@section('title', $isEdit ? 'Edit Berita Acara ' . ucfirst($pihak) : 'Buat Berita Acara ' . ucfirst($pihak))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $isEdit ? 'Edit' : 'Buat' }} Berita Acara {{ ucfirst($pihak) }}</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Informasi Pengajuan:</strong><br>
                    Pegawai: <strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong> ({{ $perceraian->pegawai->nip ?? '-' }})<br>
                    Sebagai: <strong>{{ ucfirst($perceraian->sebagai) }}</strong><br>
                    No. Surat: <strong>{{ $perceraian->nomor_surat ?? '-' }}</strong><br>
                    Tanggal Pemanggilan: <strong>{{ $perceraian->tanggal_pemanggilan?->format('d M Y H:i') ?? '-' }}</strong>
                </div>

                <div class="mb-4">
                    <h6><i class="bx bx-file"></i> Surat Panggilan</h6>
                    <div class="d-flex gap-3">
                        <a href="{{ route('perceraian.surat-panggilan', $perceraian) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="bx bx-show"></i> Lihat Surat Panggilan
                        </a>
                    </div>
                </div>

@php
    $column = $col;
    $saved = $perceraian->$column;
    $jawabanData = $perceraian->beritaAcaraJawaban->where('pihak', $pihak)->keyBy('kode');
    $pemeriksaData = $perceraian->beritaAcaraPemeriksa->where('pihak', $pihak)->keyBy('urutan');
    $parsed = [];
    // Fallback: parse dari text jika tabel baru belum terisi
    if ($jawabanData->isEmpty() && $saved) {
        foreach (explode("\n---\n", $saved) as $block) {
            $block = trim($block);
            if (!$block) continue;
            $lines = explode("\n", $block);
            foreach ($lines as $line) {
                $colonPos = strpos($line, ':');
                if ($colonPos !== false) {
                    $key = trim(substr($line, 0, $colonPos));
                    $val = trim(substr($line, $colonPos + 1));
                    $parsed[$key] = $val;
                }
            }
        }
    }
@endphp

<div class="card">
    <div class="card-body">
        <h6><i class="bx bx-edit"></i> {{ $isEdit ? 'Edit' : 'Buat' }} Berita Acara {{ ucfirst($pihak) }}</h6>
        <form action="{{ route('perceraian.berita-acara.store', [$perceraian, $pihak]) }}" method="POST">
            @csrf
            <input type="hidden" name="berita_acara" id="berita_acara_hidden">

            @php $pemeriksaJson = $pemeriksa->map(fn($p) => ['id' => $p->id, 'nama' => $p->nama, 'nip' => $p->nip, 'jabatan' => $p->jabatan]); @endphp

            <div class="mb-4">
                <h6><i class="bx bx-user"></i> Pemeriksa</h6>
                <div class="row">
                    @for ($i = 1; $i <= 3; $i++)
                    @php
                        $pm = $pemeriksaData->get($i);
                    @endphp
                    <div class="col-md-4 mb-2">
                        <label class="form-label">Pemeriksa {{ $i }}</label>
                        <input class="form-control form-control-sm pemeriksa-input" list="listPemeriksa"
                               name="pemeriksa_nama_{{ $i }}"
                               value="{{ old('pemeriksa_nama_' . $i, $pm->nama ?? $parsed['Pemeriksa ' . $i] ?? '') }}"
                               placeholder="Ketik nama..."
                               data-index="{{ $i }}">
                        <input type="hidden" name="pemeriksa_nip_{{ $i }}" value="{{ old('pemeriksa_nip_' . $i, $pm->nip ?? $parsed['Pemeriksa ' . $i . ' NIP'] ?? '') }}">
                        <input type="hidden" name="pemeriksa_jabatan_{{ $i }}" value="{{ old('pemeriksa_jabatan_' . $i, $pm->jabatan ?? $parsed['Pemeriksa ' . $i . ' Jabatan'] ?? '') }}">
                        <div class="mt-1" id="infoPemeriksa_{{ $i }}">
                            @if ($pm)
                                <small class="text-muted">{{ $pm->nip }} &middot; {{ $pm->jabatan }}</small>
                            @elseif (($parsed['Pemeriksa ' . $i . ' NIP'] ?? '') || ($parsed['Pemeriksa ' . $i . ' Jabatan'] ?? ''))
                                <small class="text-muted">
                                    {{ $parsed['Pemeriksa ' . $i . ' NIP'] ?? '' }}
                                    @if (($parsed['Pemeriksa ' . $i . ' NIP'] ?? '') && ($parsed['Pemeriksa ' . $i . ' Jabatan'] ?? '')) &middot; @endif
                                    {{ $parsed['Pemeriksa ' . $i . ' Jabatan'] ?? '' }}
                                </small>
                            @endif
                        </div>
                    </div>
                    @endfor
                </div>
                <datalist id="listPemeriksa">
                    @foreach ($pemeriksa as $p)
                        <option value="{{ $p->nama }}" data-nip="{{ $p->nip }}" data-jabatan="{{ $p->jabatan }}">
                    @endforeach
                </datalist>
            </div>

            <div class="mb-3">
                <label class="form-label">1. Apakah {{ $pihak === 'penggugat' ? 'Saudari' : 'Saudara' }} dalam kondisi sehat?</label>
                <textarea class="form-control" name="q_sehat" rows="2" placeholder="Jelaskan kondisi kesehatan...">{{ old('q_sehat', $jawabanData->get('q_sehat')->jawaban ?? $parsed['1. Sehat'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">2. Sudah menikah berapa lama?</label>
                <textarea class="form-control" name="q_menikah" rows="2" placeholder="Contoh: 5 tahun">{{ old('q_menikah', $jawabanData->get('q_menikah')->jawaban ?? $parsed['2. Lama Menikah'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">3. Apakah {{ $pihak === 'penggugat' ? 'Saudari' : 'Saudara' }} sudah tidak tinggal serumah?</label>
                <textarea class="form-control" name="q_serumah" rows="2" placeholder="Jelaskan, jika sudah pisah sejak kapan...">{{ old('q_serumah', $jawabanData->get('q_serumah')->jawaban ?? $parsed['3. Tinggal Serumah'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">4. Apa yang mendasari {{ $pihak === 'penggugat' ? 'Saudari' : 'Saudara' }} memutuskan untuk mengajukan gugatan perceraian?</label>
                <textarea class="form-control" name="q_alasan" rows="3" placeholder="Jelaskan alasan...">{{ old('q_alasan', $jawabanData->get('q_alasan')->jawaban ?? $parsed['4. Alasan'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">5. Apakah masih ada komunikasi?</label>
                <textarea class="form-control" name="q_komunikasi" rows="2" placeholder="Jelaskan kondisi komunikasi...">{{ old('q_komunikasi', $jawabanData->get('q_komunikasi')->jawaban ?? $parsed['5. Komunikasi'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">6. Apakah {{ $pihak === 'penggugat' ? 'Saudari' : 'Saudara' }} sudah yakin untuk berpisah?</label>
                <textarea class="form-control" name="q_yakin" rows="2" placeholder="Jelaskan...">{{ old('q_yakin', $jawabanData->get('q_yakin')->jawaban ?? $parsed['6. Yakin Berpisah'] ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Pertanyaan & Jawaban Tambahan</label>
                <div id="tambahanContainer">
                    @php
                        $tambahan = old('q_tambahan_tanya')
                            ? array_map(fn($i) => ['pertanyaan' => old('q_tambahan_tanya.' . $i), 'jawaban' => old('q_tambahan_jawab.' . $i)], array_keys(old('q_tambahan_tanya')))
                            : ($perceraian->beritaAcaraTambahan->where('pihak', $pihak)->values() ?: collect(['']));
                    @endphp
                    @foreach ($tambahan as $i => $t)
                    @php
                        $tanya = is_object($t) ? $t->pertanyaan : (is_array($t) ? ($t['pertanyaan'] ?? '') : '');
                        $jawab = is_object($t) ? $t->jawaban : (is_array($t) ? ($t['jawaban'] ?? '') : '');
                    @endphp
                    <div class="d-flex gap-2 align-items-start mb-2 item-tambahan">
                        <div style="flex:1">
                            <input type="text" class="form-control form-control-sm mb-1" name="q_tambahan_tanya[]" value="{{ old('q_tambahan_tanya.' . $i, $tanya) }}" placeholder="Pertanyaan...">
                            <textarea class="form-control" name="q_tambahan_jawab[]" rows="2" placeholder="Jawaban...">{{ old('q_tambahan_jawab.' . $i, $jawab) }}</textarea>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-0" onclick="this.parentElement.remove()">×</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="tambahTambahan()">
                    <i class="bx bx-plus"></i> Tambah Pertanyaan
                </button>
            </div>

            <button type="submit" class="btn btn-{{ $isEdit ? 'warning' : 'secondary' }}">
                <i class="bx bx-save"></i> {{ $isEdit ? 'Update' : 'Simpan' }} Berita Acara
            </button>
            <a href="{{ route('perceraian.dokumen', $perceraian) }}" class="btn btn-outline-secondary">Kembali</a>
        </form>
    </div>
</div>

@if ($perceraian->$column)
@php
    $sebutan = $pihak === 'penggugat' ? 'Saudari' : 'Saudara';
    $questions = [
        'q_sehat' => '1. Apakah ' . $sebutan . ' dalam kondisi sehat?',
        'q_menikah' => '2. Sudah menikah berapa lama?',
        'q_serumah' => '3. Apakah ' . $sebutan . ' sudah tidak tinggal serumah?',
        'q_alasan' => '4. Apa yang mendasari ' . $sebutan . ' memutuskan untuk mengajukan gugatan perceraian?',
        'q_komunikasi' => '5. Apakah masih ada komunikasi?',
        'q_yakin' => '6. Apakah ' . $sebutan . ' sudah yakin untuk berpisah?',
    ];
@endphp
<div class="mt-4 p-3 border rounded">
    <h6 class="mb-2"><i class="bx bx-history"></i> Berita Acara {{ ucfirst($pihak) }} Saat Ini</h6>
    <div class="p-3 bg-light rounded">
        @if ($jawabanData->isNotEmpty())
            @foreach ($questions as $kode => $question)
                @php $jawab = $jawabanData->get($kode); @endphp
                <div style="margin-bottom:10px;">
                    <strong>{{ $question }}</strong><br>
                    Jawab: {{ $jawab->jawaban ?? '-' }}
                </div>
            @endforeach
        @else
            {!! nl2br(e($perceraian->$column)) !!}
        @endif
    </div>

    @php $tambahans = $perceraian->beritaAcaraTambahan->where('pihak', $pihak); @endphp
    @if ($tambahans->isNotEmpty())
    <div class="mt-3">
        <strong>Pertanyaan Tambahan:</strong>
        @foreach ($tambahans as $t)
        <div class="mb-2 p-2 border-start border-3 border-primary">
            <strong>Pertanyaan:</strong> {{ $t->pertanyaan }}<br>
            <strong>Jawaban:</strong> {{ $t->jawaban ?? '-' }}
        </div>
        @endforeach
    </div>
    @endif
</div>
@endif

@push('scripts')
<script>
const pegawaiData = @json($pemeriksaJson);

document.querySelectorAll('.pemeriksa-input').forEach(input => {
    const updatePemeriksa = function() {
        const nama = this.value.trim();
        const idx = this.dataset.index;
        const found = pegawaiData.find(p => p.nama.toLowerCase() === nama.toLowerCase());
        const infoDiv = document.getElementById('infoPemeriksa_' + idx);
        const nipHidden = document.querySelector(`[name="pemeriksa_nip_${idx}"]`);
        const jabatanHidden = document.querySelector(`[name="pemeriksa_jabatan_${idx}"]`);

        if (found) {
            nipHidden.value = found.nip;
            jabatanHidden.value = found.jabatan;
            infoDiv.innerHTML = '<small class="text-muted">' + found.nip + ' &middot; ' + found.jabatan + '</small>';
        } else {
            nipHidden.value = '';
            jabatanHidden.value = '';
            infoDiv.innerHTML = '';
        }
    };
    input.addEventListener('change', updatePemeriksa);
    input.addEventListener('blur', updatePemeriksa);
});

document.querySelector('form').addEventListener('submit', function() {
    let text = '';

    // Pemeriksa
    for (let i = 1; i <= 3; i++) {
        const nama = document.querySelector(`[name="pemeriksa_nama_${i}"]`);
        const nip = document.querySelector(`[name="pemeriksa_nip_${i}"]`);
        const jabatan = document.querySelector(`[name="pemeriksa_jabatan_${i}"]`);
        if (nama && nama.value.trim()) {
            text += 'Pemeriksa ' + i + ': ' + nama.value.trim() + '\n';
            if (nip && nip.value.trim()) text += 'Pemeriksa ' + i + ' NIP: ' + nip.value.trim() + '\n';
            if (jabatan && jabatan.value.trim()) text += 'Pemeriksa ' + i + ' Jabatan: ' + jabatan.value.trim() + '\n';
        }
    }
    if (text) text += '---\n';

    const fields = [
        { name: 'q_sehat', label: '1. Sehat' },
        { name: 'q_menikah', label: '2. Lama Menikah' },
        { name: 'q_serumah', label: '3. Tinggal Serumah' },
        { name: 'q_alasan', label: '4. Alasan' },
        { name: 'q_komunikasi', label: '5. Komunikasi' },
        { name: 'q_yakin', label: '6. Yakin Berpisah' },
    ];

    fields.forEach(f => {
        const el = document.querySelector(`[name="${f.name}"]`);
        if (el && el.value.trim()) {
            text += f.label + ': ' + el.value.trim() + '\n';
        }
        text += '---\n';
    });

    document.getElementById('berita_acara_hidden').value = text;
});

function tambahTambahan() {
    const div = document.createElement('div');
    div.className = 'd-flex gap-2 align-items-start mb-2 item-tambahan';
    div.innerHTML = `<div style="flex:1">
                        <input type="text" class="form-control form-control-sm mb-1" name="q_tambahan_tanya[]" placeholder="Pertanyaan...">
                        <textarea class="form-control" name="q_tambahan_jawab[]" rows="2" placeholder="Jawaban..."></textarea>
                     </div>
                     <button type="button" class="btn btn-sm btn-outline-danger mt-0" onclick="this.parentElement.remove()">×</button>`;
    document.getElementById('tambahanContainer').appendChild(div);
}
</script>
@endpush
            </div>
        </div>
    </div>
</div>
@endsection
