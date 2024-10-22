<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id ?? null,
            'name'     => $this->email ?? null,
            'slug'   => $this->telephone ?? null,
            'subject'   => $this->language ?? null
        ];
    }
}
