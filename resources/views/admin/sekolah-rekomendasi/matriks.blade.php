@extends('layouts.app')
@section('title', 'Tabel Perbandingan Sekolah')
@section('page-title', 'Tabel Perbandingan Sekolah')
@section('page-subtitle', 'Halaman ini membantu admin memahami nilai yang dipakai sistem sebelum dan sesudah dihitung.')

@section('content')
<div class="alert alert-info">
    Sistem membandingkan setiap sekolah berdasarkan nilai pada tiap kriteria. Nilai asli ditampilkan di tabel pertama, lalu hasil perhitungannya ditampilkan di tabel kedua.
</div>

<div class="card mb-4">
    <div class="card-header">
        <div class="fw-bold fs-5 text-dark">1. Nilai asli yang diinput admin</div>
        <div class="small text-muted">{{ count($matrix['rows']) }} sekolah dibandingkan dengan {{ $matrix['kriteria']->count() }} kriteria.</div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0 text-center">
            <thead class="table-light">
                <tr>
                    <th class="text-start ps-3">Sekolah</th>
                    @foreach($matrix['kriteria'] as $k)
                        <th>
                            <div class="fw-semibold">{{ $k->nama_kriteria }}</div>
                            <div class="small text-muted">{{ $k->kode_kriteria }} • Bobot {{ $k->bobot_persen }}</div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($matrix['rows'] as $row)
                    <tr>
                        <td class="text-start ps-3 fw-semibold">{{ $row['sekolah'] }}</td>
                        @foreach($matrix['kriteria'] as $k)
                            <td>{{ $row[$k->kode_kriteria] !== null ? number_format($row[$k->kode_kriteria], 0, ',', '.') : '-' }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr><td colspan="{{ $matrix['kriteria']->count() + 1 }}" class="text-center text-muted py-4">Belum ada data sekolah yang bisa dibandingkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="fw-bold fs-5 text-dark">2. Hasil akhir rekomendasi</div>
        <div class="small text-muted">Skor total yang lebih besar berarti sekolah tersebut lebih cocok berdasarkan aturan dan bobot yang aktif saat ini.</div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Peringkat</th>
                    <th>Sekolah</th>
                    <th>Ringkasan Nilai</th>
                    <th class="text-center">Skor Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    @php $sekolah = $sekolahMap[$result['sekolah_id']] ?? null; @endphp
                    <tr>
                        <td class="ps-3">
                            <span class="badge rounded-pill {{ $result['ranking'] === 1 ? 'text-bg-success' : 'text-bg-light' }}">
                                #{{ $result['ranking'] }}
                            </span>
                        </td>
                        <td class="fw-semibold">{{ $sekolah?->nama_sekolah ?? 'Sekolah #'.$result['sekolah_id'] }}</td>
                        <td class="small text-muted">
                            @foreach($result['detail'] as $detail)
                                <div>{{ $detail['kode'] }}: nilai terhitung {{ $detail['weighted'] }}</div>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <span class="badge text-bg-primary fs-6">{{ $result['skor_total'] }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada hasil perhitungan yang bisa ditampilkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
