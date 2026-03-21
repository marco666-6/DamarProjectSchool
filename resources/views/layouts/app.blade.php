<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'School Portal') — BIIS</title>

    {{-- Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary:       #1a6b3c;
            --primary-dark:  #134d2c;
            --primary-light: #e8f5ee;
            --accent:        #f5a623;
        }
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            position: fixed; top: 0; left: 0; z-index: 1000;
            transition: transform .3s ease;
            display: flex; flex-direction: column;
        }
        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        #sidebar .sidebar-brand h5 { color:#fff; font-weight:700; margin:0; font-size:.95rem; }
        #sidebar .sidebar-brand small { color:rgba(255,255,255,.6); font-size:.75rem; }
        #sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: .55rem 1.25rem;
            border-radius: 0 2rem 2rem 0;
            margin: .1rem 1rem .1rem 0;
            font-size: .875rem;
            display: flex; align-items: center; gap: .6rem;
            transition: all .2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 1.2rem; }
        #sidebar .nav-section {
            color: rgba(255,255,255,.4);
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 1rem 1.25rem .3rem;
        }
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.1);
        }

        /* ── Main ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .topbar .page-title { font-weight: 600; font-size: 1.05rem; color: #1f2937; margin: 0; }
        .content-area { padding: 1.5rem; flex: 1; }

        /* ── Cards ── */
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.08); border-radius: .75rem; }
        .card-header { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 1rem 1.25rem; }

        /* ── Stats cards ── */
        .stat-card {
            background: #fff;
            border-radius: .75rem;
            padding: 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            border-left: 4px solid var(--primary);
        }
        .stat-card .stat-icon {
            width: 52px; height: 52px;
            border-radius: .75rem;
            background: var(--primary-light);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .stat-value { font-size: 1.6rem; font-weight: 700; color: #1f2937; line-height: 1; }
        .stat-card .stat-label { font-size: .8rem; color: #6b7280; margin-top: .15rem; }

        /* ── Badge colors ── */
        .badge-akreditasi-A  { background: #065f46; color:#fff; }
        .badge-akreditasi-B  { background: #1e40af; color:#fff; }
        .badge-akreditasi-C  { background: #92400e; color:#fff; }
        .badge-negeri  { background: #1e40af; color:#fff; }
        .badge-swasta  { background: #6b21a8; color:#fff; }

        /* ── SAW result card ── */
        .result-card { border-radius: .75rem; overflow: hidden; transition: transform .2s, box-shadow .2s; }
        .result-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.12); }
        .rank-badge { width: 40px; height: 40px; border-radius: 50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem; }
        .rank-1 { background: #fbbf24; color:#7c2d12; }
        .rank-2 { background: #d1d5db; color:#374151; }
        .rank-3 { background: #ca8a04; color:#fff; }
        .rank-other { background: #e5e7eb; color:#4b5563; }

        /* ── Mobile ── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── Sidebar ── --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <h5><i class="bi bi-mortarboard-fill me-2"></i>School Portal</h5>
        <small>Batam Integrated Islamic School</small>
    </div>

    <div class="py-2 flex-grow-1 overflow-auto">
        @auth
            @if(auth()->user()->isAdmin())
                @include('layouts.sidebar-admin')
            @elseif(auth()->user()->isGuru())
                @include('layouts.sidebar-guru')
            @else
                @include('layouts.sidebar-user')
            @endif
        @endauth
    </div>

    <div class="sidebar-footer">
        @auth
        <div class="d-flex align-items-center gap-2 mb-2">
            @if(auth()->user()->foto)
                <img src="{{ auth()->user()->foto_url }}" class="rounded-circle" width="32" height="32" style="object-fit:cover">
            @else
                <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;color:var(--primary);font-weight:700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <div class="text-white" style="font-size:.8rem;font-weight:600">{{ Str::limit(auth()->user()->name, 20) }}</div>
                <div style="font-size:.7rem;color:rgba(255,255,255,.5)">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm w-100" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.2)">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
        @endauth
    </div>
</nav>

{{-- ── Main Content ── --}}
<div id="main-content">
    {{-- Topbar --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-person-circle me-1"></i>Profil
            </a>
        </div>
    </div>

    {{-- Flash messages --}}
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    {{-- Page Content --}}
    <div class="content-area">
        @yield('content')
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Init Select2
    $(document).ready(function() {
        $('.select2').select2({ theme: 'bootstrap-5' });
    });

    // SweetAlert2 confirm for delete
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById(this.dataset.form);
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(result => { if (result.isConfirmed) form.submit(); });
        });
    });
</script>
@stack('scripts')
</body>
</html>
