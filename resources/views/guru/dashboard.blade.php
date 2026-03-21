@extends('layouts.app')
@section('title','Dashboard Guru')
@section('page-title','Dashboard Guru')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            <div><div class="stat-value">{{ $stats['total_nilai'] }}</div><div class="stat-label">Nilai Diinput</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="border-left-color:#d97706">
            <div class="stat-icon" style="background:#fffbeb;color:#d97706"><i class="bi bi-calendar-event"></i></div>
            <div><div class="stat-value">{{ $stats['total_kegiatan'] }}</div><div class="stat-label">Kegiatan Diinput</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="border-left-color:#2563eb">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-people"></i></div>
            <div><div class="stat-value">{{ $stats['total_siswa'] }}</div><div class="stat-label">Total Siswa</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card" style="border-left-color:#7c3aed">
            <div class="stat-icon" style="background:#f5f3ff;color:#7c3aed"><i class="bi bi-book"></i></div>
            <div><div class="stat-value">{{ $stats['total_mapel'] }}</div><div class="stat-label">Mata Pelajaran</div></div>
        </div>
    </div>
</div>

<div class="card mb-3 p-3" style="background:linear-gradient(135deg,#134d2c,#1a6b3c);border:none">
    <div class="d-flex align-items-center gap-3 text-white">
        <img src="{{ $guru->foto_url }}" class="rounded-circle" width="56" height="56" style="object-fit:cover">
        <div>
            <h6 class="fw-bold mb-0">{{ $guru->nama_guru }}</h6>
            <div class="opacity-75 small">{{ $guru->nip??'NIP belum diisi' }} &bull; {{ $guru->pendidikan_terakhir??'' }}</div>
        </div>
        <a href="{{ route('profile.edit') }}" class="btn btn-sm ms-auto" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3)">
            <i class="bi bi-pencil me-1"></i>Edit Profil
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-journal-text me-2"></i>Nilai Terbaru</span>
                <a href="{{ route('guru.nilai.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light"><tr><th class="ps-3">Siswa</th><th>Mapel</th><th>Akhir</th></tr></thead>
                    <tbody>
                    @forelse($recentNilai as $n)
                    <tr>
                        <td class="ps-3 small fw-semibold">{{ $n->siswa?->nama_siswa }}</td>
                        <td class="small text-muted">{{ $n->mataPelajaran?->nama_mapel }}</td>
                        <td><span class="badge bg-primary">{{ $n->nilai_akhir }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada nilai.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-calendar-event me-2"></i>Kegiatan Terbaru</span>
                <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
            </div>
            <div class="list-group list-group-flush">
            @forelse($recentKegiatan as $k)
            <div class="list-group-item py-2">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold small">{{ $k->nama_kegiatan }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $k->siswa?->nama_siswa }} &bull; {{ $k->jenis_kegiatan }}</div>
                    </div>
                    <span class="text-muted" style="font-size:.72rem">{{ $k->tanggal_kegiatan?->format('d M') }}</span>
                </div>
            </div>
            @empty
            <div class="list-group-item text-center text-muted py-3">Belum ada kegiatan.</div>
            @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
