<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CensorshipHistoryResource extends JsonResource
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
            'approver_id' => $this->approver->name ?? null,
            'mission_id' => $this->missions->comments->comment ?? null,
            'partner_id' => $this->partner->name ?? null,
            'money' => $this->money, 
            'created_at' => $this->created_at->format('d/m/Y H:i:s'), 
        ];
    }
}
