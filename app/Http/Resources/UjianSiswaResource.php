<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UjianSiswaResource extends JsonResource
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
            'id_ujian' => $this->id_ujian,
            'id_siswa' => $this->id_siswa,
            'w_mulai' => $this->w_mulai ? date('Y-m-d H:i:s', strtotime($this->w_mulai)) : null,
            'max_time' => $this->w_mulai ? date('m/d/Y H:i:s', strtotime($this->max_time)) : null,
            'w_selesai' => $this->w_selesai ? date('Y-m-d H:i:s', strtotime($this->w_selesai)) : null,
            'jml_pg_benar' => $this->jml_pg_benar,
            'jml_pg_salah' => $this->jml_pg_salah,
            'skor_pg' => $this->skor_pg,
            'skor_essay' => $this->skor_essay,
            'total' => (float) number_format($this->total, 2),
            'ujian' => $this->ujian ? new UjianResource($this->ujian) : null,
            'soal' => $this->ujian ? new SoalResource($this->ujian->soal) : null,
            'siswa' => $this->siswa ? new SiswaResource($this->siswa) : null,
        ];
    }
}
