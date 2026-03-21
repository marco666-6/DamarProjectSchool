<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — School Portal BIIS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: linear-gradient(135deg,#134d2c,#1a6b3c,#22543d); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem 0; }
        .card { border:none; border-radius:1.25rem; box-shadow:0 20px 60px rgba(0,0,0,.25); max-width:460px; width:100%; }
        .card-header { background:linear-gradient(135deg,#134d2c,#1a6b3c); color:#fff; border-radius:1.25rem 1.25rem 0 0 !important; padding:1.75rem 2rem; text-align:center; }
        .card-body { padding:2rem; }
        .form-control:focus { border-color:#1a6b3c; box-shadow:0 0 0 .2rem rgba(26,107,60,.15); }
        .btn-primary { background:#1a6b3c; border:none; }
        .btn-primary:hover { background:#134d2c; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <i class="bi bi-person-plus-fill" style="font-size:2rem"></i>
        <h5 class="fw-700 mt-2 mb-0">Buat Akun Baru</h5>
        <small class="opacity-75">Batam Integrated Islamic School</small>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Nama orang tua / wali" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="email@contoh.com" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">No. Telepon (Opsional)</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label small fw-semibold">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-semibold py-2">
                <i class="bi bi-person-check me-2"></i>Daftar Sekarang
            </button>
        </form>
        <hr class="my-3">
        <p class="text-center small text-muted mb-0">
            Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold" style="color:#1a6b3c">Masuk di sini</a>
        </p>
    </div>
</div>
</body>
</html>
