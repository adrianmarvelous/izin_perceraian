<div class="row g-3">
    <!-- Kode Unit -->
    <div class="col-md-4">
        <label for="kode_unit" class="form-label">Kode Unit <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('kode_unit') is-invalid @enderror" id="kode_unit" name="kode_unit"
               value="{{ old('kode_unit', $masterUnitKerja->kode_unit ?? '') }}" required maxlength="50">
        @error('kode_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Nama Unit -->
    <div class="col-md-8">
        <label for="nama_unit" class="form-label">Nama Unit <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nama_unit') is-invalid @enderror" id="nama_unit" name="nama_unit"
               value="{{ old('nama_unit', $masterUnitKerja->nama_unit ?? '') }}" required maxlength="255">
        @error('nama_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- OPD -->
    <div class="col-md-6">
        <label for="opd_id" class="form-label">OPD</label>
        <select class="form-select @error('opd_id') is-invalid @enderror" id="opd_id" name="opd_id">
            <option value="">-- Pilih OPD --</option>
            @foreach ($opdList as $opd)
                <option value="{{ $opd->id }}"
                    {{ old('opd_id', $masterUnitKerja->opd_id ?? '') == $opd->id ? 'selected' : '' }}>
                    {{ $opd->kode_opd }} - {{ $opd->nama_opd }}
                </option>
            @endforeach
        </select>
        @error('opd_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
