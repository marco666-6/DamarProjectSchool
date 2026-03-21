@extends('layouts.app')
@section('title','Detail Sekolah')
@section('page-title','Detail Sekolah')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <img src="{{ $sekolah->foto_url }}" class="card-img-top" style="height:180px;object-fit:cover">
            <div class="card-body">
                <h5 class="fw-bold">{{ $sekolah->nama_sekolah }}</h5>
                <div class="d-flex gap-2 mb-3 flex-wrap">
                    <span class="badge bg-{{ $sekolah->jenis==='Negeri'?'primary':'secondary' }}">{{ $sekolah->jenis }}</span>
                    <span class="badge bg-success">Akreditasi {{ $sekolah->akreditasi }}</span>
                    @if($sekolah->npsn)<span class="badge bg-light text-dark border">NPSN: {{ $sekolah->npsn }}</span>@endif
                </div>
                <div class="small">
                    <div class="d-flex gap-2 mb-2"><i class="bi bi-geo-alt text-danger"></i><span>{{ $sekolah->alamat_sekolah }}, {{ $sekolah->kecamatan }}</span></div>
                    @if($sekolah->phone)<div class="d-flex gap-2 mb-2"><i class="bi bi-telephone text-success"></i><span>{{ $sekolah->phone }}</span></div>@endif
                    @if($sekolah->email)<div class="d-flex gap-2 mb-2"><i class="bi bi-envelope text-info"></i><span>{{ $sekolah->email }}</span></div>@endif
                    @if($sekolah->website)<div class="d-flex gap-2 mb-2"><i class="bi bi-globe text-warning"></i><a href="{{ $sekolah->website }}" target="_blank">{{ $sekolah->website }}</a></div>@endif
                    <div class="d-flex gap-2 mb-2"><i class="bi bi-cash text-primary"></i><div><div class="fw-semibold">SPP</div><div>{{ $sekolah->biaya_spp>0?$sekolah->biaya_spp_format:'Gratis' }}</div></div></div>
                    <div class="d-flex gap-2"><i class="bi bi-cash-coin text-warning"></i><div><div class="fw-semibold">Biaya Masuk</div><div>{{ $sekolah->biaya_masuk>0?$sekolah->biaya_masuk_format:'Tidak ada info' }}</div></div></div>
                </div>
                <hr>
                <div class="row text-center small">
                    @if($sekolah->jumlah_siswa)<div class="col-6"><div class="fw-bold fs-5">{{ number_format($sekolah->jumlah_siswa) }}</div><div class="text-muted">Siswa</div></div>@endif
                    @if($sekolah->jumlah_guru)<div class="col-6"><div class="fw-bold fs-5">{{ $sekolah->jumlah_guru }}</div><div class="text-muted">Guru</div></div>@endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @if($sekolah->deskripsi)
        <div class="card mb-3">
            <div class="card-header fw-semibold"><i class="bi bi-info-circle me-2"></i>Tentang Sekolah</div>
            <div class="card-body">{{ $sekolah->deskripsi }}</div>
        </div>
        @endif

        @if(count($sekolah->fasilitas_array))
        <div class="card mb-3">
            <div class="card-header fw-semibold"><i class="bi bi-building-check me-2 text-warning"></i>Fasilitas</div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($sekolah->fasilitas_array as $f)
                        <span class="badge bg-light text-dark border"><i class="bi bi-check-circle-fill text-success me-1"></i>{{ $f }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-bar-chart me-2 text-primary"></i>Nilai Kriteria SAW</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Kriteria</th><th>Jenis</th><th>Nilai</th><th>Keterangan</th></tr></thead>
                    <tbody>
                    @foreach($kriteriaList as $k)
                        @php $nk = $sekolah->nilaiKriteria->firstWhere('kriteria_id',$k->id); @endphp
                        <tr>
                            <td><span class="badge bg-secondary me-1">{{ $k->kode_kriteria }}</span>{{ $k->nama_kriteria }}</td>
                            <td><span class="badge {{ $k->jenis==='benefit'?'bg-success':'bg-warning text-dark' }}">{{ $k->jenis }}</span></td>
                            <td>{{ $nk?number_format($nk->nilai,0,',','.'):'-' }}</td>
                            <td class="text-muted small">{{ $nk?->keterangan??'' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('user.rekomendasi.form') }}" class="btn btn-primary"><i class="bi bi-arrow-repeat me-1"></i>Hitung Ulang Rekomendasi</a>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">← Kembali</a>
        </div>
    </div>
</div>
@endsection
