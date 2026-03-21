@extends('layouts.app')
@section('title','Data Siswa')
@section('page-title','Data Siswa')

@section('content')
<div class="card">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-people me-2"></i>Daftar Siswa BIIS</span>
    </div>
    <div class="card-body border-bottom pb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-7">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama siswa / NISN..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kelas" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k }}" {{ request('kelas')==$k?'selected':'' }}>Kelas {{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="bi bi-search"></i></button>
                <a href="{{ route('user.data.siswa') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">Nama Siswa</th><th>NISN</th><th>Kelas</th><th>Jenis Kelamin</th><th></th></tr>
            </thead>
            <tbody>
            @forelse($siswaList as $s)
            <tr>
                <td class="ps-3 fw-semibold">{{ $s->nama_siswa }}</td>
                <td class="text-muted small">{{ $s->nisn }}</td>
                <td><span class="badge bg-primary">{{ $s->kelas }}</span></td>
                <td>{{ $s->jenis_kelamin==='L'?'Laki-laki':($s->jenis_kelamin==='P'?'Perempuan':'-') }}</td>
                <td><a href="{{ route('user.data.siswa.show', $s) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data siswa.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($siswaList->hasPages())
    <div class="card-footer">{{ $siswaList->links() }}</div>
    @endif
</div>
@endsection
