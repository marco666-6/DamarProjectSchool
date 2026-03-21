@extends('layouts.app')
@section('title','Data Siswa')
@section('page-title','Data Siswa')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-people me-2"></i>Daftar Siswa</span>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
        </a>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama / NISN..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kelas" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search me-1"></i>Cari</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">#</th>
                    <th>Nama Siswa</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Nama Orang Tua</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($siswaList as $i => $s)
            <tr>
                <td class="ps-3 text-muted small">{{ $siswaList->firstItem() + $i }}</td>
                <td class="fw-semibold">{{ $s->nama_siswa }}</td>
                <td class="text-muted small">{{ $s->nisn }}</td>
                <td><span class="badge bg-primary">{{ $s->kelas }}</span></td>
                <td>{{ $s->nama_orangtua }}</td>
                <td>
                    @if($s->is_active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.siswa.show', $s) }}" class="btn btn-xs btn-outline-info btn-sm me-1" title="Detail"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('admin.siswa.edit', $s) }}" class="btn btn-xs btn-outline-warning btn-sm me-1" title="Edit"><i class="bi bi-pencil"></i></a>
                    <form id="del-siswa-{{ $s->id }}" method="POST" action="{{ route('admin.siswa.destroy', $s) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-siswa-{{ $s->id }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data siswa ditemukan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($siswaList->hasPages())
    <div class="card-footer">{{ $siswaList->links() }}</div>
    @endif
</div>
@endsection
