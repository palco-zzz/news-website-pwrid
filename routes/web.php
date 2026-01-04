<?php

use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\CitizenReportController as AdminCitizenReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\CitizenReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trending', [NewsController::class, 'trending'])->name('news.trending');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/laporan-warga', [CitizenReportController::class, 'index'])->name('citizen-reports.index');
Route::post('/laporan-warga', [CitizenReportController::class, 'store'])->name('citizen-reports.store');
Route::get('/laporan-warga/{slug}', [CitizenReportController::class, 'show'])->name('citizen-reports.show');

Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');

Route::get('/agenda', function () {
    return Inertia::render('Agenda');
})->name('agenda');

// Dashboard redirect to admin
Route::get('dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // News Management
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
    Route::patch('/news/{news}/toggle/{field}', [AdminNewsController::class, 'toggleStatus'])->name('news.toggle-status');

    // UMKM Management
    Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/create', [AdminUmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [AdminUmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/{umkm}/edit', [AdminUmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm/{umkm}', [AdminUmkmController::class, 'update'])->name('umkm.update');
    Route::patch('/umkm/{umkm}/verify', [AdminUmkmController::class, 'verify'])->name('umkm.verify');
    Route::delete('/umkm/{umkm}', [AdminUmkmController::class, 'destroy'])->name('umkm.destroy');

    // Citizen Reports Management
    Route::get('/citizen-reports', [AdminCitizenReportController::class, 'index'])->name('citizen-reports.index');
    Route::get('/citizen-reports/{citizenReport}', [AdminCitizenReportController::class, 'show'])->name('citizen-reports.show');
    Route::patch('/citizen-reports/{citizenReport}/status', [AdminCitizenReportController::class, 'updateStatus'])->name('citizen-reports.update-status');
    Route::patch('/citizen-reports/{citizenReport}/publish', [AdminCitizenReportController::class, 'togglePublish'])->name('citizen-reports.toggle-publish');
    Route::put('/citizen-reports/{citizenReport}', [AdminCitizenReportController::class, 'update'])->name('citizen-reports.update');
    Route::delete('/citizen-reports/{citizenReport}', [AdminCitizenReportController::class, 'destroy'])->name('citizen-reports.destroy');

    // Agenda Management
    Route::get('/agenda', [AdminAgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda', [AdminAgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{agenda}', [AdminAgendaController::class, 'show'])->name('agenda.show');
    Route::get('/agenda/{agenda}/edit', [AdminAgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/agenda/{agenda}', [AdminAgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{agenda}', [AdminAgendaController::class, 'destroy'])->name('agenda.destroy');

    Route::get('/settings', fn() => Inertia::render('Admin/Settings/Index'))->name('settings.index');
});

require __DIR__ . '/settings.php';
