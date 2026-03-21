@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')
{{-- Welcome --}}
<div class="card mb-4" style="background:linear-gradient(135deg,#134d2c,#1a6b3c);border:none">
    <div class="card-body py-4 px-4 text-white d-flex align-items-center gap-4">
        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
             style="width:64px;height:64px;background:rgba(255,255,255,.15);font-size:1.8rem;font-weight:700">
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
        </div>
        <div>
            <h5 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name }}!</h5>
            <p class="mb-0 opacity-75">Portal Informasi Batam Integrated Islamic School</p>
        </div>
        <div class="ms-auto text-end d-none d-md-block">
            <div class="opacity-75 small">{{ now()->isoFormat('dddd, D MMMM Y') }}</div>
            <div class="fw-bold mt-1">{{ $sekolahInfo->nama_sekolah }}</div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Quick actions --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold"><i class="bi bi-lightning me-2 text-warning"></i>Menu Cepat</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('user.rekomendasi.form') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <div class="rounded p-2" style="background:#e8f5ee;color:#1a6b3c"><i class="bi bi-search fs-5"></i></div>
                    <div>
                        <div class="fw-semibold">Cari Rekomendasi SMP</div>
                        <div class="small text-muted">Temukan SMP terbaik dengan SAW</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                <a href="{{ route('user.data.nilai') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <div class="rounded p-2" style="background:#eff6ff;color:#2563eb"><i class="bi bi-journal-text fs-5"></i></div>
                    <div>
                        <div class="fw-semibold">Laporan Nilai</div>
                        <div class="small text-muted">Lihat nilai anak Anda</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                <a href="{{ route('user.data.kegiatan') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <div class="rounded p-2" style="background:#fef3c7;color:#d97706"><i class="bi bi-calendar-event fs-5"></i></div>
                    <div>
                        <div class="fw-semibold">Kegiatan Siswa</div>
                        <div class="small text-muted">Aktivitas & prestasi</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
                <a href="{{ route('user.data.sekolah') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <div class="rounded p-2" style="background:#f5f3ff;color:#7c3aed"><i class="bi bi-building fs-5"></i></div>
                    <div>
                        <div class="fw-semibold">Info Sekolah</div>
                        <div class="small text-muted">Profil BIIS</div>
                    </div>
                    <i class="bi bi-chevron-right ms-auto text-muted"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Linked siswa --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold"><i class="bi bi-people me-2"></i>Data Anak Anda</div>
            <div class="card-body">
                @forelse($siswaList as $s)
                <div class="d-flex align-items-center gap-3 p-2 rounded mb-2 border">
                    <img src="{{ $s->foto_url }}" class="rounded-circle" width="44" height="44" style="object-fit:cover">
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $s->nama_siswa }}</div>
                        <div class="text-muted" style="font-size:.75rem">Kelas {{ $s->kelas }} &bull; {{ $s->nisn }}</div>
                    </div>
                    <a href="{{ route('user.data.siswa.show', $s) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-person-x fs-3 d-block mb-2"></i>
                    <p class="small">Belum ada data siswa yang terhubung ke akun Anda.<br>Hubungi admin untuk menghubungkan data anak Anda.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Last recommendation --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header fw-semibold"><i class="bi bi-star me-2 text-warning"></i>Rekomendasi Terakhir</div>
            <div class="card-body">
                @if($lastRekomen && count($lastRekomen->ranked_results ?? []))
                    @php $top = ($lastRekomen->ranked_results)[0] ?? null; @endphp
                    @if($top)
                    <div class="text-center mb-3">
                        <div class="rank-badge rank-1 mx-auto mb-2" style="width:50px;height:50px;font-size:1.4rem">1</div>
                        <h6 class="fw-bold">{{ $top['sekolah']['nama_sekolah'] ?? '-' }}</h6>
                        <span class="badge bg-success fs-6">Skor: {{ $top['skor_total'] }}</span>
                    </div>
                    <div class="small text-muted text-center mb-3">{{ $lastRekomen->created_at->diffForHumans() }}</div>
                    <a href="{{ route('user.rekomendasi.hasil', $lastRekomen) }}" class="btn btn-outline-primary btn-sm w-100">
                        Lihat Hasil Lengkap
                    </a>
                    @endif
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-search fs-3 d-block mb-2"></i>
                        <p class="small">Belum ada rekomendasi.<br>Mulai pencarian sekarang!</p>
                        <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-search me-1"></i>Cari Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
