<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportMessageResource extends JsonResource
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
            'support_id'     => $this->support_id,
            'send_id'   => $this->send_id,
            'receive_id'  => $this->receive_id,
            'parent_id'  => $this->parent_id,
            'message'  => $this->message,
            'created_at'  => $this->created_at,
            'sender' => $this->sender ?? null,
            'receiver' => $this->receiver ?? null
        ];
    }
}
