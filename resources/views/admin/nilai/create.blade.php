@extends('layouts.app')
@section('title', 'Kelola Nilai Siswa')
@section('page-title', 'Kelola Nilai per Siswa')
@section('page-subtitle', 'Isi atau perbarui banyak mata pelajaran dalam satu halaman untuk satu siswa dan satu semester.')

@section('content')
<div class="row g-4">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <div class="fw-bold fs-5 text-dark">Pilih data yang ingin dikelola</div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.nilai.create') }}" class="d-grid gap-3">
                    <div>
                        <label class="form-label fw-semibold">Siswa</label>
                        <select name="siswa_id" class="form-select select2" required>
                            <option value="">Pilih siswa</option>
                            @foreach($siswaList as $siswa)
                                <option value="{{ $siswa->id }}" {{ request('siswa_id', $selectedSiswa?->id) == $siswa->id ? 'selected' : '' }}>
                                    {{ $siswa->nama_siswa }} ({{ $siswa->kelas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label fw-semibold">Semester</label>
                        <input type="text" name="semester" class="form-control" value="{{ request('semester', $selectedSemester) }}" placeholder="Contoh: Ganjil 2026/2027" required>
                    </div>
                    <button type="submit" class="btn btn-outline-success">
                        <i class="bi bi-search me-1"></i>Buka Nilai
                    </button>
                </form>

                <hr class="my-4">

                <div class="small text-muted">
                    <div class="fw-semibold text-dark mb-2">Cara pakai</div>
                    <div class="mb-2">1. Pilih siswa dan semester.</div>
                    <div class="mb-2">2. Isi nilai untuk semua mata pelajaran yang diperlukan.</div>
                    <div class="mb-2">3. Biarkan kosong jika mapel belum dinilai.</div>
                    <div>4. Centang hapus jika nilai mapel lama ingin dihilangkan.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <div class="page-kicker">Input Massal Nilai</div>
                    <div class="fw-bold fs-5 text-dark">
                        {{ $selectedSiswa ? $selectedSiswa->nama_siswa . ' - ' . $selectedSemester : 'Pilih siswa terlebih dahulu' }}
                    </div>
                </div>
                @if($selectedSiswa)
                    <span class="badge badge-soft-primary rounded-pill px-3 py-2">Kelas {{ $selectedSiswa->kelas ?: '-' }}</span>
                @endif
            </div>
            <div class="card-body">
                @if(!$selectedSiswa)
                    <div class="text-center py-5 text-muted">
                        Pilih siswa dan semester di panel kiri untuk mulai mengelola nilai.
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.nilai.store') }}">
                        @csrf
                        <input type="hidden" name="siswa_id" value="{{ $selectedSiswa->id }}">
                        <input type="hidden" name="semester" value="{{ $selectedSemester }}">

                        <div class="alert alert-info">
                            Nilai akhir dihitung otomatis dari tugas 30%, ujian 50%, dan praktikum 20%.
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                        <th>Tugas</th>
                                        <th>Ujian</th>
                                        <th>Praktikum</th>
                                        <th>Catatan</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mapelList as $mapel)
                                        @php $existing = $nilaiMap->get($mapel->id); @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ $mapel->nama_mapel }}</td>
                                            <td class="small text-muted">{{ $mapel->guru?->nama_guru ?: 'Guru belum diatur' }}</td>
                                            <td><input type="number" name="nilai[{{ $mapel->id }}][nilai_tugas]" class="form-control form-control-sm" min="0" max="100" step="0.01" value="{{ old("nilai.{$mapel->id}.nilai_tugas", $existing?->nilai_tugas) }}"></td>
                                            <td><input type="number" name="nilai[{{ $mapel->id }}][nilai_ujian]" class="form-control form-control-sm" min="0" max="100" step="0.01" value="{{ old("nilai.{$mapel->id}.nilai_ujian", $existing?->nilai_ujian) }}"></td>
                                            <td><input type="number" name="nilai[{{ $mapel->id }}][nilai_praktikum]" class="form-control form-control-sm" min="0" max="100" step="0.01" value="{{ old("nilai.{$mapel->id}.nilai_praktikum", $existing?->nilai_praktikum) }}"></td>
                                            <td><input type="text" name="nilai[{{ $mapel->id }}][catatan]" class="form-control form-control-sm" value="{{ old("nilai.{$mapel->id}.catatan", $existing?->catatan) }}" placeholder="Opsional"></td>
                                            <td class="text-center">
                                                <input type="checkbox" name="nilai[{{ $mapel->id }}][hapus]" value="1" {{ old("nilai.{$mapel->id}.hapus") ? 'checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i>Simpan Semua Perubahan
                            </button>
                            <a href="{{ route('admin.nilai.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
