@extends('layouts.app')
@section('title','Data Guru')
@section('page-title','Data Guru')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-person-badge me-2"></i>Daftar Guru</span>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Guru</a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-8"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / NIP / email..." value="{{ request('search') }}"></div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">Nama Guru</th><th>NIP</th><th>Email</th><th>Pendidikan</th><th>Status</th><th class="text-end pe-3">Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($guruList as $g)
            <tr>
                <td class="ps-3">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ $g->foto_url }}" class="rounded-circle" width="34" height="34" style="object-fit:cover">
                        <span class="fw-semibold">{{ $g->nama_guru }}</span>
                    </div>
                </td>
                <td class="text-muted small">{{ $g->nip??'-' }}</td>
                <td class="small">{{ $g->email }}</td>
                <td class="small text-muted">{{ $g->pendidikan_terakhir??'-' }}</td>
                <td>
                    @if($g->is_active)<span class="badge bg-success">Aktif</span>
                    @else<span class="badge bg-secondary">Nonaktif</span>@endif
                </td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.guru.show',$g) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.guru.edit',$g) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                    <form id="del-g-{{ $g->id }}" method="POST" action="{{ route('admin.guru.destroy',$g) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-g-{{ $g->id }}"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data guru.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($guruList->hasPages())
    <div class="card-footer">{{ $guruList->links() }}</div>
    @endif
</div>
@endsection
