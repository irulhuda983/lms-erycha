<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SoalItemResource extends JsonResource
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
            'id_soal' => $this->id_soal,
            'jenis_soal' => $this->jenis_soal,
            'no_urut' => $this->no_urut,
            'text_soal' => $this->text_soal,
            'pil_a' => $this->pil_a,
            'pil_b' => $this->pil_b,
            'pil_c' => $this->pil_c,
            'pil_d' => $this->pil_d,
            'pil_e' => $this->pil_e,
            'file_soal' => $this->file_soal,
            'file_pila' => $this->file_pila,
            'file_pilb' => $this->file_pilb,
            'file_pilc' => $this->file_pilc,
            'file_pild' => $this->file_pild,
            'file_pile' => $this->file_pile,
            'kunci_jawaban' => $this->kunci_jawaban,
            'created_at' => $this->created_at,
        ];
    }
}
