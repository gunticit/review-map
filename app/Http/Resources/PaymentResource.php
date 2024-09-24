<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id'         => $this->order_id,
            'amount'     => $this->amount,
            'status'   => $this->status,
            'payment_method'  => $this->payment_method,
            'transaction_id'  => $this->transaction_id
        ];
    }
}
