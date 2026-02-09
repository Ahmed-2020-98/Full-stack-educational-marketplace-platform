<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'duration_minutes',
        'sort_order',
        'is_free_preview',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'sort_order' => 'integer',
            'is_free_preview' => 'boolean',
        ];
    }

    // ---- Relationships ----

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }
}
