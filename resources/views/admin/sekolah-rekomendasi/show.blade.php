@extends('layouts.app')
@section('title','Detail SMP')
@section('page-title','Detail SMP')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <img src="{{ $sekolah->foto_url }}" class="card-img-top" style="height:160px;object-fit:cover">
            <div class="card-body">
                <h5 class="fw-bold mb-2">{{ $sekolah->nama_sekolah }}</h5>
                <div class="d-flex flex-wrap gap-1 mb-3">
                    <span class="badge {{ $sekolah->jenis==='Negeri'?'bg-primary':'bg-secondary' }}">{{ $sekolah->jenis }}</span>
                    <span class="badge bg-success">Akreditasi {{ $sekolah->akreditasi }}</span>
                    @if($sekolah->is_active)<span class="badge bg-success">Aktif</span>@else<span class="badge bg-secondary">Nonaktif</span>@endif
                </div>
                <div class="small">
                    @if($sekolah->npsn)<div class="mb-1 text-muted">NPSN: {{ $sekolah->npsn }}</div>@endif
                    <div class="d-flex gap-2 mb-1"><i class="bi bi-geo-alt text-danger"></i><span>{{ $sekolah->alamat_sekolah }}, {{ $sekolah->kecamatan }}</span></div>
                    @if($sekolah->phone)<div class="d-flex gap-2 mb-1"><i class="bi bi-telephone text-success"></i><span>{{ $sekolah->phone }}</span></div>@endif
                    @if($sekolah->email)<div class="d-flex gap-2 mb-1"><i class="bi bi-envelope text-info"></i><span>{{ $sekolah->email }}</span></div>@endif
                    @if($sekolah->website)<div class="d-flex gap-2 mb-1"><i class="bi bi-globe text-warning"></i><a href="{{ $sekolah->website }}" target="_blank">{{ $sekolah->website }}</a></div>@endif
                    <hr>
                    <div class="d-flex justify-content-between"><span class="text-muted">Biaya SPP</span><span class="fw-semibold">{{ $sekolah->biaya_spp > 0 ? $sekolah->biaya_spp_format : 'Gratis' }}</span></div>
                    <div class="d-flex justify-content-between mt-1"><span class="text-muted">Biaya Masuk</span><span class="fw-semibold">{{ $sekolah->biaya_masuk > 0 ? $sekolah->biaya_masuk_format : '-' }}</span></div>
                    @if($sekolah->jumlah_siswa || $sekolah->jumlah_guru)
                    <hr>
                    <div class="row text-center">
                        @if($sekolah->jumlah_siswa)<div class="col"><div class="fw-bold">{{ number_format($sekolah->jumlah_siswa) }}</div><div class="text-muted" style="font-size:.75rem">Siswa</div></div>@endif
                        @if($sekolah->jumlah_guru)<div class="col"><div class="fw-bold">{{ $sekolah->jumlah_guru }}</div><div class="text-muted" style="font-size:.75rem">Guru</div></div>@endif
                    </div>
                    @endif
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.sekolah-rekomendasi.edit',$sekolah) }}" class="btn btn-sm btn-warning flex-grow-1"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('admin.sekolah-rekomendasi.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if($sekolah->deskripsi)
        <div class="card mb-3">
            <div class="card-header fw-semibold"><i class="bi bi-info-circle me-2"></i>Deskripsi</div>
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
            <div class="card-header fw-semibold"><i class="bi bi-sliders me-2 text-primary"></i>Nilai Kriteria SAW</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Kriteria</th><th>Jenis</th><th>Bobot</th><th>Nilai</th><th>Keterangan</th></tr>
                    </thead>
                    <tbody>
                    @forelse($sekolah->nilaiKriteria as $nk)
                    <tr>
                        <td>
                            <span class="badge bg-secondary me-1">{{ $nk->kriteria?->kode_kriteria }}</span>
                            {{ $nk->kriteria?->nama_kriteria }}
                        </td>
                        <td>
                            <span class="badge {{ $nk->kriteria?->jenis==='benefit'?'bg-success':'bg-warning text-dark' }}">
                                {{ $nk->kriteria?->jenis }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $nk->kriteria?->bobot_persen }}</td>
                        <td><strong>{{ number_format($nk->nilai, 2) }}</strong></td>
                        <td class="small text-muted">{{ $nk->keterangan??'-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">Belum ada nilai kriteria. <a href="{{ route('admin.sekolah-rekomendasi.edit',$sekolah) }}">Isi sekarang</a></td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
