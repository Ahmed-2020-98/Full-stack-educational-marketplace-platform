<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'thumbnail' => $this->thumbnail,
            'level' => $this->level,
            'status' => $this->status,
            'duration_minutes' => $this->duration_minutes,
            'instructor' => [
                'id' => $this->instructor?->id,
                'name' => $this->instructor?->name,
            ],
            'category' => [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
                'slug' => $this->category?->slug,
            ],
            'lessons_count' => $this->whenCounted('lessons'),
            'enrollments_count' => $this->whenCounted('enrollments'),
            'created_at' => $this->created_at,
        ];
    }
}
