<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'semester',
        'nilai_tugas',
        'nilai_ujian',
        'nilai_praktikum',
        'nilai_akhir',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'nilai_tugas' => 'decimal:2',
            'nilai_ujian' => 'decimal:2',
            'nilai_praktikum' => 'decimal:2',
            'nilai_akhir' => 'decimal:2',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // ── Business Logic ────────────────────────────────────────────────────────
    /**
     * Auto-calculate nilai_akhir from components:
     * Tugas 30%, Ujian 50%, Praktikum 20% (skipped if null)
     */
    public function hitungNilaiAkhir(): float
    {
        $components = [];
        $weights = [];

        if ($this->nilai_tugas !== null) {
            $components[] = $this->nilai_tugas * 0.30;
            $weights[] = 0.30;
        }
        if ($this->nilai_ujian !== null) {
            $components[] = $this->nilai_ujian * 0.50;
            $weights[] = 0.50;
        }
        if ($this->nilai_praktikum !== null) {
            $components[] = $this->nilai_praktikum * 0.20;
            $weights[] = 0.20;
        }

        if (empty($components)) return 0;

        $totalWeight = array_sum($weights);
        return round(array_sum($components) / $totalWeight, 2);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getPredikatAttribute(): string
    {
        $nilai = $this->nilai_akhir ?? 0;
        if ($nilai >= 90) return 'A';
        if ($nilai >= 80) return 'B';
        if ($nilai >= 70) return 'C';
        if ($nilai >= 60) return 'D';
        return 'E';
    }
}