<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAccessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user' => $this->resource['user'] ?? null,
            'permissions' => $this->resource['permissions'] ?? [],
            'roles' => $this->resource['roles'] ?? [],
            'accessible_routes' => $this->resource['accessible_routes'] ?? [],
            'all_permissions' => $this->resource['all_permissions'] ?? [],
            'all_roles' => $this->resource['all_roles'] ?? []
        ];
    }
}