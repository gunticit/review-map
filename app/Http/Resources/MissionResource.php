<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Optional;

class MissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment' => optional($this->comments)->comment,
            'keyword' => optional($this->comments)->keyword,
            'project_name' => optional($this->project)->name,
            'link_confirm' => $this->link_confirm,
            'price' => formatCurrency($this->price),
            'project_code' => optional($this->project)->project_code,
            'project_description' => optional($this->project)->description,
            'image' => optional($this->images)->image_url,
            'place_id' => optional($this->project)->place_id,
            'project' => new ProjectResource($this->whenLoaded($this->project))
        ];
    }
}
