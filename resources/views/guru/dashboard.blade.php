@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('page-kicker', 'Teacher Workspace')
@section('page-title', 'Dashboard Guru')
@section('page-subtitle', 'Pantau performa pengajaran, aktivitas siswa, dan pekerjaan rutin dengan shortcut yang lebih cepat.')

@push('styles')
<style>
    .chart-wrapper { position: relative; min-height: 300px; }
    .highlight-card {
        border-radius: 22px;
        padding: 1rem;
        background: rgba(25,135,84,.06);
        border: 1px solid rgba(25,135,84,.08);
    }
</style>
@endpush

@section('content')
<div class="d-grid gap-4">
    <div class="dashboard-panel hero-panel">
        <div class="row g-4 align-items-center position-relative">
            <div class="col-lg-8">
                <div class="small text-uppercase fw-bold muted" style="letter-spacing:.2em;">Teacher Profile</div>
                <h2 class="fw-bold mt-2 mb-2">{{ $guru->nama_guru }}</h2>
                <p class="muted mb-4">Ruang kerja guru kini menampilkan ringkasan nilai, kegiatan, tren semester, dan akses cepat untuk input data tanpa harus berpindah banyak halaman.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ $stats['total_mapel'] }} mata pelajaran</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ number_format($stats['avg_nilai'], 1) }} rata-rata nilai</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ $stats['prestasi'] }} kegiatan berprestasi</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-10 d-flex align-items-center gap-3">
                    <img src="{{ $guru->foto_url }}" class="rounded-4" width="72" height="72" style="object-fit:cover" alt="{{ $guru->nama_guru }}">
                    <div>
                        <div class="small muted">Pendidikan Terakhir</div>
                        <div class="fw-semibold">{{ $guru->pendidikan_terakhir ?: '-' }}</div>
                        <div class="small muted mt-2">NIP</div>
                        <div class="fw-semibold">{{ $guru->nip ?: 'Belum diisi' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach([
            ['label' => 'Nilai Diinput', 'value' => $stats['total_nilai'], 'icon' => 'bi-journal-text', 'helper' => 'Seluruh catatan nilai Anda'],
            ['label' => 'Kegiatan Dicatat', 'value' => $stats['total_kegiatan'], 'icon' => 'bi-calendar-event', 'helper' => 'Agenda dan pembinaan'],
            ['label' => 'Mata Pelajaran', 'value' => $stats['total_mapel'], 'icon' => 'bi-book', 'helper' => 'Tanggung jawab aktif'],
            ['label' => 'Rata-rata Nilai', 'value' => number_format($stats['avg_nilai'], 1), 'icon' => 'bi-graph-up-arrow', 'helper' => 'Kinerja akademik'],
            ['label' => 'Prestasi', 'value' => $stats['prestasi'], 'icon' => 'bi-trophy', 'helper' => 'Kegiatan dengan prestasi'],
            ['label' => 'Total Siswa', 'value' => $stats['total_siswa'], 'icon' => 'bi-people', 'helper' => 'Populasi sekolah aktif'],
        ] as $item)
            <div class="col-6 col-xl-2">
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
                    <div class="fw-bold fs-5 text-dark">Shortcut guru</div>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @foreach($quickActions as $action)
                        <a href="{{ $action['route'] }}" class="quick-link">
                            <span class="quick-link-icon bg-{{ $action['tone'] }} bg-opacity-10 text-{{ $action['tone'] }}">
                                <i class="bi {{ $action['icon'] }}"></i>
                            </span>
                            <div>
                                <div class="fw-semibold">{{ $action['label'] }}</div>
                                <div class="small text-muted">Jalankan tugas utama lebih cepat.</div>
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
                        <div class="fw-bold fs-5 text-dark">Insight pembelajaran</div>
                    </div>
                    <div class="chart-toolbar d-flex gap-2">
                        <select class="form-select" id="guruChartType">
                            <option value="bar">Bar</option>
                            <option value="line">Line</option>
                            <option value="doughnut">Doughnut</option>
                        </select>
                        <select class="form-select" id="guruChartDataset">
                            <option value="mapel">Performa per Mapel</option>
                            <option value="semester">Tren Semester</option>
                            <option value="kegiatan">Jenis Kegiatan</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="guruDashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Sorotan Siswa</div></div>
                <div class="card-body d-flex flex-column gap-3">
                    @forelse($studentHighlights as $student)
                        <div class="highlight-card d-flex align-items-center justify-content-between gap-3">
                            <div>
                                <div class="fw-semibold">{{ $student->nama_siswa }}</div>
                                <div class="small text-muted">Kelas {{ $student->kelas ?: '-' }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">{{ number_format((float) $student->average_nilai, 1) }}</div>
                                <div class="small text-muted">{{ $student->kegiatan_bersama }} kegiatan</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada siswa yang bisa diringkas dari data Anda.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="fw-bold fs-5 text-dark">Nilai Terbaru</div>
                    <a href="{{ route('guru.nilai.index') }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Kelola</a>
                </div>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="fw-bold fs-5 text-dark">Kegiatan Terbaru</div>
                    <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Kelola</a>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @forelse($recentKegiatan as $item)
                        <div class="highlight-card">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $item->nama_kegiatan }}</div>
                                    <div class="small text-muted">{{ $item->siswa?->nama_siswa ?: '-' }} • {{ $item->jenis_kegiatan }}</div>
                                </div>
                                <div class="small text-muted">{{ optional($item->tanggal_kegiatan)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada kegiatan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('guruDashboardChart');
        if (!canvas) {
            return;
        }

        const datasets = {
            mapel: {
                labels: @json($nilaiPerMapel->map(fn ($item) => $item->mataPelajaran?->nama_mapel ?: 'Mapel')->values()),
                values: @json($nilaiPerMapel->pluck('average_score')->map(fn ($value) => round((float) $value, 2))),
                label: 'Rata-rata Nilai'
            },
            semester: {
                labels: @json($semesterTrend->pluck('semester')),
                values: @json($semesterTrend->pluck('average_score')->map(fn ($value) => round((float) $value, 2))),
                label: 'Tren Semester'
            },
            kegiatan: {
                labels: @json($kegiatanPerJenis->pluck('jenis_kegiatan')),
                values: @json($kegiatanPerJenis->pluck('total')),
                label: 'Jenis Kegiatan'
            }
        };

        const typeSelect = document.getElementById('guruChartType');
        const datasetSelect = document.getElementById('guruChartDataset');
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
