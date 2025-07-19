<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Tanggal' => $this->created_at,
            'Deskripsi' => $this->description,
            'Kategori' => $this->category,
            'Jumlah' => round($this->amount, 2)
        ];
    }
}
