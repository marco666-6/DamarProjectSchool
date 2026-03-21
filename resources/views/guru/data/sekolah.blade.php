@extends('layouts.app')
@section('title','Info Sekolah')
@section('page-title','Informasi Sekolah')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-4">
                <img src="{{ $sekolahInfo->logo_url }}" class="mb-3" height="70" style="object-fit:contain">
                <h5 class="fw-bold">{{ $sekolahInfo->nama_sekolah }}</h5>
                <span class="badge bg-success">{{ $sekolahInfo->singkatan }}</span>
                <span class="badge bg-primary ms-1">Akreditasi {{ $sekolahInfo->akreditasi }}</span>
                <hr>
                <div class="text-start small">
                    @if($sekolahInfo->kepala_sekolah)<div class="d-flex gap-2 mb-2"><i class="bi bi-person-badge text-primary"></i><div><div class="fw-semibold">Kepala Sekolah</div><div class="text-muted">{{ $sekolahInfo->kepala_sekolah }}</div></div></div>@endif
                    <div class="d-flex gap-2 mb-2"><i class="bi bi-geo-alt text-danger"></i><div>{{ $sekolahInfo->alamat }}</div></div>
                    @if($sekolahInfo->phone)<div class="d-flex gap-2 mb-2"><i class="bi bi-telephone text-success"></i><span>{{ $sekolahInfo->phone }}</span></div>@endif
                    @if($sekolahInfo->email)<div class="d-flex gap-2"><i class="bi bi-envelope text-info"></i><span>{{ $sekolahInfo->email }}</span></div>@endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @if($sekolahInfo->visi)<div class="card mb-3"><div class="card-header fw-semibold"><i class="bi bi-eye me-2 text-primary"></i>Visi</div><div class="card-body">{{ $sekolahInfo->visi }}</div></div>@endif
        @if($sekolahInfo->fasilitas)
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-building-check me-2 text-warning"></i>Fasilitas</div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach(($sekolahInfo->fasilitas??[]) as $f)
                        <span class="badge bg-light text-dark border"><i class="bi bi-check-circle-fill text-success me-1"></i>{{ $f }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
