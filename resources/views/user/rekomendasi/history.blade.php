@extends('layouts.app')
@section('title','Riwayat Rekomendasi')
@section('page-title','Riwayat Rekomendasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-clock-history me-2"></i>Riwayat Pencarian Rekomendasi</span>
        <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Cari Baru</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th class="ps-3">#</th><th>Sekolah Terbaik</th><th>Skor Terbaik</th><th>Waktu</th><th></th></tr>
            </thead>
            <tbody>
            @forelse($history as $h)
            @php $top = ($h->ranked_results ?? [])[0] ?? null; @endphp
            <tr>
                <td class="ps-3 text-muted small">{{ $history->firstItem() + $loop->index }}</td>
                <td class="fw-semibold">{{ $top['sekolah']['nama_sekolah'] ?? '-' }}</td>
                <td><span class="badge bg-success">{{ $h->skor_total }}</span></td>
                <td class="text-muted small">{{ $h->created_at->format('d M Y H:i') }}</td>
                <td><a href="{{ route('user.rekomendasi.hasil', $h) }}" class="btn btn-sm btn-outline-primary">Lihat Hasil</a></td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat rekomendasi.<br>
                <a href="{{ route('user.rekomendasi.form') }}">Mulai pencarian pertama Anda</a>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($history->hasPages())
    <div class="card-footer">{{ $history->links() }}</div>
    @endif
</div>
@endsection
