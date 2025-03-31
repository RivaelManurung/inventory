<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JenisBarangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'jenis_barang_id' => $this->jenisbarang_id,
            'nama' => $this->jenisbarang_nama,
            'slug' => $this->jenisbarang_slug,
            'keterangan' => $this->jenisbarang_ket,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}