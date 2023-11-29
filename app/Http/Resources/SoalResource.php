<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SoalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'id_mapel' => $this->id_mapel,
            'id_kelas' => $this->id_kelas,
            'id_rombel' => $this->id_rombel,
            'id_guru' => $this->id_guru,
            'mapel' => optional($this->mapel)->nama,
            'kelas' => optional($this->kelas)->nama,
            'rombel' => optional($this->rombel)->nama,
            'guru' => optional($this->guru)->nama,
            'kode' => $this->kode,
            'tipe_mapel_soal' => $this->tipe_mapel_soal,
            'tipe_soal' => $this->tipe_soal,
            'tipe_soal_display' => $this->tipe_soal,
            'nama' => $this->nama,
            'jml_pg' => $this->jml_pg,
            'jml_essay' => $this->jml_essay,
            'bobot_pg' => $this->bobot_pg,
            'bobot_essay' => $this->bobot_essay,
            // 'jml_pil_essay' => $this->jml_pil_essay,
            'kkm' => $this->kkm,
            'is_agama' => $this->is_agama,
            'is_active' => $this->is_active,
            'created_at' => date('d M Y', strtotime($this->created_at)),
        ];

        if($request->withSoalItem) {
            $data['list_pg'] = SoalItemResource::collection($this->items->where('jenis_soal', 'pg'));
            $data['list_essay'] = SoalItemResource::collection($this->items->where('jenis_soal', 'essay'));
        }

        return $data;
    }
}
