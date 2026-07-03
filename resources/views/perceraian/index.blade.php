@extends('layouts.sneat')

@section('title', 'Izin Perceraian')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
/* Fix dropdown terpotong oleh table-responsive */
#perceraianTable_wrapper .dropdown-menu {
    z-index: 1055;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Izin Perceraian</h5>
                <a href="{{ route('perceraian.create') }}" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus"></i> Buat Pengajuan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="perceraianTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pegawai</th>
                                <th>NIP</th>
                                <th>Pasangan</th>
                                <th>Sebagai</th>
                                <th>Status</th>
                                <th>MS/TMS</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $d->pegawai->nama ?? '-' }}</strong></td>
                                    <td><code>{{ $d->pegawai->nip ?? '-' }}</code></td>
                                    <td>{{ $d->nama_pasangan ?? $d->pegawai->nama_pasangan ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $d->sebagai == 'penggugat' ? 'bg-label-danger' : 'bg-label-info' }}">
                                            {{ ucfirst($d->sebagai) }}
                                        </span>
                                    </td>
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
                                    <td>
                                        @if ($d->ms_tms === 1)
                                            <span class="badge bg-label-success">MS</span>
                                        @elseif ($d->ms_tms === -1)
                                            <span class="badge bg-label-danger">TMS</span>
                                        @else
                                            <span class="badge bg-label-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $d->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" data-bs-boundary="window">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('perceraian.dokumen', $d) }}" class="dropdown-item">
                                                    <i class="bx bx-file me-1"></i> Dokumen
                                                </a>
                                                <a href="{{ route('perceraian.print', $d) }}" target="_blank" class="dropdown-item">
                                                    <i class="bx bx-printer me-1"></i> Cetak PDF
                                                </a>
                                                <a href="{{ route('perceraian.edit', $d) }}" class="dropdown-item">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                @if (($d->status_izin_perceraian_id == 1 || is_null($d->status_izin_perceraian_id)) && !Auth::user()->hasRole('admin'))
                                                <form action="{{ route('perceraian.ajukan', $d) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-send me-1"></i> Ajukan
                                                    </button>
                                                </form>
                                                @endif
                                                <form action="{{ route('perceraian.destroy', $d) }}" method="POST"
                                                      onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
    // Inisialisasi DataTable
    if (document.querySelector('#perceraianTable')) {
        new DataTable('#perceraianTable');
    }

    // Fix dropdown terpotong: ubah overflow table-responsive saat dropdown terbuka
    $(document).on('show.bs.dropdown', '.table-responsive', function () {
        $(this).css('overflow', 'visible');
    }).on('hide.bs.dropdown', '.table-responsive', function () {
        $(this).css('overflow', '');
    });

    // Alternatif: event langsung pada dropdown
    $(document).on('show.bs.dropdown', '.dropdown', function () {
        $(this).closest('.table-responsive').css('overflow', 'visible');
    }).on('hide.bs.dropdown', '.dropdown', function () {
        $(this).closest('.table-responsive').css('overflow', '');
    });
});
</script>
@endpush
