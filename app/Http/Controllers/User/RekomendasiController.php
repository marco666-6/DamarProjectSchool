<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Rekomendasi;
use App\Models\SekolahRekomendasi;
use App\Services\SawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekomendasiController extends Controller
{
    public function __construct(private SawService $saw) {}

    /**
     * Step 1: Show the preference form
     */
    public function form()
    {
        $kriteriaList = Kriteria::active()->get();
        $bobotCheck   = $this->saw->validateBobotSum();

        // Warn user if system not configured yet
        if (!$bobotCheck['valid'] || $kriteriaList->isEmpty()) {
            return view('user.rekomendasi.not-ready');
        }

        // History of past recommendations
        $history = Rekomendasi::where('user_id', Auth::id())
            ->latest()->take(5)->get();

        return view('user.rekomendasi.form', compact('kriteriaList', 'history'));
    }

    /**
     * Step 2: Process preferences & run SAW
     */
    public function hitung(Request $request)
    {
        $kriteriaList = Kriteria::active()->get();

        // Build preferensi array from form: kriteria_id => user_value
        $preferensi = [];
        foreach ($kriteriaList as $k) {
            $val = $request->input('pref_' . $k->id);
            if ($val !== null && $val !== '') {
                $preferensi[$k->id] = (float) $val;
            }
        }

        // Run SAW
        $hasil = $this->saw->hitung($preferensi);

        if (empty($hasil)) {
            return redirect()->route('user.rekomendasi.form')
                ->with('error', 'Tidak ada data sekolah atau kriteria yang tersedia.');
        }

        // Save result
        $topResult = $hasil[0];
        $rekomendasi = Rekomendasi::create([
            'user_id'             => Auth::id(),
            'preferensi'          => $preferensi,
            'hasil_saw'           => $hasil,
            'skor_total'          => $topResult['skor_total'],
            'ranking'             => 1,
            'status_rekomendasi'  => 'selesai',
        ]);

        return redirect()->route('user.rekomendasi.hasil', $rekomendasi->id);
    }

    /**
     * Step 3: Show ranked results
     */
    public function hasil(Rekomendasi $rekomendasi)
    {
        // Only the owner can view
        if ($rekomendasi->user_id !== Auth::id()) abort(403);

        $rankedResults = $rekomendasi->ranked_results;
        $kriteriaList  = Kriteria::active()->get();

        return view('user.rekomendasi.hasil', compact('rekomendasi', 'rankedResults', 'kriteriaList'));
    }

    /**
     * Step 4: Detail page for a single recommended school
     */
    public function detailSekolah(SekolahRekomendasi $sekolah)
    {
        $sekolah->load('nilaiKriteria.kriteria');
        $kriteriaList = Kriteria::active()->get();

        return view('user.rekomendasi.detail-sekolah', compact('sekolah', 'kriteriaList'));
    }

    /**
     * History list
     */
    public function history()
    {
        $history = Rekomendasi::where('user_id', Auth::id())
            ->latest()->paginate(10);

        return view('user.rekomendasi.history', compact('history'));
    }
}