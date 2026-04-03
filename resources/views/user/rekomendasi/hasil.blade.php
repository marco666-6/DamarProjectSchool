@extends('layouts.app')
@section('title', 'Hasil Rekomendasi Sekolah')
@section('page-title', 'Hasil Rekomendasi Sekolah')
@section('page-subtitle', 'Sekolah diurutkan dari yang paling sesuai sampai yang kurang sesuai berdasarkan kebutuhan yang Anda isi.')

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <p class="text-muted mb-0">Ditemukan <strong>{{ count($rankedResults) }}</strong> sekolah yang berhasil dibandingkan.</p>
    <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-repeat me-1"></i>Coba Lagi
    </a>
</div>

@if(count($rankedResults) >= 1)
    <div class="row g-3 mb-4">
        @foreach(array_slice($rankedResults, 0, 3) as $r)
            @php $s = $r['sekolah'] ?? null; @endphp
            <div class="col-md-4">
                <div class="card result-card h-100 {{ $r['ranking'] === 1 ? 'border-success border-2' : '' }}">
                    @if($r['ranking'] === 1)
                        <div class="bg-success text-white text-center small py-1 fw-semibold">
                            Pilihan paling cocok saat ini
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="rank-badge rank-{{ $r['ranking'] <= 3 ? $r['ranking'] : 'other' }}">{{ $r['ranking'] }}</span>
                            <div>
                                <h6 class="fw-bold mb-1">{{ $s['nama_sekolah'] ?? 'Sekolah #'.$r['sekolah_id'] }}</h6>
                                <div class="small text-muted">{{ $s['jenis'] ?? '-' }} • Akreditasi {{ $s['akreditasi'] ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="small text-muted mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $s['alamat'] ?? '-' }}</div>
                        <div class="small text-muted mb-3"><i class="bi bi-cash me-1"></i>SPP {{ $s['biaya_spp'] ?? '-' }}</div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Skor kecocokan</span>
                                <strong>{{ $r['skor_total'] }}</strong>
                            </div>
                            <div class="progress" style="height:8px">
                                <div class="progress-bar bg-success" style="width:{{ min(100, $r['skor_total'] * 100) }}%"></div>
                            </div>
                        </div>

                        <details>
                            <summary class="small text-success" style="cursor:pointer">Lihat alasan singkat</summary>
                            <div class="mt-2 small text-muted">
                                @foreach($r['detail'] as $detail)
                                    <div>{{ $detail['nama'] }} memberi nilai {{ $detail['weighted'] }}</div>
                                @endforeach
                            </div>
                        </details>

                        <a href="{{ route('user.rekomendasi.sekolah', $r['sekolah_id']) }}" class="btn btn-outline-success btn-sm w-100 mt-3">
                            Lihat Detail Sekolah
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if(count($rankedResults) > 3)
    <div class="card">
        <div class="card-header fw-semibold">Urutan Lengkap</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Urutan</th>
                        <th>Nama Sekolah</th>
                        <th>Status</th>
                        <th>Akreditasi</th>
                        <th>SPP</th>
                        <th class="text-center">Skor</th>
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
                            <td>{{ $s['jenis'] ?? '-' }}</td>
                            <td>{{ $s['akreditasi'] ?? '-' }}</td>
                            <td class="small">{{ $s['biaya_spp'] ?? '-' }}</td>
                            <td class="text-center"><span class="badge text-bg-primary">{{ $r['skor_total'] }}</span></td>
                            <td><a href="{{ route('user.rekomendasi.sekolah', $r['sekolah_id']) }}" class="btn btn-outline-success btn-sm">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
