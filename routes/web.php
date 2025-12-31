<?php

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

Route::get('/info-warga', [CitizenReportController::class, 'index'])->name('citizen-reports.index');
Route::get('/info-warga/{slug}', [CitizenReportController::class, 'show'])->name('citizen-reports.show');

Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('umkm.show');

Route::get('/agenda', function () {
    return Inertia::render('Agenda');
})->name('agenda');

// Authenticated routes
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
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

    // UMKM Management
    Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/create', [AdminUmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [AdminUmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/{umkm}/edit', [AdminUmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm/{umkm}', [AdminUmkmController::class, 'update'])->name('umkm.update');
    Route::patch('/umkm/{umkm}/verify', [AdminUmkmController::class, 'verify'])->name('umkm.verify');
    Route::delete('/umkm/{umkm}', [AdminUmkmController::class, 'destroy'])->name('umkm.destroy');

    Route::get('/citizen-reports', fn() => Inertia::render('Admin/CitizenReports/Index'))->name('citizen-reports.index');
    Route::get('/agenda', fn() => Inertia::render('Admin/Agenda/Index'))->name('agenda.index');
    Route::get('/settings', fn() => Inertia::render('Admin/Settings/Index'))->name('settings.index');
});

require __DIR__ . '/settings.php';
