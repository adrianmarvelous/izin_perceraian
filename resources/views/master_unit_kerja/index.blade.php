@extends('layouts.sneat')

@section('title', 'Data Master Unit Kerja')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Master Unit Kerja</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $unitKerja->count() }} Total</span>
                    <a href="{{ route('master-unit-kerja.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Tambah Unit Kerja
                    </a>
                    <a href="{{ route('master-opd.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="bx bx-building"></i> Lihat OPD
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

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Unit</th>
                                <th>Nama Unit</th>
                                <th>OPD</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($unitKerja as $unit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $unit->kode_unit }}</code></td>
                                    <td>{{ $unit->nama_unit }}</td>
                                    <td>
                                        @if ($unit->opd)
                                            <span class="badge bg-label-secondary">{{ $unit->opd->nama_opd }}</span>
                                        @else
                                            <span class="text-muted fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('master-unit-kerja.edit', $unit) }}" class="dropdown-item">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('master-unit-kerja.destroy', $unit) }}" method="POST"
                                                      onsubmit="return confirm('Yakin hapus data {{ $unit->nama_unit }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data unit kerja.</td>
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
