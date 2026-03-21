<?php

namespace App\Services;

use App\Models\Kriteria;
use App\Models\NilaiKriteria;
use App\Models\SekolahRekomendasi;
use Illuminate\Support\Collection;

/**
 * SAW (Simple Additive Weighting) Engine
 *
 * Steps:
 *   1. Build the raw decision matrix  X[school][criterion] = raw value
 *   2. Normalize → R[school][criterion]
 *        benefit: R = X / max(X)
 *        cost:    R = min(X) / X
 *   3. Weight   → V[school] = Σ (bobot[c] × R[school][c])
 *   4. Rank by V descending
 */
class SawService
{
    /**
     * Run the full SAW calculation.
     *
     * @param  array  $preferensi  User preference overrides keyed by kriteria_id.
     *                             Shape: [ kriteria_id => preferred_value ]
     *                             When provided the normalization is done against
     *                             the user's target (useful for "biaya maksimal" etc.)
     *                             Pass [] to use plain SAW against all schools.
     * @return array  Ranked results, each element:
     *   [
     *     'sekolah_id'  => int,
     *     'skor_total'  => float,   // V[school]
     *     'ranking'     => int,
     *     'detail'      => [        // per-criterion breakdown
     *       [ 'kriteria_id', 'nama', 'kode', 'raw', 'normalized', 'bobot', 'weighted' ]
     *     ]
     *   ]
     */
    public function hitung(array $preferensi = []): array
    {
        // 1. Load active criteria ordered by urutan
        $kriteria = Kriteria::active()->get();

        if ($kriteria->isEmpty()) {
            return [];
        }

        // 2. Load active schools with their criterion scores
        $sekolahList = SekolahRekomendasi::active()
            ->with('nilaiKriteria')
            ->get();

        if ($sekolahList->isEmpty()) {
            return [];
        }

        // 3. Build raw matrix: matrix[sekolah_id][kriteria_id] = nilai
        $matrix = [];
        foreach ($sekolahList as $sekolah) {
            $matrix[$sekolah->id] = [];
            foreach ($kriteria as $k) {
                $nilaiRow = $sekolah->nilaiKriteria
                    ->firstWhere('kriteria_id', $k->id);
                // Default 0 if no score exists
                $matrix[$sekolah->id][$k->id] = $nilaiRow ? (float) $nilaiRow->nilai : 0.0;
            }
        }

        // 4. Apply user preference adjustments
        //    If user gave a preference for a criterion, we inject it into the
        //    column so normalization naturally reflects how close each school is.
        $matrix = $this->applyPreferensi($matrix, $kriteria, $preferensi);

        // 5. Normalize matrix → R
        $normalized = $this->normalize($matrix, $kriteria);

        // 6. Calculate weighted scores V
        $scores = [];
        foreach ($sekolahList as $sekolah) {
            $sid   = $sekolah->id;
            $total = 0.0;
            $detail = [];

            foreach ($kriteria as $k) {
                $raw        = $matrix[$sid][$k->id];
                $norm       = $normalized[$sid][$k->id];
                $weighted   = (float) $k->bobot * $norm;
                $total     += $weighted;

                $detail[] = [
                    'kriteria_id' => $k->id,
                    'nama'        => $k->nama_kriteria,
                    'kode'        => $k->kode_kriteria,
                    'jenis'       => $k->jenis,
                    'raw'         => round($raw, 4),
                    'normalized'  => round($norm, 4),
                    'bobot'       => (float) $k->bobot,
                    'weighted'    => round($weighted, 4),
                ];
            }

            $scores[] = [
                'sekolah_id' => $sid,
                'skor_total' => round($total, 4),
                'ranking'    => 0, // filled below
                'detail'     => $detail,
            ];
        }

        // 7. Sort descending by skor_total, assign rankings
        usort($scores, fn($a, $b) => $b['skor_total'] <=> $a['skor_total']);
        foreach ($scores as $i => &$row) {
            $row['ranking'] = $i + 1;
        }

        return $scores;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Normalization
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Normalize using SAW formula:
     *   benefit: r_ij = x_ij / max_j(x_ij)
     *   cost:    r_ij = min_j(x_ij) / x_ij   (avoid /0 → 0)
     */
    private function normalize(array $matrix, Collection $kriteria): array
    {
        $normalized = [];

        foreach ($kriteria as $k) {
            $kid    = $k->id;
            $column = array_column($matrix, $kid, null); // [sekolah_id => nilai]
            // Rebuild with school IDs as keys
            $column = [];
            foreach ($matrix as $sid => $row) {
                $column[$sid] = $row[$kid];
            }

            $max = max($column) ?: 1;
            $min = min($column) ?: 1;

            foreach ($column as $sid => $val) {
                if ($k->jenis === 'benefit') {
                    $normalized[$sid][$kid] = $max > 0 ? $val / $max : 0;
                } else {
                    // cost
                    $normalized[$sid][$kid] = $val > 0 ? $min / $val : 0;
                }
            }
        }

        return $normalized;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Preference adjustment
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Adjust raw scores based on user preferences.
     *
     * For COST criteria (e.g. biaya): if user set a max budget, schools that
     * exceed it get their score divided by how much they exceed it, making
     * them naturally score lower after normalization.
     *
     * For BENEFIT criteria (e.g. akreditasi): if user specified a minimum,
     * schools below it are penalised (score zeroed).
     *
     * preferensi shape example:
     *   [
     *     'biaya_maks'   => 500000,
     *     'akreditasi_min' => 80,    // numeric equivalent
     *     'lokasi_kec'   => 'Batam Kota',
     *   ]
     *
     * For simplicity we also accept kriteria_id keyed values directly.
     */
    private function applyPreferensi(
        array      $matrix,
        Collection $kriteria,
        array      $preferensi
    ): array {
        if (empty($preferensi)) {
            return $matrix;
        }

        foreach ($kriteria as $k) {
            $kid = $k->id;

            // Direct numeric override by kriteria_id
            if (isset($preferensi[$kid])) {
                $userVal = (float) $preferensi[$kid];

                foreach ($matrix as $sid => &$row) {
                    $schoolVal = $row[$kid];

                    if ($k->jenis === 'cost') {
                        // Penalise schools that cost more than user's budget
                        if ($schoolVal > $userVal && $userVal > 0) {
                            // Scale down proportionally
                            $row[$kid] = $userVal; // cap at budget
                        }
                    } else {
                        // Benefit: zero out schools below minimum
                        if ($schoolVal < $userVal) {
                            $row[$kid] = 0;
                        }
                    }
                }
            }
        }

        return $matrix;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Validate that active kriteria weights sum to ~1.0 (±0.01 tolerance).
     */
    public function validateBobotSum(): array
    {
        $kriteria = Kriteria::active()->get();
        $sum      = $kriteria->sum(fn($k) => (float) $k->bobot);

        return [
            'valid'    => abs($sum - 1.0) <= 0.01,
            'sum'      => round($sum, 4),
            'kriteria' => $kriteria,
        ];
    }

    /**
     * Return the raw decision matrix as a structured array
     * (useful for displaying the full SAW table in admin view).
     */
    public function getDecisionMatrix(): array
    {
        $kriteria    = Kriteria::active()->get();
        $sekolahList = SekolahRekomendasi::active()->with('nilaiKriteria')->get();

        $rows = [];
        foreach ($sekolahList as $sekolah) {
            $row = ['sekolah' => $sekolah->nama_sekolah, 'id' => $sekolah->id];
            foreach ($kriteria as $k) {
                $nk           = $sekolah->nilaiKriteria->firstWhere('kriteria_id', $k->id);
                $row[$k->kode_kriteria] = $nk ? (float) $nk->nilai : null;
            }
            $rows[] = $row;
        }

        return [
            'kriteria' => $kriteria,
            'rows'     => $rows,
        ];
    }
}