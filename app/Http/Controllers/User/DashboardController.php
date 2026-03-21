<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use App\Models\Siswa;
use App\Models\SekolahInfo;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user       = Auth::user();
        $sekolahInfo = SekolahInfo::getInstance();

        // Find siswa linked to this user account (parent view)
        $siswaList  = Siswa::where('user_id', $user->id)->with(['nilai', 'kegiatan'])->get();

        $lastRekomen = Rekomendasi::where('user_id', $user->id)
            ->latest()->first();

        return view('user.dashboard', compact('user', 'sekolahInfo', 'siswaList', 'lastRekomen'));
    }
}