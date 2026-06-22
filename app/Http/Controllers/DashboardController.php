<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Stats & progress dashboard.
     * Most progress is client-side (localStorage), so we pass server-side
     * totals and let the page hydrate with the user's local progress.
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
                $theme->total_questions = array_sum($theme->level_counts);
                return $theme;
            });

        $byLevel = [];
        foreach (Question::LEVELS as $level) {
            $byLevel[] = [
                'code' => $level,
                'count' => Question::where('level', $level)->count(),
                'description' => Question::levelDescription($level),
            ];
        }

        $totalQuestions = Question::count();
        $totalThemes = $themes->count();

        // Most "tip-rich" questions for a "wisdom" widget
        $featuredQuestions = Question::with('theme')
            ->whereNotNull('tips')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('dashboard', [
            'themes' => $themes,
            'byLevel' => $byLevel,
            'totalQuestions' => $totalQuestions,
            'totalThemes' => $totalThemes,
            'featuredQuestions' => $featuredQuestions,
        ]);
    }
}
