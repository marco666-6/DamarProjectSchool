<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'sekolah_rekomendasi';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'jenis',
        'akreditasi',
        'alamat_sekolah',
        'kecamatan',
        'kota',
        'latitude',
        'longitude',
        'fasilitas_sekolah',
        'biaya_spp',
        'biaya_masuk',
        'phone',
        'website',
        'email',
        'deskripsi',
        'foto',
        'jumlah_siswa',
        'jumlah_guru',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'biaya_spp'    => 'decimal:2',
            'biaya_masuk'  => 'decimal:2',
            'latitude'     => 'decimal:7',
            'longitude'    => 'decimal:7',
            'is_active'    => 'boolean',
            'jumlah_siswa' => 'integer',
            'jumlah_guru'  => 'integer',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteria::class, 'sekolah_id');
    }

    // Get score for a specific criterion
    public function getNilaiForKriteria(int $kriteriaId): ?float
    {
        return $this->nilaiKriteria
            ->where('kriteria_id', $kriteriaId)
            ->first()
            ?->nilai;
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-school.png');
    }

    public function getBiayaSppFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya_spp ?? 0, 0, ',', '.');
    }

    public function getBiayaMasukFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->biaya_masuk ?? 0, 0, ',', '.');
    }

    public function getFasilitasArrayAttribute(): array
    {
        if (!$this->fasilitas_sekolah) return [];
        // Support both JSON and comma-separated
        $decoded = json_decode($this->fasilitas_sekolah, true);
        if (json_last_error() === JSON_ERROR_NONE) return $decoded;
        return array_map('trim', explode(',', $this->fasilitas_sekolah));
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNegeri($query)
    {
        return $query->where('jenis', 'Negeri');
    }

    public function scopeSwasta($query)
    {
        return $query->where('jenis', 'Swasta');
    }
}