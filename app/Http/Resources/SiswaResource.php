<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'id_kelas' => $this->id_kelas,
            'kelas' => optional($this->kelas)->nama,
            'id_rombel' => $this->id_rombel,
            'rombel' => $this->id_rombel ? optional($this->rombel)->nama : null,
            'nama' => $this->nama,
            'nik' => $this->nik,
            'no_peserta' => $this->no_peserta,
            'nisn' => $this->nisn,
            'gender' => $this->gender,
            'tempat_lahir' => $this->tempat_lahir,
            'tgl_lahir' => $this->tgl_lahir,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'desa' => $this->desa,
            'kec' => $this->kec,
            'kab' => $this->kab,
            'prov' => $this->prov,
            'foto' => $this->foto ? url('api/upload/' . $this->foto) : null,
        ];
    }
}
