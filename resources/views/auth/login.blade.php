<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Damar Project School</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top left, rgba(52, 168, 83, .22), transparent 30%),
                radial-gradient(circle at bottom right, rgba(15, 93, 58, .18), transparent 32%),
                linear-gradient(135deg, #0d2a1d 0%, #0f5d3a 45%, #198754 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1.5rem;
        }
        .auth-shell {
            width: min(1080px, 100%);
            background: rgba(255,255,255,.92);
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 28px 60px rgba(0,0,0,.18);
            display: grid;
            grid-template-columns: 1.05fr .95fr;
        }
        .auth-hero {
            background: linear-gradient(160deg, rgba(15, 93, 58, .98), rgba(52, 168, 83, .92));
            color: #fff;
            padding: 3rem;
            position: relative;
        }
        .auth-hero::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            right: -100px;
            bottom: -120px;
            background: radial-gradient(circle, rgba(255,255,255,.14), transparent 70%);
        }
        .auth-badge {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            padding: .55rem .95rem;
            font-size: .82rem;
            margin-bottom: 1.2rem;
        }
        .auth-panel {
            padding: 3rem;
            background: #fff;
        }
        .info-card {
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 22px;
            padding: 1rem;
        }
        .form-control, .input-group-text {
            border-radius: 16px;
            min-height: 52px;
        }
        .input-group > .form-control,
        .input-group > .btn,
        .input-group > .input-group-text { border-radius: 16px; }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25, 135, 84, .12);
        }
        .btn-login {
            background: linear-gradient(135deg, #0f5d3a, #198754);
            border: none;
            border-radius: 16px;
            min-height: 52px;
            box-shadow: 0 16px 28px rgba(25, 135, 84, .18);
        }
        .btn-login:hover { filter: brightness(.97); }
        @media (max-width: 991.98px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-hero { padding: 2rem; }
            .auth-panel { padding: 2rem; }
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <section class="auth-hero">
            <div class="auth-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Portal Sekolah Terintegrasi
            </div>
            <h1 class="display-5 fw-bold mb-3">Masuk ke Damar Project School</h1>
            <p class="text-white-50 fs-5 mb-4">Akses landing page sekolah, data akademik, dashboard peran, dan rekomendasi sekolah dari satu sistem yang konsisten.</p>

            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="info-card">
                        <div class="small text-white-50">Akses Cepat</div>
                        <div class="fw-semibold">Dashboard Admin, Guru, dan Wali Murid</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="info-card">
                        <div class="small text-white-50">Landing Page</div>
                        <div class="fw-semibold">Profil dan pengumuman berbasis database</div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </section>

        <section class="auth-panel">
            <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <div class="text-success text-uppercase small fw-bold" style="letter-spacing:.18em;">Login</div>
                    <h2 class="fw-bold mb-1">Selamat datang kembali</h2>
                    <p class="text-muted mb-0">Masukkan email dan password untuk melanjutkan.</p>
                </div>
                <div class="rounded-4 p-3" style="background:rgba(25,135,84,.08);color:#198754;">
                    <i class="bi bi-shield-lock fs-4"></i>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-4">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="nama@email.com" required autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="pwd" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" placeholder="Password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-muted" for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('home') }}#kontak" class="text-decoration-none text-success fw-semibold">Butuh bantuan?</a>
                </div>

                <button type="submit" class="btn btn-login text-white w-100 fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                </button>
            </form>

            <hr class="my-4">
            <p class="text-center text-muted mb-0">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-success">Daftar di sini</a>
            </p>
        </section>
    </div>

    <script>
        function togglePwd() {
            const input = document.getElementById('pwd');
            const icon = document.getElementById('eye-icon');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        }
    </script>
</body>
</html>
