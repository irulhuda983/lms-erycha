<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JawabanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if($request->forList) {
            return [
                'id' => $this->id,
                'is_ragu' => $this->is_ragu,
                'is_jawab' => $this->jawaban ? 1 : 0,
                'jawaban' => $this->jawaban,
                'no_soal' => (int) optional($this->soalItem)->no_urut,
            ];
        }

        return [
            'id' => $this->id,
            'id_mapel' => $this->id_mapel,
            'id_siswa' => $this->id_siswa,
            'id_soal' => $this->id_soal,
            'id_soal_item' => $this->id_soal_item,
            'id_ujian_siswa' => $this->id_ujian_siswa,
            'is_ragu' => $this->is_ragu,
            'jawaban' => $this->jawaban,
            'kunci' => $this->kunci,
            'jenis' => $this->jenis,
            'nilai_essay' => $this->nilai_essay,
            'soal' => $this->soal,
            'soal_item' => $this->soalItem,
        ];
    }
}
