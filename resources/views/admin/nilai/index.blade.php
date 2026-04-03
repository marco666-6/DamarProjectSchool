@extends('layouts.app')
@section('title', 'Kelola Nilai')
@section('page-title', 'Kelola Nilai Siswa')
@section('page-subtitle', 'Nilai ditampilkan per siswa dan semester supaya lebih rapi, mudah dicari, dan mudah dikelola.')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <div class="page-kicker">Nilai Akademik</div>
            <div class="fw-bold fs-5 text-dark">Daftar nilai per siswa</div>
        </div>
        <a href="{{ route('admin.nilai.create') }}" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Kelola Nilai per Siswa
        </a>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Cari siswa</label>
                <input type="text" name="search" class="form-control" placeholder="Nama siswa atau NISN" value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Mata pelajaran</label>
                <select name="mapel_id" class="form-select">
                    <option value="">Semua mapel</option>
                    @foreach($mapelList as $mapel)
                        <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">Semua kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-semibold">Semester</label>
                <select name="semester" class="form-select">
                    <option value="">Semua semester</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small fw-semibold">Baris</label>
                <select name="per_page" class="form-select">
                    @foreach([10,20,50,100] as $size)
                        <option value="{{ $size }}" {{ $perPage === $size ? 'selected' : '' }}>{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-outline-success flex-grow-1">Terapkan</button>
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Siswa</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Jumlah Mapel</th>
                    <th>Rata-rata</th>
                    <th>Terakhir Diubah</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilaiList as $row)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $row->nama_siswa }}</div>
                            <div class="small text-muted">ID siswa: {{ $row->siswa_id }}</div>
                        </td>
                        <td><span class="badge badge-soft-primary rounded-pill">{{ $row->kelas ?: '-' }}</span></td>
                        <td class="small text-muted">{{ $row->semester }}</td>
                        <td><span class="badge badge-soft-info rounded-pill">{{ $row->total_mapel }} mapel</span></td>
                        <td><strong>{{ number_format((float) $row->rata_nilai, 1) }}</strong></td>
                        <td class="small text-muted">{{ \Carbon\Carbon::parse($row->terakhir_diubah)->diffForHumans() }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.nilai.create', ['siswa_id' => $row->siswa_id, 'semester' => $row->semester]) }}" class="btn btn-outline-success rounded-pill btn-sm px-3">
                                Kelola Nilai
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">Belum ada data nilai yang cocok dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($nilaiList->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Menampilkan {{ $nilaiList->firstItem() }}-{{ $nilaiList->lastItem() }} dari {{ $nilaiList->total() }} kelompok data.
            </div>
            {{ $nilaiList->links() }}
        </div>
    @endif
</div>
@endsection
