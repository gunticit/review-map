<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'code' => $this->code,
            'description' => $this->description,
            'discount_type' => $this->discount_type, 
            'discount_value' => $this->discount_value, 
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_uses' => $this->max_uses,
            'uses_left' => $this->uses_left,
            'status' => $this->status,
            'min_order_value' => $this->min_order_value
        ];
    }
}
