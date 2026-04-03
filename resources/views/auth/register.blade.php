<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Damar Project School</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top left, rgba(52, 168, 83, .18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(15, 93, 58, .2), transparent 30%),
                linear-gradient(135deg, #0d2a1d 0%, #0f5d3a 45%, #198754 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1.5rem;
        }
        .register-card {
            width: min(720px, 100%);
            background: rgba(255,255,255,.94);
            border-radius: 30px;
            box-shadow: 0 28px 60px rgba(0,0,0,.18);
            padding: 2.4rem;
        }
        .hero-strip {
            background: linear-gradient(135deg, rgba(15, 93, 58, .08), rgba(52, 168, 83, .16));
            border: 1px solid rgba(25,135,84,.1);
            border-radius: 24px;
            padding: 1.2rem 1.3rem;
        }
        .form-control {
            min-height: 52px;
            border-radius: 16px;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.12);
        }
        .btn-register {
            min-height: 52px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #0f5d3a, #198754);
            box-shadow: 0 16px 28px rgba(25,135,84,.18);
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="hero-strip d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <div class="text-success text-uppercase small fw-bold" style="letter-spacing:.18em;">Registrasi</div>
                <h1 class="h2 fw-bold mb-1">Buat akun wali murid</h1>
                <p class="text-muted mb-0">Akun baru akan langsung terhubung ke portal pengguna untuk melihat data siswa, nilai, kegiatan, dan rekomendasi sekolah.</p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-success rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nama orang tua / wali" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat') }}" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat domisili">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register text-white w-100 fw-semibold mt-4">
                <i class="bi bi-person-check me-2"></i>Buat Akun
            </button>
        </form>

        <hr class="my-4">
        <p class="text-center text-muted mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-success">Masuk sekarang</a>
        </p>
    </div>
</body>
</html>
