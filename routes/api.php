<?php

use API\SuratPKLController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PerusahaanApiController;

// Surat PKL API Routes
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('surat-pkl', SuratPKLController::class);
// }); 

// PKL Submission API Routes
// Route::prefix('pengajuan-pkl')->group(function () {
//     Route::get('/', [App\Http\Controllers\Api\PengajuanPKLApiController::class, 'index']);
//     Route::post('/', [App\Http\Controllers\Api\PengajuanPKLApiController::class, 'store']);
//     Route::get('/{id}', [App\Http\Controllers\Api\PengajuanPKLApiController::class, 'show']);
//     Route::put('/{id}', [App\Http\Controllers\Api\PengajuanPKLApiController::class, 'update']);
//     Route::delete('/{id}', [App\Http\Controllers\Api\PengajuanPKLApiController::class, 'destroy']);
// });



//perusahaan
// Import perusahaan dari JSON
Route::get('/data', [App\Http\Controllers\API\PerusahaanApiController::class, 'importFromJson']); 
Route::post('perusahaan/api', [App\Http\Controllers\API\PerusahaanApiController::class, 'returnPerusahaan']);
// Endpoint untuk menampilkan data perusahaan dari file JSON
Route::get('perusahaan/json', [App\Http\Controllers\API\PerusahaanApiController::class, 'getFromJson']);    

