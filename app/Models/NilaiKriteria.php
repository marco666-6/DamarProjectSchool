<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKriteria extends Model
{
    use HasFactory;

    protected $table = 'nilai_kriteria';

    protected $fillable = [
        'sekolah_id',
        'kriteria_id',
        'nilai',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:4',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function sekolah()
    {
        return $this->belongsTo(SekolahRekomendasi::class, 'sekolah_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}