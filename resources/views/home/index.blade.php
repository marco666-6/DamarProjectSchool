@extends('layouts.public')

@section('title', ($school->nama_sekolah ?: 'Damar Project School') . ' - Profil Sekolah')

@php
    $schoolName = $school->nama_sekolah ?: 'Damar Project School';
    $schoolShortName = $school->singkatan ?: 'Damar Project School';
    $contactAddress = trim(implode(', ', array_filter([$school->alamat, $school->kota, $school->provinsi])));
    $contactPhone = $school->phone;
    $contactEmail = $school->email;
    $headlineAnnouncements = $announcements->take(3);
    $headlineFacilities = collect($school->fasilitas ?? [])->take(4);
@endphp

@push('styles')
<style>
    .hero-section { padding: 4.5rem 0 2.5rem; }
    .hero-shell {
        background:
            linear-gradient(135deg, rgba(15, 93, 58, .96) 0%, rgba(52, 168, 83, .92) 100%),
            url('{{ $school->foto_url }}') center/cover;
        border-radius: 32px;
        padding: 3rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 28px 54px rgba(15, 93, 58, .22);
    }
    .hero-shell::after {
        content: '';
        position: absolute;
        inset: auto -10% -40% auto;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(255,255,255,.16), transparent 68%);
    }
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .55rem .95rem;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        color: #fff;
        font-size: .88rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .hero-title {
        color: #fff;
        font-size: clamp(2.1rem, 4.6vw, 3.8rem);
        line-height: 1.04;
        letter-spacing: -.04em;
        font-weight: 800;
        max-width: 680px;
    }
    .hero-text {
        color: rgba(255,255,255,.86);
        max-width: 620px;
        font-size: 1rem;
    }
    .hero-panel {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.16);
        backdrop-filter: blur(12px);
        color: #fff;
        border-radius: 24px;
        padding: 1.25rem;
    }
    .stat-pill {
        background: #fff;
        padding: 1.05rem 1.1rem;
        border-radius: 22px;
        border: 1px solid rgba(15, 93, 58, .08);
        box-shadow: 0 18px 34px rgba(15, 23, 42, .05);
        height: 100%;
    }
    .stat-pill .icon {
        width: 48px;
        height: 48px;
        display: grid;
        place-items: center;
        border-radius: 15px;
        background: rgba(25, 135, 84, .12);
        color: #198754;
        font-size: 1.25rem;
    }
    .mini-metric {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: .8rem;
        align-items: start;
    }
    .feature-card, .announcement-card {
        background: rgba(255,255,255,.92);
        border-radius: 24px;
        border: 1px solid rgba(15, 93, 58, .08);
        box-shadow: 0 18px 34px rgba(15, 23, 42, .05);
        height: 100%;
    }
    .feature-card, .announcement-card { padding: 1.4rem; }
    .info-strip {
        background: linear-gradient(135deg, rgba(25, 135, 84, .08), rgba(52, 168, 83, .14));
        border: 1px solid rgba(25, 135, 84, .08);
        border-radius: 20px;
        padding: 1.15rem;
    }
    .announcement-meta {
        color: #198754;
        font-size: .76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
    }
    .chart-shell {
        position: relative;
        min-height: 280px;
    }
    @media (max-width: 991.98px) {
        .hero-shell { padding: 2rem; }
    }
</style>
@endpush

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="hero-shell">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <span class="hero-badge">
                        <i class="bi bi-stars"></i>
                        Profil Sekolah dan Portal Informasi
                    </span>
                    <h1 class="hero-title">{{ $school->nama_sekolah ?: 'Damar Project School' }}</h1>
                    <p class="hero-text mt-3 mb-4">
                        {{ $school->visi ?: 'Profil sekolah, pengumuman penting, dan akses portal akademik dalam satu tampilan yang lebih ringan dan fokus.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill px-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Portal
                        </a>
                        <a href="#pengumuman" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            <i class="bi bi-megaphone me-2"></i>Pengumuman
                        </a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-4 bg-white bg-opacity-10 p-3">
                                <i class="bi bi-award fs-3"></i>
                            </div>
                            <div>
                                <div class="small text-white-50">Akreditasi</div>
                                <div class="fs-4 fw-bold">{{ $school->akreditasi ?: 'Belum diatur' }}</div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="border rounded-4 p-3 border-light border-opacity-25">
                                    <div class="small text-white-50">Kepala Sekolah</div>
                                    <div class="fw-semibold">{{ $school->kepala_sekolah ?: 'Belum diisi' }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded-4 p-3 border-light border-opacity-25">
                                    <div class="small text-white-50">NPSN</div>
                                    <div class="fw-semibold">{{ $school->npsn ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded-4 p-3 border-light border-opacity-25">
                                    <div class="small text-white-50">Lokasi</div>
                                    <div class="fw-semibold">{{ $contactAddress ?: 'Alamat sekolah belum tersedia' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1" id="statistik">
            <div class="col-6 col-lg-3">
                <div class="stat-pill">
                    <div class="mini-metric">
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $stats['total_siswa'] }}</div>
                            <div class="text-muted">Siswa aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-pill">
                    <div class="mini-metric">
                        <div class="icon"><i class="bi bi-person-badge"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $stats['total_guru'] }}</div>
                            <div class="text-muted">Guru aktif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-pill">
                    <div class="mini-metric">
                        <div class="icon"><i class="bi bi-graph-up"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ number_format($stats['rata_nilai'], 1) }}</div>
                            <div class="text-muted">Rata-rata nilai</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-pill">
                    <div class="mini-metric">
                        <div class="icon"><i class="bi bi-calendar-event"></i></div>
                        <div>
                            <div class="fs-3 fw-bold">{{ $stats['total_kegiatan'] }}</div>
                            <div class="text-muted">Kegiatan tercatat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4" id="profil">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="feature-card h-100">
                    <div class="section-eyebrow">Profil</div>
                    <h2 class="section-title mt-2 mb-3">Informasi inti sekolah</h2>
                    <p class="text-muted mb-4">{{ $school->sejarah ?: 'Profil sekolah belum dilengkapi. Admin dapat memperbarui data profil agar informasi publik selalu konsisten dan terbaru.' }}</p>

                    <div class="info-strip mb-3">
                        <div class="fw-bold text-success mb-2">Visi</div>
                        <div class="text-muted">{{ $school->visi ?: 'Belum tersedia' }}</div>
                    </div>

                    <div class="info-strip">
                        <div class="fw-bold text-success mb-2">Fasilitas Utama</div>
                        <ul class="mb-0 ps-3 text-muted">
                            @forelse($headlineFacilities as $facility)
                                <li>{{ $facility }}</li>
                            @empty
                                <li>Daftar fasilitas belum diisi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="pengumuman">
                <div class="feature-card h-100">
                    <div class="section-eyebrow">Pengumuman</div>
                    <h2 class="section-title mt-2 mb-3">Informasi terbaru sekolah</h2>
                    <div class="d-flex flex-column gap-3">
                        @forelse($headlineAnnouncements as $announcement)
                            <div class="announcement-card">
                                <div class="announcement-meta mb-2">{{ $announcement->jenis_kegiatan }}</div>
                                <h5 class="fw-bold mb-2">{{ $announcement->nama_kegiatan }}</h5>
                                <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($announcement->deskripsi ?: 'Informasi kegiatan sekolah terbaru.', 100) }}</p>
                                <div class="small text-muted">
                                    <i class="bi bi-calendar-event me-2"></i>{{ optional($announcement->tanggal_kegiatan ?? $announcement->created_at)->translatedFormat('d M Y') }}
                                </div>
                            </div>
                        @empty
                            <div class="announcement-card">
                                <p class="text-muted mb-0">Belum ada pengumuman yang tersimpan di database.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="feature-card h-100">
                    <div class="section-eyebrow">Statistik</div>
                    <h2 class="section-title mt-2 mb-3">Ringkasan akademik</h2>
                    <p class="text-muted mb-4">Grafik utama tetap tersedia, tapi sekarang lebih fokus pada tren nilai agar halaman depan terasa cepat dan bersih.</p>
                    <div class="chart-shell">
                        <canvas id="landingChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="feature-card h-100">
                    <div class="section-eyebrow">Kontak</div>
                    <h2 class="section-title mt-2 mb-3">Hubungi sekolah</h2>
                    <div class="d-flex flex-column gap-3">
                        <div class="info-strip">
                            <div class="fw-bold text-success mb-2">Alamat</div>
                            <div class="text-muted">{{ $contactAddress ?: 'Alamat sekolah belum tersedia' }}</div>
                        </div>
                        <div class="info-strip">
                            <div class="fw-bold text-success mb-2">Telepon</div>
                            <div class="text-muted">{{ $school->phone ?: '-' }}</div>
                        </div>
                        <div class="info-strip">
                            <div class="fw-bold text-success mb-2">Email</div>
                            <div class="text-muted">{{ $school->email ?: '-' }}</div>
                        </div>
                        <div class="info-strip">
                            <div class="fw-bold text-success mb-2">Website</div>
                            <div class="text-muted">{{ $school->website ?: 'Belum diatur' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('landingChart');
        if (!ctx) {
            return;
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($scoreTrend->pluck('semester')),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: @json($scoreTrend->pluck('average_score')->map(fn ($value) => round((float) $value, 2))),
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.16)',
                    pointBackgroundColor: '#0f5d3a',
                    fill: true,
                    tension: .35,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush
