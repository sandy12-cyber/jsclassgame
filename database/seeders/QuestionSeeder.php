<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $bank = require __DIR__.'/data/questions.php';

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
