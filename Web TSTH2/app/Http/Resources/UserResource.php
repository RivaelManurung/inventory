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
            'user_id' => $this->user_id,
            'user_nama' => $this->user_nama,
            'user_nmlengkap' => $this->user_nmlengkap,
            'user_email' => $this->user_email,
            'role' => $this->role,
            'permissions' => $this->permissions
        ];
    }
}
