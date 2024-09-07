<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status_config = config('constants.support_status');
        return [
            'id'         => $this->id,
            'name'     => $this->name,
            'description'   => $this->description,
            'package'  => $this->package,
            'is_slow'  => $this->is_slow,
            'point_slow'  => $this->point_slow,
            'keyword'  => $this->keyword,
            'has_image'  => $this->has_image,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'place_id' => $this->place_id,
            'status'  => $this->status ? $status_config[$this->status] : null,
        ];
    }
}
