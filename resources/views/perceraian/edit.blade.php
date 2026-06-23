@extends('layouts.sneat')

@section('title', 'Edit Pengajuan Izin Perceraian')

@section('content')
<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Pengajuan: {{ $perceraian->pegawai->nama ?? '-' }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('perceraian.update', $perceraian) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('pegawai_id') is-invalid @enderror" id="pegawai_id" name="pegawai_id" required>
                            <option value="">-- Pilih --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}"
                                    data-pasangan="{{ $p->nama_pasangan ?? '-' }}"
                                    {{ old('pegawai_id', $perceraian->pegawai_id) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->nip }})
                                </option>
                            @endforeach
                        </select>
                        @error('pegawai_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_pasangan" class="form-label">Nama Pasangan</label>
                        <input type="text" class="form-control @error('nama_pasangan') is-invalid @enderror"
                               id="nama_pasangan" name="nama_pasangan"
                               value="{{ old('nama_pasangan', $perceraian->nama_pasangan ?? $perceraian->pegawai->nama_pasangan) }}">
                        @error('nama_pasangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sebagai <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sebagai" id="penggugat"
                                       value="penggugat" {{ old('sebagai', $perceraian->sebagai) == 'penggugat' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="penggugat">Penggugat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sebagai" id="tergugat"
                                       value="tergugat" {{ old('sebagai', $perceraian->sebagai) == 'tergugat' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tergugat">Tergugat</label>
                            </div>
                        </div>
                        @error('sebagai')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    @can('admin')
                    <div class="mb-3">
                        <label for="status_izin_perceraian_id" class="form-label">Status</label>
                        <select class="form-select @error('status_izin_perceraian_id') is-invalid @enderror" id="status_izin_perceraian_id" name="status_izin_perceraian_id">
                            @foreach (\App\Models\StatusIzinPerceraian::all() as $s)
                                <option value="{{ $s->id }}" {{ old('status_izin_perceraian_id', $perceraian->status_izin_perceraian_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_izin_perceraian_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $perceraian->catatan) }}</textarea>
                        @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">MS / TMS</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ms_tms" id="ms_tms_1"
                                       value="1" {{ old('ms_tms', $perceraian->ms_tms) === 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ms_tms_1">
                                    <span class="badge bg-label-success">MS (Memenuhi Syarat)</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ms_tms" id="ms_tms_-1"
                                       value="-1" {{ old('ms_tms', $perceraian->ms_tms) === -1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="ms_tms_-1">
                                    <span class="badge bg-label-danger">TMS (Tidak Memenuhi Syarat)</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ms_tms" id="ms_tms_0"
                                       value="0" {{ old('ms_tms', $perceraian->ms_tms) === 0 || is_null($perceraian->ms_tms) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ms_tms_0">
                                    <span class="badge bg-label-secondary">Belum ditentukan</span>
                                </label>
                            </div>
                        </div>
                        @error('ms_tms')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    @if ($perceraian->ms_tms === 1 || old('ms_tms') === '1')
                    <div class="mb-3">
                        <label for="tanggal_pemanggilan" class="form-label">Tanggal Pemanggilan</label>
                        <input type="date" class="form-control @error('tanggal_pemanggilan') is-invalid @enderror"
                               id="tanggal_pemanggilan" name="tanggal_pemanggilan"
                               value="{{ old('tanggal_pemanggilan', $perceraian->tanggal_pemanggilan?->format('Y-m-d')) }}">
                        @error('tanggal_pemanggilan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="berita_acara_pemanggilan_file" class="form-label">Upload Berita Acara Pemanggilan (PDF)</label>
                        <input type="file" class="form-control @error('berita_acara_pemanggilan_file') is-invalid @enderror"
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
                    @endif
                    @endcan

                    @cannot('admin')
                    <div class="mb-3">
                        <label class="form-label">MS / TMS</label>
                        <div>
                            @if ($perceraian->ms_tms === 1)
                                <span class="badge bg-label-success">MS (Memenuhi Syarat)</span>
                            @elseif ($perceraian->ms_tms === -1)
                                <span class="badge bg-label-danger">TMS (Tidak Memenuhi Syarat)</span>
                            @else
                                <span class="badge bg-label-secondary">Belum ditentukan</span>
                            @endif
                        </div>
                    </div>

                    @if ($perceraian->ms_tms === 1)
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pemanggilan</label>
                        <input type="text" class="form-control" value="{{ $perceraian->tanggal_pemanggilan?->format('d M Y') ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Berita Acara Pemanggilan</label>
                        @if ($perceraian->berita_acara_pemanggilan_file)
                            <div>
                                <a href="{{ asset('storage/' . $perceraian->berita_acara_pemanggilan_file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="bx bx-file"></i> Lihat PDF
                                </a>
                            </div>
                        @else
                            <textarea class="form-control" rows="3" readonly>{{ $perceraian->berita_acara_pemanggilan ?? '-' }}</textarea>
                        @endif
                    </div>

                    @endif
                    @endcannot

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Update</button>
                        <a href="{{ route('perceraian.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('pegawai_id')?.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const pasangan = selected ? selected.dataset.pasangan : '';
    if (pasangan !== '-') {
        document.getElementById('nama_pasangan').value = pasangan;
    }
});
</script>
@endpush
