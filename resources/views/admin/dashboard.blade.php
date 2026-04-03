@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-kicker', 'Control Center')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Kelola profil sekolah, data akademik, aktivitas, dan insight rekomendasi dari satu tampilan.')

@push('styles')
<style>
    .dashboard-grid { display: grid; gap: 1.5rem; }
    .chart-wrapper { position: relative; min-height: 320px; }
    .student-highlight { display: flex; align-items: center; gap: .95rem; padding: .95rem 0; border-bottom: 1px solid rgba(148, 163, 184, .12); }
    .student-highlight:last-child { border-bottom: none; padding-bottom: 0; }
    .student-highlight img, .student-avatar {
        width: 52px; height: 52px; border-radius: 18px; object-fit: cover;
        background: rgba(25,135,84,.12); display: grid; place-items: center; color: #198754; font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="dashboard-grid">
    <div class="dashboard-panel hero-panel">
        <div class="row g-4 align-items-center position-relative">
            <div class="col-lg-8">
                <div class="small text-uppercase fw-bold muted" style="letter-spacing:.2em;">School Overview</div>
                <h2 class="mt-2 mb-2 fw-bold">{{ $school->nama_sekolah }}</h2>
                <p class="muted mb-4">Landing page publik, dashboard internal, dan data profil sekolah sekarang bergerak dalam satu bahasa visual yang konsisten dan lebih informatif.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge rounded-pill text-bg-light px-3 py-2">Akreditasi {{ $school->akreditasi ?: '-' }}</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ $stats['total_kegiatan'] }} kegiatan</span>
                    <span class="badge rounded-pill text-bg-light px-3 py-2">{{ number_format($stats['avg_nilai'], 1) }} rata-rata nilai</span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white bg-opacity-10 rounded-4 p-4 border border-white border-opacity-10">
                    <div class="small muted">Kepala Sekolah</div>
                    <div class="fs-5 fw-semibold mb-3">{{ $school->kepala_sekolah ?: 'Belum diatur' }}</div>
                    <div class="small muted">Alamat</div>
                    <div class="fw-semibold">{{ trim(implode(', ', array_filter([$school->alamat, $school->kota, $school->provinsi]))) ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach([
            ['label' => 'Siswa Aktif', 'value' => $stats['total_siswa'], 'icon' => 'bi-people', 'helper' => 'Peserta didik aktif'],
            ['label' => 'Guru Aktif', 'value' => $stats['total_guru'], 'icon' => 'bi-person-badge', 'helper' => 'Tenaga pengajar aktif'],
            ['label' => 'Orang Tua/User', 'value' => $stats['total_user'], 'icon' => 'bi-person-check', 'helper' => 'Akun wali murid'],
            ['label' => 'SMP Rekomendasi', 'value' => $stats['total_sekolah'], 'icon' => 'bi-building', 'helper' => 'Data SAW aktif'],
            ['label' => 'Kriteria SAW', 'value' => $stats['total_kriteria'], 'icon' => 'bi-sliders', 'helper' => 'Bobot penilaian'],
            ['label' => 'Riwayat Rekomendasi', 'value' => $stats['total_rekomendasi'], 'icon' => 'bi-stars', 'helper' => 'Total proses selesai'],
            ['label' => 'Rata-rata Nilai', 'value' => number_format($stats['avg_nilai'], 1), 'icon' => 'bi-graph-up-arrow', 'helper' => 'Semua mapel'],
            ['label' => 'Kegiatan Tercatat', 'value' => $stats['total_kegiatan'], 'icon' => 'bi-calendar-event', 'helper' => 'Agenda dan prestasi'],
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

    @if(!$bobotCheck['valid'])
        <div class="alert alert-warning mb-0">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Total bobot SAW saat ini <strong>{{ $bobotCheck['sum'] }}</strong>. Bobot harus tepat <strong>1.0</strong> agar rekomendasi valid.
            <a href="{{ route('admin.kriteria.index') }}" class="alert-link ms-2">Perbaiki sekarang</a>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div>
                        <div class="page-kicker">Analytics</div>
                        <div class="fw-bold fs-5 text-dark">Statistik utama sekolah</div>
                    </div>
                    <div class="chart-toolbar d-flex gap-2">
                        <select class="form-select" id="adminChartType">
                            <option value="bar">Bar</option>
                            <option value="line">Line</option>
                            <option value="doughnut">Doughnut</option>
                        </select>
                        <select class="form-select" id="adminChartDataset">
                            <option value="kelas">Siswa per Kelas</option>
                            <option value="nilai">Tren Nilai</option>
                            <option value="kegiatan">Jenis Kegiatan</option>
                            <option value="akreditasi">Akreditasi Sekolah</option>
                            <option value="gender">Gender Siswa</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-wrapper">
                        <canvas id="adminDashboardChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="page-kicker">Quick Access</div>
                    <div class="fw-bold fs-5 text-dark">Aksi cepat admin</div>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @foreach($quickActions as $action)
                        <a href="{{ $action['route'] }}" class="quick-link">
                            <span class="quick-link-icon bg-{{ $action['tone'] }} bg-opacity-10 text-{{ $action['tone'] }}">
                                <i class="bi {{ $action['icon'] }}"></i>
                            </span>
                            <div>
                                <div class="fw-semibold">{{ $action['label'] }}</div>
                                <div class="small text-muted">Akses modul terkait tanpa berpindah alur kerja.</div>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="page-kicker">Students</div>
                        <div class="fw-bold fs-5 text-dark">Siswa dengan performa terbaik</div>
                    </div>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @forelse($topStudents as $student)
                        <div class="student-highlight">
                            @if($student->foto)
                                <img src="{{ $student->foto_url }}" alt="{{ $student->nama_siswa }}">
                            @else
                                <div class="student-avatar">{{ strtoupper(substr($student->nama_siswa, 0, 1)) }}</div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $student->nama_siswa }}</div>
                                <div class="small text-muted">Kelas {{ $student->kelas ?: '-' }} • {{ number_format((float) $student->average_nilai, 1) }} rata-rata nilai</div>
                            </div>
                            <span class="badge badge-soft-success rounded-pill">{{ $student->kegiatan_count }} kegiatan</span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada data siswa untuk dirangkum.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <div class="page-kicker">Activity Feed</div>
                        <div class="fw-bold fs-5 text-dark">Kegiatan terbaru</div>
                    </div>
                    <a href="{{ route('admin.kegiatan.index') }}" class="btn btn-outline-success rounded-pill btn-sm px-3">Kelola</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Kegiatan</th>
                                    <th>Siswa</th>
                                    <th>Guru</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentKegiatan as $activity)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold">{{ $activity->nama_kegiatan }}</div>
                                            <div class="small text-muted">{{ $activity->jenis_kegiatan }}</div>
                                        </td>
                                        <td>{{ $activity->siswa?->nama_siswa ?: '-' }}</td>
                                        <td>{{ $activity->guru?->nama_guru ?: '-' }}</td>
                                        <td>{{ optional($activity->tanggal_kegiatan ?? $activity->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kegiatan terbaru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Siswa Terbaru</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Nama</th><th>Kelas</th><th>NISN</th></tr></thead>
                            <tbody>
                                @forelse($recentSiswa as $siswa)
                                    <tr>
                                        <td class="ps-4">{{ $siswa->nama_siswa }}</td>
                                        <td><span class="badge badge-soft-primary rounded-pill">{{ $siswa->kelas ?: '-' }}</span></td>
                                        <td class="text-muted small">{{ $siswa->nisn }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Guru Terbaru</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">Nama</th><th>Email</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse($recentGuru as $guru)
                                    <tr>
                                        <td class="ps-4">{{ $guru->nama_guru }}</td>
                                        <td class="small text-muted">{{ $guru->email }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $guru->is_active ? 'badge-soft-success' : 'text-bg-secondary' }}">
                                                {{ $guru->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header"><div class="fw-bold fs-5 text-dark">Rekomendasi Terbaru</div></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light"><tr><th class="ps-4">User</th><th>Skor</th><th>Waktu</th></tr></thead>
                            <tbody>
                                @forelse($recentRekomen as $item)
                                    <tr>
                                        <td class="ps-4">{{ $item->user?->name ?: '-' }}</td>
                                        <td><span class="badge badge-soft-warning rounded-pill">{{ $item->skor_total }}</span></td>
                                        <td class="small text-muted">{{ $item->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada proses rekomendasi.</td></tr>
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
        const chartCanvas = document.getElementById('adminDashboardChart');
        if (!chartCanvas) {
            return;
        }

        const datasets = {
            kelas: {
                labels: @json($kelasStats->pluck('kelas')),
                values: @json($kelasStats->pluck('total')),
                label: 'Jumlah Siswa'
            },
            nilai: {
                labels: @json($nilaiTrend->pluck('semester')),
                values: @json($nilaiTrend->pluck('average_score')->map(fn ($value) => round((float) $value, 2))),
                label: 'Rata-rata Nilai'
            },
            kegiatan: {
                labels: @json($kegiatanStats->pluck('jenis_kegiatan')),
                values: @json($kegiatanStats->pluck('total')),
                label: 'Jumlah Kegiatan'
            },
            akreditasi: {
                labels: @json($schoolAccreditationStats->pluck('akreditasi')),
                values: @json($schoolAccreditationStats->pluck('total')),
                label: 'Sekolah per Akreditasi'
            },
            gender: {
                labels: @json($genderStats->pluck('label')),
                values: @json($genderStats->pluck('total')),
                label: 'Sebaran Gender'
            }
        };

        const typeSelect = document.getElementById('adminChartType');
        const datasetSelect = document.getElementById('adminChartDataset');
        let chart;

        function palette() {
            return ['#198754', '#34a853', '#95d5b2', '#0f5d3a', '#2dd4bf', '#84cc16'];
        }

        function renderChart() {
            const key = datasetSelect.value;
            const type = typeSelect.value;
            const current = datasets[key];
            if (chart) {
                chart.destroy();
            }
            chart = new Chart(chartCanvas, {
                type,
                data: {
                    labels: current.labels,
                    datasets: [{
                        label: current.label,
                        data: current.values,
                        borderColor: '#198754',
                        backgroundColor: type === 'doughnut' ? palette() : 'rgba(25, 135, 84, .2)',
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
                    scales: type === 'doughnut' ? {} : {
                        y: { beginAtZero: true, ticks: { precision: 0 } }
                    }
                }
            });
        }

        typeSelect.addEventListener('change', renderChart);
        datasetSelect.addEventListener('change', renderChart);
        renderChart();
    });
</script>
@endpush
