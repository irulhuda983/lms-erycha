<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UjianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        $ujianSiswa = $this->ujianSiswa->first( function($item) use ($user) { return $item->id_siswa == $user->pemilik->id; }) ? 1 : 0;

        $status = null;

        if( date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($this->waktu_mulai)) && date('Y-m-d H:i:s') < date('Y-m-d H:i:s', strtotime($this->w_akhir)) ) {
            if($ujianSiswa == 1) {
                $status = 'sudah_mengerjakan';
            }else{
                $status = 'mulai_kerjakan';
            }
        }else {
            if( date('Y-m-d H:i:s') < date('Y-m-d H:i:s', strtotime($this->waktu_mulai)) ) {
                $status = 'belum_dimulai';
            }else{
                $status = 'kadaluarsa';
            }
        }

        $data = [
            'id' => $this->id,
            'id_soal' => $this->id_soal,
            'id_kelas' => $this->id_kelas,
            'id_jenis_ujian' => $this->id_jenis_ujian,
            'id_materi' => $this->id_materi,
            'id_guru' => $this->id_guru,
            'id_rombel' => $this->id_rombel,
            'soal' => optional($this->soal)->nama,
            'kelas' => optional($this->kelas)->nama,
            'jenis_ujian' => optional($this->jenisujian)->nama,
            'materi' => optional($this->materi)->judul,
            'mapel' => optional(optional($this->soal)->mapel)->nama,
            'guru' => optional($this->guru)->nama,
            'rombel' => optional($this->rombel)->nama,
            'kode' => $this->kode,
            'nama' => $this->nama,
            'lama_ujian' => $this->lama_ujian,
            'waktu_mulai' => date('Y-m-d H:i:s', strtotime($this->waktu_mulai)),
            'waktu_mulai_view' => date('d/m/Y H:i:s', strtotime($this->waktu_mulai)),
            'w_akhir' => date('Y-m-d H:i:s', strtotime($this->w_akhir)),
            'last_token' => $this->last_token,
            'is_active' => $this->is_active,
            'is_hasil' => $this->is_hasil,
            'is_acak' => $this->is_acak,
            'is_mulai_kerjakan' => $status != 'mulai_kerjakan' ? 0 : 1,
            'status' => $status,
        ];

        if($user->role == 'siswa') {
            $data['ujianSiswa'] = $ujianSiswa;
        }

        return $data;
    }
}
