<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LessonController extends Controller
{
    /**
     * Lesson Mode — guided practice with a 4-criterion speaking rubric.
     * Same deck as the game, but with a self-assessment panel after each card.
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

        // The speaking rubric used for self-assessment.
        $rubric = [
            [
                'key' => 'fluency',
                'label' => 'Fluency',
                'icon' => 'waves',
                'desc' => 'Spoke smoothly without too many long pauses.',
                'scale' => ['Needs work', 'Okay', 'Good', 'Very good'],
            ],
            [
                'key' => 'accuracy',
                'label' => 'Accuracy',
                'icon' => 'target',
                'desc' => 'Used correct grammar and word forms.',
                'scale' => ['Needs work', 'Okay', 'Good', 'Very good'],
            ],
            [
                'key' => 'vocabulary',
                'label' => 'Vocabulary',
                'icon' => 'book-open',
                'desc' => 'Used a good range of words and phrases.',
                'scale' => ['Needs work', 'Okay', 'Good', 'Very good'],
            ],
            [
                'key' => 'pronunciation',
                'label' => 'Pronunciation',
                'icon' => 'volume-2',
                'desc' => 'Spoke clearly enough to be easily understood.',
                'scale' => ['Needs work', 'Okay', 'Good', 'Very good'],
            ],
        ];

        return view('lesson', compact('theme', 'level', 'questions', 'suggestedTime', 'rubric'));
    }
}
