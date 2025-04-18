<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class GudangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'gudang_id' => $this->gudang_id,
            'gudang_nama' => $this->gudang_nama,
            'gudang_slug' => $this->gudang_slug,
            'gudang_deskripsi' => $this->gudang_deskripsi,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}