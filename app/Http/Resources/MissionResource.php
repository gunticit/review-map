<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'comment' => $this->comments->comment,
            'keyword' => $this->comments->keyword,
            'project_name' => $this->project->name,
            'project_code' => $this->project->project_code,
            'project_description' => $this->project->description,
            'project' => new ProjectResource($this->project)
        ];
    }
}
