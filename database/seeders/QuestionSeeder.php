<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        // Base bank (6 questions per level) + supplementary bank (4 more per level).
        // Both share the same structure and are merged so every deck has 10 cards.
        $bank = require __DIR__.'/data/questions.php';
        $extra = require __DIR__.'/data/questions_extra.php';

        // Deep-merge: append extra questions under each theme/level.
        foreach ($extra as $themeSlug => $levels) {
            if (! isset($bank[$themeSlug])) {
                $bank[$themeSlug] = [];
            }
            foreach ($levels as $level => $questions) {
                if (! isset($bank[$themeSlug][$level])) {
                    $bank[$themeSlug][$level] = [];
                }
                foreach ($questions as $q) {
                    $bank[$themeSlug][$level][] = $q;
                }
            }
        }

        $total = 0;

        foreach ($bank as $themeSlug => $levels) {
            $theme = Theme::where('slug', $themeSlug)->first();

            if (! $theme) {
                $this->command->warn("Theme '{$themeSlug}' not found — skipping its questions.");
                continue;
            }

            $sortLevel = 0;
            foreach ($levels as $level => $questions) {
                $sortItem = 0;
                foreach ($questions as $q) {
                    Question::updateOrCreate(
                        [
                            'theme_id' => $theme->id,
                            'level' => $level,
                            'prompt' => $q[0],
                        ],
                        [
                            'sample_answer' => $q[1] ?? null,
                            'tips' => $q[2] ?? null,
                            'vocabulary' => $q[3] ?? null,
                            'sort_order' => $sortItem,
                        ]
                    );
                    $sortItem++;
                    $total++;
                }
                $sortLevel++;
            }
        }

        $this->command->info("Seeded {$total} questions across all themes and levels.");
    }
}
