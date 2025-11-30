<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicNewsController;

use App\Http\Controllers\PredictController;


use Illuminate\Support\Str;
// --------------------------------------
// HOMEPAGE (Landing page)
// --------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {return view('about');})->name('about');
Route::get('/rating', function () {return view('rating');})->name('rating');
Route::get('/contact', function () {return view('contact');})->name('contact');

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
})->middleware(['auth'])->name('dashboard');
// ->middleware(['auth', 'verified'])->name('dashboard');

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

// --------------------------------------
// Latest News Route
// --------------------------------------
Route::get('/', function () {
    $csvPath = base_path('ml/sebenarnya_labeledLatest.csv');

    $newsList = [];

    if (file_exists($csvPath) && ($handle = fopen($csvPath, 'r')) !== false) {

        // Read first line
        $firstLine = fgets($handle);

        if ($firstLine !== false) {
            // Detect delimiter automatically (comma, semicolon, tab)
            if (strpos($firstLine, "\t") !== false) {
                $delimiter = "\t";
            } elseif (strpos($firstLine, ";") !== false) {
                $delimiter = ";";
            } else {
                $delimiter = ",";
            }

            // Reset pointer
            rewind($handle);

            // Read headers
            $headers = fgetcsv($handle, 0, $delimiter);
            $headers = array_map('trim', $headers);
            // Remove BOM if present
            $headers[0] = preg_replace('/^\x{FEFF}/u', '', $headers[0]);

            // Read rows
            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                // Skip malformed rows
                if (count($row) != count($headers)) continue;

                $newsList[] = array_combine($headers, $row);
            }
        }

        fclose($handle);
    }

    // // Sort by date descending
    // usort($newsList, function ($a, $b) {
    //     return strtotime($b['date']) - strtotime($a['date']);
    // });

    // ✅ Place the date sorting here
    usort($newsList, function ($a, $b) {
    $dateA = DateTime::createFromFormat('d/m/Y', $a['date']) ?: strtotime($a['date']);
    $dateB = DateTime::createFromFormat('d/m/Y', $b['date']) ?: strtotime($b['date']);
    
    $timestampA = $dateA instanceof DateTime ? $dateA->getTimestamp() : $dateA;
    $timestampB = $dateB instanceof DateTime ? $dateB->getTimestamp() : $dateB;

    return $timestampB <=> $timestampA;
});

    // Take latest 3
    $latestNews = array_slice($newsList, 0, 3);

    return view('welcome', compact('latestNews'));
});

// --------------------------------------
// Latest News Route for Dashboard
// --------------------------------------
Route::get('/dashboard', function () {
    $csvPath = base_path('ml/sebenarnya_labeledLatest.csv');
    $newsList = [];

    if (file_exists($csvPath) && ($handle = fopen($csvPath, 'r')) !== false) {
        $firstLine = fgets($handle);
        if ($firstLine !== false) {
            $delimiter = strpos($firstLine, "\t") !== false ? "\t" : (strpos($firstLine, ";") !== false ? ";" : ",");
            rewind($handle);

            $headers = fgetcsv($handle, 0, $delimiter);
            $headers = array_map('trim', $headers);
            $headers[0] = preg_replace('/^\x{FEFF}/u', '', $headers[0]);

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (count($row) != count($headers)) continue;
                $newsList[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
    }

    // Sort by date descending (supports d/m/Y)
    usort($newsList, function ($a, $b) {
        $dateA = DateTime::createFromFormat('d/m/Y', trim($a['date'])) ?: strtotime($a['date']);
        $dateB = DateTime::createFromFormat('d/m/Y', trim($b['date'])) ?: strtotime($b['date']);

        $timestampA = $dateA instanceof DateTime ? $dateA->getTimestamp() : $dateA;
        $timestampB = $dateB instanceof DateTime ? $dateB->getTimestamp() : $dateB;

        return $timestampB <=> $timestampA;
    });

    $latestNews = array_slice($newsList, 0, 3);

    return view('dashboard', compact('latestNews'));
})->middleware(['auth'])->name('dashboard');