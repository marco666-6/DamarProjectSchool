@extends('layouts.app')
@section('title','Data Guru')
@section('page-title','Data Guru BIIS')

@section('content')
<div class="card">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-person-badge me-2"></i>Daftar Guru</span>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-8"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama guru..." value="{{ request('search') }}"></div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('user.data.guru') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="row g-3 p-3">
        @forelse($guruList as $g)
        <div class="col-md-4 col-lg-3">
            <div class="card text-center h-100 border">
                <div class="card-body py-3">
                    <img src="{{ $g->foto_url }}" class="rounded-circle mb-2" width="56" height="56" style="object-fit:cover">
                    <div class="fw-semibold small">{{ $g->nama_guru }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $g->pendidikan_terakhir??'' }}</div>
                    @if($g->mataPelajaran->count())
                    <div class="mt-2 d-flex flex-wrap gap-1 justify-content-center">
                        @foreach($g->mataPelajaran->take(3) as $m)
                        <span class="badge bg-light text-dark border" style="font-size:.65rem">{{ $m->nama_mapel }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-4">Tidak ada data guru.</div>
        @endforelse
    </div>
    @if($guruList->hasPages())
    <div class="card-footer">{{ $guruList->links() }}</div>
    @endif
</div>
@endsection
