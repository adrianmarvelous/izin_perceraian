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
                    Status: 
                    @php
                        $colors = [
                            1 => 'bg-label-secondary',
                            2 => 'bg-label-warning',
                            3 => 'bg-label-info',
                            4 => 'bg-label-primary',
                            5 => 'bg-label-success',
                        ];
                        $statusBadge = $colors[$perceraian->status_izin_perceraian_id] ?? 'bg-label-secondary';
                    @endphp
                    <span class="badge {{ $statusBadge }}">{{ $perceraian->statusIzin?->nama ?? 'Draft' }}</span>
                </div>

                {{-- Tanggal Pemanggilan & Berita Acara --}}
                @can('admin')
                <form action="{{ route('perceraian.update', $perceraian) }}" method="POST" class="mb-4 p-3 border rounded" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <input type="hidden" name="pegawai_id" value="{{ $perceraian->pegawai_id }}">
                    <input type="hidden" name="nama_pasangan" value="{{ $perceraian->nama_pasangan }}">
                    <input type="hidden" name="sebagai" value="{{ $perceraian->sebagai }}">
                    <input type="hidden" name="catatan" value="{{ $perceraian->catatan }}">
                    @if ($perceraian->ms_tms === 1)
                    <h6 class="mb-3"><i class="bx bx-calendar"></i> Data Pemanggilan</h6>
                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label for="tanggal_pemanggilan" class="form-label">Tanggal Pemanggilan</label>
                            <input type="date" class="form-control form-control-sm @error('tanggal_pemanggilan') is-invalid @enderror"
                                   id="tanggal_pemanggilan" name="tanggal_pemanggilan"
                                   value="{{ old('tanggal_pemanggilan', $perceraian->tanggal_pemanggilan?->format('Y-m-d')) }}">
                            @error('tanggal_pemanggilan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8 mb-2">
                            <label for="berita_acara_pemanggilan_file" class="form-label">Upload Berita Acara Pemanggilan (PDF)</label>
                            <input type="file" class="form-control form-control-sm @error('berita_acara_pemanggilan_file') is-invalid @enderror"
                                   id="berita_acara_pemanggilan_file" name="berita_acara_pemanggilan_file" accept=".pdf">
                            @error('berita_acara_pemanggilan_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if ($perceraian->berita_acara_pemanggilan_file)
                                <div class="mt-1">
                                    <small class="text-success">
                                        <a href="{{ asset('storage/' . $perceraian->berita_acara_pemanggilan_file) }}" target="_blank">
                                            <i class="bx bx-file"></i> Lihat file saat ini
                                        </a>
                                    </small>
                                </div>
                            @endif
                            <small class="text-muted">Format: PDF, maks 10MB</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary mt-1">
                        <i class="bx bx-save"></i> Simpan Data Pemanggilan
                    </button>
                    @endif
                </form>
                @else
                <div class="mb-4 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">MS / TMS</label>
                            <div>
                                @if ($perceraian->ms_tms === 1)
                                    <span class="badge bg-label-success">MS</span>
                                @elseif ($perceraian->ms_tms === -1)
                                    <span class="badge bg-label-danger">TMS</span>
                                @else
                                    <span class="badge bg-label-secondary">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($perceraian->ms_tms === 1)
                    <h6 class="mb-3"><i class="bx bx-calendar"></i> Data Pemanggilan</h6>
                    <div class="row mt-2">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Tanggal Pemanggilan</label>
                            <input type="text" class="form-control form-control-sm"
                                   value="{{ $perceraian->tanggal_pemanggilan?->format('d M Y') ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-8 mb-2">
                            <label class="form-label">Berita Acara Pemanggilan</label>
                            @if ($perceraian->berita_acara_pemanggilan_file)
                                <div>
                                    <a href="{{ asset('storage/' . $perceraian->berita_acara_pemanggilan_file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                        <i class="bx bx-file"></i> Lihat PDF
                                    </a>
                                </div>
                            @else
                                <textarea class="form-control form-control-sm" rows="2" readonly>{{ $perceraian->berita_acara_pemanggilan ?? '-' }}</textarea>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @endcan

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
                                        @if (in_array($dok->kode, ['dokumentasi', 'bukti_lain']))
                                            @if ($dok->link)
                                                <a href="{{ $dok->link }}" target="_blank" class="text-break">
                                                    <i class="bx bx-folder"></i> {{ $dok->link }}
                                                </a>
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

                                                    @if (in_array($dok->kode, ['dokumentasi', 'bukti_lain']))
                                                    <div class="mb-2">
                                                        <label class="form-label">Link Folder Google Drive</label>
                                                        <div class="input-group">
                                                            <input type="url" class="form-control" id="link_{{ $dok->id }}"
                                                                   name="link" value="{{ $dok->link }}"
                                                                   placeholder="https://drive.google.com/drive/folders/..."
                                                                   readonly>
                                                            @if ($dok->link)
                                                            <a href="{{ $dok->link }}" target="_blank"
                                                               class="btn btn-outline-success" title="Buka Folder">
                                                                <i class="bx bx-folder"></i> Buka Folder
                                                            </a>
                                                            @else
                                                            <button type="button" class="btn btn-primary"
                                                                    onclick="createDriveFolder({{ $dok->id }}, {{ $perceraian->id }})"
                                                                    id="btnDrive_{{ $dok->id }}">
                                                                <i class="bx bx-folder-open"></i> Buat Folder
                                                            </button>
                                                            @endif
                                                        </div>
                                                        <div id="driveStatus_{{ $dok->id }}" class="mt-1"></div>
                                                        @if ($dok->link)
                                                        <small class="text-success">✅ Folder sudah dibuat</small>
                                                        @else
                                                        <small class="text-muted">Klik "Buat Folder" untuk membuat folder Google Drive secara otomatis</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan_{{ $dok->id }}" class="form-label">Keterangan</label>
                                                        <textarea class="form-control" id="keterangan_{{ $dok->id }}"
                                                                  name="keterangan" rows="2">{{ $dok->keterangan }}</textarea>
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

                <div class="mt-4 d-flex gap-2 align-items-center">
                    <a href="{{ route('perceraian.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back"></i> Kembali
                    </a>
                    @can('admin')
                    <div class="d-flex gap-1 ms-auto" id="msTmsButtons">
                        <button type="button" class="btn btn-sm {{ $perceraian->ms_tms === 1 ? 'btn-success' : 'btn-outline-success' }}"
                                onclick="updateMsTms({{ $perceraian->id }}, 1)" id="btnMs_{{ $perceraian->id }}">
                            <i class="bx bx-check-circle"></i> MS
                        </button>
                        <button type="button" class="btn btn-sm {{ $perceraian->ms_tms === -1 ? 'btn-danger' : 'btn-outline-danger' }}"
                                onclick="updateMsTms({{ $perceraian->id }}, -1)" id="btnTms_{{ $perceraian->id }}">
                            <i class="bx bx-x-circle"></i> TMS
                        </button>
                        <span id="msTmsStatus_{{ $perceraian->id }}"></span>
                    </div>
                    @endcan
                    @if ($perceraian->status_izin_perceraian_id == 1 || is_null($perceraian->status_izin_perceraian_id))
                    <form id="formAjukan" action="{{ route('perceraian.ajukan', $perceraian) }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-success" onclick="cekDokumenWajib()">
                            <i class="bx bx-send"></i> Ajukan Izin
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Dokumen Belum Lengkap --}}
<div class="modal fade" id="modalDokumenBelum" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="bx bx-error-circle"></i> Dokumen Belum Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Harap lengkapi dokumen wajib berikut sebelum mengajukan izin:</p>
                <ul id="listDokumenKurang" class="list-group list-group-flush"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cekDokumenWajib() {
    const dokumen = @json($perceraian->dokumen);
    const kurang = dokumen.filter(d => d.wajib && !d.status && d.kondisi_wajib !== 'pisah_rumah>=2_tahun');

    if (kurang.length > 0) {
        const list = document.getElementById('listDokumenKurang');
        list.innerHTML = '';
        kurang.forEach(d => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex align-items-center';
            li.innerHTML = `<i class="bx bx-x-circle text-danger me-2"></i> ${d.nama_dokumen}`;
            list.appendChild(li);
        });
        const modal = new bootstrap.Modal(document.getElementById('modalDokumenBelum'));
        modal.show();
    } else {
        document.getElementById('formAjukan').submit();
    }
}
</script>
<script>
function createDriveFolder(dokumenId, perceraianId) {
    const btn = document.getElementById('btnDrive_' + dokumenId);
    const statusDiv = document.getElementById('driveStatus_' + dokumenId);
    const linkInput = document.getElementById('link_' + dokumenId);

    // Disable button & show loading
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Membuat...';
    statusDiv.innerHTML = '<small class="text-info">⏳ Membuat folder Google Drive...</small>';

    const url = `/perceraian/${perceraianId}/dokumen/${dokumenId}/create-drive-folder`;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            linkInput.value = data.link;
            statusDiv.innerHTML = '<small class="text-success">✅ ' + data.message + '</small>';

            // Refresh halaman setelah 1.5 detik agar data terbaru tampil
            setTimeout(() => location.reload(), 1500);
        } else {
            statusDiv.innerHTML = '<small class="text-danger">❌ ' + data.message + '</small>';
            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-folder-open"></i> Buat Folder';
        }
    })
    .catch(err => {
        statusDiv.innerHTML = '<small class="text-danger">❌ Terjadi kesalahan: ' + err.message + '</small>';
        btn.disabled = false;
        btn.innerHTML = '<i class="bx bx-folder-open"></i> Buat Folder';
    });
}

function updateMsTms(perceraianId, value) {
    const label = value === 1 ? 'MS (Memenuhi Syarat)' : 'TMS (Tidak Memenuhi Syarat)';
    const icon = value === 1 ? 'question' : 'warning';

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Yakin ingin menetapkan status ' + label + '?',
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: value === 1 ? '#28a745' : '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, ' + (value === 1 ? 'MS' : 'TMS'),
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (!result.isConfirmed) return;

        const btnMs = document.getElementById('btnMs_' + perceraianId);
        const btnTms = document.getElementById('btnTms_' + perceraianId);
        const statusSpan = document.getElementById('msTmsStatus_' + perceraianId);

        btnMs.disabled = true;
        btnTms.disabled = true;
        statusSpan.innerHTML = '<small class="text-info">⏳ Menyimpan...</small>';

        const url = `/perceraian/${perceraianId}/ms-tms/${value}`;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    if (value === -1) {
                        // TMS → kembali ke halaman sebelumnya
                        window.location.href = '{{ route("perceraian.index") }}';
                    } else {
                        // MS → refresh halaman ini
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message,
                });
                btnMs.disabled = false;
                btnTms.disabled = false;
                statusSpan.innerHTML = '';
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan: ' + err.message,
            });
            btnMs.disabled = false;
            btnTms.disabled = false;
            statusSpan.innerHTML = '';
        });
    });
}
</script>
@endpush
