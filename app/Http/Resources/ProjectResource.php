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
            'project_code' => $this->project_code,
            'description'   => $this->description,
            'package'  => $this->package,
            'is_slow'  => $this->is_slow,
            'point_slow'  => $this->point_slow,
            'keyword'  => $this->keyword,
            'has_image'  => $this->has_image,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'place_id' => $this->place_id,
            'status'  => $this->status,
            'comments' => CommentResource::collection($this->comments),
            'images' => ProjectImageResource::collection($this->images),
        ];
    }
}
