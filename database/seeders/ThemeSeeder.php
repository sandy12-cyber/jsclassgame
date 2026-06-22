<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = require __DIR__.'/data/themes.php';

        foreach ($themes as $data) {
            Theme::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        $this->command->info('Seeded '.count($themes).' themes.');
    }
}
