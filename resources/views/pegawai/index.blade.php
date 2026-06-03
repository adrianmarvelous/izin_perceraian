@extends('layouts.sneat')

@section('title', 'Data Pegawai')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Pegawai</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $pegawai->count() }} Total</span>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Tambah Pegawai
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Filter OPD -->
                @can('admin')
                <form method="GET" class="row g-2 mb-3 align-items-end">
                    <div class="col-md-3">
                        <label for="opd" class="form-label fw-medium">Filter OPD</label>
                        <select name="opd" id="opd" class="form-select form-select-sm"
                                onchange="this.form.submit()">
                            <option value="">-- Semua OPD --</option>
                            @foreach ($opdList as $opd)
                                <option value="{{ $opd }}" {{ request('opd') == $opd ? 'selected' : '' }}>
                                    {{ $opd }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if (request('opd'))
                        <div class="col-md-2 d-flex align-items-end">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-x"></i> Reset
                            </a>
                        </div>
                    @endif
                </form>
                @endcan

                <div class="table-responsive">
                    <table id="pegawaiTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>JK</th>
                                <th>Jabatan</th>
                                <th>Unit Kerja</th>
                                <th>Status Peg</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $p->nip }}</code></td>
                                    <td>
                                        <strong>{{ $p->nama }}</strong>
                                        @if ($p->gelar_belakang)
                                            <small class="text-muted">, {{ $p->gelar_belakang }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $p->jk }}</td>
                                    <td>{{ $p->jabatan ?? '-' }}</td>
                                    <td>
                                        {{ $p->unit_kerja ?? '-' }}
                                        <br><small class="text-muted">({{ $p->opd }})</small>
                                    </td>
                                    <td>
                                        @php
                                            $badge = match ($p->status_peg) {
                                                'PNSD' => 'bg-label-primary',
                                                'PPPK', 'PPPK PW' => 'bg-label-success',
                                                default => 'bg-label-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badge }}">{{ $p->status_peg ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id }}">
                                                    <i class="bx bx-info-circle me-1"></i> Detail
                                                </button>
                                                <a href="{{ route('pegawai.edit', $p) }}" class="dropdown-item">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('pegawai.destroy', $p) }}" method="POST"
                                                      onsubmit="return confirm('Yakin hapus data {{ $p->nama }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal Detail -->
                                        <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Pegawai</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">NIP</div>
                                                            <div class="col-sm-8"><code>{{ $p->nip }}</code></div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Nama</div>
                                                            <div class="col-sm-8">
                                                                {{ $p->nama }}
                                                                @if ($p->gelar_belakang)<small class="text-muted">, {{ $p->gelar_belakang }}</small>@endif
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Jenis Kelamin</div>
                                                            <div class="col-sm-8">{{ $p->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Tempat / Tgl Lahir</div>
                                                            <div class="col-sm-8">{{ $p->tempat_lahir ?? '-' }}@if($p->tanggal_lahir), {{ $p->tanggal_lahir->format('d M Y') }}@endif</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Agama</div>
                                                            <div class="col-sm-8">{{ $p->agama ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Alamat</div>
                                                            <div class="col-sm-8">{{ $p->alamat ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Status Pegawai</div>
                                                            <div class="col-sm-8">{{ $p->status_peg ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Gelar Depan</div>
                                                            <div class="col-sm-8">{{ $p->gelar_depan ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Gelar Belakang</div>
                                                            <div class="col-sm-8">{{ $p->gelar_belakang ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Jabatan</div>
                                                            <div class="col-sm-8">{{ $p->jabatan ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Kode Unit</div>
                                                            <div class="col-sm-8">{{ $p->kode_unit ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Unit Kerja</div>
                                                            <div class="col-sm-8">{{ $p->unit_kerja ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">OPD</div>
                                                            <div class="col-sm-8">{{ $p->opd ?? '-' }}</div>
                                                        </div>
                                                        <hr>
                                                        <h6>Data Keluarga</h6>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Status Menikah</div>
                                                            <div class="col-sm-8">{{ $p->status_menikah ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Nama Pasangan</div>
                                                            <div class="col-sm-8">{{ $p->nama_pasangan ?? '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Tgl Menikah</div>
                                                            <div class="col-sm-8">{{ $p->tgl_menikah ? $p->tgl_menikah->format('d M Y') : '-' }}</div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-4 fw-medium text-muted">Pekerjaan</div>
                                                            <div class="col-sm-8">{{ $p->pekerjaan ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
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
if (document.querySelector('#pegawaiTable')) {
    new DataTable('#pegawaiTable');
}
</script>
@endpush
