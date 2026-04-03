@php $sekolah = $sekolah ?? null; @endphp

<ul class="nav nav-tabs mb-4" id="sekolahTab">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#tab-info">
            <i class="bi bi-building me-1"></i>Informasi Sekolah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tab-saw">
            <i class="bi bi-sliders me-1"></i>Nilai untuk Rekomendasi
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-info">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label small fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror"
                       value="{{ old('nama_sekolah', $sekolah?->nama_sekolah) }}" required>
                @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">NPSN</label>
                <input type="text" name="npsn" class="form-control @error('npsn') is-invalid @enderror"
                       value="{{ old('npsn', $sekolah?->npsn) }}">
                @error('npsn')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Status Sekolah <span class="text-danger">*</span></label>
                <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                    <option value="Negeri" {{ old('jenis', $sekolah?->jenis) === 'Negeri' ? 'selected' : '' }}>Negeri</option>
                    <option value="Swasta" {{ old('jenis', $sekolah?->jenis) === 'Swasta' ? 'selected' : '' }}>Swasta</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Akreditasi <span class="text-danger">*</span></label>
                <select name="akreditasi" class="form-select @error('akreditasi') is-invalid @enderror" required>
                    @foreach(['A','B','C','Belum Terakreditasi'] as $a)
                        <option value="{{ $a }}" {{ old('akreditasi', $sekolah?->akreditasi) === $a ? 'selected' : '' }}>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control"
                       value="{{ old('kecamatan', $sekolah?->kecamatan) }}" placeholder="Contoh: Batam Kota">
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
                <textarea name="alamat_sekolah" class="form-control @error('alamat_sekolah') is-invalid @enderror" rows="2" required>{{ old('alamat_sekolah', $sekolah?->alamat_sekolah) }}</textarea>
                @error('alamat_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">SPP per Bulan</label>
                <input type="number" name="biaya_spp" class="form-control" min="0"
                       value="{{ old('biaya_spp', $sekolah?->biaya_spp) }}" placeholder="0 jika gratis">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Biaya Masuk</label>
                <input type="number" name="biaya_masuk" class="form-control" min="0"
                       value="{{ old('biaya_masuk', $sekolah?->biaya_masuk) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Nomor Telepon</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ old('phone', $sekolah?->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', $sekolah?->email) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Website</label>
                <input type="url" name="website" class="form-control"
                       value="{{ old('website', $sekolah?->website) }}" placeholder="https://...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Jumlah Siswa</label>
                <input type="number" name="jumlah_siswa" class="form-control"
                       value="{{ old('jumlah_siswa', $sekolah?->jumlah_siswa) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Jumlah Guru</label>
                <input type="number" name="jumlah_guru" class="form-control"
                       value="{{ old('jumlah_guru', $sekolah?->jumlah_guru) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Latitude</label>
                <input type="number" name="latitude" class="form-control" step="any"
                       value="{{ old('latitude', $sekolah?->latitude) }}" placeholder="Opsional">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">Longitude</label>
                <input type="number" name="longitude" class="form-control" step="any"
                       value="{{ old('longitude', $sekolah?->longitude) }}" placeholder="Opsional">
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Fasilitas</label>
                <input type="text" name="fasilitas_sekolah" class="form-control"
                       value="{{ old('fasilitas_sekolah', $sekolah?->fasilitas_sekolah) }}"
                       placeholder="Contoh: Perpustakaan, Laboratorium, Masjid, Lapangan">
                <div class="form-text">Tulis singkat dan pisahkan dengan koma agar mudah dibaca pengguna.</div>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan keunggulan utama sekolah ini.">{{ old('deskripsi', $sekolah?->deskripsi) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Foto Sekolah</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                @if($sekolah?->foto)
                    <img src="{{ $sekolah->foto_url }}" class="mt-2 rounded" height="60" alt="{{ $sekolah->nama_sekolah }}">
                @endif
            </div>
            @if($sekolah)
                <div class="col-md-6">
                    <label class="form-label small fw-semibold">Status Tampil</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                               {{ old('is_active', $sekolah->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="isActive">Tampilkan sekolah ini di hasil rekomendasi</label>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="tab-pane fade" id="tab-saw">
        <div class="alert alert-info">
            Isi nilai yang dipakai sistem untuk membandingkan sekolah. Gunakan angka yang konsisten dan mudah dijelaskan.
        </div>

        @if($kriteriaList->isEmpty())
            <div class="alert alert-warning">
                Belum ada kriteria rekomendasi. <a href="{{ route('admin.kriteria.create') }}">Tambah kriteria terlebih dahulu</a>.
            </div>
        @else
            <div class="row g-3">
                @foreach($kriteriaList as $k)
                    @php
                        $existingNilai = isset($nilaiMap) ? $nilaiMap[$k->id]?->nilai : null;
                        $existingKet = isset($nilaiMap) ? $nilaiMap[$k->id]?->keterangan : null;
                    @endphp
                    <div class="col-md-6">
                        <div class="p-3 rounded border h-100">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <div>
                                    <div class="fw-semibold">{{ $k->nama_kriteria }}</div>
                                    <div class="small text-muted">{{ $k->kode_kriteria }} • Bobot {{ $k->bobot_persen }}</div>
                                </div>
                                <span class="badge {{ $k->jenis === 'benefit' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $k->jenis === 'benefit' ? 'Semakin besar semakin baik' : 'Semakin kecil semakin baik' }}
                                </span>
                            </div>
                            <div class="small text-muted mb-2">
                                {{ $k->deskripsi ?: 'Tambahkan penjelasan kriteria di menu kriteria agar pengguna lebih mudah mengisi nilai.' }}
                            </div>
                            <label class="form-label small fw-semibold">Nilai angka untuk sistem</label>
                            <input type="number" name="nilai_kriteria[{{ $k->id }}]" class="form-control form-control-sm"
                                   value="{{ old('nilai_kriteria.'.$k->id, $existingNilai) }}" step="any" placeholder="Contoh: 100, 80, 500000">
                            <label class="form-label small fw-semibold mt-2">Catatan penjelas</label>
                            <input type="text" name="keterangan_kriteria[{{ $k->id }}]" class="form-control form-control-sm"
                                   value="{{ old('keterangan_kriteria.'.$k->id, $existingKet) }}"
                                   placeholder="Contoh: Akreditasi A, SPP Rp500.000, jarak 4 km">
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
