<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Damar Project School')</title>
    @php
        $schoolInfo = $school ?? \App\Models\SekolahInfo::getInstance();
    @endphp
    <link rel="icon" type="image/png" href="{{ $schoolInfo->logo_url }}">
    <link rel="shortcut icon" href="{{ $schoolInfo->logo_url }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #52648f;
            --primary-dark: #314062;
            --primary-light: #dfe7f6;
            --accent: #d7b86a;
            --surface: #f8faf7;
            --ink: #263247;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at top left, rgba(215, 184, 106, 0.12), transparent 24%),
                radial-gradient(circle at bottom right, rgba(82, 100, 143, 0.10), transparent 28%),
                var(--surface);
            color: #1f2937;
            padding-top: 76px;
        }

        .navbar {
            background: rgba(255, 255, 255, .86);
            border-bottom: 1px solid rgba(82, 100, 143, .12);
            box-shadow: 0 14px 34px rgba(49, 64, 98, 0.08);
            backdrop-filter: blur(14px);
            padding: .75rem 0;
            transition: all .3s ease;
        }

        .navbar.scrolled {
            padding: .5rem 0;
            box-shadow: 0 18px 42px rgba(49, 64, 98, 0.12);
        }

        .navbar-brand {
            color: var(--ink) !important;
            display: flex;
            align-items: center;
            gap: .85rem;
            font-weight: 700;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #fff;
            display: grid;
            place-items: center;
            font-size: 1.35rem;
            box-shadow: 0 10px 24px rgba(49, 64, 98, .14), inset 0 0 0 1px rgba(82, 100, 143, .10);
            overflow: hidden;
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }

        .brand-title {
            font-size: 1.1rem;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: .74rem;
            font-weight: 400;
            color: #64748b;
        }

        .nav-link {
            color: #526075 !important;
            padding: .55rem 1rem !important;
            border-radius: 999px;
            font-weight: 500;
            transition: all .24s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(82, 100, 143, .08);
            color: var(--primary-dark) !important;
            box-shadow: inset 0 0 0 1px rgba(82, 100, 143, .10);
            transform: translateY(-1px);
        }

        .navbar-toggler {
            border-color: rgba(82, 100, 143, .18);
        }

        .navbar-toggler-icon {
            filter: invert(34%) sepia(13%) saturate(1100%) hue-rotate(184deg) brightness(88%);
        }

        .dropdown-menu {
            border: none;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(49, 64, 98, 0.12);
            padding: .55rem;
        }

        .dropdown-item {
            border-radius: 12px;
            padding: .75rem .95rem;
            transition: all .2s ease;
        }

        .dropdown-item:hover {
            background: rgba(82, 100, 143, .10);
            color: var(--primary-dark);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #f1f5fb 0%, #f7efd8 100%);
            border: 1px solid rgba(82, 100, 143, .14);
            color: var(--primary-dark);
            box-shadow: 0 16px 30px rgba(49, 64, 98, .10);
        }

        .btn-gradient:hover {
            color: var(--primary-dark);
            filter: brightness(.96);
        }

        .btn-soft {
            background: rgba(82, 100, 143, .10);
            color: var(--primary-dark);
            border: 1px solid rgba(18, 40, 108, .12);
        }

        .btn-soft:hover {
            background: rgba(215, 184, 106, .18);
            color: var(--primary-dark);
        }

        .section-title {
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -.03em;
        }

        .section-eyebrow {
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: .18em;
            font-weight: 700;
            font-size: .72rem;
        }

        .glass-card,
        .card {
            border: 1px solid rgba(82, 100, 143, .10);
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(49, 64, 98, .07);
        }

        .glass-card {
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(12px);
        }

        .card:hover {
            transform: translateY(-3px);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        footer {
            margin-top: auto;
            background: linear-gradient(135deg, #eef4fb 0%, #f6f1de 100%);
            color: #334155;
            border-top: 1px solid rgba(82, 100, 143, .12);
        }

        footer a {
            color: var(--primary-dark);
            text-decoration: none;
        }

        footer a:hover {
            color: #111827;
        }

        .alert {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(18, 40, 108, .08);
        }

        @media (max-width: 991.98px) {
            body {
                padding-top: 70px;
            }

            .navbar-collapse {
                background: rgba(255, 255, 255, .96);
                border-radius: 20px;
                margin-top: 1rem;
                padding: 1rem;
                box-shadow: 0 18px 38px rgba(15, 23, 42, .12);
            }

            .brand-subtitle {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-logo">
                    <img src="{{ $schoolInfo->logo_url }}" alt="{{ $schoolName ?? 'Logo sekolah' }}">
                </span>
                <span>
                    <span class="d-block brand-title">{{ $schoolName ?? 'Damar Project School' }}</span>
                    <span class="brand-subtitle">{{ $schoolShortName ?? 'Portal Profil & Akademik' }}</span>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#profil">
                            <i class="bi bi-building me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pengumuman">
                            <i class="bi bi-megaphone me-1"></i>Pengumuman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#statistik">
                            <i class="bi bi-graph-up me-1"></i>Statistik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">
                            <i class="bi bi-envelope me-1"></i>Kontak
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i
                                            class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                            class="bi bi-person me-2"></i>Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success') || session('error'))
            <div class="container pt-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">{{ $schoolName ?? 'Damar Project School' }}</h5>
                    <p class="mb-0 text-light-emphasis">Portal profil sekolah, informasi akademik, dan layanan orang tua
                        dengan tampilan yang lebih informatif dan ramah pengguna.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Akses Cepat</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="#pengumuman"><i class="bi bi-chevron-right me-2"></i>Pengumuman
                                terbaru</a></li>
                        <li class="mb-2"><a href="#statistik"><i class="bi bi-chevron-right me-2"></i>Statistik
                                sekolah</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}"><i class="bi bi-chevron-right me-2"></i>Masuk ke
                                portal</a></li>
                    </ul>
                </div>
                <div class="col-md-4" id="kontak">
                    <h6 class="fw-bold mb-3">Kontak Sekolah</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i
                                class="bi bi-geo-alt me-2"></i>{{ $contactAddress ?? 'Alamat sekolah belum tersedia' }}
                        </li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $contactPhone ?? '-' }}</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>{{ $contactEmail ?? '-' }}</li>
                    </ul>
                </div>
            </div>
            <hr class="border-light opacity-25 my-4">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
                <p class="mb-0 text-light-emphasis">&copy; {{ date('Y') }}
                    {{ $schoolShortName ?? 'Damar Project School' }}. All rights reserved.
                </p>
                <p class="mb-0 text-light-emphasis">Built for school information, parent access, and recommendation
                    workflows.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
