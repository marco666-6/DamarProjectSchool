<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';

    protected $fillable = [
        'nama_kriteria',
        'kode_kriteria',
        'jenis',
        'bobot',
        'deskripsi',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'bobot'     => 'decimal:4',
            'is_active' => 'boolean',
            'urutan'    => 'integer',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function nilaiKriteria()
    {
        return $this->hasMany(NilaiKriteria::class, 'kriteria_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    public function scopeBenefit($query)
    {
        return $query->where('jenis', 'benefit');
    }

    public function scopeCost($query)
    {
        return $query->where('jenis', 'cost');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getBobotPersenAttribute(): string
    {
        return number_format($this->bobot * 100, 1) . '%';
    }

    public function getJenisBadgeAttribute(): string
    {
        return $this->jenis === 'benefit'
            ? '<span class="badge bg-success">Benefit</span>'
            : '<span class="badge bg-warning text-dark">Cost</span>';
    }
}