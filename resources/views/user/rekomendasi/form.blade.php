@extends('layouts.app')
@section('title','Rekomendasi SMP')
@section('page-title','Cari Rekomendasi SMP')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-search me-2 text-primary"></i>Masukkan Preferensi Anda</h5>
                <p class="text-muted small mb-0 mt-1">Sistem akan menghitung rekomendasi SMP terbaik menggunakan metode SAW (Simple Additive Weighting).</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.rekomendasi.hitung') }}">
                    @csrf
                    <div class="row g-3">
                    @foreach($kriteriaList as $k)
                    <div class="col-12">
                        <div class="p-3 rounded border bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <label class="form-label fw-semibold mb-0">
                                        <span class="badge bg-secondary me-1">{{ $k->kode_kriteria }}</span>
                                        {{ $k->nama_kriteria }}
                                    </label>
                                    <div class="small text-muted mt-1">{{ $k->deskripsi }}</div>
                                </div>
                                <span class="badge {{ $k->jenis === 'benefit' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $k->jenis === 'benefit' ? '↑ Benefit' : '↓ Cost' }}
                                    &nbsp;{{ $k->bobot_persen }}
                                </span>
                            </div>

                            @if($k->jenis === 'cost' && str_contains(strtolower($k->nama_kriteria), 'biaya'))
                                {{-- Budget input --}}
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="pref_{{ $k->id }}"
                                           class="form-control"
                                           placeholder="Batas maksimal biaya (kosongkan = abaikan)"
                                           min="0" step="50000">
                                    <span class="input-group-text">/bulan</span>
                                </div>
                                <div class="form-text">Masukkan anggaran SPP maksimal per bulan. Kosongkan jika tidak ada preferensi.</div>

                            @elseif($k->jenis === 'benefit' && str_contains(strtolower($k->nama_kriteria), 'akreditasi'))
                                {{-- Akreditasi picker --}}
                                <select name="pref_{{ $k->id }}" class="form-select">
                                    <option value="">Semua Akreditasi</option>
                                    <option value="100">Minimal A (100 poin)</option>
                                    <option value="80">Minimal B (80 poin)</option>
                                    <option value="60">Minimal C (60 poin)</option>
                                </select>

                            @elseif($k->jenis === 'cost' && str_contains(strtolower($k->nama_kriteria), 'jarak'))
                                {{-- Distance input --}}
                                <div class="input-group">
                                    <input type="number" name="pref_{{ $k->id }}" class="form-control"
                                           placeholder="Jarak maksimal (kosongkan = abaikan)" min="0" max="50" step="1">
                                    <span class="input-group-text">km</span>
                                </div>
                                <div class="form-text">Estimasi jarak maksimal dari rumah Anda ke sekolah.</div>

                            @else
                                {{-- Generic numeric --}}
                                <input type="number" name="pref_{{ $k->id }}" class="form-control"
                                       placeholder="Nilai preferensi (kosongkan = abaikan)" step="any">
                            @endif
                        </div>
                    </div>
                    @endforeach
                    </div>

                    <div class="mt-4 d-flex gap-3 align-items-center">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-calculator me-2"></i>Hitung Rekomendasi
                        </button>
                        <span class="text-muted small">Menggunakan algoritma SAW dengan {{ $kriteriaList->count() }} kriteria</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        {{-- How it works --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold"><i class="bi bi-info-circle me-2"></i>Cara Kerja Sistem</div>
            <div class="card-body small">
                <div class="d-flex gap-2 mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:.8rem">1</div>
                    <div><strong>Input Preferensi</strong><br>Masukkan kriteria yang penting bagi Anda (opsional).</div>
                </div>
                <div class="d-flex gap-2 mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:.8rem">2</div>
                    <div><strong>Normalisasi SAW</strong><br>Sistem menormalisasi setiap nilai sekolah per kriteria.</div>
                </div>
                <div class="d-flex gap-2 mb-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:.8rem">3</div>
                    <div><strong>Pembobotan</strong><br>Setiap kriteria diberi bobot sesuai tingkat kepentingannya.</div>
                </div>
                <div class="d-flex gap-2">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:.8rem">4</div>
                    <div><strong>Perankingan</strong><br>Sekolah diurutkan berdasarkan skor total tertinggi.</div>
                </div>
            </div>
        </div>

        {{-- History --}}
        @if($history->count())
        <div class="card">
            <div class="card-header fw-semibold d-flex justify-content-between">
                <span><i class="bi bi-clock-history me-2"></i>Riwayat Terakhir</span>
                <a href="{{ route('user.rekomendasi.history') }}" class="small text-decoration-none">Semua →</a>
            </div>
            <div class="list-group list-group-flush">
                @foreach($history as $h)
                <a href="{{ route('user.rekomendasi.hasil', $h) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <span class="small fw-semibold">Skor terbaik: {{ $h->skor_total }}</span>
                        <span class="text-muted" style="font-size:.75rem">{{ $h->created_at->diffForHumans() }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
