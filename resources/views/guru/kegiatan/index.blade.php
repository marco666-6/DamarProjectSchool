@extends('layouts.app')
@section('title','Kelola Kegiatan')
@section('page-title','Kelola Kegiatan Siswa')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-calendar-event me-2"></i>Daftar Kegiatan</span>
        <a href="{{ route('guru.kegiatan.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Kegiatan</a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kegiatan / siswa..." value="{{ request('search') }}"></div>
            <div class="col-md-4">
                <select name="jenis_kegiatan" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisOptions as $j)
                        <option value="{{ $j }}" {{ request('jenis_kegiatan')==$j?'selected':'' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search"></i></button>
                <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">Siswa</th><th>Kegiatan</th><th>Jenis</th><th>Tanggal</th><th>Prestasi</th><th class="text-end pe-3">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($kegiatanList as $k)
            <tr>
                <td class="ps-3 fw-semibold small">{{ $k->siswa?->nama_siswa }}</td>
                <td>{{ $k->nama_kegiatan }}</td>
                <td><span class="badge bg-info text-dark">{{ $k->jenis_kegiatan }}</span></td>
                <td class="small text-muted">{{ $k->tanggal_kegiatan?->format('d M Y')??'-' }}</td>
                <td class="small">{{ $k->prestasi??'-' }}</td>
                <td class="text-end pe-3">
                    <a href="{{ route('guru.kegiatan.edit',$k) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form id="del-k-{{ $k->id }}" method="POST" action="{{ route('guru.kegiatan.destroy',$k) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-k-{{ $k->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada kegiatan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($kegiatanList->hasPages())
    <div class="card-footer">{{ $kegiatanList->links() }}</div>
    @endif
</div>
@endsection
