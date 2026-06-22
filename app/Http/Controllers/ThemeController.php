<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController extends Controller
{
    /**
     * Show a single theme with its level breakdown (A1–B2).
     */
    public function show(Theme $theme): View
    {
        $theme->load('questions');

        $levels = [];
        foreach (Question::LEVELS as $level) {
            $count = $theme->questions->where('level', $level)->count();
            $levels[] = [
                'code' => $level,
                'name' => Question::levelDescription($level) === 'Unknown level' ? $level : explode(' — ', Question::levelDescription($level))[0],
                'description' => Question::levelDescription($level),
                'count' => $count,
                'time' => Question::suggestedTime($level),
            ];
        }

        $sampleQuestions = $theme->questions
            ->groupBy('level')
            ->map(fn ($items) => $items->first());

        return view('theme', compact('theme', 'levels', 'sampleQuestions'));
    }
}
