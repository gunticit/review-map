<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'     => $this->name,
            'url_map'   => $this->url_map,
            'description'   => $this->description,
            'package'  => $this->package,
            'is_slow'  => $this->is_slow,
            'point_slow'  => $this->point_slow,
            'keyword'  => $this->keyword,
            'has_image'  => $this->has_image,
            'status'  => $this->status,
        ];
    }
}
