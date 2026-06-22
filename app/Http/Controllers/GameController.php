<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * Render the card game page for a theme + level.
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

        return view('game', compact('theme', 'level', 'questions', 'suggestedTime'));
    }

    /**
     * Return questions as JSON (used by the game UI / future SPA features).
     */
    public function questions(Theme $theme, string $level): JsonResponse
    {
        $level = strtoupper($level);

        if (! in_array($level, Question::LEVELS, true)) {
            return response()->json(['error' => 'Unknown level'], 404);
        }

        $questions = $theme->questionsForLevel($level)->values();

        return response()->json([
            'theme' => [
                'name' => $theme->name,
                'slug' => $theme->slug,
                'emoji' => $theme->emoji,
            ],
            'level' => $level,
            'count' => $questions->count(),
            'questions' => $questions,
        ]);
    }

    /**
     * Save progress (cards practiced) — stored in the session so it works
     * without authentication. Swappable for a real DB-backed store later.
     */
    public function saveProgress(Request $request): JsonResponse
    {
        $data = $request->validate([
            'theme_slug' => ['required', 'string'],
            'level' => ['required', 'in:A1,A2,B1,B2'],
            'practiced' => ['required', 'array'],
            'practiced.*' => ['integer'],
        ]);

        $key = "progress.{$data['theme_slug']}.{$data['level']}";
        $existing = session($key, []);
        session([$key => array_unique(array_merge($existing, $data['practiced']))]);

        return response()->json(['ok' => true, 'total_practiced' => count(session($key))]);
    }

    /**
     * Get progress for a theme (all levels).
     */
    public function getProgress(Theme $theme): JsonResponse
    {
        $levels = [];
        foreach (Question::LEVELS as $level) {
            $levels[$level] = count(session("progress.{$theme->slug}.{$level}", []));
        }

        return response()->json(['theme' => $theme->slug, 'progress' => $levels]);
    }

    /**
     * Overall stats for the dashboard widget.
     */
    public function stats(): JsonResponse
    {
        $themes = Theme::where('is_active', true)->count();
        $questions = Question::count();

        $byLevel = [];
        foreach (Question::LEVELS as $level) {
            $byLevel[$level] = Question::where('level', $level)->count();
        }

        return response()->json([
            'themes' => $themes,
            'questions' => $questions,
            'by_level' => $byLevel,
        ]);
    }
}
