<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'amount' => $this->amount,
            'status' => $this->status,
            'course' => new CourseListResource($this->whenLoaded('course')),
            'user' => new UserResource($this->whenLoaded('user')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'created_at' => $this->created_at,
        ];
    }
}
