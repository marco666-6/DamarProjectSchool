@extends('layouts.app')
@section('title','Kriteria SAW')
@section('page-title','Kriteria & Bobot SAW')

@section('content')
{{-- Bobot status --}}
<div class="alert alert-{{ $bobotCheck['valid'] ? 'success' : 'warning' }} d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-{{ $bobotCheck['valid'] ? 'check-circle-fill' : 'exclamation-triangle-fill' }} fs-5"></i>
    <div>
        Total bobot saat ini: <strong>{{ $bobotCheck['sum'] }}</strong>
        @if($bobotCheck['valid'])
            &nbsp;✓ Valid — sistem rekomendasi siap digunakan.
        @else
            &nbsp;— Harus tepat <strong>1.0</strong> agar SAW bekerja dengan benar.
        @endif
    </div>
</div>

<div class="row g-4">
    {{-- Bulk bobot update form --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-sliders me-2"></i>Daftar Kriteria</span>
                <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Kriteria
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.kriteria.update-bobot') }}">
                    @csrf
                    <div class="table-responsive">
                        <table class="table align-middle mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Kriteria</th>
                                    <th>Jenis</th>
                                    <th style="width:140px">Bobot (0–1)</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($kriteriaList as $k)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $k->kode_kriteria }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $k->nama_kriteria }}</div>
                                    <small class="text-muted">{{ $k->deskripsi }}</small>
                                </td>
                                <td>
                                    @if($k->jenis === 'benefit')
                                        <span class="badge bg-success">Benefit ↑</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Cost ↓</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="number" name="bobot[{{ $k->id }}]"
                                           class="form-control form-control-sm bobot-input"
                                           value="{{ $k->bobot }}" step="0.01" min="0" max="1"
                                           {{ $k->is_active ? '' : 'disabled' }}>
                                </td>
                                <td class="text-end">
                                    @if($k->is_active)
                                        <span class="badge bg-success me-1">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary me-1">Nonaktif</span>
                                    @endif
                                    <a href="{{ url('/admin/kriteria/' . $k->id . '/edit') }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                    <form id="del-k-{{ $k->id }}" method="POST" action="{{ url('/admin/kriteria/' . $k->id) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-form="del-k-{{ $k->id }}"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kriteria. <a href="{{ route('admin.kriteria.create') }}">Tambah sekarang</a></td></tr>
                            @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-semibold">Total Bobot:</td>
                                    <td><span id="total-bobot" class="fw-bold fs-5">{{ $bobotCheck['sum'] }}</span></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan Semua Bobot
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Info card --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header fw-semibold"><i class="bi bi-info-circle me-2"></i>Panduan SAW</div>
            <div class="card-body small">
                <p><strong>Benefit</strong> — Nilai lebih tinggi = lebih baik.<br><em>Contoh: Akreditasi, Fasilitas</em></p>
                <p><strong>Cost</strong> — Nilai lebih rendah = lebih baik.<br><em>Contoh: Biaya SPP, Jarak</em></p>
                <p><strong>Bobot</strong> harus berjumlah tepat <strong>1.0</strong>.<br>
                Contoh: C1=0.25, C2=0.30, C3=0.25, C4=0.20</p>
                <p class="mb-0"><strong>Rumus SAW:</strong><br>
                Benefit: r = X / max(X)<br>
                Cost: r = min(X) / X<br>
                Score: V = Σ (bobot × r)</p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header fw-semibold"><i class="bi bi-table me-2"></i>Matriks SAW</div>
            <div class="card-body small">
                <p>Lihat hasil perhitungan SAW lengkap untuk semua sekolah.</p>
                <a href="{{ route('admin.sekolah-rekomendasi.matriks') }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-calculator me-1"></i>Lihat Matriks
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.bobot-input').forEach(inp => {
    inp.addEventListener('input', updateTotal);
});
function updateTotal() {
    let sum = 0;
    document.querySelectorAll('.bobot-input:not([disabled])').forEach(i => sum += parseFloat(i.value)||0);
    const el = document.getElementById('total-bobot');
    el.textContent = sum.toFixed(4);
    el.className = Math.abs(sum - 1.0) <= 0.001 ? 'fw-bold fs-5 text-success' : 'fw-bold fs-5 text-danger';
}
</script>
@endpush
