@extends('layouts.app')
@section('title','Kelola Nilai')
@section('page-title','Kelola Laporan Nilai')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-journal-text me-2"></i>Daftar Nilai</span>
        <a href="{{ route('guru.nilai.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Input Nilai</a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari siswa..." value="{{ request('search') }}"></div>
            <div class="col-md-3">
                <select name="mapel_id" class="form-select form-select-sm">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id')==$m->id?'selected':'' }}>{{ $m->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="semester" class="form-select form-select-sm">
                    <option value="">Semua Semester</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem }}" {{ request('semester')==$sem?'selected':'' }}>{{ $sem }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search"></i></button>
                <a href="{{ route('guru.nilai.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">Siswa</th><th>Mata Pelajaran</th><th>Semester</th><th>Tugas</th><th>Ujian</th><th>Praktikum</th><th>Akhir</th><th class="text-end pe-3">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($nilaiList as $n)
            <tr>
                <td class="ps-3 fw-semibold small">{{ $n->siswa?->nama_siswa }}</td>
                <td class="small">{{ $n->mataPelajaran?->nama_mapel }}</td>
                <td class="small text-muted">{{ $n->semester }}</td>
                <td>{{ $n->nilai_tugas??'-' }}</td>
                <td>{{ $n->nilai_ujian??'-' }}</td>
                <td>{{ $n->nilai_praktikum??'-' }}</td>
                <td><strong>{{ $n->nilai_akhir??'-' }}</strong></td>
                <td class="text-end pe-3">
                    <a href="{{ route('guru.nilai.edit',$n) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form id="del-n-{{ $n->id }}" method="POST" action="{{ route('guru.nilai.destroy',$n) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-n-{{ $n->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data nilai.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($nilaiList->hasPages())
    <div class="card-footer">{{ $nilaiList->links() }}</div>
    @endif
</div>
@endsection
