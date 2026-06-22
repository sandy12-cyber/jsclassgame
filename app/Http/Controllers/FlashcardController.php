<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FlashcardController extends Controller
{
    /**
     * Index — pick a theme + level to print as flashcards.
     */
    public function index(): View
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('questions')
            ->get()
            ->map(function ($theme) {
                $theme->level_counts = $theme->levelCounts();
                return $theme;
            });

        return view('flashcards-index', compact('themes'));
    }

    /**
     * Show — render a printable flashcard sheet for a theme + level.
     * Designed to print 6 cards per A4 page (2 columns x 3 rows).
     */
    public function show(Theme $theme, string $level): View
    {
        $level = strtoupper($level);

        if (! in_array($level, Question::LEVELS, true)) {
            abort(404, 'Unknown CEFR level.');
        }

        $questions = $theme->questionsForLevel($level);

        if ($questions->isEmpty()) {
            return view('game-empty', compact('theme', 'level'));
        }

        return view('flashcards', compact('theme', 'level', 'questions'));
    }
}
