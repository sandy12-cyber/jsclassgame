<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    public const LEVELS = ['A1', 'A2', 'B1', 'B2'];

    protected $fillable = [
        'theme_id',
        'level',
        'prompt',
        'sample_answer',
        'tips',
        'vocabulary',
        'sort_order',
    ];

    protected $casts = [
        'vocabulary' => 'array',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    /**
     * Human-readable description of a CEFR level.
     */
    public static function levelDescription(string $level): string
    {
        return match ($level) {
            'A1' => 'Beginner — simple words and short phrases',
            'A2' => 'Elementary — common, everyday expressions',
            'B1' => 'Intermediate — describe experiences and opinions',
            'B2' => 'Upper-Intermediate — discuss abstract topics in detail',
            default => 'Unknown level',
        };
    }

    /**
     * Suggested speaking time (in seconds) per level.
     */
    public static function suggestedTime(string $level): int
    {
        return match ($level) {
            'A1' => 30,
            'A2' => 45,
            'B1' => 60,
            'B2' => 90,
            default => 60,
        };
    }
}
