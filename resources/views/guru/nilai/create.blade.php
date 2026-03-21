@extends('layouts.app')
@section('title','Input Nilai')
@section('page-title','Input Nilai Siswa')

@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-plus-circle me-2"></i>Form Input Nilai</div>
    <div class="card-body">
        <form method="POST" action="{{ route('guru.nilai.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-select select2 @error('siswa_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswaList as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id')==$s->id?'selected':'' }}>{{ $s->nama_siswa }} ({{ $s->kelas }})</option>
                        @endforeach
                    </select>
                    @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Mata Pelajaran <span class="text-danger">*</span></label>
                    <select name="mapel_id" class="form-select select2 @error('mapel_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapelList as $m)
                            <option value="{{ $m->id }}" {{ old('mapel_id')==$m->id?'selected':'' }}>{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    @error('mapel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Semester <span class="text-danger">*</span></label>
                    <input type="text" name="semester" class="form-control @error('semester') is-invalid @enderror"
                           value="{{ old('semester','Ganjil 2024/2025') }}" placeholder="cth: Ganjil 2024/2025" required>
                    @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Nilai Tugas <span class="text-muted">(30%)</span></label>
                    <input type="number" name="nilai_tugas" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_tugas') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Nilai Ujian <span class="text-muted">(50%)</span></label>
                    <input type="number" name="nilai_ujian" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_ujian') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Nilai Praktikum <span class="text-muted">(20%)</span></label>
                    <input type="number" name="nilai_praktikum" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_praktikum') }}">
                </div>
                <div class="col-12">
                    <div class="alert alert-info py-2 small mb-0">
                        <i class="bi bi-info-circle me-1"></i>Nilai akhir dihitung otomatis: <strong>(Tugas×30% + Ujian×50% + Praktikum×20%)</strong>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('guru.nilai.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
