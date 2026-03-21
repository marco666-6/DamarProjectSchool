<div class="nav-section">Menu Utama</div>
<a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>

<div class="nav-section">Kelola Data</div>
<a href="{{ route('guru.nilai.index') }}" class="nav-link {{ request()->routeIs('guru.nilai.*') ? 'active' : '' }}">
    <i class="bi bi-journal-text"></i> Laporan Nilai
</a>
<a href="{{ route('guru.kegiatan.index') }}" class="nav-link {{ request()->routeIs('guru.kegiatan.*') ? 'active' : '' }}">
    <i class="bi bi-calendar-event"></i> Kegiatan Siswa
</a>

<div class="nav-section">Lihat Data</div>
<a href="{{ route('guru.siswa.index') }}" class="nav-link {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
    <i class="bi bi-people"></i> Data Siswa
</a>
<a href="{{ route('guru.sekolah') }}" class="nav-link {{ request()->routeIs('guru.sekolah') ? 'active' : '' }}">
    <i class="bi bi-building"></i> Info Sekolah
</a>
