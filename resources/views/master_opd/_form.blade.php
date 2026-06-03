<div class="row g-3">
    <!-- Kode OPD -->
    <div class="col-md-4">
        <label for="kode_opd" class="form-label">Kode OPD <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('kode_opd') is-invalid @enderror" id="kode_opd" name="kode_opd"
               value="{{ old('kode_opd', $masterOpd->kode_opd ?? '') }}" required maxlength="50">
        @error('kode_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Nama OPD -->
    <div class="col-md-8">
        <label for="nama_opd" class="form-label">Nama OPD <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nama_opd') is-invalid @enderror" id="nama_opd" name="nama_opd"
               value="{{ old('nama_opd', $masterOpd->nama_opd ?? '') }}" required maxlength="255">
        @error('nama_opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
