@extends('layouts.sneat')

@section('title', 'Laporan Pemanggilan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Laporan Hasil Pemanggilan</h5>
                <span class="badge bg-primary">{{ $perceraian->pegawai->nama ?? '-' }}</span>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Informasi Pengajuan:</strong><br>
                    Pegawai: <strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong> ({{ $perceraian->pegawai->nip ?? '-' }})<br>
                    No. Surat: <strong>{{ $perceraian->nomor_surat ?? '-' }}</strong><br>
                    Tanggal Pemanggilan: <strong>{{ $perceraian->tanggal_pemanggilan?->format('d M Y') ?? '-' }}</strong>
                </div>

                <div class="mb-4">
                    <h6><i class="bx bx-file"></i> Surat Panggilan</h6>
                    <div class="d-flex gap-3">
                        @if ($perceraian->surat_panggilan_istri)
                            <a href="{{ asset('storage/' . $perceraian->surat_panggilan_istri) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="bx bx-show"></i> Lihat Surat Panggilan Istri
                            </a>
                        @endif
                        @if ($perceraian->surat_panggilan_suami)
                            <a href="{{ asset('storage/' . $perceraian->surat_panggilan_suami) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                <i class="bx bx-show"></i> Lihat Surat Panggilan Suami
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6><i class="bx bx-edit"></i> Laporan Hasil Pemanggilan</h6>
                        <form>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Kronologi / Hasil Pemanggilan</label>
                                <textarea class="form-control" rows="5" placeholder="Isi laporan hasil pemanggilan..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kesimpulan</label>
                                <select class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="mediasi_berhasil">Mediasi Berhasil</option>
                                    <option value="mediasi_gagal">Mediasi Gagal</option>
                                    <option value="tidak_hadir">Tidak Hadir</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan Laporan
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
