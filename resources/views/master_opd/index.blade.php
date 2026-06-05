@extends('layouts.sneat')

@section('title', 'Data Master OPD')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Master OPD</h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $masterOpd->count() }} Total</span>
                    <a href="{{ route('master-opd.create') }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Tambah OPD
                    </a>
                    <a href="{{ route('master-unit-kerja.index') }}" class="btn btn-outline-info btn-sm">
                        <i class="bx bx-list-ul"></i> Lihat Unit Kerja
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
                    <table id="masterOpdTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode OPD</th>
                                <th>Nama OPD</th>
                                <th>Unit Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masterOpd as $opd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $opd->kode_opd }}</code></td>
                                    <td>{{ $opd->nama_opd }}</td>
                                    <td>
                                        <span class="badge bg-label-info">{{ $opd->unit_kerja_count }} unit</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('master-opd.edit', $opd) }}" class="dropdown-item">
                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('master-opd.destroy', $opd) }}" method="POST"
                                                      onsubmit="return confirm('Yakin hapus {{ $opd->nama_opd }}? Semua unit kerja di dalamnya juga akan dihapus.')">
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
                                    <td colspan="5" class="text-center text-muted">Belum ada data master OPD.</td>
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
if (document.querySelector('#masterOpdTable')) {
    new DataTable('#masterOpdTable');
}
</script>
@endpush
