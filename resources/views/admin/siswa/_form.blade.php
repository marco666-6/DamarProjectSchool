{{-- Shared form fields for siswa create & edit --}}
@php $siswa = $siswa ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">NISN <span class="text-danger">*</span></label>
        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
               value="{{ old('nisn', $siswa?->nisn) }}" required>
        @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">NIS (Lokal)</label>
        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
               value="{{ old('nis', $siswa?->nis) }}">
        @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama Siswa <span class="text-danger">*</span></label>
        <input type="text" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror"
               value="{{ old('nama_siswa', $siswa?->nama_siswa) }}" required>
        @error('nama_siswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Kelas</label>
        <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
               value="{{ old('kelas', $siswa?->kelas) }}" placeholder="6A">
        @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
            <option value="">Pilih</option>
            <option value="L" {{ old('jenis_kelamin', $siswa?->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $siswa?->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control"
               value="{{ old('tempat_lahir', $siswa?->tempat_lahir) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control"
               value="{{ old('tanggal_lahir', $siswa?->tanggal_lahir?->format('Y-m-d')) }}">
    </div>

    <div class="col-12"><hr class="my-1"><small class="text-muted fw-semibold">DATA ORANG TUA / WALI</small></div>

    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama Orang Tua <span class="text-danger">*</span></label>
        <input type="text" name="nama_orangtua" class="form-control @error('nama_orangtua') is-invalid @enderror"
               value="{{ old('nama_orangtua', $siswa?->nama_orangtua) }}" required>
        @error('nama_orangtua')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_orangtua" class="form-control"
               value="{{ old('pekerjaan_orangtua', $siswa?->pekerjaan_orangtua) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">No. HP Orang Tua</label>
        <input type="text" name="phone_orangtua" class="form-control"
               value="{{ old('phone_orangtua', $siswa?->phone_orangtua) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tahun Masuk</label>
        <input type="number" name="tahun_masuk" class="form-control" min="2000" max="2100"
               value="{{ old('tahun_masuk', $siswa?->tahun_masuk) }}">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Alamat <span class="text-danger">*</span></label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2" required>{{ old('alamat', $siswa?->alamat) }}</textarea>
        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Foto Siswa</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        @if($siswa?->foto)
            <img src="{{ $siswa->foto_url }}" class="mt-2 rounded" height="60">
        @endif
    </div>
    @if($siswa)
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Status</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active', $siswa->is_active) ? 'checked' : '' }}>
            <label class="form-check-label" for="isActive">Aktif</label>
        </div>
    </div>
    @endif
</div>
