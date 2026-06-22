<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ChallengeController extends Controller
{
    /**
     * Daily Challenge — deterministic "card of the day".
     * The same question is returned to everyone on a given day, then rotates.
     */
    public function daily(): View
    {
        $question = $this->questionOfTheDay();
        $theme = $question->theme;

        $levelStyles = $this->levelStyles();
        $s = $levelStyles[$question->level];

        // Tomorrow's date for the countdown
        $nextDay = now()->addDay()->startOfDay();

        return view('challenge', [
            'question' => $question,
            'theme' => $theme,
            'level' => $question->level,
            'suggestedTime' => Question::suggestedTime($question->level),
            'levelStyle' => $s,
            'nextDay' => $nextDay,
            'mode' => 'daily',
        ]);
    }

    /**
     * Random challenge — a brand new random card each visit.
     */
    public function random(): View
    {
        $question = Question::with('theme')
            ->inRandomOrder()
            ->first();

        if (! $question) {
            abort(404, 'No questions available.');
        }

        $theme = $question->theme;
        $levelStyles = $this->levelStyles();
        $s = $levelStyles[$question->level];

        return view('challenge', [
            'question' => $question,
            'theme' => $theme,
            'level' => $question->level,
            'suggestedTime' => Question::suggestedTime($question->level),
            'levelStyle' => $s,
            'nextDay' => null,
            'mode' => 'random',
        ]);
    }

    /**
     * Single question lookup (JSON).
     */
    public function question(int $id): JsonResponse
    {
        $q = Question::with('theme')->findOrFail($id);

        return response()->json([
            'id' => $q->id,
            'prompt' => $q->prompt,
            'sample_answer' => $q->sample_answer,
            'tips' => $q->tips,
            'vocabulary' => $q->vocabulary,
            'level' => $q->level,
            'theme' => [
                'slug' => $q->theme->slug,
                'name' => $q->theme->name,
                'emoji' => $q->theme->emoji,
                'gradient' => $q->theme->gradient,
            ],
        ]);
    }

    /**
     * Deterministic question of the day based on the date.
     */
    protected function questionOfTheDay(): Question
    {
        $total = Question::count();

        if ($total === 0) {
            abort(404, 'No questions seeded yet.');
        }

        // Stable offset based on the day so the whole world sees the same card.
        // Days since a fixed epoch (2024-01-01) — always positive, deterministic.
        $offset = (int) now()->startOfDay()->diffInDays(\Illuminate\Support\Carbon::create(2024, 1, 1)->startOfDay(), false);
        // diffInDays($other, false) returns a signed difference; we want absolute days elapsed.
        $offset = abs($offset);
        $index = (($offset % $total) + $total) % $total;

        return Question::with('theme')
            ->orderBy('id')
            ->skip($index)
            ->firstOrFail();
    }

    protected function levelStyles(): array
    {
        return [
            'A1' => ['gradient' => 'from-emerald-400 to-green-500', 'text' => 'text-emerald-600', 'soft' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'emoji' => '🌱'],
            'A2' => ['gradient' => 'from-teal-400 to-cyan-500', 'text' => 'text-teal-600', 'soft' => 'bg-teal-50', 'border' => 'border-teal-200', 'emoji' => '🌿'],
            'B1' => ['gradient' => 'from-amber-400 to-orange-500', 'text' => 'text-amber-600', 'soft' => 'bg-amber-50', 'border' => 'border-amber-200', 'emoji' => '⚡'],
            'B2' => ['gradient' => 'from-rose-400 to-pink-600', 'text' => 'text-rose-600', 'soft' => 'bg-rose-50', 'border' => 'border-rose-200', 'emoji' => '🔥'],
        ];
    }
}
