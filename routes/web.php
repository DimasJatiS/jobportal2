<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', fn() => view('welcome'));

// ===== DASHBOARD UMUM ===== //
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// =====================================================
// 🧑‍💼 AREA USER (pencari kerja)
// =====================================================
Route::middleware(['auth', 'isUser'])->group(function () {

    // Profil user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Lamar pekerjaan
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('apply.store');
});

// =====================================================
// 🧰 AREA ADMIN
// =====================================================
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {

    // CRUD Lowongan
    Route::resource('jobs', JobController::class)->except(['index', 'show']);
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // Import Export Job
    Route::post('/jobs/import', [JobController::class, 'import'])->name('jobs.import');
    Route::get('/jobs/import/template', function () {
        return Excel::download(new \App\Exports\JobTemplateExport, 'template_import_jobs.xlsx');
        })->name('jobs.import.template');

    // Pelamar (Admin)
    Route::get('/applications', [ApplicationController::class, 'adminIndex'])
        ->name('applications.index');

    // Pelamar berdasarkan lowongan tertentu (opsional)
    Route::get('/jobs/{job}/applicants', [ApplicationController::class, 'index'])
        ->name('applications.byJob');

    // Update status pelamar
    Route::put('/applications/{application}', [ApplicationController::class, 'update'])
        ->name('applications.update');

    // Export pelamar
    Route::get('/applications/export', [ApplicationController::class, 'export'])
        ->name('applications.export');

    

});

// =====================================================
// 🌍 ROUTE PUBLIK (non-login / guest & umum)
// =====================================================
Route::resource('jobs', JobController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
