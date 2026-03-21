@extends('layouts.app')
@section('title','Edit SMP')
@section('page-title','Edit Data SMP')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-pencil me-2"></i>Edit: {{ $sekolah->nama_sekolah }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sekolah-rekomendasi.update', $sekolah) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.sekolah-rekomendasi._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.sekolah-rekomendasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
