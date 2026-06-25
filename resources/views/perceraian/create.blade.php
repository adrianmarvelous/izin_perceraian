@extends('layouts.sneat')

@section('title', 'Buat Pengajuan Izin Perceraian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Buat Pengajuan Izin Perceraian</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('perceraian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Pilih Pegawai <span class="text-danger">*</span></label>
                        <select class="form-select @error('pegawai_id') is-invalid @enderror" id="pegawai_id" name="pegawai_id" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}"
                                    data-pasangan="{{ $p->nama_pasangan ?? '-' }}"
                                    {{ old('pegawai_id') == $p->id ? 'selected' : '' }}>
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
                               value="{{ old('nama_pasangan') }}" readonly placeholder="Akan terisi otomatis">
                        @error('nama_pasangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sebagai <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sebagai" id="penggugat"
                                       value="penggugat" {{ old('sebagai') == 'penggugat' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="penggugat">Penggugat</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sebagai" id="tergugat"
                                       value="tergugat" {{ old('sebagai') == 'tergugat' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tergugat">Tergugat</label>
                            </div>
                        </div>
                        @error('sebagai')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat Pengajuan</label>
                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                               id="nomor_surat" name="nomor_surat"
                               value="{{ old('nomor_surat') }}" placeholder="Contoh: 800/123/BKPSDM">
                        @error('nomor_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="surat_permohonan" class="form-label">Upload Surat Permohonan (PDF)</label>
                        <input type="file" class="form-control @error('surat_permohonan') is-invalid @enderror"
                               id="surat_permohonan" name="surat_permohonan" accept=".pdf">
                        @error('surat_permohonan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Format: PDF, maks 10MB</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Simpan & Lanjutkan Dokumen
                        </button>
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
document.getElementById('pegawai_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const pasangan = selected ? selected.dataset.pasangan : '';
    document.getElementById('nama_pasangan').value = pasangan !== '-' ? pasangan : '';
});
</script>
@endpush
