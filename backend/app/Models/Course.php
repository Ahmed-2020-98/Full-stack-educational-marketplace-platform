<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'thumbnail',
        'level',
        'status',
        'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'level' => CourseLevel::class,
            'status' => CourseStatus::class,
            'duration_minutes' => 'integer',
        ];
    }

    // ---- Relationships ----

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
