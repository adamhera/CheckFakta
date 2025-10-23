<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicNewsController;

use App\Http\Controllers\PredictController;

// --------------------------------------
// HOMEPAGE (Landing page)
// --------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');

// --------------------------------------
// PUBLIC NEWS (from landing page)
// --------------------------------------
Route::get('/verified-news/{id}', [PublicNewsController::class, 'show'])->name('public.news.show');

// --------------------------------------
// FAKE NEWS DETECTION (logged-in users)
// --------------------------------------
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/result/{id}', [NewsController::class, 'show'])->name('news.show');
Route::get('/history', [NewsController::class, 'history'])->name('news.history');

// --------------------------------------
// DASHBOARD
// --------------------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --------------------------------------
// PROFILE
// --------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --------------------------------------
// SEMANTIC SIMILARITY PREDICTION
// --------------------------------------
Route::post('/predict', [PredictController::class, 'predict'])->name('predict');
require __DIR__.'/auth.php';
