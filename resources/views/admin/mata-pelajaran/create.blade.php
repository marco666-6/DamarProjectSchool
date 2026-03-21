@extends('layouts.app')
@section('title','Tambah Mata Pelajaran')
@section('page-title','Tambah Mata Pelajaran')
@section('content')
<div class="row justify-content-center"><div class="col-lg-6">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-plus-circle me-2"></i>Form Mata Pelajaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.mata-pelajaran.store') }}">
            @csrf
            @include('admin.mata-pelajaran._form')
            <div class="d-flex gap-2 mt-4"><button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button><a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-outline-secondary">Batal</a></div>
        </form>
    </div>
</div>
</div></div>
@endsection
