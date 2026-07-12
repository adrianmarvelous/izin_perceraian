<div class="row g-3">
    <!-- NIP -->
    <div class="col-md-4">
        <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
               value="{{ old('nip', $pegawai->nip ?? '') }}" required>
        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Nama -->
    <div class="col-md-4">
        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
               value="{{ old('nama', $pegawai->nama ?? '') }}" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- JK -->
    <div class="col-md-2">
        <label for="jk" class="form-label">JK <span class="text-danger">*</span></label>
        <select class="form-select @error('jk') is-invalid @enderror" id="jk" name="jk" required>
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jk', $pegawai->jk ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jk', $pegawai->jk ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jk')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Status Peg -->
    <div class="col-md-2">
        <label for="status_peg" class="form-label">Status Peg</label>
        <select class="form-select @error('status_peg') is-invalid @enderror" id="status_peg" name="status_peg">
            <option value="">-- Pilih --</option>
            <option value="PNSD" {{ old('status_peg', $pegawai->status_peg ?? '') == 'PNSD' ? 'selected' : '' }}>PNSD</option>
            <option value="PPPK" {{ old('status_peg', $pegawai->status_peg ?? '') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
            <option value="PPPK PW" {{ old('status_peg', $pegawai->status_peg ?? '') == 'PPPK PW' ? 'selected' : '' }}>PPPK PW</option>
        </select>
        @error('status_peg')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Tempat Lahir -->
    <div class="col-md-4">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir"
               value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}">
        @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Tanggal Lahir -->
    <div class="col-md-4">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir"
               value="{{ old('tanggal_lahir', isset($pegawai) && $pegawai->tanggal_lahir ? $pegawai->tanggal_lahir->format('Y-m-d') : '') }}">
        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Agama -->
    <div class="col-md-4">
        <label for="agama" class="form-label">Agama</label>
        <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama">
            <option value="">-- Pilih --</option>
            @foreach (['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha', 'Konghucu'] as $a)
                <option value="{{ $a }}" {{ old('agama', $pegawai->agama ?? '') == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>
        @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Gelar Depan -->
    <div class="col-md-4">
        <label for="gelar_depan" class="form-label">Gelar Depan</label>
        <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror" id="gelar_depan" name="gelar_depan"
               value="{{ old('gelar_depan', $pegawai->gelar_depan ?? '') }}">
        @error('gelar_depan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Gelar Belakang -->
    <div class="col-md-4">
        <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
        <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" id="gelar_belakang" name="gelar_belakang"
               value="{{ old('gelar_belakang', $pegawai->gelar_belakang ?? '') }}">
        @error('gelar_belakang')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Jabatan -->
    <div class="col-md-6">
        <label for="jabatan" class="form-label">Jabatan</label>
        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan"
               value="{{ old('jabatan', $pegawai->jabatan ?? '') }}">
        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Golongan -->
    <div class="col-md-3">
        <label for="id_gol" class="form-label">Golongan</label>
        <select class="form-select @error('id_gol') is-invalid @enderror" id="id_gol" name="id_gol">
            <option value="">-- Pilih Golongan --</option>
            @foreach ($golonganList as $g)
                <option value="{{ $g->id }}"
                    {{ old('id_gol', $pegawai->id_gol ?? '') == $g->id ? 'selected' : '' }}>
                    {{ $g->gol_ruang }} - {{ $g->pangkat }}
                </option>
            @endforeach
        </select>
        @error('id_gol')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- OPD -->
    <div class="col-md-4">
        <label for="opd" class="form-label">OPD <span class="text-danger">*</span></label>
        <select class="form-select @error('opd') is-invalid @enderror" id="opd" name="opd" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}>
            <option value="">-- Pilih OPD --</option>
            @foreach ($opdList as $opd)
                <option value="{{ $opd->nama_opd }}" data-id="{{ $opd->id }}"
                    {{ old('opd', $pegawai->opd ?? Auth::user()->name) == $opd->nama_opd ? 'selected' : '' }}>
                    {{ $opd->nama_opd }}
                </option>
            @endforeach
        </select>
        @if (!Auth::user()->hasRole('admin'))
            <input type="hidden" name="opd" value="{{ Auth::user()->name }}">
        @endif
        @error('opd')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Unit Kerja -->
    <div class="col-md-4">
        <label for="unit_kerja_id" class="form-label">Unit Kerja</label>
        <select class="form-select @error('unit_kerja_id') is-invalid @enderror" id="unit_kerja_id" name="unit_kerja_id">
            <option value="">-- Pilih Unit Kerja --</option>
        </select>
        @error('unit_kerja_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Kode Unit & Unit Kerja (hidden, auto-filled via JS) -->
    <input type="hidden" id="kode_unit" name="kode_unit" value="{{ old('kode_unit', $pegawai->kode_unit ?? '') }}">
    <input type="hidden" id="unit_kerja" name="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja ?? '') }}">

    <!-- Alamat -->
    <div class="col-12">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Status Menikah -->
    <div class="col-md-4">
        <label for="status_menikah" class="form-label">Status Menikah</label>
        <select class="form-select @error('status_menikah') is-invalid @enderror" id="status_menikah" name="status_menikah">
            <option value="">-- Pilih --</option>
            @foreach (['Belum Kawin', 'Kawin', 'Menikah', 'Janda', 'Duda', 'Cerai Hidup', 'Cerai Mati'] as $s)
                <option value="{{ $s }}" {{ old('status_menikah', $pegawai->status_menikah ?? '') == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
        @error('status_menikah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Nama Pasangan -->
    <div class="col-md-4">
        <label for="nama_pasangan" class="form-label">Nama Pasangan</label>
        <input type="text" class="form-control @error('nama_pasangan') is-invalid @enderror" id="nama_pasangan" name="nama_pasangan"
               value="{{ old('nama_pasangan', $pegawai->nama_pasangan ?? '') }}">
        @error('nama_pasangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Tgl Menikah -->
    <div class="col-md-4">
        <label for="tgl_menikah" class="form-label">Tgl Menikah</label>
        <input type="date" class="form-control @error('tgl_menikah') is-invalid @enderror" id="tgl_menikah" name="tgl_menikah"
               value="{{ old('tgl_menikah', isset($pegawai) && $pegawai->tgl_menikah ? $pegawai->tgl_menikah->format('Y-m-d') : '') }}">
        @error('tgl_menikah')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <!-- Pekerjaan -->
    <div class="col-md-4">
        <label for="pekerjaan" class="form-label">Pekerjaan</label>
        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan"
               value="{{ old('pekerjaan', $pegawai->pekerjaan ?? '') }}">
        @error('pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

@push('scripts')
<script>
$(function () {
    const $opdSelect = $('#opd');
    const $unitKerjaSelect = $('#unit_kerja_id');
    const $kodeUnitInput = $('#kode_unit');
    const $unitKerjaInput = $('#unit_kerja');
    const pegawaiKodeUnit = '{{ old('kode_unit', $pegawai->kode_unit ?? '') }}';
    const pegawaiUnitKerja = '{{ old('unit_kerja', $pegawai->unit_kerja ?? '') }}';

    /**
     * Load unit kerja berdasarkan OPD yang dipilih.
     */
    function loadUnitKerja(opdId, selectedKodeUnit, selectedNamaUnit) {
        if (!opdId) {
            $unitKerjaSelect.html('<option value="">-- Pilih Unit Kerja --</option>');
            $kodeUnitInput.val('');
            $unitKerjaInput.val('');
            return;
        }

        $.getJSON('/get-unit-kerja/' + opdId, function (data) {
            let options = '<option value="">-- Pilih Unit Kerja --</option>';
            let found = false;
            $.each(data, function (i, uk) {
                const selected = (uk.kode_unit === selectedKodeUnit) ? 'selected' : '';
                if (selected) found = true;
                options += '<option value="' + uk.id + '" data-kode="' + uk.kode_unit + '" data-nama="' + uk.nama_unit + '" ' + selected + '>' + uk.nama_unit + ' (' + uk.kode_unit + ')</option>';
            });
            $unitKerjaSelect.html(options);

            // Auto-fill hidden fields jika ada yang terpilih
            const sel = $unitKerjaSelect.find('option:selected');
            if (sel.val()) {
                $kodeUnitInput.val(sel.data('kode'));
                $unitKerjaInput.val(sel.data('nama'));
            } else if (found && selectedKodeUnit) {
                $kodeUnitInput.val(selectedKodeUnit);
                $unitKerjaInput.val(selectedNamaUnit || '');
            } else {
                $kodeUnitInput.val('');
                $unitKerjaInput.val('');
            }
        });
    }

    /**
     * Ketika OPD berubah, reload unit kerja.
     */
    $opdSelect.on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const opdId = selectedOption.data('id');
        loadUnitKerja(opdId, '', '');
        $kodeUnitInput.val('');
        $unitKerjaInput.val('');
    });

    /**
     * Ketika unit kerja dipilih, isi kode_unit dan unit_kerja.
     */
    $unitKerjaSelect.on('change', function () {
        const selected = $(this).find('option:selected');
        if (selected.val()) {
            $kodeUnitInput.val(selected.data('kode'));
            $unitKerjaInput.val(selected.data('nama'));
        } else {
            $kodeUnitInput.val('');
            $unitKerjaInput.val('');
        }
    });

    // Load unit kerja awal jika ada OPD yang sudah terpilih
    const initialOpd = $opdSelect.find('option:selected');
    const initialOpdId = initialOpd.data('id');
    if (initialOpdId) {
        loadUnitKerja(initialOpdId, pegawaiKodeUnit, pegawaiUnitKerja);
    }
});
</script>
@endpush
