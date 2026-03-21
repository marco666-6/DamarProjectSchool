@extends('layouts.app')
@section('title','Mata Pelajaran')
@section('page-title','Mata Pelajaran')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-book me-2"></i>Daftar Mata Pelajaran</span>
        <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Mapel</a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-5"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / kode..." value="{{ request('search') }}"></div>
            <div class="col-md-4">
                <select name="kategori" class="form-select form-select-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $k)<option value="{{ $k }}" {{ request('kategori')==$k?'selected':'' }}>{{ $k }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search"></i></button>
                <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th class="ps-3">Kode</th><th>Nama Mapel</th><th>Kategori</th><th>Guru</th><th>Status</th><th class="text-end pe-3">Aksi</th></tr></thead>
            <tbody>
            @forelse($mapelList as $m)
            <tr>
                <td class="ps-3"><span class="badge bg-secondary">{{ $m->kode_mapel??'-' }}</span></td>
                <td class="fw-semibold">{{ $m->nama_mapel }}</td>
                <td><span class="badge bg-light text-dark border">{{ $m->kategori }}</span></td>
                <td class="small text-muted">{{ $m->guru?->nama_guru??'-' }}</td>
                <td>@if($m->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif</td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.mata-pelajaran.edit',$m) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    <form id="del-mp-{{ $m->id }}" method="POST" action="{{ route('admin.mata-pelajaran.destroy',$m) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-mp-{{ $m->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada mata pelajaran.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($mapelList->hasPages())<div class="card-footer">{{ $mapelList->links() }}</div>@endif
</div>
@endsection
