<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes — SpeakUp! Speaking Question Card Game
|--------------------------------------------------------------------------
*/

// Home — list all themes
Route::get('/', [HomeController::class, 'index'])->name('home');

// About page
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Theme detail — show levels A1–B2 for a theme
Route::get('/themes/{theme:slug}', [ThemeController::class, 'show'])->name('themes.show');

// Card game — play a deck for a specific theme + level
Route::get('/play/{theme:slug}/{level}', [GameController::class, 'play'])->name('game.play');

// API endpoints (JSON) used by the game UI via fetch
Route::prefix('api')->group(function () {
    Route::get('/themes/{theme:slug}/{level}/questions', [GameController::class, 'questions'])->name('api.questions');
    Route::post('/progress', [GameController::class, 'saveProgress'])->name('api.progress.save');
    Route::get('/progress/{theme:slug}', [GameController::class, 'getProgress'])->name('api.progress.get');
    Route::get('/stats', [GameController::class, 'stats'])->name('api.stats');
});
