<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PairworkController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes — SpeakUp! Speaking Question Card Game
|--------------------------------------------------------------------------
*/

// Home — list all themes
Route::get('/', [HomeController::class, 'index'])->name('home');

// About / how-to-play page
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Onboarding welcome tour (first-time visitors)
Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');

// Dashboard — overall stats & progress
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rubric history — lesson self-assessment score trends
Route::get('/rubric-history', [DashboardController::class, 'rubricHistory'])->name('rubric.history');

// Achievements & streaks page
Route::get('/achievements', [DashboardController::class, 'achievements'])->name('achievements');

// Daily Challenge — one random card a day
Route::get('/challenge', [ChallengeController::class, 'daily'])->name('challenge.daily');
Route::get('/challenge/random', [ChallengeController::class, 'random'])->name('challenge.random');

// Search across all questions
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Favorites — client-rendered list of starred questions (ids in localStorage)
Route::get('/favorites', [SearchController::class, 'favorites'])->name('favorites');

// Tools — standalone speaking stopwatch / timer
Route::get('/tools/timer', [ToolsController::class, 'timer'])->name('tools.timer');

// Playlist — queue multiple decks into a single session
Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');
Route::get('/playlist/play', [PlaylistController::class, 'play'])->name('playlist.play');

// Export — CSV download for teachers
Route::get('/export/questions.csv', [ExportController::class, 'questionsCsv'])->name('export.questions.csv');
Route::get('/export', [ExportController::class, 'index'])->name('export.index');

// Theme detail — show levels A1–B2 for a theme
Route::get('/themes/{theme:slug}', [ThemeController::class, 'show'])->name('themes.show');

// Card game — play a deck for a specific theme + level
Route::get('/play/{theme:slug}/{level}', [GameController::class, 'play'])->name('game.play');

// Lesson Mode — guided practice with a speaking rubric self-assessment
Route::get('/lesson/{theme:slug}/{level}', [LessonController::class, 'play'])->name('lesson.play');

// Pair-work classroom mode — 2-player turn-based
Route::get('/pairwork', [PairworkController::class, 'setup'])->name('pairwork.setup');
Route::get('/pairwork/{theme:slug}/{level}', [PairworkController::class, 'play'])->name('pairwork.play');

// Printable flashcards
Route::get('/flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');
Route::get('/flashcards/{theme:slug}/{level}', [FlashcardController::class, 'show'])->name('flashcards.show');

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

    // Playlist — resolve a list of {theme_slug, level} pairs into decks
    Route::post('/playlist/resolve', [PlaylistController::class, 'resolve'])->name('api.playlist.resolve');
});


