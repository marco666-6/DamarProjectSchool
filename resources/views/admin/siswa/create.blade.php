@extends('layouts.app')
@section('title','Tambah Siswa')
@section('page-title','Tambah Siswa Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-person-plus me-2"></i>Form Data Siswa</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.siswa._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
