{{-- guru/kegiatan/_form.blade.php --}}
@php $kegiatan = $kegiatan ?? null; @endphp
<div class="row g-3">
    <div class="col-12">
        <label class="form-label small fw-semibold">Siswa <span class="text-danger">*</span></label>
        <select name="siswa_id" class="form-select select2 @error('siswa_id') is-invalid @enderror" required>
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswaList as $s)
                <option value="{{ $s->id }}" {{ old('siswa_id',$kegiatan?->siswa_id)==$s->id?'selected':'' }}>{{ $s->nama_siswa }} ({{ $s->kelas }})</option>
            @endforeach
        </select>
        @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label class="form-label small fw-semibold">Nama Kegiatan <span class="text-danger">*</span></label>
        <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror"
               value="{{ old('nama_kegiatan',$kegiatan?->nama_kegiatan) }}" required>
        @error('nama_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Jenis <span class="text-danger">*</span></label>
        <select name="jenis_kegiatan" class="form-select @error('jenis_kegiatan') is-invalid @enderror" required>
            @foreach($jenisOptions as $j)
                <option value="{{ $j }}" {{ old('jenis_kegiatan',$kegiatan?->jenis_kegiatan)==$j?'selected':'' }}>{{ $j }}</option>
            @endforeach
        </select>
        @error('jenis_kegiatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Tanggal</label>
        <input type="date" name="tanggal_kegiatan" class="form-control"
               value="{{ old('tanggal_kegiatan',$kegiatan?->tanggal_kegiatan?->format('Y-m-d')) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Prestasi</label>
        <input type="text" name="prestasi" class="form-control" placeholder="cth: Juara 1"
               value="{{ old('prestasi',$kegiatan?->prestasi) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label small fw-semibold">Tingkat</label>
        <select name="tingkat" class="form-select">
            <option value="">Pilih tingkat</option>
            @foreach(['Sekolah','Kecamatan','Kota','Provinsi','Nasional','Internasional'] as $t)
                <option value="{{ $t }}" {{ old('tingkat',$kegiatan?->tingkat)==$t?'selected':'' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label small fw-semibold">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi',$kegiatan?->deskripsi) }}</textarea>
    </div>
</div>
