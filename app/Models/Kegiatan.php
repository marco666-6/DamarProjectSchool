<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'nama_kegiatan',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'deskripsi',
        'prestasi',
        'tingkat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('tanggal_kegiatan', '>=', now()->subDays($days));
    }
}