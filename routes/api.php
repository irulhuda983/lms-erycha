<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ADMIN\AuthController;
use App\Http\Controllers\ADMIN\KelasController;
use App\Http\Controllers\ADMIN\RombelController;
use App\Http\Controllers\ADMIN\MapelController;
use App\Http\Controllers\ADMIN\GuruController;
use App\Http\Controllers\ADMIN\SiswaController;
use App\Http\Controllers\ADMIN\MateriController;
use App\Http\Controllers\ADMIN\SoalController;
use App\Http\Controllers\ADMIN\SoalItemController;
use App\Http\Controllers\ADMIN\UjianController;
use App\Http\Controllers\ADMIN\OptController;

use App\Http\Controllers\SISWA\AuthController as SiswaAuthController;
use App\Http\Controllers\SISWA\DashboardController as SiswaDashboardController;
use App\Http\Controllers\SISWA\MateriController as SiswaMateriController;
use App\Http\Controllers\SISWA\UjianController as SiswaUjianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// controller siswa
Route::prefix('peserta')->group(function() {
    Route::prefix('account')->group(function() {
        Route::post('issue-token', [SiswaAuthController::class, 'issueTokenPeserta']);
        Route::get('profil', [SiswaAuthController::class, 'getMe'])->middleware(['auth:api']);
        Route::post('refresh-token', [SiswaAuthController::class, 'refreshToken']);
        Route::post('/logout', [SiswaAuthController::class, 'logout'])->middleware(['auth:api']);
    });

    Route::prefix('dashboard')
    ->controller(SiswaDashboardController::class)
    ->middleware(['auth:api', 'role:admin|guru|siswa'])
    ->group(function() {
        Route::get('/popular-materi', 'popularMateri');
        Route::get('/nilai-tertinggi', 'nilaiTertinggi');
    });

    Route::prefix('materi')
    ->controller(SiswaMateriController::class)
    ->middleware(['auth:api', 'role:admin|guru|siswa'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{materi}/detail', 'show');
    });

    Route::prefix('ujian')
    ->controller(SiswaUjianController::class)
    ->middleware(['auth:api', 'role:admin|guru|siswa'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('/hasil', 'getHasil');
        Route::get('{ujian}/detail', 'show');
        Route::post('{ujian}/mulai', 'mulaiUjian');
    });

    Route::prefix('tes')
    ->controller(SiswaUjianController::class)
    ->middleware(['auth:api', 'role:admin|guru|siswa'])
    ->group(function() {
        Route::post('{ujian}/mulai', 'mulaiUjian');
        Route::post('{soal}/get-soal-item', 'getSoal');
        Route::post('{ujianSiswa}/get-jawaban', 'getJawaban');
        Route::post('{ujianSiswa}/get-all-jawaban', 'getAllJawaban');
        Route::post('{ujianSiswa}/jawab-soal', 'jawabSoal');
        Route::post('{ujianSiswa}/selesai', 'selesaiTes');
    });
});


// controller admin
Route::prefix('admin')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('issue-token', [AuthController::class, 'issueTokenAdmin']);
        Route::get('profil', [AuthController::class, 'getMe'])->middleware(['auth:api', 'role:admin|guru']);
        Route::post('refresh-token', [AuthController::class, 'refreshToken']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api', 'role:admin|guru']);
    });

    Route::prefix('kelas')
    ->controller(KelasController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{kelas}/detail', 'show');
        Route::post('', 'store');
        Route::post('{kelas}/update', 'update');
        Route::delete('{kelas}/delete', 'destroy');
    });

    Route::prefix('rombel')
    ->controller(RombelController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{rombel}/detail', 'show');
        Route::post('', 'store');
        Route::post('{rombel}/update', 'update');
        Route::delete('{rombel}/delete', 'destroy');
    });

    Route::prefix('mapel')
    ->controller(MapelController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{mapel}/detail', 'show');
        Route::post('', 'store');
        Route::post('{mapel}/update', 'update');
        Route::delete('{mapel}/delete', 'destroy');
    });

    Route::prefix('guru')
    ->controller(GuruController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{guru}/detail', 'show');
        Route::post('', 'store');
        Route::post('{guru}/update', 'update');
        Route::delete('{guru}/delete', 'destroy');
    });

    Route::prefix('siswa')
    ->controller(SiswaController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{siswa}/detail', 'show');
        Route::post('', 'store');
        Route::post('/generate-from-file', 'generateFromFile');
        Route::post('{siswa}/update', 'update');
        Route::delete('{siswa}/delete', 'destroy');
    });

    Route::prefix('materi')
    ->controller(MateriController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{materi}/detail', 'show');
        Route::post('', 'store');
        Route::post('{materi}/update', 'update');
        Route::delete('{materi}/delete', 'destroy');
    });

    Route::prefix('soal')
    ->controller(SoalController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{soal}/detail', 'show');
        Route::post('', 'store');
        Route::post('{soal}/update', 'update');
        Route::delete('{soal}/delete', 'destroy');
    });

    Route::prefix('soal-item')
    ->controller(SoalItemController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('list-soal', 'index');
        Route::get('get-single-item', 'getSingleItem');
        Route::get('{soalItem}/detail', 'show');
        Route::post('', 'storeOrUpdate');
        Route::delete('{soalItem}/delete', 'destroy');
    });

    Route::prefix('ujian')
    ->controller(UjianController::class)
    ->middleware(['auth:api', 'role:admin|guru'])
    ->group(function() {
        Route::get('', 'index');
        Route::get('{ujian}/detail', 'show');
        Route::post('', 'store');
        Route::post('{ujian}/update', 'update');
        Route::post('{ujian}/activate', 'activate');
        Route::post('{ujian}/deactivate', 'deactivate');
        Route::delete('{ujian}/delete', 'destroy');
    });

});
// end controller admin

// route opt
Route::prefix('opt')
->controller(OptController::class)
->middleware(['auth:api', 'role:admin|guru|siswa'])
->group(function() {
    Route::get('kelas', 'kelas');
    Route::get('mapel', 'mapel');
    Route::get('rombel', 'rombel');
    Route::get('tipe-ujian', 'tipeUjian');
    Route::get('guru', 'guru');
    Route::get('materi', 'materi');
    Route::get('soal', 'soal');
});
// end route opt


// generate url dokumen
Route::get('upload/{pathA}/{pathB}/{pathC?}', function ($pathA, $pathB, $pathC = null) {
    $path = "{$pathA}/{$pathB}";
    if ($pathC !== null) $path .= "/{$pathC}";
    $mime = Storage::mimeType($path);
    $allowedMime = ['video/mp4', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.ms-excel'];

    if (!in_array($mime, $allowedMime))
        return response()->json(['error' => 'Tidak terpenuhi.'], 400);
    else
        return response()->file(storage_path("app/{$path}"));
});
// end generate url dokumen
