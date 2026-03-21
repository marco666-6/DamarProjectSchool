@extends('layouts.app')
@section('title','Detail Siswa')
@section('page-title','Detail Siswa')

@section('content')
<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $siswa->foto_url }}" class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover">
                <h5 class="fw-bold mb-1">{{ $siswa->nama_siswa }}</h5>
                <span class="badge bg-primary mb-2">Kelas {{ $siswa->kelas }}</span>
                <div class="small text-muted">NISN: {{ $siswa->nisn }}</div>
                <hr>
                <div class="text-start small">
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Orang Tua</span><span>{{ $siswa->nama_orangtua }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Pekerjaan</span><span>{{ $siswa->pekerjaan_orangtua ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">HP Ortu</span><span>{{ $siswa->phone_orangtua ?? '-' }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">L/P</span><span>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</span></div>
                    <div class="d-flex justify-content-between py-1"><span class="text-muted">Tgl Lahir</span><span>{{ $siswa->tanggal_lahir?->format('d M Y') ?? '-' }}</span></div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn btn-sm btn-warning flex-grow-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary flex-grow-1">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        {{-- Nilai --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold"><i class="bi bi-journal-text me-2"></i>Laporan Nilai</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Mata Pelajaran</th><th>Semester</th><th>Tugas</th><th>Ujian</th><th>Praktikum</th><th>Akhir</th><th>Predikat</th></tr></thead>
                    <tbody>
                    @forelse($siswa->nilai as $n)
                    <tr>
                        <td>{{ $n->mataPelajaran?->nama_mapel }}</td>
                        <td class="small text-muted">{{ $n->semester }}</td>
                        <td>{{ $n->nilai_tugas ?? '-' }}</td>
                        <td>{{ $n->nilai_ujian ?? '-' }}</td>
                        <td>{{ $n->nilai_praktikum ?? '-' }}</td>
                        <td><strong>{{ $n->nilai_akhir ?? '-' }}</strong></td>
                        <td><span class="badge bg-{{ $n->predikat === 'A' ? 'success' : ($n->predikat === 'B' ? 'primary' : ($n->predikat === 'C' ? 'warning' : 'danger')) }}">{{ $n->predikat }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada nilai.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Kegiatan --}}
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-calendar-event me-2"></i>Kegiatan</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Kegiatan</th><th>Jenis</th><th>Tanggal</th><th>Prestasi</th></tr></thead>
                    <tbody>
                    @forelse($siswa->kegiatan as $k)
                    <tr>
                        <td>{{ $k->nama_kegiatan }}</td>
                        <td><span class="badge bg-info text-dark">{{ $k->jenis_kegiatan }}</span></td>
                        <td class="small text-muted">{{ $k->tanggal_kegiatan?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $k->prestasi ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada kegiatan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
