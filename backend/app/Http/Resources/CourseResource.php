<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'price' => $this->price,
            'thumbnail' => $this->thumbnail,
            'level' => $this->level,
            'status' => $this->status,
            'duration_minutes' => $this->duration_minutes,
            'instructor' => new UserResource($this->whenLoaded('instructor')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'lessons_count' => $this->whenCounted('lessons'),
            'enrollments_count' => $this->whenCounted('enrollments'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
