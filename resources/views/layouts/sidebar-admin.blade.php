<div class="nav-section">Menu Utama</div>
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>

<div class="nav-section">Data Sekolah</div>
<a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
    <i class="bi bi-people"></i> Data Siswa
</a>
<a href="{{ route('admin.guru.index') }}" class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
    <i class="bi bi-person-badge"></i> Data Guru
</a>
<a href="{{ route('admin.mata-pelajaran.index') }}" class="nav-link {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
    <i class="bi bi-book"></i> Mata Pelajaran
</a>
<a href="{{ route('admin.nilai.index') }}" class="nav-link {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}">
    <i class="bi bi-journal-text"></i> Laporan Nilai
</a>
<a href="{{ route('admin.kegiatan.index') }}" class="nav-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
    <i class="bi bi-calendar-event"></i> Kegiatan Siswa
</a>

<div class="nav-section">Rekomendasi SAW</div>
<a href="{{ route('admin.kriteria.index') }}" class="nav-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}">
    <i class="bi bi-sliders"></i> Kriteria & Bobot
</a>
<a href="{{ route('admin.sekolah-rekomendasi.index') }}" class="nav-link {{ request()->routeIs('admin.sekolah-rekomendasi.*') ? 'active' : '' }}">
    <i class="bi bi-building"></i> Data SMP Batam
</a>
<a href="{{ route('admin.sekolah-rekomendasi.matriks') }}" class="nav-link {{ request()->routeIs('admin.sekolah-rekomendasi.matriks') ? 'active' : '' }}">
    <i class="bi bi-table"></i> Matriks SAW
</a>

<div class="nav-section">Pengaturan</div>
<a href="{{ route('admin.sekolah-info.edit') }}" class="nav-link {{ request()->routeIs('admin.sekolah-info.*') ? 'active' : '' }}">
    <i class="bi bi-gear"></i> Info Sekolah
</a>
<a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
    <i class="bi bi-person-gear"></i> Manajemen User
</a>
