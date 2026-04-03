<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Damar Project School')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sidebar-width: 296px;
            --primary: #198754;
            --primary-dark: #0f5d3a;
            --primary-soft: rgba(25, 135, 84, .12);
            --surface: #f4f8f5;
            --panel: rgba(255, 255, 255, .92);
            --ink: #123524;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(52, 168, 83, .14), transparent 22%),
                radial-gradient(circle at bottom right, rgba(15, 93, 58, .12), transparent 24%),
                var(--surface);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #334155;
        }

        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1035;
            padding: 1.1rem;
            background: linear-gradient(180deg, #0d2a1d 0%, #0f5d3a 38%, #198754 100%);
            box-shadow: 22px 0 45px rgba(15, 23, 42, .12);
            display: flex;
            flex-direction: column;
        }
        .sidebar-shell {
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 28px;
            background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
            backdrop-filter: blur(8px);
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .sidebar-brand {
            padding: 1.35rem 1.35rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand-badge {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background: rgba(255,255,255,.12);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.4rem;
        }
        .sidebar-brand h5 { color: #fff; margin: 0; font-weight: 800; letter-spacing: -.02em; }
        .sidebar-brand small { color: rgba(255,255,255,.64); }
        .sidebar-nav {
            padding: 1rem .75rem;
            overflow: auto;
            flex: 1;
        }
        .nav-section {
            color: rgba(255,255,255,.44);
            font-size: .68rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            font-weight: 700;
            padding: .95rem .85rem .35rem;
        }
        .nav-link {
            color: rgba(255,255,255,.82);
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .86rem .95rem;
            border-radius: 18px;
            margin-bottom: .3rem;
            font-weight: 500;
            transition: all .22s ease;
        }
        .nav-link i {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(255,255,255,.08);
        }
        .nav-link:hover,
        .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.13);
            transform: translateX(3px);
        }
        .nav-link:hover i,
        .nav-link.active i {
            background: rgba(255,255,255,.18);
        }
        .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,.08);
            padding: 1rem 1.15rem 1.2rem;
        }
        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: 1rem;
        }
        .sidebar-profile img,
        .avatar-fallback {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            object-fit: cover;
            background: rgba(255,255,255,.14);
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 700;
        }

        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.1rem 1.5rem 0;
        }
        .topbar-inner {
            background: rgba(255,255,255,.86);
            border: 1px solid rgba(15, 93, 58, .08);
            border-radius: 26px;
            padding: 1rem 1.15rem;
            box-shadow: 0 16px 38px rgba(15, 23, 42, .06);
            width: 100%;
            backdrop-filter: blur(10px);
        }
        .page-kicker {
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: .18em;
            font-size: .68rem;
            font-weight: 700;
        }
        .page-title { margin: 0; color: var(--ink); font-size: 1.55rem; font-weight: 800; letter-spacing: -.03em; }
        .page-subtitle { color: #64748b; margin: .15rem 0 0; }
        .content-area { padding: 1.5rem; }

        .card,
        .dashboard-panel {
            border: 1px solid rgba(15, 93, 58, .08);
            border-radius: 26px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .06);
            background: var(--panel);
            backdrop-filter: blur(10px);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(148, 163, 184, .12);
            padding: 1.1rem 1.3rem;
        }
        .card-body { padding: 1.3rem; }

        .hero-panel {
            padding: 1.4rem;
            color: #fff;
            background: linear-gradient(135deg, #0f5d3a 0%, #198754 68%, #34a853 100%);
            overflow: hidden;
            position: relative;
        }
        .hero-panel::after {
            content: '';
            position: absolute;
            width: 280px;
            height: 280px;
            right: -80px;
            bottom: -120px;
            background: radial-gradient(circle, rgba(255,255,255,.16), transparent 68%);
        }
        .hero-panel .muted { color: rgba(255,255,255,.78); }

        .stat-card {
            height: 100%;
            border-radius: 24px;
            padding: 1.15rem;
            background: rgba(255,255,255,.94);
            border: 1px solid rgba(15, 93, 58, .08);
            box-shadow: 0 16px 30px rgba(15, 23, 42, .05);
        }
        .stat-card .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            font-size: 1.35rem;
            background: var(--primary-soft);
            color: var(--primary);
            margin-bottom: .9rem;
        }
        .stat-value { font-size: 1.9rem; line-height: 1; color: var(--ink); font-weight: 800; letter-spacing: -.04em; }
        .stat-label { color: #64748b; margin-top: .35rem; font-size: .9rem; }
        .stat-helper { color: #94a3b8; font-size: .75rem; margin-top: .25rem; }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 18px;
            border: 1px solid rgba(15, 93, 58, .08);
            background: rgba(255,255,255,.72);
            text-decoration: none;
            color: inherit;
            transition: all .22s ease;
        }
        .quick-link:hover { transform: translateY(-2px); box-shadow: 0 14px 26px rgba(15, 23, 42, .08); }
        .quick-link-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
        }

        .table thead th {
            font-size: .78rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            border-bottom-width: 1px;
        }
        .table > :not(caption) > * > * { background: transparent; padding-top: .9rem; padding-bottom: .9rem; }
        .list-group-item {
            border-color: rgba(148, 163, 184, .12);
            padding: .95rem 1.1rem;
        }

        .alert {
            border: none;
            border-radius: 20px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .05);
        }

        .badge-soft-success { background: rgba(25,135,84,.12); color: #0f5d3a; }
        .badge-soft-primary { background: rgba(37,99,235,.12); color: #1d4ed8; }
        .badge-soft-warning { background: rgba(217,119,6,.12); color: #b45309; }
        .badge-soft-info { background: rgba(8,145,178,.12); color: #0e7490; }

        .chart-toolbar .form-select {
            border-radius: 14px;
            border-color: rgba(15, 93, 58, .12);
            min-width: 120px;
        }

        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); transition: transform .28s ease; }
            #sidebar.open { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav id="sidebar">
        <div class="sidebar-shell">
            <div class="sidebar-brand">
                <div class="d-flex align-items-center gap-3">
                    <div class="sidebar-brand-badge"><i class="bi bi-mortarboard-fill"></i></div>
                    <div>
                        <h5>{{ auth()->user()->isAdmin() ? 'Admin Hub' : (auth()->user()->isGuru() ? 'Teacher Hub' : 'Parent Hub') }}</h5>
                        <small>Damar Project School</small>
                    </div>
                </div>
            </div>

            <div class="sidebar-nav">
                @if(auth()->user()->isAdmin())
                    @include('layouts.sidebar-admin')
                @elseif(auth()->user()->isGuru())
                    @include('layouts.sidebar-guru')
                @else
                    @include('layouts.sidebar-user')
                @endif
            </div>

            <div class="sidebar-footer">
                <div class="sidebar-profile">
                    @if(auth()->user()->foto)
                        <img src="{{ auth()->user()->foto_url }}" alt="{{ auth()->user()->name }}">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <div>
                        <div class="text-white fw-semibold">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 22) }}</div>
                        <div class="small text-white-50">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-globe me-1"></i>Lihat Landing Page
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm w-100 text-white" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
                            <i class="bi bi-box-arrow-left me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div id="main-content">
        <div class="topbar">
            <div class="topbar-inner">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <button class="btn btn-outline-secondary d-lg-none" type="button" onclick="document.getElementById('sidebar').classList.toggle('open')">
                            <i class="bi bi-list"></i>
                        </button>
                        <div>
                            <div class="page-kicker">@yield('page-kicker', 'Dashboard Overview')</div>
                            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                            <p class="page-subtitle mb-0">@yield('page-subtitle', 'Pantau data, aksi cepat, dan insight penting dari satu tempat.') </p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <a href="{{ route('profile.show') }}" class="btn btn-light rounded-pill px-3">
                            <i class="bi bi-person-circle me-1"></i>Profil
                        </a>
                        <span class="badge rounded-pill text-bg-light px-3 py-2">
                            <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-octagon me-2"></i>Terdapat kesalahan input</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({ theme: 'bootstrap-5' });
        });

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const form = document.getElementById(this.dataset.form);
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Tindakan ini tidak dapat dibatalkan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed && form) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
