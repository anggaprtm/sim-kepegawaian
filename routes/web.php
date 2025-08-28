<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\TendikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\PromotionSubmissionController;
use App\Http\Controllers\Tendik\VerificationController;
use App\Http\Controllers\Tendik\AssessorAssignmentController;
use App\Http\Controllers\Tendik\PakSessionController;
use App\Http\Controllers\Tendik\BpfSessionController;
use App\Http\Controllers\Tendik\FinalizationController;
use App\Http\Controllers\Tendik\PromotionModuleController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======================================================================
// URUTAN RUTE DIPERBAIKI DI SINI
// ======================================================================

// Rute Dosen (Spesifik)
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('pengajuan', [PromotionSubmissionController::class, 'index'])->name('promotion.index');
    Route::get('pengajuan/buat', [PromotionSubmissionController::class, 'create'])->name('promotion.create');
    Route::post('pengajuan', [PromotionSubmissionController::class, 'store'])->name('promotion.store');
    Route::get('pengajuan/{submission}', [PromotionSubmissionController::class, 'show'])->name('promotion.show');
    Route::post('pengajuan/{submission}/upload', [PromotionSubmissionController::class, 'uploadDocument'])->name('promotion.upload');
    Route::post('pengajuan/{submission}/submit', [PromotionSubmissionController::class, 'submitForVerification'])->name('promotion.submit');
});

Route::middleware(['auth', 'role:tendik'])->prefix('tendik')->name('tendik.')->group(function () {
    // Rute utama modul kenaikan pangkat
    Route::get('kenaikan-pangkat', [PromotionModuleController::class, 'index'])->name('promotion.index');
    Route::get('kenaikan-pangkat/{submission}', [PromotionModuleController::class, 'show'])->name('promotion.show');

    // Rute untuk proses (masih menggunakan controller lama untuk sementara)
    Route::post('verifikasi/{submission}/process', [VerificationController::class, 'process'])->name('verification.process');
    Route::post('penilaian-asesor/{submission}', [AssessorAssignmentController::class, 'store'])->name('assessor.store');
    Route::get('penilaian-asesor/{submission}/surat-tugas', [AssessorAssignmentController::class, 'generateAssignmentLetter'])->name('assessor.letter');

    // Rute untuk sidang dan finalisasi (tetap terpisah karena merupakan halaman tersendiri)
    Route::resource('sidang-pak', PakSessionController::class)->names('pak_session');
    Route::post('sidang-pak/{sidang_pak}/process', [PakSessionController::class, 'processResults'])->name('pak_session.process');
    Route::get('sidang-pak/{sidang_pak}/undangan', [PakSessionController::class, 'generateInvitation'])->name('pak_session.invitation');
    
    Route::resource('sidang-bpf', BpfSessionController::class)->names('bpf_session');
    Route::post('sidang-bpf/{sidang_bpf}/process', [BpfSessionController::class, 'processResults'])->name('bpf_session.process');
    Route::get('sidang-bpf/{sidang_bpf}/undangan', [BpfSessionController::class, 'generateInvitation'])->name('bpf_session.invitation');
    
    Route::get('finalisasi', [FinalizationController::class, 'index'])->name('finalization.index');
    Route::post('finalisasi/generate-letter', [FinalizationController::class, 'generateUniversityCoverLetter'])->name('finalization.generate_letter');
    Route::post('finalisasi/{submission}/process', [FinalizationController::class, 'processFinalResult'])->name('finalization.process');
});


// Rute Superadmin (Umum) - Ditempatkan PALING AKHIR
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dosen', DosenController::class);
    Route::resource('tendik', TendikController::class);
});


require __DIR__.'/auth.php';