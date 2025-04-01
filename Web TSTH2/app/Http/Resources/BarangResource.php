<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'barang_id' => $this->barang_id,
            'nama' => $this->barang_nama,
            'harga' => $this->barang_harga,
            'satuan_id' => $this->satuan_id,
            'jenisbarang_id' => $this->jenisbarang_id,
            'klasifikasi' => $this->klasifikasi_barang,
            'created_at' => Carbon::parse($this->created_at)->translatedFormat('d F Y h:i A'),
            'updated_at' => Carbon::parse($this->updated_at)->translatedFormat('d F Y h:i A'),
        ];
    }
}