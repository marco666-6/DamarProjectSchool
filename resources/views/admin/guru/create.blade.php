@extends('layouts.app')
@section('title','Tambah Guru')
@section('page-title','Tambah Guru Baru')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-person-plus me-2"></i>Form Data Guru</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.guru.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.guru._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
