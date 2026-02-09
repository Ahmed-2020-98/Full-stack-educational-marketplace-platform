<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'progress_percentage' => $this->progress_percentage,
            'completed_at' => $this->completed_at,
            'course' => new CourseListResource($this->whenLoaded('course')),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
        ];
    }
}
