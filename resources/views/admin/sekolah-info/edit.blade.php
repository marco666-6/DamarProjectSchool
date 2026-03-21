@extends('layouts.app')
@section('title','Info Sekolah')
@section('page-title','Pengaturan Info Sekolah BIIS')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-gear me-2"></i>Edit Informasi Sekolah
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sekolah-info.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">Identitas Sekolah</h6>
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                    <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah',$sekolah->nama_sekolah) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Singkatan</label>
                    <input type="text" name="singkatan" class="form-control" value="{{ old('singkatan',$sekolah->singkatan) }}" placeholder="BIIS">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kepala Sekolah</label>
                    <input type="text" name="kepala_sekolah" class="form-control" value="{{ old('kepala_sekolah',$sekolah->kepala_sekolah) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">NPSN</label>
                    <input type="text" name="npsn" class="form-control" value="{{ old('npsn',$sekolah->npsn) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Akreditasi</label>
                    <select name="akreditasi" class="form-select">
                        @foreach(['A','B','C','Belum'] as $a)
                            <option value="{{ $a }}" {{ old('akreditasi',$sekolah->akreditasi)===$a?'selected':'' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3 border-bottom pb-2">Kontak & Lokasi</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat',$sekolah->alamat) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ old('kota',$sekolah->kota) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi',$sekolah->provinsi) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos',$sekolah->kode_pos) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone',$sekolah->phone) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email',$sekolah->email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Website</label>
                    <input type="url" name="website" class="form-control" value="{{ old('website',$sekolah->website) }}" placeholder="https://...">
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3 border-bottom pb-2">Visi, Misi & Sejarah</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold">Visi</label>
                    <textarea name="visi" class="form-control" rows="2">{{ old('visi',$sekolah->visi) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Misi <span class="text-muted">(satu baris per poin)</span></label>
                    @php
                        $misiText = '';
                        if($sekolah->misi) {
                            $misiArr = is_array($sekolah->misi) ? $sekolah->misi : json_decode($sekolah->misi, true);
                            $misiText = is_array($misiArr) ? implode("\n", $misiArr) : $sekolah->misi;
                        }
                    @endphp
                    <textarea name="misi_text" class="form-control" rows="4" placeholder="Satu poin per baris...">{{ old('misi_text', $misiText) }}</textarea>
                    <div class="form-text">Setiap baris akan menjadi satu poin misi.</div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-semibold">Sejarah Singkat</label>
                    <textarea name="sejarah" class="form-control" rows="4">{{ old('sejarah',$sekolah->sejarah) }}</textarea>
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3 border-bottom pb-2">Fasilitas</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label small fw-semibold">Daftar Fasilitas <span class="text-muted">(pisahkan dengan enter)</span></label>
                    <textarea name="fasilitas_text" class="form-control" rows="4"
                              placeholder="Perpustakaan&#10;Lab IPA&#10;Lapangan Olahraga">{{ old('fasilitas_text', is_array($sekolah->fasilitas) ? implode("\n", $sekolah->fasilitas) : '') }}</textarea>
                </div>
            </div>

            <h6 class="fw-bold text-primary mt-4 mb-3 border-bottom pb-2">Media</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Logo Sekolah</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    @if($sekolah->logo)
                        <img src="{{ $sekolah->logo_url }}" class="mt-2" style="height:50px;object-fit:contain">
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Foto Gedung Sekolah</label>
                    <input type="file" name="foto_sekolah" class="form-control" accept="image/*">
                    @if($sekolah->foto_sekolah)
                        <img src="{{ $sekolah->foto_url }}" class="mt-2 rounded" style="height:60px;object-fit:cover">
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
