<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Search & filter all questions.
     */
    public function index(Request $request): View
    {
        $query = Question::with('theme');

        // Keyword search on prompt, sample_answer, and tips
        if ($search = trim((string) $request->input('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('prompt', 'like', "%{$search}%")
                  ->orWhere('sample_answer', 'like', "%{$search}%")
                  ->orWhere('tips', 'like', "%{$search}%");
            });
        }

        // Theme filter
        if ($themeSlug = $request->input('theme')) {
            $query->whereHas('theme', fn ($t) => $t->where('slug', $themeSlug));
        }

        // Level filter (multi)
        $levels = (array) $request->input('levels', []);
        $levels = array_values(array_intersect($levels, Question::LEVELS));
        if (! empty($levels)) {
            $query->whereIn('level', $levels);
        }

        $questions = $query->orderBy('theme_id')
            ->orderByRaw("FIELD(level, 'A1','A2','B1','B2')")
            ->orderBy('sort_order')
            ->paginate(24)
            ->withQueryString();

        $themes = Theme::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('search', [
            'questions' => $questions,
            'themes' => $themes,
            'filters' => [
                'q' => $search,
                'theme' => $themeSlug,
                'levels' => $levels,
            ],
        ]);
    }

    /**
     * Favorites page — client-side: ids stored in localStorage, but we
     * render a placeholder shell that JS fills by calling the resolve API.
     */
    public function favorites(): View
    {
        $themes = Theme::where('is_active', true)->orderBy('name')->get();

        return view('favorites', [
            'themes' => $themes,
        ]);
    }

    /**
     * Resolve a list of question ids into full records (for the favorites page).
     */
    public function resolveFavorites(Request $request): JsonResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $questions = Question::with('theme')
            ->whereIn('id', $data['ids'])
            ->get()
            ->keyBy('id');

        // Preserve the order given by the client
        $ordered = collect($data['ids'])
            ->map(fn ($id) => $questions->get($id))
            ->filter()
            ->values();

        return response()->json([
            'count' => $ordered->count(),
            'questions' => $ordered,
        ]);
    }
}
