<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes — SpeakUp! Speaking Question Card Game
|--------------------------------------------------------------------------
*/

// Home — list all themes
Route::get('/', [HomeController::class, 'index'])->name('home');

// About / how-to-play page
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Dashboard — overall stats & progress
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Daily Challenge — one random card a day
Route::get('/challenge', [ChallengeController::class, 'daily'])->name('challenge.daily');
Route::get('/challenge/random', [ChallengeController::class, 'random'])->name('challenge.random');

// Search across all questions
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Favorites — client-rendered list of starred questions (ids in localStorage)
Route::get('/favorites', [SearchController::class, 'favorites'])->name('favorites');

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

    // Favorites resolution — given a list of question ids, return full records
    Route::post('/favorites/resolve', [SearchController::class, 'resolveFavorites'])->name('api.favorites.resolve');

    // Question lookup by id (used by challenge / favorites)
    Route::get('/question/{id}', [ChallengeController::class, 'question'])->name('api.question');
});
