<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'id' => $this->id,
            'name' => $this->name,
            'parent_name' => optional($this->parent)->name, 
            'created_by' => optional($this->created_by)->name, 
            'created_at' => $this->created_at->format('d/m/Y H:i:s'), 
        ];
    }
}
