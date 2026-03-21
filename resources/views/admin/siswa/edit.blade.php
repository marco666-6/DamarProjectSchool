@extends('layouts.app')
@section('title','Edit Siswa')
@section('page-title','Edit Data Siswa')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header fw-semibold"><i class="bi bi-pencil me-2"></i>Edit: {{ $siswa->nama_siswa }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.siswa.update', $siswa) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.siswa._form')
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Perbarui</button>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
