<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuruResource extends JsonResource
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
            'nama' => $this->nama,
            'gelar_depan' => $this->gelar_depan,
            'gelar_belakang' => $this->gelar_belakang,
            'nik' => $this->nik,
            'niy' => $this->niy,
            'nuptk' => $this->nuptk,
            'nip' => $this->nip,
            'gender' => $this->gender,
            'tempat_lahir' => $this->tempat_lahir,
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_ptk' => $this->jenis_ptk,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'desa' => $this->desa,
            'kec' => $this->kec,
            'kab' => $this->kab,
            'prov' => $this->prov,
            'foto' => $this->foto ? url('api/upload/' . $this->foto) : null,
            'mapel_guru' => $this->mapel,
        ];
    }
}
