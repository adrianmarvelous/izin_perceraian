@extends('layouts.sneat')

@section('title', 'Rekomendasi BKPSDM')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Rekomendasi BKPSDM</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Informasi Pengajuan:</strong><br>
                    Pegawai: <strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong> ({{ $perceraian->pegawai->nip ?? '-' }})<br>
                    Jabatan: {{ $perceraian->pegawai->jabatan ?? '-' }}<br>
                    Golongan: {{ $perceraian->pegawai->golongan->gol_ruang ?? '-' }} ({{ $perceraian->pegawai->golongan->pangkat ?? '-' }})<br>
                    OPD: {{ $perceraian->pegawai->opd ?? '-' }}<br>
                    No. Surat: <strong>{{ $perceraian->nomor_surat ?? '-' }}</strong><br>
                    Status: <span class="badge bg-label-warning">{{ $perceraian->statusIzin?->nama ?? '-' }}</span>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6><i class="bx bx-receipt"></i> Form Rekomendasi</h6>
                        <form>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Pertimbangan / Analisis</label>
                                <textarea class="form-control" rows="4" placeholder="Isi pertimbangan dan analisis..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rekomendasi</label>
                                <select class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="direkomendasikan">Direkomendasikan</option>
                                    <option value="tidak_direkomendasikan">Tidak Direkomendasikan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-save"></i> Simpan Rekomendasi
                            </button>
                            <a href="{{ route('perceraian.dokumen', $perceraian) }}" class="btn btn-outline-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
