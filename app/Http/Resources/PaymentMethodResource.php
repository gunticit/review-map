<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [ 
            'type' => $this->type,
            'owner_name' => $this->owner_name,
            'account_number' => $this->account_number, 
            'bank_name' => $this->bank_name, 
            'bank_branch' => $this->bank_branch,
            'note' => $this->note
        ];
    }
}
