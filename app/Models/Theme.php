<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'emoji',
        'gradient',
        'accent',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Auto-generate the slug when creating a theme.
     */
    protected static function booted(): void
    {
        static::creating(function (Theme $theme) {
            $theme->slug ??= Str::slug($theme->name);
        });
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get questions for a specific CEFR level.
     */
    public function questionsForLevel(string $level)
    {
        return $this->questions()
            ->where('level', $level)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Count of questions per level for this theme.
     */
    public function levelCounts(): array
    {
        $counts = ['A1' => 0, 'A2' => 0, 'B1' => 0, 'B2' => 0];

        $raw = $this->questions()
            ->selectRaw('level, COUNT(*) as total')
            ->groupBy('level')
            ->pluck('total', 'level');

        foreach ($raw as $level => $total) {
            $counts[$level] = (int) $total;
        }

        return $counts;
    }
}
