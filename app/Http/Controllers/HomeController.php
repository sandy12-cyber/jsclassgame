<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Home page — colorful grid of all active themes.
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

        $totalQuestions = Question::count();
        $totalThemes = $themes->count();

        return view('home', compact('themes', 'totalQuestions', 'totalThemes'));
    }

    /**
     * About / how-to-play page.
     */
    public function about(): View
    {
        $levels = [
            'A1' => ['name' => 'Beginner', 'desc' => 'Simple words and short phrases about concrete, everyday topics.'],
            'A2' => ['name' => 'Elementary', 'desc' => 'Common expressions and routine situations. Sentences become longer.'],
            'B1' => ['name' => 'Intermediate', 'desc' => 'Describe experiences, dreams, opinions and give brief reasons.'],
            'B2' => ['name' => 'Upper-Intermediate', 'desc' => 'Discuss abstract and complex topics with fluency and detail.'],
        ];

        return view('about', compact('levels'));
    }

    /**
     * Welcome / onboarding tour for first-time visitors.
     */
    public function welcome(): View
    {
        $totalQuestions = Question::count();
        $totalThemes = Theme::where('is_active', true)->count();

        return view('welcome', compact('totalQuestions', 'totalThemes'));
    }
}
