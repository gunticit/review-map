<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectImageResource extends JsonResource
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
            'project_id'     => $this->project_id,
            'image_url'   => $this->image_url,
            'created_at'   => $this->created_at,
            'created_by'  => $this->created_by,
            'active'  => $this->active,
        ];
    }
}
