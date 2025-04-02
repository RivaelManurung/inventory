<?php
namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'barang_id' => $this->barang_id,
            'barang_kode' => $this->barang_kode,
            'barang_nama' => $this->barang_nama,
            'barang_slug' => $this->barang_slug,
            'barang_harga' => $this->barang_harga,
            'klasifikasi_barang' => $this->klasifikasi_barang,
            'satuan' => $this->whenLoaded('satuan'),
            'jenisbarang' => $this->whenLoaded('jenisBarang'), // Note the capitalization change
            'user' => $this->whenLoaded('user'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? Carbon::parse($this->deleted_at)->translatedFormat('d F Y h:i A') : null,
        ];
    }
}