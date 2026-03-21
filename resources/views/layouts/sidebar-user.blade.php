<div class="nav-section">Menu Utama</div>
<a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>

<div class="nav-section">Informasi</div>
<a href="{{ route('user.data.sekolah') }}" class="nav-link {{ request()->routeIs('user.data.sekolah') ? 'active' : '' }}">
    <i class="bi bi-building"></i> Info Sekolah
</a>
<a href="{{ route('user.data.siswa') }}" class="nav-link {{ request()->routeIs('user.data.siswa*') ? 'active' : '' }}">
    <i class="bi bi-people"></i> Data Siswa
</a>
<a href="{{ route('user.data.guru') }}" class="nav-link {{ request()->routeIs('user.data.guru') ? 'active' : '' }}">
    <i class="bi bi-person-badge"></i> Data Guru
</a>
<a href="{{ route('user.data.nilai') }}" class="nav-link {{ request()->routeIs('user.data.nilai') ? 'active' : '' }}">
    <i class="bi bi-journal-text"></i> Laporan Nilai
</a>
<a href="{{ route('user.data.kegiatan') }}" class="nav-link {{ request()->routeIs('user.data.kegiatan') ? 'active' : '' }}">
    <i class="bi bi-calendar-event"></i> Kegiatan Siswa
</a>

<div class="nav-section">Rekomendasi SMP</div>
<a href="{{ route('user.rekomendasi.form') }}" class="nav-link {{ request()->routeIs('user.rekomendasi.form') ? 'active' : '' }}">
    <i class="bi bi-search"></i> Cari Rekomendasi
</a>
<a href="{{ route('user.rekomendasi.history') }}" class="nav-link {{ request()->routeIs('user.rekomendasi.history') ? 'active' : '' }}">
    <i class="bi bi-clock-history"></i> Riwayat Rekomendasi
</a>
