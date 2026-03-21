@extends('layouts.app')
@section('title','Laporan Nilai')
@section('page-title','Laporan Nilai Siswa')

@section('content')
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-journal-text me-2"></i>Laporan Nilai</div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa..." value="{{ request('search') }}"></div>
            <div class="col-md-4">
                <select name="semester" class="form-select form-select-sm">
                    <option value="">Semua Semester</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem }}" {{ request('semester')==$sem?'selected':'' }}>{{ $sem }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search"></i></button>
                <a href="{{ route('user.data.nilai') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">Siswa</th><th>Mata Pelajaran</th><th>Semester</th><th>Tugas</th><th>Ujian</th><th>Praktikum</th><th>Akhir</th><th>Predikat</th></tr>
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
                <td><span class="badge bg-{{ $n->predikat==='A'?'success':($n->predikat==='B'?'primary':($n->predikat==='C'?'warning':'danger')) }}">{{ $n->predikat }}</span></td>
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
