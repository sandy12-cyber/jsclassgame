<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ToolsController extends Controller
{
    /**
     * Standalone speaking stopwatch / timer.
     * A focused tool: pick a duration, hit start, speak, and the timer
     * counts down (or up) with visual + audio cues. Useful for warm-ups
     * and self-timed practice without a full deck.
     */
    public function timer(): View
    {
        $presets = [
            ['secs' => 30,  'label' => '30s', 'desc' => 'A1 quick answer', 'color' => 'from-emerald-400 to-green-500'],
            ['secs' => 45,  'label' => '45s', 'desc' => 'A2 short talk',   'color' => 'from-teal-400 to-cyan-500'],
            ['secs' => 60,  'label' => '1m',  'desc' => 'B1 minute talk',  'color' => 'from-amber-400 to-orange-500'],
            ['secs' => 90,  'label' => '1m30s','desc' => 'B2 extended',     'color' => 'from-rose-400 to-pink-600'],
            ['secs' => 120, 'label' => '2m',  'desc' => 'Long answer',     'color' => 'from-violet-400 to-purple-500'],
            ['secs' => 180, 'label' => '3m',  'desc' => 'Deep discussion', 'color' => 'from-indigo-400 to-violet-500'],
        ];

        // A few random warm-up prompts to inspire the speaker
        $warmups = Question::with('theme')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('tools-timer', compact('presets', 'warmups'));
    }
}
