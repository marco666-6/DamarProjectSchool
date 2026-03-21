@extends('layouts.app')
@section('title','Dashboard Admin')
@section('page-title','Dashboard Admin')

@section('content')
{{-- Stats Grid --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_siswa'] }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="border-left-color:#2563eb">
            <div class="stat-icon" style="background:#eff6ff;color:#2563eb"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_guru'] }}</div>
                <div class="stat-label">Total Guru</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="border-left-color:#7c3aed">
            <div class="stat-icon" style="background:#f5f3ff;color:#7c3aed"><i class="bi bi-person-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_user'] }}</div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="border-left-color:#d97706">
            <div class="stat-icon" style="background:#fffbeb;color:#d97706"><i class="bi bi-building"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_sekolah'] }}</div>
                <div class="stat-label">SMP Terdaftar</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="border-left-color:#0891b2">
            <div class="stat-icon" style="background:#ecfeff;color:#0891b2"><i class="bi bi-sliders"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_kriteria'] }}</div>
                <div class="stat-label">Kriteria SAW</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card" style="border-left-color:#059669">
            <div class="stat-icon" style="background:#ecfdf5;color:#059669"><i class="bi bi-star-fill"></i></div>
            <div>
                <div class="stat-value">{{ $stats['total_rekomendasi'] }}</div>
                <div class="stat-label">Rekomendasi</div>
            </div>
        </div>
    </div>
</div>

{{-- SAW Weight Warning --}}
@if(!$bobotCheck['valid'])
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <div>
        <strong>Perhatian:</strong> Total bobot kriteria SAW saat ini <strong>{{ $bobotCheck['sum'] }}</strong>.
        Bobot harus berjumlah tepat <strong>1.0</strong> agar sistem rekomendasi bekerja dengan benar.
        <a href="{{ route('admin.kriteria.index') }}" class="alert-link ms-1">Atur Bobot →</a>
    </div>
</div>
@endif

<div class="row g-4">
    {{-- Siswa per Kelas --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-bar-chart me-2 text-primary"></i>Siswa per Kelas</span>
            </div>
            <div class="card-body">
                @forelse($kelasStats as $ks)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-primary">Kelas {{ $ks->kelas }}</span>
                    <div class="flex-grow-1 mx-3">
                        <div class="progress" style="height:8px">
                            <div class="progress-bar" style="width:{{ $stats['total_siswa'] > 0 ? ($ks->total/$stats['total_siswa'])*100 : 0 }}%"></div>
                        </div>
                    </div>
                    <span class="fw-semibold">{{ $ks->total }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-3">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Rekomendasi --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-star me-2 text-warning"></i>Rekomendasi Terbaru</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr>
                            <th class="ps-3">User</th>
                            <th>Skor Terbaik</th>
                            <th>Waktu</th>
                        </tr></thead>
                        <tbody>
                        @forelse($recentRekomen as $r)
                        <tr>
                            <td class="ps-3">{{ $r->user?->name ?? '-' }}</td>
                            <td><span class="badge bg-success">{{ $r->skor_total }}</span></td>
                            <td class="text-muted small">{{ $r->created_at->diffForHumans() }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">Belum ada rekomendasi.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Siswa --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-people me-2"></i>Siswa Terbaru</span>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th class="ps-3">Nama</th><th>Kelas</th><th>NISN</th></tr></thead>
                        <tbody>
                        @foreach($recentSiswa as $s)
                        <tr>
                            <td class="ps-3">{{ $s->nama_siswa }}</td>
                            <td><span class="badge bg-secondary">{{ $s->kelas }}</span></td>
                            <td class="text-muted small">{{ $s->nisn }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Guru --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-person-badge me-2"></i>Guru Terbaru</span>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th class="ps-3">Nama</th><th>Email</th><th>Status</th></tr></thead>
                        <tbody>
                        @foreach($recentGuru as $g)
                        <tr>
                            <td class="ps-3">{{ $g->nama_guru }}</td>
                            <td class="text-muted small">{{ $g->email }}</td>
                            <td>
                                @if($g->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
