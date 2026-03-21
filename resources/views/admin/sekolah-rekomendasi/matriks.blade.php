@extends('layouts.app')
@section('title','Matriks SAW')
@section('page-title','Matriks Keputusan SAW')

@section('content')
<div class="card mb-4">
    <div class="card-header fw-semibold">
        <i class="bi bi-table me-2"></i>Matriks Keputusan (Raw Values)
        <span class="badge bg-secondary ms-2">{{ count($matrix['rows']) }} Sekolah × {{ $matrix['kriteria']->count() }} Kriteria</span>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm mb-0 text-center">
            <thead class="table-dark">
                <tr>
                    <th class="text-start ps-3">Alternatif (Sekolah)</th>
                    @foreach($matrix['kriteria'] as $k)
                        <th>
                            {{ $k->kode_kriteria }}<br>
                            <small class="fw-normal opacity-75">{{ $k->nama_kriteria }}</small><br>
                            <span class="badge {{ $k->jenis === 'benefit' ? 'bg-success' : 'bg-warning text-dark' }} mt-1" style="font-size:.65rem">
                                {{ $k->jenis === 'benefit' ? 'Benefit ↑' : 'Cost ↓' }}
                            </span>
                        </th>
                    @endforeach
                </tr>
                <tr class="table-secondary">
                    <th class="text-start ps-3 text-muted small">Bobot</th>
                    @foreach($matrix['kriteria'] as $k)
                        <th class="text-muted small">{{ $k->bobot_persen }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($matrix['rows'] as $row)
                <tr>
                    <td class="text-start ps-3 fw-semibold">{{ $row['sekolah'] }}</td>
                    @foreach($matrix['kriteria'] as $k)
                        <td>
                            @if(isset($row[$k->kode_kriteria]) && $row[$k->kode_kriteria] !== null)
                                {{ number_format($row[$k->kode_kriteria], 0, ',', '.') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Ranking Results --}}
<div class="card">
    <div class="card-header fw-semibold">
        <i class="bi bi-trophy me-2 text-warning"></i>Hasil Perankingan SAW
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Ranking</th>
                    <th>Nama Sekolah</th>
                    @foreach($matrix['kriteria'] as $k)
                        <th class="text-center small">{{ $k->kode_kriteria }}<br><span class="fw-normal text-muted" style="font-size:.7rem">norm × bobot</span></th>
                    @endforeach
                    <th class="text-center">Skor Total (V)</th>
                </tr>
            </thead>
            <tbody>
            @foreach($results as $r)
            @php $sekolah = $sekolahMap[$r['sekolah_id']] ?? null; @endphp
            <tr class="{{ $r['ranking'] <= 3 ? 'table-'.['','warning','','light'][$r['ranking']] : '' }}">
                <td class="ps-3">
                    <span class="rank-badge rank-{{ $r['ranking'] <= 3 ? $r['ranking'] : 'other' }}">
                        {{ $r['ranking'] }}
                    </span>
                </td>
                <td class="fw-semibold">{{ $sekolah?->nama_sekolah ?? 'Sekolah #'.$r['sekolah_id'] }}</td>
                @foreach($matrix['kriteria'] as $k)
                    @php
                        $det = collect($r['detail'])->firstWhere('kriteria_id', $k->id);
                    @endphp
                    <td class="text-center small">
                        @if($det)
                            <div>{{ $det['normalized'] }}</div>
                            <div class="text-muted" style="font-size:.7rem">× {{ $det['bobot'] }} = <strong>{{ $det['weighted'] }}</strong></div>
                        @else —
                        @endif
                    </td>
                @endforeach
                <td class="text-center">
                    <span class="badge fs-6 {{ $r['ranking'] === 1 ? 'bg-success' : 'bg-primary' }}">
                        {{ $r['skor_total'] }}
                    </span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
