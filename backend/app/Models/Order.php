<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'order_number',
        'amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => OrderStatus::class,
        ];
    }

    // ---- Relationships ----

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }
}
