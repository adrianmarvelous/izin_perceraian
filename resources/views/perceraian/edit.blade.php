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
                <form action="{{ route('perceraian.update', $perceraian) }}" method="POST">
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
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="draft" {{ $perceraian->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pengajuan" {{ $perceraian->status == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                            <option value="diproses" {{ $perceraian->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $perceraian->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $perceraian->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $perceraian->catatan) }}</textarea>
                        @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endcan

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
