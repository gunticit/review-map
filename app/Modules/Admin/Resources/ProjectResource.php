<?php

namespace App\Modules\Project\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $req): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
