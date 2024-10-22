<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id ?? null,
            'name'   => $this->name ?? null,
            'username' => $this->username ?? null,
            'avatar' => $this->avatar ? getAssetStorageLocal("avatars/{$this->avatar}") : null,
            'email'     => $this->email ?? null,
            'telephone'   => $this->telephone ?? null,
            'language'   => $this->language ?? null,
            'dark_mode'  => $this->dark_mode ?? null,
            'google_id'  => $this->google_id ?? null,

        ];
    }
}
