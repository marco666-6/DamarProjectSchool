{{-- admin/guru/_form.blade.php --}}
@php $guru = $guru ?? null; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Nama Guru <span class="text-danger">*</span></label>
        <input type="text" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror"
               value="{{ old('nama_guru', $guru?->nama_guru) }}" required>
        @error('nama_guru')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">NIP</label>
        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
               value="{{ old('nip', $guru?->nip) }}">
        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $guru?->email) }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @if(!$guru)
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Password <span class="text-danger">*</span></label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Minimal 8 karakter" required>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    @else
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Password Baru <span class="text-muted">(opsional)</span></label>
        <input type="password" name="new_password" class="form-control" placeholder="Kosongkan jika tidak diubah">
    </div>
    @endif
    <div class="col-md-6">
        <label class="form-label small fw-semibold">No. Telepon</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $guru?->phone) }}">
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select">
            <option value="">Pilih</option>
            <option value="L" {{ old('jenis_kelamin',$guru?->jenis_kelamin)==='L'?'selected':'' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin',$guru?->jenis_kelamin)==='P'?'selected':'' }}>Perempuan</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label small fw-semibold">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control"
               value="{{ old('tanggal_lahir', $guru?->tanggal_lahir?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Pendidikan Terakhir</label>
        <input type="text" name="pendidikan_terakhir" class="form-control" placeholder="cth: S1 Pendidikan Matematika"
               value="{{ old('pendidikan_terakhir', $guru?->pendidikan_terakhir) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $guru?->tempat_lahir) }}">
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $guru?->alamat) }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Foto</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        @if($guru?->foto)<img src="{{ $guru->foto_url }}" class="mt-2 rounded-circle" width="50" height="50" style="object-fit:cover">@endif
    </div>
    @if($guru)
    <div class="col-md-6">
        <label class="form-label small fw-semibold">Status</label>
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active',$guru->is_active)?'checked':'' }}>
            <label class="form-check-label" for="isActive">Aktif</label>
        </div>
    </div>
    @endif
</div>
