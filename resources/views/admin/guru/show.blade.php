@extends('layouts.app')
@section('title','Detail Guru')
@section('page-title','Detail Guru')
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $guru->foto_url }}" class="rounded-circle mb-3" width="80" height="80" style="object-fit:cover">
                <h5 class="fw-bold mb-1">{{ $guru->nama_guru }}</h5>
                @if($guru->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif
                <hr>
                <div class="text-start small">
                    <div class="py-1 border-bottom d-flex justify-content-between"><span class="text-muted">NIP</span><span>{{ $guru->nip??'-' }}</span></div>
                    <div class="py-1 border-bottom d-flex justify-content-between"><span class="text-muted">Email</span><span>{{ $guru->email }}</span></div>
                    <div class="py-1 border-bottom d-flex justify-content-between"><span class="text-muted">Telepon</span><span>{{ $guru->phone??'-' }}</span></div>
                    <div class="py-1 border-bottom d-flex justify-content-between"><span class="text-muted">Pendidikan</span><span>{{ $guru->pendidikan_terakhir??'-' }}</span></div>
                    <div class="py-1 d-flex justify-content-between"><span class="text-muted">Tgl Lahir</span><span>{{ $guru->tanggal_lahir?->format('d M Y')??'-' }}</span></div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.guru.edit',$guru) }}" class="btn btn-sm btn-warning flex-grow-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-secondary flex-grow-1">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header fw-semibold"><i class="bi bi-book me-2"></i>Mata Pelajaran yang Diajar</div>
            <div class="card-body">
                @forelse($guru->mataPelajaran as $m)
                    <span class="badge bg-light text-dark border me-1 mb-1">{{ $m->nama_mapel }}</span>
                @empty
                    <span class="text-muted small">Belum ada mata pelajaran.</span>
                @endforelse
            </div>
        </div>
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-journal-text me-2"></i>Nilai yang Diinput (Terbaru)</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Siswa</th><th>Mapel</th><th>Semester</th><th>Akhir</th></tr></thead>
                    <tbody>
                    @forelse($guru->nilai->take(8) as $n)
                    <tr>
                        <td>{{ $n->siswa?->nama_siswa }}</td>
                        <td class="small text-muted">{{ $n->mataPelajaran?->nama_mapel }}</td>
                        <td class="small text-muted">{{ $n->semester }}</td>
                        <td><span class="badge bg-primary">{{ $n->nilai_akhir }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada nilai.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
