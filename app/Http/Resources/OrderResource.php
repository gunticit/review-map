<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $recipient_name = $this->recipient_name ? $this->recipient_name : ($this->user->name ? $this->user->name : null);
        $recipient_phone = $this->recipient_phone ? $this->recipient_phone : ($this->user->telephone ? $this->user->telephone : null);
        return [
            'id'         => $this->id,
            'user_info'         => $this->user->user_id,
            'status'     => $this->status,
            'telephone' => $this->user->telephone,
            'total'   => $this->total,
            'shipping_address'  => $this->shipping_address,
            'payment_method'  => $this->payment_method,
            'items' => $this->items,
            'recipient_name' => $recipient_name,
            'recipient_phone' => $recipient_phone
        ];
    }
}
