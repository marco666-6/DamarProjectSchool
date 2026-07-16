@extends('layouts.app')
@section('title', 'Cari Sekolah Lanjutan')
@section('page-title', 'Cari Sekolah Lanjutan')
@section('page-subtitle', 'Masukkan kebutuhan yang penting bagi Anda. Sistem akan membantu menyusun urutan sekolah yang paling cocok.')

@section('content')
@php
    $hasDistanceCriterion = $kriteriaList->contains(fn($k) => str_contains(strtolower($k->nama_kriteria), 'jarak') || str_contains(strtolower($k->nama_kriteria), 'lokasi'));
    $defaultLat = old('user_latitude', 1.1186);
    $defaultLng = old('user_longitude', 104.0486);
@endphp
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <div class="fw-bold fs-5 text-dark">Isi kebutuhan Anda</div>
                <p class="text-muted small mb-0 mt-1">Tidak semua kolom harus diisi. Isi hanya yang memang penting bagi keluarga Anda.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.rekomendasi.hitung') }}">
                    @csrf
                    <div class="row g-3">
                        @if($hasDistanceCriterion)
                            <div class="col-12">
                                <div class="p-3 rounded border bg-light">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                        <div>
                                            <label class="form-label fw-semibold mb-1">Lokasi Rumah</label>
                                            <div class="small text-muted">Klik titik rumah di peta. Jarak sekolah akan dihitung otomatis dari titik ini.</div>
                                        </div>
                                        <span class="badge bg-primary">GPS input</span>
                                    </div>
                                    <div id="home-location-map" class="rounded border mb-2" style="height:280px"></div>
                                    <input type="hidden" name="user_latitude" id="user_latitude" value="{{ $defaultLat }}">
                                    <input type="hidden" name="user_longitude" id="user_longitude" value="{{ $defaultLng }}">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold">Latitude</label>
                                            <input type="number" id="user_latitude_display" class="form-control form-control-sm" step="any" value="{{ $defaultLat }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label small fw-semibold">Longitude</label>
                                            <input type="number" id="user_longitude_display" class="form-control form-control-sm" step="any" value="{{ $defaultLng }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" id="use-current-location" class="btn btn-outline-primary btn-sm w-100" title="Gunakan lokasi perangkat">
                                                <i class="bi bi-crosshair"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('user_latitude')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                                    @error('user_longitude')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        @endif

                        @foreach($kriteriaList as $k)
                            @php
                                $lowerName = strtolower($k->nama_kriteria);
                                $isBiaya = str_contains($lowerName, 'biaya');
                                $isAkreditasi = str_contains($lowerName, 'akreditasi');
                                $isJarak = str_contains($lowerName, 'jarak');
                            @endphp
                            <div class="col-12">
                                <div class="p-3 rounded border bg-light">
                                    <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                        <div>
                                            <label class="form-label fw-semibold mb-1">{{ $k->nama_kriteria }}</label>
                                            <div class="small text-muted">{{ $k->deskripsi ?: 'Belum ada penjelasan untuk kriteria ini.' }}</div>
                                        </div>
                                        <span class="badge {{ $k->jenis === 'benefit' ? 'bg-success' : 'bg-warning text-dark' }}">
                                            {{ $k->jenis === 'benefit' ? 'Semakin besar semakin baik' : 'Semakin kecil semakin baik' }}
                                        </span>
                                    </div>

                                    @if($isBiaya)
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="pref_{{ $k->id }}" class="form-control"
                                                   placeholder="Contoh: 500000" min="0" step="50000">
                                            <span class="input-group-text">maksimal</span>
                                        </div>
                                        <div class="form-text">Isi jika Anda punya batas biaya per bulan. Kosongkan jika biaya tidak menjadi prioritas.</div>
                                    @elseif($isAkreditasi)
                                        <select name="pref_{{ $k->id }}" class="form-select">
                                            <option value="">Tidak dibatasi</option>
                                            <option value="100">Minimal akreditasi A</option>
                                            <option value="80">Minimal akreditasi B</option>
                                            <option value="60">Minimal akreditasi C</option>
                                        </select>
                                        <div class="form-text">Pilih standar terendah yang masih Anda anggap layak.</div>
                                    @elseif($isJarak)
                                        <div class="input-group">
                                            <input type="number" name="pref_{{ $k->id }}" class="form-control"
                                                   placeholder="Contoh: 5" min="0" max="100" step="1">
                                            <span class="input-group-text">km maksimal</span>
                                        </div>
                                        <div class="form-text">Nilai jarak dihitung dari lokasi rumah yang Anda pilih di peta.</div>
                                    @else
                                        <input type="number" name="pref_{{ $k->id }}" class="form-control"
                                               placeholder="Isi angka yang sesuai dengan penjelasan di atas" step="any">
                                        <div class="form-text">Gunakan angka sesuai petunjuk kriteria. Jika ragu, tanyakan admin sekolah.</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex gap-3 align-items-center flex-wrap">
                        <button type="submit" class="btn btn-success btn-lg px-4">
                            <i class="bi bi-search me-2"></i>Tampilkan Rekomendasi
                        </button>
                        <span class="text-muted small">Sistem membandingkan sekolah berdasarkan {{ $kriteriaList->count() }} kriteria aktif.</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header fw-semibold">Panduan Singkat</div>
            <div class="card-body small">
                <div class="mb-3">
                    <strong>1. Isi yang penting saja</strong><br>
                    Tidak perlu mengisi semua kolom. Sistem tetap bisa memberi hasil walau hanya beberapa kebutuhan yang diisi.
                </div>
                <div class="mb-3">
                    <strong>2. Angka lebih kecil atau lebih besar</strong><br>
                    Jika tertulis “semakin kecil semakin baik”, masukkan batas maksimal. Jika tertulis “semakin besar semakin baik”, masukkan target minimal.
                </div>
                <div>
                    <strong>3. Hasil berupa urutan kecocokan</strong><br>
                    Sekolah di urutan teratas adalah sekolah yang paling sesuai dengan data yang tersedia saat ini.
                </div>
            </div>
        </div>

        @if($history->count())
            <div class="card">
                <div class="card-header fw-semibold d-flex justify-content-between">
                    <span>Riwayat Terakhir</span>
                    <a href="{{ route('user.rekomendasi.history') }}" class="small text-decoration-none">Lihat semua</a>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($history as $item)
                        <a href="{{ route('user.rekomendasi.hasil', $item) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between gap-2">
                                <span class="small fw-semibold">Skor terbaik {{ $item->skor_total }}</span>
                                <span class="text-muted" style="font-size:.75rem">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@if($hasDistanceCriterion)
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const latInput = document.getElementById('user_latitude');
                const lngInput = document.getElementById('user_longitude');
                const latDisplay = document.getElementById('user_latitude_display');
                const lngDisplay = document.getElementById('user_longitude_display');
                const initialLat = parseFloat(latInput.value) || 1.1186;
                const initialLng = parseFloat(lngInput.value) || 104.0486;
                const map = L.map('home-location-map').setView([initialLat, initialLng], 12);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                const marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

                function setLocation(lat, lng, pan = true) {
                    const fixedLat = Number(lat).toFixed(7);
                    const fixedLng = Number(lng).toFixed(7);
                    latInput.value = fixedLat;
                    lngInput.value = fixedLng;
                    latDisplay.value = fixedLat;
                    lngDisplay.value = fixedLng;
                    marker.setLatLng([fixedLat, fixedLng]);
                    if (pan) map.setView([fixedLat, fixedLng], Math.max(map.getZoom(), 14));
                }

                map.on('click', (event) => setLocation(event.latlng.lat, event.latlng.lng));
                marker.on('dragend', () => {
                    const point = marker.getLatLng();
                    setLocation(point.lat, point.lng, false);
                });
                latDisplay.addEventListener('change', () => setLocation(latDisplay.value, lngDisplay.value));
                lngDisplay.addEventListener('change', () => setLocation(latDisplay.value, lngDisplay.value));

                document.getElementById('use-current-location').addEventListener('click', () => {
                    if (!navigator.geolocation) return;
                    navigator.geolocation.getCurrentPosition((position) => {
                        setLocation(position.coords.latitude, position.coords.longitude);
                    });
                });
            });
        </script>
    @endpush
@endif
