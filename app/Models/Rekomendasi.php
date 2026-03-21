<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

    protected $fillable = [
        'user_id',
        'preferensi',
        'hasil_saw',
        'skor_total',
        'ranking',
        'status_rekomendasi',
    ];

    protected function casts(): array
    {
        return [
            'preferensi'         => 'array',
            'hasil_saw'          => 'array',
            'skor_total'         => 'decimal:4',
            'ranking'            => 'integer',
        ];
    }

    // ── Relationships ─────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    /**
     * Get ranked results with full school data loaded.
     * hasil_saw is an array: [ { sekolah_id, skor_total, ranking, detail: [...] } ]
     */
    public function getRankedResultsAttribute(): array
    {
        if (!$this->hasil_saw) return [];

        $results = $this->hasil_saw;
        // Eager-load school names
        $schoolIds = array_column($results, 'sekolah_id');
        $schools   = SekolahRekomendasi::whereIn('id', $schoolIds)
            ->get()
            ->keyBy('id');

        foreach ($results as &$row) {
            $school = $schools[$row['sekolah_id']] ?? null;
            $row['sekolah'] = $school ? [
                'id'           => $school->id,
                'nama_sekolah' => $school->nama_sekolah,
                'jenis'        => $school->jenis,
                'akreditasi'   => $school->akreditasi,
                'alamat'       => $school->alamat_sekolah,
                'kecamatan'    => $school->kecamatan,
                'biaya_spp'    => $school->biaya_spp_format,
                'foto_url'     => $school->foto_url,
            ] : null;
        }

        usort($results, fn($a, $b) => $a['ranking'] <=> $b['ranking']);
        return $results;
    }
}