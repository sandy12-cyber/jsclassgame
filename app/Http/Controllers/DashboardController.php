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

    /**
     * Achievements & streaks page.
     * Definitions are server-side; progress is hydrated client-side from
     * localStorage (practiced ids, streak data, etc.).
     */
    public function achievements(): View
    {
        // Static achievement definitions. The client computes which are unlocked.
        $achievements = [
            [
                'id' => 'first-card',
                'title' => 'First Words',
                'desc' => 'Practise your very first card.',
                'icon' => 'sparkles',
                'color' => 'from-rose-400 to-pink-500',
                'goal' => 1,
                'metric' => 'practiced',
            ],
            [
                'id' => 'ten-cards',
                'title' => 'Getting Warmed Up',
                'desc' => 'Practise 10 cards in total.',
                'icon' => 'flame',
                'color' => 'from-amber-400 to-orange-500',
                'goal' => 10,
                'metric' => 'practiced',
            ],
            [
                'id' => 'fifty-cards',
                'title' => 'Conversationalist',
                'desc' => 'Practise 50 cards in total.',
                'icon' => 'message-circle',
                'color' => 'from-emerald-400 to-teal-500',
                'goal' => 50,
                'metric' => 'practiced',
            ],
            [
                'id' => 'hundred-cards',
                'title' => 'Speaking Champion',
                'desc' => 'Practise 100 cards in total.',
                'icon' => 'trophy',
                'color' => 'from-violet-500 to-fuchsia-600',
                'goal' => 100,
                'metric' => 'practiced',
            ],
            [
                'id' => 'favorite-first',
                'title' => 'Collector',
                'desc' => 'Save your first favourite card.',
                'icon' => 'heart',
                'color' => 'from-rose-400 to-red-500',
                'goal' => 1,
                'metric' => 'favorites',
            ],
            [
                'id' => 'favorite-ten',
                'title' => 'Curator',
                'desc' => 'Save 10 favourite cards.',
                'icon' => 'bookmark',
                'color' => 'from-fuchsia-400 to-purple-500',
                'goal' => 10,
                'metric' => 'favorites',
            ],
            [
                'id' => 'streak-3',
                'title' => 'Habit Forming',
                'desc' => 'Practise on 3 different days.',
                'icon' => 'calendar',
                'color' => 'from-teal-400 to-cyan-500',
                'goal' => 3,
                'metric' => 'streak-days',
            ],
            [
                'id' => 'streak-7',
                'title' => 'Week Warrior',
                'desc' => 'Practise on 7 different days.',
                'icon' => 'flame',
                'color' => 'from-orange-500 to-red-600',
                'goal' => 7,
                'metric' => 'streak-days',
            ],
            [
                'id' => 'theme-explorer',
                'title' => 'Theme Explorer',
                'desc' => 'Practise cards from 3 different themes.',
                'icon' => 'compass',
                'color' => 'from-indigo-400 to-violet-500',
                'goal' => 3,
                'metric' => 'themes-touched',
            ],
            [
                'id' => 'level-climber',
                'title' => 'Level Climber',
                'desc' => 'Practise at every CEFR level (A1–B2).',
                'icon' => 'trending-up',
                'color' => 'from-emerald-500 to-green-600',
                'goal' => 4,
                'metric' => 'levels-touched',
            ],
            [
                'id' => 'daily-challenge',
                'title' => 'Daily Ritual',
                'desc' => 'Complete the Daily Challenge.',
                'icon' => 'gift',
                'color' => 'from-amber-400 to-yellow-500',
                'goal' => 1,
                'metric' => 'daily-done',
            ],
            [
                'id' => 'deck-complete',
                'title' => 'Deck Sweeper',
                'desc' => 'Finish a whole deck (all cards practiced).',
                'icon' => 'award',
                'color' => 'from-rose-500 to-pink-600',
                'goal' => 1,
                'metric' => 'deck-completed',
            ],
        ];

        $totalQuestions = Question::count();

        return view('achievements', compact('achievements', 'totalQuestions'));
    }

    /**
     * Rubric history page — surfaces the per-card speaking-rubric scores
     * saved in localStorage during Lesson Mode. The page is a shell that
     * hydrates client-side (scores live in the browser, not the DB).
     */
    public function rubricHistory(): View
    {
        $themes = Theme::where('is_active', true)->orderBy('name')->get();
        $totalQuestions = Question::count();

        // The four rubric criteria (kept in sync with LessonController)
        $criteria = [
            ['key' => 'fluency',       'label' => 'Fluency',       'color' => 'from-emerald-400 to-green-500',   'hex' => '#10b981'],
            ['key' => 'accuracy',      'label' => 'Accuracy',      'color' => 'from-teal-400 to-cyan-500',       'hex' => '#14b8a6'],
            ['key' => 'vocabulary',    'label' => 'Vocabulary',    'color' => 'from-amber-400 to-orange-500',    'hex' => '#f59e0b'],
            ['key' => 'pronunciation', 'label' => 'Pronunciation', 'color' => 'from-rose-400 to-pink-600',       'hex' => '#f43f5e'],
        ];

        return view('rubric-history', compact('themes', 'totalQuestions', 'criteria'));
    }
}
