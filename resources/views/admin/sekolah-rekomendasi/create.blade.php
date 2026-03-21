@extends('layouts.app')
@section('title','Tambah SMP')
@section('page-title','Tambah Data SMP')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-plus-circle me-2"></i>Form Data SMP Batam
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sekolah-rekomendasi.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.sekolah-rekomendasi._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.sekolah-rekomendasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
