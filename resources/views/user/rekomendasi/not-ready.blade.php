@extends('layouts.app')
@section('title','Sistem Belum Siap')
@section('page-title','Rekomendasi SMP')

@section('content')
<div class="text-center py-5">
    <i class="bi bi-tools" style="font-size:4rem;color:#d97706"></i>
    <h4 class="mt-3 fw-bold">Sistem Rekomendasi Belum Siap</h4>
    <p class="text-muted">Admin belum mengkonfigurasi kriteria dan data sekolah untuk sistem SAW.<br>Silakan hubungi admin untuk mengatur sistem terlebih dahulu.</p>
    <a href="{{ route('user.dashboard') }}" class="btn btn-primary mt-2"><i class="bi bi-house me-1"></i>Kembali ke Dashboard</a>
</div>
@endsection
