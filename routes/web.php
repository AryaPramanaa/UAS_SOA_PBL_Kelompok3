<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\API\PerusahaanApiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\LowonganPKLController;
use App\Http\Controllers\pengajuanPKLController;
use App\Http\Controllers\PerusahaanPKLController;
use App\Http\Controllers\SuratPernyataanController;
use App\Http\Controllers\daftarPerusahaanController;
use App\Http\Controllers\laporanMahasiswaController;
use App\Http\Controllers\pembimbingIndustriController;
use App\Http\Controllers\JurusanProdiController;
use App\Http\Controllers\JadwalPendaftaranController;
use App\Http\Controllers\pengajuanPKLKapordiController;
use App\Http\Controllers\OperatorLowonganPKlController;
use App\Http\Controllers\PerusahaanLowonganPKLController;
use App\Http\Controllers\SuratPKLController;
use App\Http\Controllers\OperatorSuratPKLController;
use App\Http\Controllers\PembimbingAkademikController;
use App\Http\Controllers\OperatorPengajuanPKLController;
use App\Http\Controllers\perusahaanPembimbingIndustriController;
use App\Http\Controllers\PerusahaanProfilController;
use App\Http\Controllers\MahasiswaProfilController;
use App\Http\Controllers\ProdiProfilController;
use App\Http\Controllers\RegisterMahasiswaController;
use App\Http\Controllers\MahasiswaPembimbingAkademikController;
use App\Http\Controllers\RekapMahasiswaPKLKaprodiController;
use App\Http\Controllers\RekapMahasiswaPKLPimpinanController;
use App\Http\Controllers\PengumumanController;


//Frontend
Route::get('/', function () {
    $pengumumans = \App\Models\Pengumuman::orderBy('created_at', 'desc')->get();
    $lowongans = \App\Models\LowonganPKL::with('perusahaan')->orderBy('created_at', 'desc')->take(4)->get();
    return view('frontend.homepage', compact('pengumumans', 'lowongans'));
});
Route::get('/entry', function () {
    return view('auth.entry');
});


// Login
Route::get('/dashboard/{username}', [LoginController::class, 'redirect'])->name('dashboard')->middleware('auth');
Route::get('/login', function () {
    return redirect('/entry');
});
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Role-specific dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/perusahaan/dashboard', function () {
        return view('backend.dashboard.perusahaan');
    })->name('perusahaan.dashboard');

    Route::get('/mahasiswa/dashboard', function () {
        return view('backend.dashboard.mahasiswa');
    })->name('mahasiswa.dashboard');

    Route::get('/operator/dashboard', function () {
        return view('backend.dashboard.operator');
    })->name('operator.dashboard');

    Route::get('/kaprodi/dashboard', function () {
        return view('backend.dashboard.kaprodi');
    })->name('kaprodi.dashboard');

    Route::get('/pimpinan/dashboard', function () {
        return view('backend.dashboard.pimpinan');
    })->name('pimpinan.dashboard');

    Route::get('perusahaan/lowongan-saya', [App\Http\Controllers\LowonganPKlController::class, 'indexPerusahaan'])->name('perusahaan.lowongan.saya');
});



//MAHASISWA
Route::middleware(['auth'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::resource('daftarPerusahaanPKL', daftarPerusahaanController::class);
    Route::resource('pembimbingIndustri', pembimbingIndustriController::class);
    Route::resource('pembimbingAkademik', MahasiswaPembimbingAkademikController::class)->only(['index','show']);
    Route::resource('pengajuanPKL', pengajuanPKLController::class);
    Route::resource('lowonganPKL', LowonganPKLController::class);
    Route::resource('suratPKL', SuratPKLController::class);
    // Profil Mahasiswa
    Route::get('profil/edit', [App\Http\Controllers\MahasiswaProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [App\Http\Controllers\MahasiswaProfilController::class, 'update'])->name('profil.update');
});

//PERUSAHAAN ROUTE
Route::middleware(['auth'])->prefix('perusahaan')->name('perusahaan.')->group(function () {
    Route::resource('lowonganPKL', PerusahaanLowonganPKLController::class);
    Route::resource('pembimbingIndustri', perusahaanPembimbingIndustriController::class);
    Route::post('pembimbingIndustri/{pembimbingIndustri}/assign-mahasiswa', [App\Http\Controllers\perusahaanPembimbingIndustriController::class, 'assignMahasiswa'])->name('pembimbingIndustri.assignMahasiswa');
    Route::delete('pembimbingIndustri/{pembimbingIndustri}/mahasiswa/{mahasiswa}', [App\Http\Controllers\perusahaanPembimbingIndustriController::class, 'removeMahasiswa'])->name('pembimbingIndustri.removeMahasiswa');
    Route::resource('laporanMahasiswa', App\Http\Controllers\laporanMahasiswaController::class);
    // Profil Perusahaan
    Route::get('profil/edit', [App\Http\Controllers\PerusahaanProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [App\Http\Controllers\PerusahaanProfilController::class, 'update'])->name('profil.update');
    Route::put('profil/updatePassword', [App\Http\Controllers\PerusahaanProfilController::class, 'updatePassword'])->name('profil.updatePassword');
    // Rekap Mahasiswa PKL
    Route::resource('rekapMahasiswaPKL', App\Http\Controllers\RekapMahasiswaPKLPerusahaanController::class)->only(['index', 'show']);
});

//OPERATOR ROUTE
Route::middleware(['auth'])->prefix('operator')->name('operator.')->group(function () {
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('perusahaanPKL', PerusahaanPKLController::class);
    Route::resource('jurusanProdi', JurusanProdiController::class);
    Route::resource('akun', AkunController::class);
    Route::resource('lowonganPKL', OperatorLowonganPKlController::class);
    Route::resource('suratPKL', OperatorSuratPKLController::class);
    Route::resource('pengajuanPKL', OperatorPengajuanPKLController::class);
    Route::post('/akun/{id}/activate', [App\Http\Controllers\AkunController::class, 'activate'])->name('operator.akun.activate');
    // AJAX: Mahasiswa diterima di perusahaan tertentu untuk surat PKL operator
    Route::get('/surat-pkl/mahasiswa-by-perusahaan/{perusahaan_id}', [App\Http\Controllers\OperatorSuratPKLController::class, 'mahasiswaByPerusahaan'])->name('operator.suratPKL.mahasiswaByPerusahaan');
});

//KAPRODI
Route::middleware(['auth'])->prefix('kaprodi')->name('kaprodi.')->group(function () {
    Route::resource('pengajuanPKL', pengajuanPKLKapordiController::class);
    Route::resource('rekapMahasiswaPKL', RekapMahasiswaPKLKaprodiController::class)->only(['index', 'show']);
    // Profil Prodi (Kaprodi)
    Route::get('profil/edit', [App\Http\Controllers\ProdiProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil/update', [App\Http\Controllers\ProdiProfilController::class, 'update'])->name('profil.update');
    Route::put('profil/updatePassword', [App\Http\Controllers\ProdiProfilController::class, 'updatePassword'])->name('profil.updatePassword');
});

// Pembimbing Akademik Routes
Route::middleware(['auth'])->prefix('kaprodi')->group(function () {
    Route::resource('pembimbing-akademik', PembimbingAkademikController::class);
    Route::post('pembimbing-akademik/{pembimbingAkademik}/assign-mahasiswa', [PembimbingAkademikController::class, 'assignMahasiswa'])->name('pembimbing-akademik.assign-mahasiswa');
    Route::delete('pembimbing-akademik/{pembimbingAkademik}/mahasiswa/{mahasiswa}', [PembimbingAkademikController::class, 'removeMahasiswa'])->name('pembimbing-akademik.remove-mahasiswa');
    Route::post('kaprodi/pembimbing-akademik/{pembimbingAkademik}/assign-mahasiswa/{mahasiswa}', [App\Http\Controllers\PembimbingAkademikController::class, 'assignSingleMahasiswa'])->name('pembimbing-akademik.assign-single-mahasiswa');
});

//API
Route::get('/data', [App\Http\Controllers\API\PerusahaanApiController::class, 'importFromJson']); 
Route::get('/api/perusahaan/search', [App\Http\Controllers\API\PerusahaanApiController::class, 'search'])->name('api.perusahaan.search');

// Register Mahasiswa
Route::middleware('guest')->group(function () {
    Route::get('/register/mahasiswa', [App\Http\Controllers\RegisterMahasiswaController::class, 'showRegistrationForm'])->name('register.mahasiswa');
    Route::post('/register/mahasiswa', [App\Http\Controllers\RegisterMahasiswaController::class, 'register']);
});

//PIMPINAN
Route::middleware(['auth'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::resource('laporanMahasiswa', App\Http\Controllers\PimpinanLaporanMahasiswaController::class)->only(['index', 'show']);
    Route::resource('rekapMahasiswaPKL', App\Http\Controllers\RekapMahasiswaPKLPimpinanController::class)->only(['index', 'show']);
});

// API untuk ambil divisi berdasarkan perusahaan_id (untuk pengajuan PKL mahasiswa)
Route::get('/api/perusahaan/{perusahaan}/divisi', function($perusahaanId) {
    $divisis = \App\Models\LowonganPKL::where('perusahaan_id', $perusahaanId)->pluck('divisi');
    return response()->json($divisis);
});
















