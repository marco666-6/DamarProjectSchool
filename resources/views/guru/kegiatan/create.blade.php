@extends('layouts.app')
@section('title','Tambah Kegiatan')
@section('page-title','Tambah Kegiatan Siswa')

@section('content')
<div class="row justify-content-center"><div class="col-lg-7">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-plus-circle me-2"></i>Form Kegiatan</div>
    <div class="card-body">
        <form method="POST" action="{{ route('guru.kegiatan.store') }}">
            @csrf
            @include('guru.kegiatan._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('guru.kegiatan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
