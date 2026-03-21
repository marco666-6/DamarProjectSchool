<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahInfo extends Model
{
    use HasFactory;

    protected $table = 'sekolah_info';

    protected $fillable = [
        'nama_sekolah',
        'singkatan',
        'visi',
        'misi',
        'sejarah',
        'kepala_sekolah',
        'npsn',
        'nss',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'phone',
        'email',
        'website',
        'logo',
        'foto_sekolah',
        'akreditasi',
        'fasilitas',
    ];

    protected function casts(): array
    {
        return [
            'fasilitas' => 'array',
        ];
    }

    // ── Singleton helper ──────────────────────────────────────────────────────
    public static function getInstance(): self
    {
        return static::firstOrCreate([], [
            'nama_sekolah' => 'Batam Integrated Islamic School',
            'singkatan'    => 'BIIS',
            'alamat'       => 'Batam, Kepulauan Riau',
            'akreditasi'   => 'A',
        ]);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return asset('images/logo-biis.png');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto_sekolah) {
            return asset('storage/' . $this->foto_sekolah);
        }
        return asset('images/school-default.jpg');
    }
}