@extends('layouts.app')
@section('title','Hasil Rekomendasi SMP')
@section('page-title','Hasil Rekomendasi SMP')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <p class="text-muted mb-0">Ditemukan <strong>{{ count($rankedResults) }}</strong> sekolah berdasarkan preferensi Anda.</p>
    </div>
    <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-arrow-repeat me-1"></i>Hitung Ulang
    </a>
</div>

{{-- Top 3 podium --}}
@if(count($rankedResults) >= 1)
<div class="row g-3 mb-4">
    @foreach(array_slice($rankedResults, 0, 3) as $r)
    @php $s = $r['sekolah'] ?? null; @endphp
    <div class="col-md-4">
        <div class="card result-card h-100 {{ $r['ranking'] === 1 ? 'border-warning border-2' : '' }}">
            @if($r['ranking'] === 1)
                <div class="bg-warning text-dark text-center small py-1 fw-semibold">
                    <i class="bi bi-trophy-fill me-1"></i>Rekomendasi Terbaik
                </div>
            @endif
            <div class="card-body">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <span class="rank-badge rank-{{ $r['ranking'] }}">{{ $r['ranking'] }}</span>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $s['nama_sekolah'] ?? 'Sekolah #'.$r['sekolah_id'] }}</h6>
                        <span class="badge bg-{{ ($s['jenis'] ?? '') === 'Negeri' ? 'primary' : 'purple' }} me-1">{{ $s['jenis'] ?? '' }}</span>
                        <span class="badge bg-success">Akreditasi {{ $s['akreditasi'] ?? '' }}</span>
                    </div>
                </div>

                <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $s['kecamatan'] ?? '' }}, {{ $s['alamat'] ?? '' }}</div>
                <div class="small mb-3"><i class="bi bi-cash me-1 text-warning"></i>SPP: {{ $s['biaya_spp'] ?? 'Gratis' }}</div>

                {{-- Score bar --}}
                <div class="mb-2">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Skor SAW</span>
                        <strong>{{ $r['skor_total'] }}</strong>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar {{ $r['ranking'] === 1 ? 'bg-warning' : 'bg-primary' }}"
                             style="width:{{ $r['skor_total'] * 100 }}%"></div>
                    </div>
                </div>

                {{-- Per-criterion detail --}}
                <details class="mt-3">
                    <summary class="small text-primary" style="cursor:pointer">Lihat detail perhitungan</summary>
                    <div class="mt-2">
                        @foreach($r['detail'] as $d)
                        <div class="d-flex justify-content-between small py-1 border-bottom">
                            <span class="text-muted">{{ $d['kode'] }} {{ $d['nama'] }}</span>
                            <span>{{ $d['normalized'] }} × {{ $d['bobot'] }} = <strong>{{ $d['weighted'] }}</strong></span>
                        </div>
                        @endforeach
                    </div>
                </details>

                <a href="{{ route('user.rekomendasi.sekolah', $r['sekolah_id']) }}" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    <i class="bi bi-info-circle me-1"></i>Lihat Detail Sekolah
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Full ranking table --}}
@if(count($rankedResults) > 3)
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-list-ol me-2"></i>Semua Hasil (Peringkat Lengkap)</div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Rank</th>
                    <th>Nama Sekolah</th>
                    <th>Jenis</th>
                    <th>Akreditasi</th>
                    <th>Biaya SPP</th>
                    <th class="text-center">Skor SAW</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($rankedResults as $r)
            @php $s = $r['sekolah'] ?? null; @endphp
            <tr>
                <td class="ps-3">
                    <span class="rank-badge rank-{{ $r['ranking'] <= 3 ? $r['ranking'] : 'other' }}">{{ $r['ranking'] }}</span>
                </td>
                <td class="fw-semibold">{{ $s['nama_sekolah'] ?? '-' }}</td>
                <td><span class="badge bg-{{ ($s['jenis'] ?? '') === 'Negeri' ? 'primary' : 'secondary' }}">{{ $s['jenis'] ?? '' }}</span></td>
                <td><span class="badge bg-success">{{ $s['akreditasi'] ?? '' }}</span></td>
                <td class="small">{{ $s['biaya_spp'] ?? 'Gratis' }}</td>
                <td class="text-center">
                    <span class="badge bg-primary">{{ $r['skor_total'] }}</span>
                </td>
                <td>
                    <a href="{{ route('user.rekomendasi.sekolah', $r['sekolah_id']) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
