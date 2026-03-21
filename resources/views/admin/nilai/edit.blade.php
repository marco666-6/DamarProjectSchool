@extends('layouts.app')
@section('title','Edit Nilai')
@section('page-title','Edit Nilai')
@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-pencil me-2"></i>Edit Nilai: {{ $nilai->siswa?->nama_siswa }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.nilai.update',$nilai) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-12"><div class="alert alert-light border py-2 small"><strong>Siswa:</strong> {{ $nilai->siswa?->nama_siswa }} &bull; <strong>Mapel:</strong> {{ $nilai->mataPelajaran?->nama_mapel }}</div></div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Guru</label>
                    <select name="guru_id" class="form-select select2">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guruList as $g)<option value="{{ $g->id }}" {{ old('guru_id',$nilai->guru_id)==$g->id?'selected':'' }}>{{ $g->nama_guru }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Semester</label>
                    <input type="text" name="semester" class="form-control" value="{{ old('semester',$nilai->semester) }}" required>
                </div>
                <div class="col-md-4"><label class="form-label small fw-semibold">Nilai Tugas</label><input type="number" name="nilai_tugas" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_tugas',$nilai->nilai_tugas) }}"></div>
                <div class="col-md-4"><label class="form-label small fw-semibold">Nilai Ujian</label><input type="number" name="nilai_ujian" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_ujian',$nilai->nilai_ujian) }}"></div>
                <div class="col-md-4"><label class="form-label small fw-semibold">Nilai Praktikum</label><input type="number" name="nilai_praktikum" class="form-control" min="0" max="100" step="0.01" value="{{ old('nilai_praktikum',$nilai->nilai_praktikum) }}"></div>
                <div class="col-12"><textarea name="catatan" class="form-control" rows="2" placeholder="Catatan">{{ old('catatan',$nilai->catatan) }}</textarea></div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
