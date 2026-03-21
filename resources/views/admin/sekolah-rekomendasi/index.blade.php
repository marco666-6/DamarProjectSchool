@extends('layouts.app')
@section('title','Data SMP Batam')
@section('page-title','Data SMP Batam (Alternatif SAW)')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-building me-2"></i>Daftar SMP Batam</span>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.sekolah-rekomendasi.matriks') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-table me-1"></i>Matriks SAW
            </a>
            <a href="{{ route('admin.sekolah-rekomendasi.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i>Tambah Sekolah
            </a>
        </div>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama sekolah..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="jenis" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    <option value="Negeri"  {{ request('jenis')=='Negeri' ?'selected':'' }}>Negeri</option>
                    <option value="Swasta"  {{ request('jenis')=='Swasta' ?'selected':'' }}>Swasta</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="akreditasi" class="form-select form-select-sm">
                    <option value="">Semua Akreditasi</option>
                    @foreach(['A','B','C','Belum Terakreditasi'] as $a)
                        <option value="{{ $a }}" {{ request('akreditasi')==$a?'selected':'' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="{{ route('admin.sekolah-rekomendasi.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Nama Sekolah</th>
                    <th>Jenis</th>
                    <th>Akreditasi</th>
                    <th>Kecamatan</th>
                    <th>Biaya SPP</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($sekolahList as $s)
            <tr>
                <td class="ps-3 fw-semibold">{{ $s->nama_sekolah }}</td>
                <td>
                    <span class="badge {{ $s->jenis==='Negeri' ? 'bg-primary' : 'bg-purple' }}" style="{{ $s->jenis==='Swasta' ? 'background:#6b21a8' : '' }}">
                        {{ $s->jenis }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $s->akreditasi==='A' ? 'bg-success' : ($s->akreditasi==='B' ? 'bg-info' : 'bg-warning text-dark') }}">
                        {{ $s->akreditasi }}
                    </span>
                </td>
                <td class="small text-muted">{{ $s->kecamatan??'-' }}</td>
                <td class="small">{{ $s->biaya_spp > 0 ? $s->biaya_spp_format : '<span class="badge bg-success">Gratis</span>' }}</td>
                <td>
                    @if($s->is_active)<span class="badge bg-success">Aktif</span>
                    @else<span class="badge bg-secondary">Nonaktif</span>@endif
                </td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.sekolah-rekomendasi.show',$s) }}" class="btn btn-sm btn-outline-info me-1" title="Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('admin.sekolah-rekomendasi.edit',$s) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form id="del-sr-{{ $s->id }}" method="POST" action="{{ route('admin.sekolah-rekomendasi.destroy',$s) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-sr-{{ $s->id }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    Belum ada data sekolah.
                    <a href="{{ route('admin.sekolah-rekomendasi.create') }}">Tambah sekarang →</a>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($sekolahList->hasPages())
    <div class="card-footer">{{ $sekolahList->links() }}</div>
    @endif
</div>
@endsection
