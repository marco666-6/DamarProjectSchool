@php $kriteria = $kriteria ?? null; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Kode Kriteria <span class="text-danger">*</span></label>
        <input type="text" name="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror"
               value="{{ old('kode_kriteria', $kriteria?->kode_kriteria ?? $nextCode ?? '') }}" placeholder="C1" required>
        @error('kode_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Urutan</label>
        <input type="number" name="urutan" class="form-control" min="1"
               value="{{ old('urutan', $kriteria?->urutan ?? $nextUrutan ?? 1) }}">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
        <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
               value="{{ old('nama_kriteria', $kriteria?->nama_kriteria) }}" placeholder="cth: Biaya SPP, Akreditasi" required>
        @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Jenis <span class="text-danger">*</span></label>
        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
            <option value="">Pilih Jenis</option>
            <option value="benefit" {{ old('jenis', $kriteria?->jenis) === 'benefit' ? 'selected' : '' }}>Benefit (↑ lebih besar lebih baik)</option>
            <option value="cost"    {{ old('jenis', $kriteria?->jenis) === 'cost'    ? 'selected' : '' }}>Cost (↓ lebih kecil lebih baik)</option>
        </select>
        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Bobot (0–1) <span class="text-danger">*</span></label>
        <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
               value="{{ old('bobot', $kriteria?->bobot ?? '0.25') }}" step="0.01" min="0" max="1" required>
        <div class="form-text">Total semua bobot harus = 1.0</div>
        @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="2" placeholder="Penjelasan singkat tentang kriteria ini...">{{ old('deskripsi', $kriteria?->deskripsi) }}</textarea>
    </div>
    @if($kriteria)
    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active', $kriteria->is_active) ? 'checked' : '' }}>
            <label class="form-check-label small" for="isActive">Aktif (digunakan dalam perhitungan SAW)</label>
        </div>
    </div>
    @endif
</div>
