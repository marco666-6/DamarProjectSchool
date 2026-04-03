<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kegiatan;
use App\Models\Nilai;
use App\Models\Rekomendasi;
use App\Models\SekolahInfo;
use App\Models\SekolahRekomendasi;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $school = SekolahInfo::getInstance();

        $stats = [
            'total_siswa' => Siswa::active()->count(),
            'total_guru' => Guru::active()->count(),
            'total_kegiatan' => Kegiatan::count(),
            'total_rekomendasi' => Rekomendasi::count(),
            'rata_nilai' => round((float) (Nilai::avg('nilai_akhir') ?? 0), 1),
            'mitra_smp' => SekolahRekomendasi::active()->count(),
        ];

        $announcements = Kegiatan::with(['siswa', 'guru'])
            ->orderByDesc(DB::raw('COALESCE(tanggal_kegiatan, created_at)'))
            ->take(6)
            ->get();

        $featuredStudents = Siswa::active()
            ->withAvg('nilai as average_nilai', 'nilai_akhir')
            ->withCount('kegiatan')
            ->orderByDesc('average_nilai')
            ->orderByDesc('kegiatan_count')
            ->take(4)
            ->get();

        $achievementStats = Kegiatan::selectRaw('jenis_kegiatan, count(*) as total')
            ->groupBy('jenis_kegiatan')
            ->orderByDesc('total')
            ->get();

        $classStats = Siswa::active()
            ->selectRaw('kelas, count(*) as total')
            ->whereNotNull('kelas')
            ->groupBy('kelas')
            ->orderBy('kelas')
            ->get();

        $scoreTrend = Nilai::selectRaw('semester, AVG(nilai_akhir) as average_score, COUNT(*) as total_records')
            ->whereNotNull('nilai_akhir')
            ->groupBy('semester')
            ->orderBy('semester')
            ->get();

        $recommendedSchools = SekolahRekomendasi::active()
            ->orderBy('akreditasi')
            ->orderByDesc('jumlah_siswa')
            ->take(6)
            ->get();

        $timeline = $this->buildTimeline($announcements);

        return view('home.index', compact(
            'school',
            'stats',
            'announcements',
            'featuredStudents',
            'achievementStats',
            'classStats',
            'scoreTrend',
            'recommendedSchools',
            'timeline'
        ));
    }

    protected function buildTimeline(Collection $announcements): array
    {
        return $announcements
            ->take(4)
            ->map(function (Kegiatan $item): array {
                return [
                    'title' => $item->nama_kegiatan,
                    'date' => optional($item->tanggal_kegiatan ?? $item->created_at)->translatedFormat('d M Y'),
                    'description' => $item->deskripsi ?: 'Informasi kegiatan terbaru dari sekolah.',
                    'meta' => trim(implode(' • ', array_filter([
                        $item->jenis_kegiatan,
                        $item->siswa?->nama_siswa,
                        $item->guru?->nama_guru,
                    ]))),
                ];
            })
            ->values()
            ->all();
    }
}
