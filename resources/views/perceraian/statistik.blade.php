@extends('layouts.sneat')

@section('title', 'Statistik Izin Perceraian')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-bar-chart-alt-2"></i> Statistik Izin Perceraian</h5>
            </div>
            <div class="card-body">
                {{-- Filter Periode --}}
                <form method="GET" class="row g-3 mb-4 p-3 bg-light rounded">
                    <div class="col-md-4">
                        <label class="form-label">Bulan Awal</label>
                        <input type="month" class="form-control" name="bulan_awal" value="{{ $bulanAwal }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bulan Akhir</label>
                        <input type="month" class="form-control" name="bulan_akhir" value="{{ $bulanAkhir }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        <a href="{{ route('statistik') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </a>
                        <a href="{{ route('statistik.pdf', ['bulan_awal' => $bulanAwal, 'bulan_akhir' => $bulanAkhir]) }}" target="_blank" class="btn btn-danger">
                            <i class="bx bx-file-pdf"></i> PDF
                        </a>
                    </div>
                </form>

                {{-- Ringkasan --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3 class="mb-0 text-white">{{ $totalKeseluruhan }}</h3>
                                <small>Total Pengajuan</small>
                            </div>
                        </div>
                    </div>
                    @foreach ($countPerStatus as $id => $item)
                        @if ($item['total'] > 0)
                        <div class="col-md-3">
                            <div class="card border">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $item['total'] }}</h3>
                                    <small>{{ $item['nama'] }}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table id="statistikTable" class="table table-hover table-bordered" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Pegawai</th>
                                <th>NIP</th>
                                <th>Pasangan</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($semuaData as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $d->pegawai->nama ?? '-' }}</strong></td>
                                <td><code>{{ $d->pegawai->nip ?? '-' }}</code></td>
                                <td>{{ $d->nama_pasangan ?? $d->pegawai->nama_pasangan ?? '-' }}</td>
                                <td>
                                    @php
                                        $colors = [
                                            1 => 'bg-label-secondary',
                                            2 => 'bg-label-warning',
                                            3 => 'bg-label-info',
                                            4 => 'bg-label-primary',
                                            5 => 'bg-label-success',
                                        ];
                                        $badge = $colors[$d->status_izin_perceraian_id] ?? 'bg-label-secondary';
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $d->statusIzin?->nama ?? 'Draft' }}</span>
                                </td>
                                <td>{{ $d->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data pada periode ini</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    if (document.querySelector('#statistikTable')) {
        new DataTable('#statistikTable');
    }
});
</script>
@endpush
