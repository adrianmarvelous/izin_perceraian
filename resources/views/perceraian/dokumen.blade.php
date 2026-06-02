@extends('layouts.sneat')

@section('title', 'Dokumen Pendukung')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dokumen Pendukung</h5>
                <span class="badge bg-primary">{{ $perceraian->pegawai->nama ?? '-' }}</span>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Informasi Pengajuan:</strong><br>
                    Pegawai: <strong>{{ $perceraian->pegawai->nama ?? '-' }}</strong> ({{ $perceraian->pegawai->nip ?? '-' }})<br>
                    Pasangan: {{ $perceraian->nama_pasangan ?? $perceraian->pegawai->nama_pasangan ?? '-' }}<br>
                    Sebagai: <strong>{{ ucfirst($perceraian->sebagai) }}</strong> |
                    Status: <span class="badge bg-label-warning">{{ ucfirst($perceraian->status) }}</span>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Nama Dokumen</th>
                                <th style="width:120px">Status</th>
                                <th style="width:300px">Link / Keterangan</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perceraian->dokumen as $dok)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $dok->nama_dokumen }}
                                        @if ($dok->wajib)
                                            <span class="badge bg-label-danger ms-1">Wajib</span>
                                        @endif
                                        @if ($dok->kondisi_wajib == 'pisah_rumah>=2_tahun')
                                            <br><small class="text-danger">* Wajib jika sudah pisah rumah &ge; 2 tahun</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dok->status)
                                            <span class="badge bg-label-success">Sudah</span>
                                        @else
                                            <span class="badge bg-label-secondary">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dok->kode == 'dokumentasi')
                                            @if ($dok->link)
                                                <a href="{{ $dok->link }}" target="_blank" class="text-break">{{ $dok->link }}</a>
                                            @else
                                                <em class="text-muted">-</em>
                                            @endif
                                        @else
                                            @if ($dok->file)
                                                <a href="{{ asset('storage/' . $dok->file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                    <i class="bx bx-file"></i> Lihat PDF
                                                </a>
                                            @else
                                                <em class="text-muted">Belum upload</em>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#dokumenModal{{ $dok->id }}">
                                            <i class="bx bx-edit-alt"></i> Update
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Update Dokumen -->
                                <div class="modal fade" id="dokumenModal{{ $dok->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('perceraian.dokumen.update', [$perceraian, $dok]) }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Dokumen</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>{{ $dok->nama_dokumen }}</strong></p>

                                                    @if ($dok->kode == 'dokumentasi')
                                                    <div class="mb-3">
                                                        <label for="link_{{ $dok->id }}" class="form-label">Link Google Drive</label>
                                                        <input type="url" class="form-control" id="link_{{ $dok->id }}"
                                                               name="link" value="{{ $dok->link }}"
                                                               placeholder="https://drive.google.com/...">
                                                    </div>
                                                    @else
                                                    <div class="mb-3">
                                                        <label for="file_{{ $dok->id }}" class="form-label">Upload File PDF</label>
                                                        <input type="file" class="form-control" id="file_{{ $dok->id }}"
                                                               name="file" accept=".pdf">
                                                        @if ($dok->file)
                                                            <div class="mt-1">
                                                                <small class="text-success">
                                                                    <a href="{{ asset('storage/' . $dok->file) }}" target="_blank">Lihat file saat ini</a>
                                                                </small>
                                                            </div>
                                                        @endif
                                                        <small class="text-muted">Format: PDF, maks 10MB</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan_{{ $dok->id }}" class="form-label">Keterangan</label>
                                                        <textarea class="form-control" id="keterangan_{{ $dok->id }}"
                                                                  name="keterangan" rows="2">{{ $dok->keterangan }}</textarea>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('perceraian.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                    @if ($perceraian->status == 'draft')
                    <form action="{{ route('perceraian.ajukan', $perceraian) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bx bx-send"></i> Ajukan Izin
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
