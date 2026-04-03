@extends('layouts.app')
@section('title', 'Dashboard Pengguna')
@section('page-kicker', 'Parent Portal')
@section('page-title', 'Dashboard Wali Murid')
@section('page-subtitle', 'Lihat data anak, tren nilai, kegiatan terbaru, dan riwayat rekomendasi dalam satu dashboard yang lebih informatif.')

@push('styles')
<style>
    .chart-wrapper { position: relative; min-height: 290px; }
    .child-card {
        padding: 1rem;
        border-radius: 20px;
        border: 1px solid rgba(15, 93, 58, .08);
        background: rgba(255,255,255,.78);
    }
    .child-card img { width: 56px; height: 56px; border-radius: 18px; object-fit: cover; }
</style>
@endpush

@section('content')
<div class="d-grid gap-4">
    <div class="dashboard-panel hero-panel">
        <div class="row g-4 align-items-center position-relative">
            <div class="col-lg-8">
                <div class="small text-uppercase fw-bold muted" style="letter-spacing:.2em;">Welcome Back</div>
                <h2 class="fw-bold mt-2 mb-2">{{ $user->name }}</h2>
                <p class="muted mb-4">Portal wali murid kini menampilkan ringkasan akademik, aktivitas anak, dan shortcut ke fitur rekomendasi sekolah dalam tampilan yang lebih rapi dan mudah dipakai.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ $stats['jumlah_anak'] }} anak terhubung</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ number_format($stats['rata_nilai'], 1) }} rata-rata nilai</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ $stats['riwayat_rekomendasi'] }} riwayat rekomendasi</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-10">
                    <div class="small muted">Sekolah</div>
                    <div class="fw-semibold mb-2">{{ $sekolahInfo->nama_sekolah }}</div>
                    <div class="small muted">Hari ini</div>
                    <div class="fw-semibold">{{ now()->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach([
            ['label' => 'Anak Terhubung', 'value' => $stats['jumlah_anak'], 'icon' => 'bi-people', 'helper' => 'Data siswa keluarga'],
            ['label' => 'Rata-rata Nilai', 'value' => number_format($stats['rata_nilai'], 1), 'icon' => 'bi-graph-up-arrow', 'helper' => 'Nilai akademik terbaru'],
            ['label' => 'Kegiatan Anak', 'value' => $stats['jumlah_kegiatan'], 'icon' => 'bi-calendar-event', 'helper' => 'Agenda dan prestasi'],
            ['label' => 'Riwayat Rekomendasi', 'value' => $stats['riwayat_rekomendasi'], 'icon' => 'bi-stars', 'helper' => 'Pencarian sekolah'],
        ] as $item)
            <div class="col-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="bi {{ $item['icon'] }}"></i></div>
                    <div class="stat-value">{{ $item['value'] }}</div>
                    <div class="stat-label">{{ $item['label'] }}</div>
                    <div class="stat-helper">{{ $item['helper'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="page-kicker">Quick Access</div>
                    <div class="fw-bold fs-5 text-dark">Menu cepat</div>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @foreach($quickActions as $action)
                        <a href="{{ $action['route'] }}" class="quick-link">
                            <span class="quick-link-icon bg-{{ $action['tone'] }} bg-opacity-10 text-{{ $action['tone'] }}">
                                <i class="bi {{ $action['icon'] }}"></i>
                            </span>
                            <div>
                                <div class="fw-semibold">{{ $action['label'] }}</div>
                                <div class="small text-muted">Buka fitur yang paling sering dipakai.</div>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div>
                        <div class="page-kicker">Analytics</div>
                        <div class="fw-bold fs-5 text-dark">Ringkasan anak dan kegiatan</div>
                    </div>
                    <div class="chart-toolbar d-flex gap-2">
                        <select class="form-select" id="userChartType">
                            <option value="bar">Bar</option>
                            <option value="line">Line</option>
                            <option value="doughnut">Doughnut</option>
                        </select>
                        <select class="form-select" id="userChartDataset">
                            <option value="nilai">Tren Nilai</option>
                            <option value="kegiatan">Jenis Kegiatan</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="userDashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Data Anak</div></div>
                <div class="card-body d-flex flex-column gap-3">
                    @forelse($siswaList as $student)
                        <div class="child-card d-flex align-items-center gap-3">
                            <img src="{{ $student->foto_url }}" alt="{{ $student->nama_siswa }}">
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $student->nama_siswa }}</div>
                                <div class="small text-muted">Kelas {{ $student->kelas ?: '-' }} • NISN {{ $student->nisn }}</div>
                            </div>
                            <a href="{{ route('user.data.siswa.show', $student) }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Detail</a>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada data siswa yang terhubung ke akun Anda.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Nilai Terbaru</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Siswa</th><th>Mapel</th><th>Nilai</th></tr></thead>
                            <tbody>
                                @forelse($recentNilai as $nilai)
                                    <tr>
                                        <td class="ps-4">{{ $nilai->siswa?->nama_siswa }}</td>
                                        <td class="small text-muted">{{ $nilai->mataPelajaran?->nama_mapel }}</td>
                                        <td><span class="badge badge-soft-success rounded-pill">{{ $nilai->nilai_akhir }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada nilai.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Kegiatan Terbaru</div></div>
                <div class="card-body d-flex flex-column gap-3">
                    @forelse($recentActivities as $activity)
                        <div class="child-card">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $activity->nama_kegiatan }}</div>
                                    <div class="small text-muted">{{ $activity->siswa?->nama_siswa ?: '-' }} • {{ $activity->jenis_kegiatan }}</div>
                                </div>
                                <div class="small text-muted">{{ optional($activity->tanggal_kegiatan)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada kegiatan siswa.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Rekomendasi Terakhir</div></div>
                <div class="card-body">
                    @if($lastRekomen && count($lastRekomen->ranked_results ?? []))
                        @php $top = $lastRekomen->ranked_results[0] ?? null; @endphp
                        @if($top)
                            <div class="text-center mb-4">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold mb-3" style="width:68px;height:68px;background:linear-gradient(135deg,#0f5d3a,#198754);font-size:1.4rem;">1</div>
                                <h4 class="fw-bold mb-1">{{ $top['sekolah']['nama_sekolah'] ?? '-' }}</h4>
                                <div class="text-muted mb-2">{{ $top['sekolah']['jenis'] ?? '-' }} • Akreditasi {{ $top['sekolah']['akreditasi'] ?? '-' }}</div>
                                <span class="badge badge-soft-success rounded-pill fs-6 px-3 py-2">Skor {{ $top['skor_total'] }}</span>
                            </div>
                            <a href="{{ route('user.rekomendasi.hasil', $lastRekomen) }}" class="btn btn-success w-100 rounded-pill">Lihat Hasil Lengkap</a>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;background:rgba(25,135,84,.12);color:#198754;">
                                <i class="bi bi-search fs-3"></i>
                            </div>
                            <h5 class="fw-bold">Belum ada rekomendasi</h5>
                            <p class="text-muted">Mulai proses rekomendasi sekolah untuk mendapatkan pilihan terbaik bagi anak Anda.</p>
                            <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-success rounded-pill px-4">Cari Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Riwayat Rekomendasi</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Tanggal</th><th>Skor</th><th>Status</th><th>Aksi</th></tr></thead>
                            <tbody>
                                @forelse($recommendationHistory as $history)
                                    <tr>
                                        <td class="ps-4">{{ $history->created_at->format('d M Y H:i') }}</td>
                                        <td><span class="badge badge-soft-warning rounded-pill">{{ $history->skor_total }}</span></td>
                                        <td>{{ $history->status_rekomendasi ?: 'Selesai' }}</td>
                                        <td><a href="{{ route('user.rekomendasi.hasil', $history) }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Buka</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat rekomendasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('userDashboardChart');
        if (!canvas) {
            return;
        }

        const datasets = {
            nilai: {
                labels: @json($nilaiTrend->pluck('semester')),
                values: @json($nilaiTrend->pluck('average_score')->map(fn ($value) => round((float) $value, 2))),
                label: 'Tren Nilai'
            },
            kegiatan: {
                labels: @json($activityBreakdown->pluck('jenis_kegiatan')),
                values: @json($activityBreakdown->pluck('total')),
                label: 'Jenis Kegiatan'
            }
        };

        const typeSelect = document.getElementById('userChartType');
        const datasetSelect = document.getElementById('userChartDataset');
        let chart;

        function render() {
            const type = typeSelect.value;
            const current = datasets[datasetSelect.value];
            if (chart) {
                chart.destroy();
            }
            chart = new Chart(canvas, {
                type,
                data: {
                    labels: current.labels,
                    datasets: [{
                        label: current.label,
                        data: current.values,
                        borderColor: '#198754',
                        backgroundColor: type === 'doughnut'
                            ? ['#198754', '#34a853', '#95d5b2', '#0f5d3a', '#2dd4bf']
                            : 'rgba(25, 135, 84, .18)',
                        pointBackgroundColor: '#0f5d3a',
                        fill: type === 'line',
                        tension: .34,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } },
                    scales: type === 'doughnut' ? {} : { y: { beginAtZero: true } }
                }
            });
        }

        typeSelect.addEventListener('change', render);
        datasetSelect.addEventListener('change', render);
        render();
    });
</script>
@endpush
