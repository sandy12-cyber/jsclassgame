<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Index — landing page explaining the CSV export with download buttons.
     */
    public function index(): View
    {
        $themes = Theme::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $totalQuestions = Question::count();

        return view('export-index', compact('themes', 'totalQuestions'));
    }

    /**
     * Download all questions as a CSV file. Optional ?theme=slug and ?level=A1
     * query params to filter. Columns: theme, level, prompt, sample_answer,
     * tips, vocabulary.
     */
    public function questionsCsv(Request $request): StreamedResponse
    {
        $query = Question::with('theme');

        if ($themeSlug = $request->input('theme')) {
            $query->whereHas('theme', fn ($t) => $t->where('slug', $themeSlug));
        }
        if ($level = strtoupper((string) $request->input('level', ''))) {
            if (in_array($level, Question::LEVELS, true)) {
                $query->where('level', $level);
            }
        }

        $questions = $query->orderBy('theme_id')
            ->orderByRaw("FIELD(level, 'A1','A2','B1','B2')")
            ->orderBy('sort_order')
            ->get();

        $filename = 'speakup-questions';
        if ($themeSlug) $filename .= '-' . $themeSlug;
        if ($level) $filename .= '-' . strtolower($level);
        $filename .= '-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($questions) {
            $out = fopen('php://output', 'w');
            // BOM so Excel opens UTF-8 correctly
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['theme', 'level', 'prompt', 'sample_answer', 'tips', 'vocabulary']);
            foreach ($questions as $q) {
                fputcsv($out, [
                    $q->theme->slug ?? '',
                    $q->level,
                    $q->prompt,
                    $q->sample_answer ?? '',
                    $q->tips ?? '',
                    is_array($q->vocabulary) ? implode('; ', $q->vocabulary) : '',
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }
}
