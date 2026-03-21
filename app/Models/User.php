<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'password' => 'hashed',
        ];
    }

    // ── Role helpers ──────────────────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function rekomendasi()
    {
        return $this->hasMany(Rekomendasi::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeGurus($query)
    {
        return $query->where('role', 'guru');
    }

    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }
}