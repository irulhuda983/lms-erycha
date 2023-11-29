<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->pemilik->nama,
            'username' => $this->username,
            'password_view' => $this->password_view,
            'jenis_pemilik' => $this->jenis_pemilik,
            'role' => $this->role,
            'nik' => $this->pemilik->nik,
            'gender' => $this->pemilik->gender,
            'foto' => $this->pemilik->foto ? url('api/upload/' . optional($this->pemilik)->foto) : null,
        ];
    }
}
