<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class SatuanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'satuan_id' => $this->satuan_id,
            'satuan_nama' => $this->satuan_nama,
            'satuan_slug' => $this->satuan_slug,
            'satuan_keterangan' => $this->satuan_keterangan,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}