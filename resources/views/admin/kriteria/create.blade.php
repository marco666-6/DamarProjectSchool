@extends('layouts.app')
@section('title','Tambah Kriteria')
@section('page-title','Tambah Kriteria SAW')

@section('content')
<div class="row justify-content-center"><div class="col-lg-6">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-plus-circle me-2"></i>Form Kriteria</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.kriteria.store') }}">
            @csrf
            @include('admin.kriteria._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
