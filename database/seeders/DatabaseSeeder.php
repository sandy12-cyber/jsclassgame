<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ThemeSeeder::class,
            QuestionSeeder::class,
        ]);
    }
}
