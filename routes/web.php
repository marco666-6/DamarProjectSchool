<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Guru;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

// ── Public / Guest ────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Role-based dashboard redirect ────────────────────────────────────────────
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'guru'  => redirect()->route('guru.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware('auth')->name('dashboard');

// ── Shared Profile (all authenticated roles) ─────────────────────────────────
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/',              [ProfileController::class, 'show'])->name('show');
    Route::get('/edit',          [ProfileController::class, 'edit'])->name('edit');
    Route::put('/update',        [ProfileController::class, 'update'])->name('update');
    Route::put('/password',      [ProfileController::class, 'updatePassword'])->name('password');
});

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN ROUTES
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Siswa
    Route::resource('siswa', Admin\SiswaController::class);

    // Guru
    Route::resource('guru', Admin\GuruController::class);

    // Mata Pelajaran
    Route::resource('mata-pelajaran', Admin\MataPelajaranController::class);

    // Nilai
    Route::resource('nilai', Admin\NilaiController::class)->except(['show']);

    // Kegiatan
    Route::resource('kegiatan', Admin\KegiatanController::class)->except(['show']);

    // Kriteria SAW
    Route::resource('kriteria', Admin\KriteriaController::class)->except(['show']);
    Route::post('kriteria/update-bobot', [Admin\KriteriaController::class, 'updateBobot'])
        ->name('kriteria.update-bobot');

    // Sekolah Rekomendasi (SMP)
    Route::resource('sekolah-rekomendasi', Admin\SekolahRekomendasiController::class);
    Route::get('sekolah-rekomendasi/matriks-keputusan',
        [Admin\SekolahRekomendasiController::class, 'matriksKeputusan'])
        ->name('sekolah-rekomendasi.matriks');

    // Sekolah Info (BIIS profile)
    Route::get('sekolah-info',         [Admin\SekolahInfoController::class, 'edit'])->name('sekolah-info.edit');
    Route::put('sekolah-info',         [Admin\SekolahInfoController::class, 'update'])->name('sekolah-info.update');

    // User management
    Route::resource('users', Admin\UserController::class)->except(['show']);
});

// ─────────────────────────────────────────────────────────────────────────────
// GURU ROUTES
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {

    Route::get('/dashboard', [Guru\DashboardController::class, 'index'])->name('dashboard');

    // Nilai
    Route::resource('nilai', Guru\NilaiController::class)->except(['show']);

    // Kegiatan
    Route::resource('kegiatan', Guru\KegiatanController::class)->except(['show']);

    // Read-only: view siswa & sekolah info
    Route::get('siswa',           [Guru\DataController::class, 'siswa'])->name('siswa.index');
    Route::get('siswa/{siswa}',   [Guru\DataController::class, 'siswaShow'])->name('siswa.show');
    Route::get('sekolah',         [Guru\DataController::class, 'sekolah'])->name('sekolah');
});

// ─────────────────────────────────────────────────────────────────────────────
// USER (PARENT/PUBLIC) ROUTES
// ─────────────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

    // Data views (read-only)
    Route::get('sekolah',           [User\DataController::class, 'sekolah'])->name('data.sekolah');
    Route::get('siswa',             [User\DataController::class, 'siswa'])->name('data.siswa');
    Route::get('siswa/{siswa}',     [User\DataController::class, 'siswaShow'])->name('data.siswa.show');
    Route::get('guru',              [User\DataController::class, 'guru'])->name('data.guru');
    Route::get('nilai',             [User\DataController::class, 'nilai'])->name('data.nilai');
    Route::get('kegiatan',          [User\DataController::class, 'kegiatan'])->name('data.kegiatan');

    // SAW Recommendation
    Route::get('rekomendasi',                        [User\RekomendasiController::class, 'form'])->name('rekomendasi.form');
    Route::post('rekomendasi/hitung',                [User\RekomendasiController::class, 'hitung'])->name('rekomendasi.hitung');
    Route::get('rekomendasi/hasil/{rekomendasi}',    [User\RekomendasiController::class, 'hasil'])->name('rekomendasi.hasil');
    Route::get('rekomendasi/sekolah/{sekolah}',      [User\RekomendasiController::class, 'detailSekolah'])->name('rekomendasi.sekolah');
    Route::get('rekomendasi/riwayat',                [User\RekomendasiController::class, 'history'])->name('rekomendasi.history');
});