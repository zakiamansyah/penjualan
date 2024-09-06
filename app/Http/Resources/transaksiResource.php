<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class transaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_barang' => $this->barang->nama,
            'stok' => $this->stok_awal,
            'jumlah_terjual' => $this->jumlah_terjual,
            'tanggal_transaksi' => Carbon::parse($this->tanggal_transaksi)->format('d-m-Y'),
            'jenis_barang_nama' => $this->barang->jenisBarang->nama,
        ];
    }
}
