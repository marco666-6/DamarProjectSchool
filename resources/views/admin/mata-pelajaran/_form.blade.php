{{-- admin/mata-pelajaran/_form.blade.php --}}
@php $mataPelajaran = $mataPelajaran ?? null; @endphp
<div class="row g-3">
    <div class="col-md-6"><label class="form-label small fw-semibold">Kode Mapel</label><input type="text" name="kode_mapel" class="form-control @error('kode_mapel') is-invalid @enderror" value="{{ old('kode_mapel',$mataPelajaran?->kode_mapel) }}" placeholder="MTK, BIN...">@error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label small fw-semibold">Nama Mapel <span class="text-danger">*</span></label><input type="text" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" value="{{ old('nama_mapel',$mataPelajaran?->nama_mapel) }}" required>@error('nama_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Kategori <span class="text-danger">*</span></label>
        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
            @foreach($kategoriList as $k)<option value="{{ $k }}" {{ old('kategori',$mataPelajaran?->kategori)==$k?'selected':'' }}>{{ $k }}</option>@endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Guru Pengajar</label>
        <select name="guru_id" class="form-select select2">
            <option value="">-- Pilih Guru --</option>
            @foreach($guruList as $g)<option value="{{ $g->id }}" {{ old('guru_id',$mataPelajaran?->guru_id)==$g->id?'selected':'' }}>{{ $g->nama_guru }}</option>@endforeach
        </select>
    </div>
    <div class="col-12"><label class="form-label small fw-semibold">Deskripsi</label><textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi',$mataPelajaran?->deskripsi) }}</textarea></div>
    @if($mataPelajaran)
    <div class="col-12"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ old('is_active',$mataPelajaran->is_active)?'checked':'' }}><label class="form-check-label small" for="isActive">Aktif</label></div></div>
    @endif
</div>
