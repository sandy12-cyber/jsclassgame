<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PairworkController extends Controller
{
    /**
     * Setup page — choose a theme + level for a pair-work session.
     */
    public function setup(Request $request): View
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('questions')
            ->get()
            ->map(function ($theme) {
                $theme->level_counts = $theme->levelCounts();
                $theme->total_questions = array_sum($theme->level_counts);
                return $theme;
            });

        return view('pairwork-setup', compact('themes'));
    }

    /**
     * Play page — 2-player turn-based. Even cards = Player A answers, Player B
     * asks a follow-up; odd cards swap roles. The UI handles the turn logic.
     */
    public function play(Theme $theme, string $level): View
    {
        $level = strtoupper($level);

        if (! in_array($level, Question::LEVELS, true)) {
            abort(404, 'Unknown CEFR level.');
        }

        $questions = $theme->questionsForLevel($level);

        if ($questions->isEmpty()) {
            return view('game-empty', compact('theme', 'level'));
        }

        $suggestedTime = Question::suggestedTime($level);

        return view('pairwork', compact('theme', 'level', 'questions', 'suggestedTime'));
    }
}
