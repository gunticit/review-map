<?php

namespace App\Modules\Sample\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
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
