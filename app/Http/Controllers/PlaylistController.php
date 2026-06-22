<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    /**
     * Index — builder page where you queue up multiple decks.
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

        return view('playlist-index', compact('themes'));
    }

    /**
     * Play — renders a shell page; the actual deck queue is resolved
     * client-side via the resolve API (so the playlist lives in the URL
     * query string and survives refreshes).
     */
    public function play(Request $request): View
    {
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('playlist-play', compact('themes'));
    }

    /**
     * Resolve a list of {theme_slug, level} pairs into full question records.
     * Used by the playlist-play page to load all queued decks in one request.
     */
    public function resolve(Request $request): JsonResponse
    {
        $data = $request->validate([
            'decks' => ['required', 'array'],
            'decks.*.theme_slug' => ['required', 'string'],
            'decks.*.level' => ['required', 'in:A1,A2,B1,B2'],
        ]);

        $result = [];
        foreach ($data['decks'] as $deck) {
            $theme = Theme::where('slug', $deck['theme_slug'])->first();
            if (! $theme) {
                continue;
            }
            $questions = $theme->questionsForLevel($deck['level']);
            if ($questions->isEmpty()) {
                continue;
            }
            $result[] = [
                'theme' => [
                    'slug' => $theme->slug,
                    'name' => $theme->name,
                    'emoji' => $theme->emoji,
                    'gradient' => $theme->gradient,
                ],
                'level' => $deck['level'],
                'count' => $questions->count(),
                'questions' => $questions->values(),
            ];
        }

        return response()->json([
            'decks' => $result,
            'total_questions' => array_sum(array_map(fn ($d) => $d['count'], $result)),
        ]);
    }
}
