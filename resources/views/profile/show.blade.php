@extends('layouts.app')
@section('title','Profil Saya')
@section('page-title','Profil Saya')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $user->foto_url }}" class="rounded-circle mb-3" width="90" height="90" style="object-fit:cover">
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <span class="badge bg-{{ $user->role==='admin'?'danger':($user->role==='guru'?'primary':'success') }}">
                    {{ ucfirst($user->role) }}
                </span>
                <div class="mt-3 text-start small">
                    <div class="d-flex gap-2 mb-2"><i class="bi bi-envelope text-muted"></i><span>{{ $user->email }}</span></div>
                    @if($user->phone)<div class="d-flex gap-2 mb-2"><i class="bi bi-telephone text-muted"></i><span>{{ $user->phone }}</span></div>@endif
                    @if($user->alamat)<div class="d-flex gap-2 mb-2"><i class="bi bi-geo-alt text-muted"></i><span>{{ $user->alamat }}</span></div>@endif
                    @if($user->tanggal_lahir)<div class="d-flex gap-2"><i class="bi bi-calendar text-muted"></i><span>{{ $user->tanggal_lahir->format('d M Y') }}</span></div>@endif
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm w-100 mt-3">
                    <i class="bi bi-pencil me-1"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @if($guru)
        <div class="card mb-3">
            <div class="card-header fw-semibold"><i class="bi bi-person-badge me-2"></i>Data Kepegawaian</div>
            <div class="card-body small">
                <div class="row g-2">
                    <div class="col-6"><span class="text-muted">NIP</span><div class="fw-semibold">{{ $guru->nip??'-' }}</div></div>
                    <div class="col-6"><span class="text-muted">Pendidikan</span><div class="fw-semibold">{{ $guru->pendidikan_terakhir??'-' }}</div></div>
                    <div class="col-6"><span class="text-muted">Jenis Kelamin</span><div class="fw-semibold">{{ $guru->jenis_kelamin==='L'?'Laki-laki':($guru->jenis_kelamin==='P'?'Perempuan':'-') }}</div></div>
                    <div class="col-6"><span class="text-muted">Status</span><div><span class="badge bg-{{ $guru->is_active?'success':'secondary' }}">{{ $guru->is_active?'Aktif':'Nonaktif' }}</span></div></div>
                </div>
            </div>
        </div>
        @endif
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-shield-lock me-2"></i>Ubah Password</div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-semibold">Password Lama</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm mt-3"><i class="bi bi-key me-1"></i>Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
