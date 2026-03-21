<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — School Portal BIIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #134d2c 0%, #1a6b3c 50%, #22543d 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            overflow: hidden;
            width: 100%; max-width: 420px;
        }
        .login-header {
            background: linear-gradient(135deg, #134d2c, #1a6b3c);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .login-header .school-icon {
            width: 70px; height: 70px;
            background: rgba(255,255,255,.15);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        .login-header h4 { font-weight: 700; margin: 0; }
        .login-header p  { font-size: .85rem; opacity: .8; margin: .3rem 0 0; }
        .login-body { padding: 2rem; }
        .form-control:focus { border-color: #1a6b3c; box-shadow: 0 0 0 .2rem rgba(26,107,60,.15); }
        .btn-login { background: #1a6b3c; border: none; font-weight: 600; padding: .7rem; }
        .btn-login:hover { background: #134d2c; }
        .input-group-text { background: #f8f9fa; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-header">
        <div class="school-icon"><i class="bi bi-mortarboard-fill"></i></div>
        <h4>School Portal</h4>
        <p>Batam Integrated Islamic School</p>
    </div>
    <div class="login-body">
        <h5 class="fw-700 mb-1">Selamat Datang</h5>
        <p class="text-muted small mb-4">Masukkan email dan password Anda untuk masuk.</p>

        @if(session('success'))
            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold small">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="pwd" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        <hr class="my-3">
        <p class="text-center small text-muted mb-0">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color:#1a6b3c">Daftar sekarang</a>
        </p>
    </div>
</div>
<script>
function togglePwd() {
    const p = document.getElementById('pwd');
    const i = document.getElementById('eye-icon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
