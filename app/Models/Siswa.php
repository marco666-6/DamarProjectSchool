<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nisn',
        'nis',
        'nama_siswa',
        'nama_orangtua',
        'pekerjaan_orangtua',
        'phone_orangtua',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kelas',
        'tahun_masuk',
        'foto',
        'is_active',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_active' => 'boolean',
            'tahun_masuk' => 'integer',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-student.png');
    }

    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
        //return $this->tanggal_lahir?->diffInYears(now());
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKelas($query, string $kelas)
    {
        return $query->where('kelas', $kelas);
    }
}